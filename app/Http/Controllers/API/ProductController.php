<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productname' => 'required|max:50',
            'productcode' => 'required|max:8|min:4',
            'productdescription' => 'required|max:191',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validate_err' => $validator->messages(),
            ]);
        } else {
            $product = new Product;
            $product->productname = $request->input('productname');
            $product->productcode = $request->input('productcode');
            $product->productdescription = $request->input('productdescription');
            $product->price = $request->input('price');
            $product->stok = $request->input('stok');
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product has been added!',
            ]);
        }

    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product ID Found!',
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'productname' => 'required|max:50',
            'productcode' => 'required|max:8|min:4',
            'productdescription' => 'required|max:191',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validate_err' => $validator->messages(),
            ]);
        } else {

            $product = Product::find($id);
            if ($product) {
                $product->productname = $request->input('productname');
                $product->productcode = $request->input('productcode');
                $product->productdescription = $request->input('productdescription');
                $product->price = $request->input('price');
                $product->stok = $request->input('stok');
                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product has been updated!',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Product ID Found!',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product has been deleted!',
        ]);
    }
}