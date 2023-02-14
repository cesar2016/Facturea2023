<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Brand_categoryController extends Controller
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
        $response = $this->client->request('GET','providers', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $token = $request->cookie('facturea_token');
        $response_categories = $this->client->request('GET','categories', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $token = $request->cookie('facturea_token');
        $response_brandProducts = $this->client->request('GET','brandProducts', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);


        $providers = json_decode($response->getBody(), true);
        $categories = json_decode($response_categories->getBody(), true);
        $brandProducts = json_decode($response_brandProducts->getBody(), true);

        return view('brand_categories')
        ->with('brandProducts',$brandProducts)
        ->with('providers',$providers)
        ->with('categories',$categories);

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
}
