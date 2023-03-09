<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store_pay_account(Request $request)
    {

        $payment = new Payment();
        $payment->client_id = $request->client_id;
        $payment->date_payment = $request->date_pay;
        $payment->payment = number_format($request->importe, 2, '.', '');
        $payment->save();

        return $payment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = Payment::where('client_id',$id)
        ->with(['Client'])
        ->get();

        if($payments->count() > 0){

            return response()->json($payments->toArray());

        }else{

            return response()->json(['msg'=>'error']);

        }



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

    public function calculator_totals($client_id)
    {

        //return $client_id;
        $debt = DB::table('payments')->where('client_id', $client_id)->sum('debt');
        $payments = DB::table('payments')->where('client_id', $client_id)->sum('payment');
        $countdown = DB::table('payments')->where('client_id', $client_id)->sum('countdown');

        $plus = $countdown + $payments;

        $total_debt = $debt - $plus;

        return response()->json(['total_debt' => $total_debt]);


    }
}
