<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoce;
use App\Models\InvoiceItem;
use Illuminate\Validation\Rule;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItem = CartItem::with('product','cart')->get();
        return response()->json([
            'status' => 'success',
            'data' => $cartItem
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
            'cart_id'=> 'required|integer',
            'product_id'=> 'required|numeric',
            'discount'=> 'required|numeric',
            'quantity'=> 'required|numeric',
            'subtotal'=> 'numeric',
        ];
        $validator = Validator::make($request->all(),$rules);
        $cartItem = CartItem::create($request->all());

        return response()->json([
            'status' => 'data added successfully',
            'data' => $cartItem,
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

        $cartItem = CartItem::with('cart','product')->find($id);
        return response()->json([
            'status' => 'success',
            'data' => $cartItem
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
            'cart_id'=> 'integer',
            'product_id'=> 'integer',
            'discount'=> 'numeric',
            'quantity'=> 'numeric',
            'subtotal'=> 'numeric',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($request->all());

        $cartItem->update();
        return response()->json([
            'status' => 'data updated successuflly',
            'data' => $cartItem,
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
        $cartItem = CartItem::find($id);
        $cartItem->delete();

        return response()->json([
            'status' => 'data deleted successuflly',
            'data' => null,
        ]);
    }

}
