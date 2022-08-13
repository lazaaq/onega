<?php

namespace App\Http\Controllers;

//use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Validation\Rule;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::with('cart_items')->get();
        return response()->json([
            'status' => 'success',
            'data' => $carts,
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
        $cart = Cart::create($request->all());

        return response()->json([
            'status' => 'Cart added successfully',
            'data' => $cart,
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
        $cart = Cart::with('cart_items.product.discount')->find($id);
        return response()->json([
            'status' => 'data retrieved successfully',
            'data' => $cart,
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
        
        $cart = Cart::findOrFail($id);
        $cart->update($request->all());
        return response()->json([
            'status' => 'data updated successuflly',
            'data' => $cart,
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
        $cart = Cart::find($id);
        $cart_items = CartItem::where('cart_id', $cart->id)->get()->all();

        foreach($cart_items as $cart_item){
            $cart_item->delete();
        }
        $cart->delete();

        return response()->json([
            'status' => 'data deleted successuflly',
            'data' => null,
        ]);
    }

    public function getByCustomer($customerId) {
        $carts = Cart::with('cart_items.product.discount')->where('customer_id', $customerId)->first();
        return response()->json([
            'status' => 'success',
            'data' => $carts,
        ]);
    }

}
