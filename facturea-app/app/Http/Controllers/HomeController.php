<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function env_js(Request $request)
    {
        $url = env('API_URL');
        $facturea_token = $request->cookie('facturea_token');

        return response([
            'URI_API' => $url,
            'TOKEN' => $facturea_token
        ]);

    }

}
