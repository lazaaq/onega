<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Cart;
use App\Models\CartItem;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batas = 15;
        $invoices = Invoice::with('invoice_items')->paginate($batas);
        return response()->json([
            'status' => 'success',
            'data' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_id'=> 'required|integer',
            'subtotal'=> 'required|numeric',
            'discount'=> 'required|numeric',
            'tax'=> 'required|numeric',
            'total_price'=> 'required|numeric',
            'notes'=> 'required|string',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $invoice = Invoice::create($request->all());

        return response()->json([
            'status' => 'data added successfully',
            'data' => $invoice,
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::with('invoice_items.product.discount', 'customer')->find($id);
     
        return response()->json([
            'status' => 'success',
            'data' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'customer_id'=> 'integer',
            'subtotal'=> 'numeric',
            'discount'=> 'numeric',
            'tax'=> 'numeric',
            'total_price'=> 'numeric',
            'notes'=> 'string',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $invoice = Invoice::find($id);
        $invoice = $invoice->update($request->all());

        return response()->json([
            'status' => 'data updated successfully',
            'data' => $invoice,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice_items = InvoiceItem::where('invoice_id',$invoice->id)->get()->all();

        foreach($invoice_items as $invoice_item){
            $invoice_item->delete();
        }
        $invoice->delete();

        return response()->json([
            'status' => 'data deleted successuflly',
            'data' => null,
        ]);
    }
    public function get_invoice($id)
    {
        $cart = Cart::find($id);
        $cartItems = CartItem::where('cart_id', $id)->get()->all();

        $invoice = new Invoice();    
        $invoice->customer_id=$cart->customer_id;
        $invoice->subtotal=$cart->subtotal;
        $invoice->discount=$cart->discount;
        $invoice->tax=$cart->tax;
        $invoice->total_price=$cart->total_price;
        $invoice->notes=$cart->notes;
        $invoice->save();

        foreach ($cartItems as $cartItem){
            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id=$cartItem->cart_id;
            $invoiceItem->product_id=$cartItem->product_id;
            $invoiceItem->discount=$cartItem->discount;
            $invoiceItem->quantity=$cartItem->quantity;
            $invoiceItem->price=$cartItem->price;
            $invoiceItem->save();

            $cartItem->delete();
        }

        $cart->delete();
        return response()->json([
            'status' => 'get invoice successfully',
        ]);
    }

    public function make_invoice(Request $request)
    {
        DB::beginTransaction();
        
        try{
            $newInvoice = Invoice::create([
                'customer_id'=>$request->customer_id,
                'subtotal'=>$request->subtotal,
                'discount'=>$request->discount,
                'tax'=>$request->tax,
                'total_price'=>$request->total_price,
                'notes'=>$request->notes,
            ]);
            $newInvoiceItems = [];
            foreach($request->items as $item){
                $newInvoiceItem = InvoiceItem::create([
                    'invoice_id' => $newInvoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
                $newInvoiceItems[] = $newInvoiceItem;
            }
            $newInvoice->items = $newInvoiceItems;
            $cart = Cart::where('customer_id', $request->customer_id)->first();
            if($cart) {
                $cartItems = CartItem::where('cart_id', $cart->id)->get();
                if($cartItems) {
                    $cart->delete();
                    foreach($cartItems as $cartItem){
                        $cartItem->delete();
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' =>  $newInvoice,
            ]);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'failed',
            ]);
        }

    }

}
