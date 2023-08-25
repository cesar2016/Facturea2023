<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

    }
    public function index(Request $request)
    {
        $token = $request->cookie('facturea_token');
        $response = $this->client->request('GET','clients', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $responsePayments = $this->client->request('GET','payments', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $datePayments = json_decode($responsePayments->getBody(), true);


        if( count($datePayments) > 0){
            $days_expired = $this->expired_date($datePayments);
        }else{
            $days_expired = '';
        }


        //$clients = $raw_response->getBody()->getContents();
        $clients = json_decode($response->getBody(), true);

        //$clients = array_push($clients, $days_expired);

         //return $clients;
        //$clients = ['nombre' => 'cesar sanchez', 'edad'=> 40];
        return view('clients', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // ## FUNCION PARA MANEJAR LOS PAYMENTS - Vencimientos

    public function expired_date($datePayments){




        foreach ($datePayments as $item) {

            // Obtenga la fecha actual
            $fechaActual = Carbon::now();

            // Obtenga la fecha especificada en la pregunta
            $dates = Carbon::parse($item['date_payment']);

            // Calcule la diferencia en días
            $days = $dates->diffInDays($fechaActual);

            //Despliegue el resultado
            //echo "Han pasado $diferenciaEnDias días desde la fecha especificada.<br>";

            $arr[] = [

                'clinet_id' => $item['client_id'],
                'days' => $days
            ];
        }


        return $arr;

    }



}
