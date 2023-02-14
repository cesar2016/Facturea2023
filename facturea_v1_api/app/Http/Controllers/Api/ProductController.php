<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {


            $products = Product::with(['Category', 'BrandProduct'])->get();

            if($products){
                return $products;

            }else{

                throw new Exception(response("Error Processing Request", 1));

            }

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //return $request;
        $request->validate([

            'code' => 'string|unique:products',
            'name' => 'required|max:255',
            'stock' => 'numeric',
            'price_purchase' => 'numeric',
            'price_sale' => 'numeric',
            'status' => 'required|string',
            'date_purchase'=> 'date_format:Y-m-d',
            'category_id' => 'required|numeric',
            'brand_product_id' => 'required|numeric',


        ]);

        Product::create($request->all());
        $products = Product::with(['Category', 'BrandProduct'])->latest()->first();
        return $products;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $products = Product::with(['Category', 'BrandProduct'])->findOrFail($product->id);
        return $products;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([

            'code' => 'string|unique:products,code,'.$product->id,
            'name' => 'required|max:255',
            'stock' => 'numeric',
            'price_purchase' => 'numeric',
            'price_sale' => 'numeric',
            'status' => 'required|string',
            'date_purchase'=> 'date',
            'category_id' => 'required|numeric',
            'brand_product_id' => 'required|numeric',

        ]);

        $product->update($request->all());
        $products = Product::with(['Category', 'BrandProduct'])->findOrFail($product->id);
        return $products;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }
}
