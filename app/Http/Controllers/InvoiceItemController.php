<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function index()
    {
        $invoiceItem = InvoiceItem::with('product','invoice')->get();
        return response()->json([
            'status' => 'success',
            'data' => $invoiceItem
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
            'invoice_id'=> 'required|integer',
            'product_id'=> 'required|numeric',
            'discount'=> 'required|numeric',
            'quantity'=> 'required|numeric',
            'subtotal'=> 'numeric',
        ];
        $validator = Validator::make($request->all(),$rules);
        $invoiceItem = InvoiceItem::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $invoiceItem
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
        $invoiceItem = InvoiceItem::with('invoice', 'product')->find($id);
        return response()->json([
            'status' => 'success',
            'data' => $invoiceItem
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
            'invoice_id'=> 'integer',
            'product_id'=> 'integer',
            'discount'=> 'numeric',
            'quantity'=> 'numeric',
            'subtotal'=> 'numeric',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $invoiceItem = InvoiceItem::find($id);
        $invoiceItem->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $invoiceItem
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
        $invoiceItem = InvoiceItem::find($id);
        $invoiceItem->delete();
        return response()->json([
            'status' => 'success',
            'data' => $invoiceItem
        ]);
    }

    public function byInvoice($id)
    {
        $invoice = Invoice::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $invoice ->invoice_items,
        ]);
    }

    public function get_invoice_item($id)
    {
        $cartItem = CartItem::find($id);
        
        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoice_id=$cartItem->cart_id;
        $invoiceItem->product_id=$cartItem->product_id;
        $invoiceItem->discount=$cartItem->discount;
        $invoiceItem->quantity=$cartItem->quantity;
        $invoiceItem->price=$cartItem->price;
        $invoiceItem->save();
        
        $cartItem->delete();

        return response()->json([
            'status' => 'get invoice item successfully',
            'data' => $invoiceItem,
        ]);
    }
}
