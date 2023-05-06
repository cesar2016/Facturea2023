<?php


namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class Proforma_C_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_invoice_c(Request $request)
    {

        return Http::get('http://172.19.0.1:8000/api/test');



        $img_source_afip = public_path('my/images/afip_logo.jpeg');
        $imgbinary_afip = fread(fopen($img_source_afip, "r"), filesize($img_source_afip));
        $img_base64_afip = base64_encode($imgbinary_afip);

        // echo $img_base64_afip;
        // return;

        $image = file_get_contents('https://www.shutterstock.com/image-vector/sample-qr-code-icon-vector-600w-529327996.jpg');
        $img_base64 = base64_encode($image);

        view()->share('PDFs.invoice_c');


        $pdf = PDF::loadView('PDFs.invoice_c' /*['data' => $data]*/, ['img' => $img_base64], ['img_afip' => $img_base64_afip])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->setPaper('A4');

        return $pdf->stream();

        //return view('clients', compact('clients'));
        return view('PDFs.invoice_c');


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
