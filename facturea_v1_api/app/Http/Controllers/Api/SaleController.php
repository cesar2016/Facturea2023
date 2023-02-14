<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sale = Sale::all();
        return $sale;
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

            'indentificator_sale'=> 'required|numeric',
            //'date_sale'=> 'required|date|nullable',
            'cuantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'type_sale_id' => 'required|numeric',
            'client_id'  => 'required|numeric',
            'product_id'  => 'required|numeric',
            'status'  => 'required',

        ]);

        $sale = Sale::create($request->all());
        return $sale;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */

    // # Busqueda por ID de Sale
    public function show(Sale $sale)
    {
        $sale = Sale::with(['Client', 'Product'])->findOrFail($sale->id);
        return $sale;

    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([

            'indentificator_sale'=> 'required|numeric',
            //'date_sale'=> 'required|date|nullable',
            'cuantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'type_sale_id' => 'required|numeric',
            'client_id'  => 'required|numeric',
            'product_id'  => 'required|numeric',
            'status'  => 'required',

        ]);

        $sale->update($request->all());
        return $sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return $sale;
    }
}
