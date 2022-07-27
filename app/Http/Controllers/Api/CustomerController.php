<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\mst_customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = mst_customers::all();
        return response()->json([
            'data' => $customers,
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    public function show($id)
    {
        $customer = mst_customers::where('customer_id', $id)->first();
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found!'
            ]);
        }
        return response()->json([
            ['data' => $customer],
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    public function store(Request $request)
    {

        $customer = mst_customers::create(
            [
                'customer_name' => $request->name,
                'address' => $request->address,
                'tel_num' => $request->phone,
                'email' => $request->email
            ]
        );
        return response()->json([
            'data' => $customer,
            'status' => 201,
            'message' => 'Created data successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        $customer = mst_customers::where('customer_id', $id)->first();
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found!'
            ]);
        }
        $customer->update(
            $request->all()
        );
        return response()->json([
            'data' => $customer,
            'status' => 200,
            'message' => 'Updated data successfully!'
        ]);
    }
    public function destroy($id)
    {
        $customer = mst_customers::where('customer_id', $id)->first();
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found!'
            ]);
        }
        $customer->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Deleted data successfully!'
        ]);
    }
}
