<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = Payment::all();
        return $payment;
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

            'client_id' => 'required|numeric',
            'sale_id' => 'required|numeric',
            'identificator_sale' => 'required|numeric',
            'debt' => 'required|numeric',
            'payment' => 'required|numeric',
            'debt_positive' => 'required|numeric',
            //'data_payment' => 'required|date|nullable',
            'status' => 'required|string'

        ]);

        $payment = Payment::create($request->all());
        return $payment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payment = Payment::with(['Client'])->findOrFail($payment->id);
        return $payment;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([

            'client_id' => 'required|numeric',
            'sale_id' => 'required|numeric',
            'identificator_sale' => 'required|numeric',
            'debt' => 'required|numeric',
            'payment' => 'required|numeric',
            'debt_positive' => 'required|numeric',
            'data_payment' => 'required|numeric',
            'staus' => 'required'

        ]);

        $payment->update($request->all());
        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return $payment;
    }
}
