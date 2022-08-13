<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with('discount')->get();
        return response()->json([
            'status' => 'success',
            'data' => $product,
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
            'sku_code'=> 'required|string',
            'product_name'=> 'required|string',
            'description'=> 'string',
            'unit_price'=> 'required|numeric',
            'discount_id'=> 'integer',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $product = Product::create($request->all());

        return response()->json([
            'status' => 'data added successfully',
            'data' => $product,
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
        $product = Product::find($id);
        return response()->json([
            'status' => 'data retrieved successfully',
            'data' => $product,
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
            'sku_code'=> 'string',
            'product_name'=> 'string',
            'description'=> 'string',
            'unit_price'=> 'numeric',
            'discount_id'=> 'integer',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json([
            'status' => 'data upddated successfully',
            'data' => $product,
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
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'status' => 'data deleted successuflly',
            'data' => null,
        ]);
    }
}
