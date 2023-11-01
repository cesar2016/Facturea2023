<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function daily_cash(){


        $reports = Payment::whereDate('date_payment', now())
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->get();


        $date = $reports[0]->date_payment; //'2023-10-31 10:10:10';
        $date_format = Carbon::parse($date)->format('d-m-Y');


        return response()->json([
                'report' => $reports,
                'date_format' => $date_format,
                'street_cash' => $this->street_cash(),
                'sum_debt' => $reports->sum('debt'),
                'sum_payment' => $reports->sum('payment'),
                'sum_countdown' => $reports->sum('countdown'),

            ]);
    }

    public function frame_cash(Request $request){

        $reports = Payment::whereDate('date_payment', '>=', $request->from)
            ->whereDate('date_payment', '<=', $request->until)
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->get();



        return response()->json([
                'report' => $reports,
                'street_cash' => $this->street_cash(),
                'sum_debt' => $reports->sum('debt'),
                'sum_payment' => $reports->sum('payment'),
                'sum_countdown' => $reports->sum('countdown'),

            ]);
    }

    public function street_cash(){

        $sum_total_debt = Payment::all()->where('status', 1)->sum('debt');
        $sum_total_payment = Payment::all()->where('status', 1)->sum('payment');
        $sum_total_countdow = Payment::all()->where('status', 1)->sum('countdown');

        return ($sum_total_debt - $sum_total_countdow) - $sum_total_payment;

    }
}
