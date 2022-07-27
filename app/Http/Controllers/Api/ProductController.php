<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\mst_products;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = mst_products::all();
        return response()->json([
            ['data' => $products],
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    public function show($id)
    {
        $product = mst_products::where('product_id', $id)->first();
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found!'
            ]);
        }
        return response()->json([
            'data' => [$product],
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    //ten
    //gia
    //mo ta
    //hinh anh
    //trang thai
    public function store(Request $request)
    {
        $firstCharProduct = mb_substr($request->product_name, 0, 1);
        $id = IdGenerator::generate(['table' => 'mst_products', 'field' => 'product_id', 'length' => 10, 'prefix' => $firstCharProduct]);
        if ($request->file('product_image')) {
            $file = $request->file('product_image');
            $name = $file->getClientOriginalName();
            $images = Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis') . $name;
            $file->move("upload/product", $images);
            // $product->product_image = $images;
        }
        $product = mst_products::create([
            'product_id' => $id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'description' => $request->description,
            'product_image' => $images,
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);
        return response()->json([
            ['data' => $product],
            'status' => 201,
            'message' => 'Created data successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        $product = mst_products::where('product_id', $id)->first();
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found!'
            ]);
        }
        $images = '';
        if ($request->file('product_image')) {
            $file = $request->file('product_image');
            $name = $file->getClientOriginalName();
            $images = Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis') . $name;
            $file->move("upload/product", $images);
        }
        if ($images != '') {
            $product->update($request->all(), ['product_image' => $images, 'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        }
        $product->update($request->all(), ['updated_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        return response()->json([
            ['data' => $product],
            'status' => 200,
            'message' => 'Updated data successfully!'
        ]);
    }
    public function destroy($id)
    {
        $product = mst_products::where('product_id', $id)->first();
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found!'
            ]);
        }
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Deleted data successfully!'
        ]);
    }
}
