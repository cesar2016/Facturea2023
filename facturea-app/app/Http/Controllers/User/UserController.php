<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
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

    public function index()
    {

    }

    public function registerUser(Request $request)
    {

        $api_uri = config('app.api_uri').'register';
        $response = Http::post($api_uri, [
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
            'password_confirmation' => $request->password_confirmation

        ]);

        return $response;

    }

    public function loginUser(Request $request)
    {

        $api_uri = config('app.api_uri').'login';
        $response = Http::post($api_uri, [

            'email'=> $request->email,
            'password'=> $request->password,
        ]);

        if(@json_decode($response)->message){

            return Redirect::back()->withErrors(['msg' => 'Ups, los datos ingresados son incorrectos']);

        }

        return redirect()->route('home')->cookie('facturea_token', json_decode($response)->access_token, 60);


    }

    public function testing()
    {




        $token = '4|6LMImgFqw0Cfv6QoznsxxOPjwE2fAq8ivtfXAW5P';
        $response = $this->client->post('http://44.204.35.177/api/info_user', [
            'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],



        ]);


        return $getDatesClient = json_decode($response->getBody(), true);


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
    public function showUser(Request $request)
    {
        $token = $request->cookie('facturea_token');
        $raw_response = $this->client->request('POST','showUser', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],
        //'body' => json_encode($data),
        ]);

        $response = $raw_response->getBody()->getContents();
        return $response;
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
    public function destroy()
    {

        $cookieToken = Cookie::forget('facturea_token');
        return response(view('auth.login'))->withCookie($cookieToken);
    }


}
