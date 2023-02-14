<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type_sale;
use Illuminate\Http\Request;

class TypeSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_sale = Type_sale::all();
        return $type_sale;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',
            'status' => 'required',

        ]);

        $type_sale = Type_sale::create($request->all());
        return $type_sale;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type_sale  $type_sale
     * @return \Illuminate\Http\Response
     */
    public function show(Type_sale $type_sale)
    {
        return $type_sale;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type_sale  $type_sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type_sale $type_sale)
    {
        $request->validate([

            'name' => 'required|max:255',
            'status' => 'required',

        ]);

        $type_sale->update($request->all());
        return $type_sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type_sale  $type_sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type_sale $type_sale)
    {
        $type_sale->delete();
        return $type_sale;
    }
}
