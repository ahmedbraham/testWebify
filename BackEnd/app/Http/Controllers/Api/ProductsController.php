<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{


    public function index()
    {
        //  $productsList =   Product::all();
        $productsList = Product::select('name', 'image')->get();
        return response()->json([
            'code' => '01',
            'message' => 'list of all products returned with success',
            'error' => null,
            'data' => [
                'products' => $productsList
            ]
        ], 200);
    }


    // get all detail of one product
    public function detail($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'code' => '01',
                'message' => 'your product details are returned with success',
                'status' => '200',
                'data' => [
                    'product' => $product
                ]
            ], 200);

        } else {
            return response()->json([
                'code' => '02',
                'message' => 'sorry, this product does not exist',
                'status' => '200',
                'data' => null
            ], 200);
        }
    }


}
