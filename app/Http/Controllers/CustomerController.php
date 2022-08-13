<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
        $cust = Customer::all();
        return response()->json([
            'status' => 'success',
            'data' => $cust,
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
            'code'=> 'required|string|unique',
            'name'=> 'required|string',
            'address'=> 'string',
            'phone_num'=> 'string',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $cust = new Customer;
        $cust->code = $request->code;
        $cust->name= $request->name;
        $cust->address = $request->address;
        $cust->phone_num= $request->phone_num;

        $cust->save();
        return response()->json([
            'status' => 'data added successfully',
            'data' => $cust,
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
        $cust = Customer::find($id);
        if (is_null($cust)){
            return $this->sendError('Customer not found.');
        }
        return response()->json([
            'status' => 'Customer retrieved successfully',
            'data' => $cust,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//menangkap id yang dikirimkan dari form, yaitu ketika tombol edit di klik
    {
        
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
            'code'=> 'string|unique',
            'name'=> 'string',
            'address'=> 'string',
            'phone_num'=> 'string',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        $cust = Customer::findOrFail($id);
        $cust->update($request->all());

        $cust->update();
        return response()->json([
            'status' => 'data updated successuflly',
            'data' => $cust,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //menangkap id yang dikirimkan dari form, yaitu ketika tombol Hapus di klik    
    {
        $customer = Customer::find($id); 
        $customer->delete();

        return response()->json([
            'status' => 'data deleted successuflly',
            'data' => $id,
        ]);
    }

    public function search($keyword)
    {
        $result = Customer::where('code', 'like', '%'.$keyword.'%')->
        orwhere('name', 'like', '%'.$keyword.'%')->orwhere('id', 'like', '%'.$keyword.'%') -> get();
 
        return response()->json($result);
    }

}
