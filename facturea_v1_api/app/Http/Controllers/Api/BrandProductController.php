<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BrandProduct;
use Illuminate\Http\Request;

class BrandProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$brandProduct = BrandProduct::all();
        $brandProduct = BrandProduct::with(['Provider'])->get();
        return $brandProduct;
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

            'name' => 'required|max:255',
            'provider_id' => 'required',
            'status' => 'required'
        ]);

        BrandProduct::create($request->all());
        $brandProduct = BrandProduct::with(['Provider'])->latest()->first();
        return $brandProduct;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function show(BrandProduct $brandProduct)
    {
        $brandProduct = BrandProduct::with(['Provider'])->findOrFail($brandProduct->id);
        return $brandProduct;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BrandProduct $brandProduct)
    {
        $request->validate([

            'name' => 'required|max:255',
            'provider_id' => 'required',
            'status' => 'required'

        ]);

        $brandProduct->update($request->all());
        //$brandProduct = BrandProduct::with(['Provider'])->latest()->first();
        return $brandProduct::with(['Provider'])->findOrFail($brandProduct->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrandProduct $brandProduct)
    {
        $brandProduct->delete();
        return $brandProduct;
    }
}
