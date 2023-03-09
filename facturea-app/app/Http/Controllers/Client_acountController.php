<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Client_acountController extends Controller
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
    public function index(Request $request, $id)
    {

        $token = $request->cookie('facturea_token');

        $response_payments = $this->client->request('GET','payments/'.$id, [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $response_products = $this->client->request('GET','products', [
            'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
            //'body' => json_encode($data),
            ]);

        $payments = json_decode($response_payments->getBody(), true);
        $products = json_decode($response_products->getBody(), true);

        return view('client_acount')
        ->with('products',$products)
        ->with( 'payments', $payments);



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
}
