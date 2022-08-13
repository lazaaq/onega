<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = Discount::all();
        return response()->json([
            'status' => 'success',
            'data' => $discount,
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
            'name'=> 'required|string',
            'discount_amount'=> 'numeric',
            'discount_percent'=> 'numeric',
            'type'=>'required|enum',
            'is_active'=> 'required|boolean',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $discount = Discount::create($request->all());

        return response()->json([
            'status' => 'data added successfully',
            'data' => $discount,
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
        $discount = Discount::find($id);

        return response()->json([
            'status' => 'data retrieved successfully',
            'data' => $discount,
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
            'name'=> 'string',
            'discount_amount'=> 'numeric',
            'discount_percent'=> 'numeric',
            'type'=>'enum',
            'is_active'=> 'boolean',
        ];
        $validator = Validator::make($request->all(),$rules);

        $discount = Discount::find($id);
        $discount->update($request->all());

        return response()->json([
            'status' => 'data updated successfully',
            'data' => $discount,
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
        $discount = Discount::find($id);
        $discount->delete();

        return response()->json([
            'status' => 'data deleted successfully',
            'data' => $discount,
        ]);
    }
}
