<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct(Client $client)
    {
        $this->middleware('guest')->except('logout');
        $this->client = $client;
    }

    public function testing(Request $request)
    {


        // //$url = "https://api.datos.gob.mx/v1/precio.gasolina.publico";


        // $client = new Client([
        //     'base_uri' => 'http://192.168.1.18:9001/v1/',
        //     'time' => 2.0
        // ]);

        $response = $this->client->request('GET','payments' );
        return json_decode($response->getBody());

    }

    public function login(Request $request)
    {
        return $request;
    }
}
