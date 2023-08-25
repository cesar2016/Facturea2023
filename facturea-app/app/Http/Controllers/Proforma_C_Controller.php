<?php


namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Exception;
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
    public function __construct(Client $client)
    {
        $this->client = $client;

    }

    public function create_invoice_c(Request $request)
    {


        $numeros = array(
            20002307554,
            20002460123,
            20188192514,
            20221062583,
            20200083394,
            20220707513,
            20221124643,
            20221064233,
            20201731594,
            20201797064,
            20203032723,
            20168598204,
            20188153853,
            20002195624,
            20002400783,
            20187850143,
            20187908303,
            20187986843,
            20188027963,
            20187387443,
            30202020204,
            30558515305,
            30558521135,
            30558525025,
            30558525645,
            30558529535,
            30558535365,
            30558535985,
            30558539565,
            30558564675
        );

        $token = '6|PGZfG7fmEABZzP4qiLVH9PlsKSuXaohcQg0Df3uN';
        $response = $this->client->post('http://44.204.35.177/api/datesPerson', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],

            'json' => [
                        // Errro monot. 20201797064
                        "cuitl" => $numeros[rand(0,29)],
                        "condition_front_iva" => ''

                    ],

        ]);


        return json_decode($response->getBody(), true);

        return;

        // Para consumidos final no hace falta datos del cliente
        // Para Iva Responsable Inscripto -> buscar en el padron 04

        $diez = 10;
        $cien = 100000;
        $qu = 1;

        $all = [

        //     ['code' => 110,
        //     'prod_serv' => 'Producto_1',
        //     'quantity' => 2,
        //     'unit_extent'=> '',
        //     'unit_price' => 200,
        //     'bonus' => '',
        //     'imp_bonus' => '',
        //     'sub_total' => 400],

        //     ['code' => 111,
        //     'prod_serv' => 'Producto_2',
        //     'quantity' => 2,
        //     'unit_extent'=> '',
        //     'unit_price' => 300,
        //     'bonus' => '',
        //     'imp_bonus' => '',
        //     'sub_total' => 600],

             [
                'code' => '',
                'prod_serv' => 'Servicio Informaticos - Desarrollo de Software',
                'quantity' => number_format($qu, 2, ',', ''),
                'unit_extent'=> 'otras unidades',
                'unit_price' => number_format($diez, 2, ',', ''),
                'bonus' => '',
                'imp_bonus' => '',
                'sub_total' => number_format($cien, 2, ',', '')
             ]


        ];


        // $all = [];
        // $diez = 10;
        // $cien = 100;
        // for ($i=1; $i <= 20; $i++) {

        //     $all[] = [

        //     'code' => $i,
        //      'prod_serv' => 'Producto, Item al azar descripciondel producto N°'. $i,
        //      'quantity' => $i,
        //      'unit_extent'=> 'otras unidades',
        //      'unit_price' => number_format($diez + $i, 2, ',', ''),
        //      'bonus' => '',
        //      'imp_bonus' => '',
        //      'sub_total' => number_format($cien + $i, 2, ',', '')

        //     ];
        // }

        $details = array_chunk($all, 13);


        $token = '6|PGZfG7fmEABZzP4qiLVH9PlsKSuXaohcQg0Df3uN';
        $response = $this->client->post('http://44.204.35.177/api/proforma_c', [
        'headers' => [ 'Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token ],

            'json' => [
                        "date_emition"               => date('Y-m-d'), // Emision de la fac (Pueden ser: fecha de hoy > o < 10 ) -> NO permite ser NULL
                        "date_init"                  => date('Y-m-01'), // Inicio del servicio : desde -> NO permite ser NULL
                        "date_end"                   => date('Y-m-30'), // Fin del servicio : hasta -> NO permite ser NULL
                        "date_expired"               => date('Y-06-10'), // Vencimiento del pago de la fac -> NO permite ser NULL
                        "type_concept"               => 3, // 1)_Productos, 2)_ Servicios, 3)_ productos y servicios
                        "currencies_types"           => "PES",
                        "id_tax"                     => 1,
                        "type_doc"                   => 99,
                        "indetification_client"      => 26435789,
                        "firstname"                  => "Augusto",
                        "lastname"                   => "Catedral",
                        "address_comerce"            => "Gral Dorrego 3082, Andaluz, CABA",
                        "condition_sale"             => 1,
                        "iva_front_condition_client" => "Consumidor final",
                        "details"                    => $details, //Arr()
                        "total_amount"               => number_format(1500, 2, ',', '')
                    ],

        ]);




        //$clients = $raw_response->getBody()->getContents();
       return $dates_proforma_c = json_decode($response->getBody(), true);

        $logo_enterprise = public_path('my/images/logo.png');
        $imgbinary_log_enterprice = fread(fopen($logo_enterprise, "r"), filesize($logo_enterprise));
        $img_base64_enterprise = base64_encode($imgbinary_log_enterprice);


        $img_source_afip = public_path('my/images/afip_logo.jpeg');
        $imgbinary_afip = fread(fopen($img_source_afip, "r"), filesize($img_source_afip));
        $img_base64_afip = base64_encode($imgbinary_afip);

        $image = file_get_contents("https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=".$dates_proforma_c['code_QR']."") ;
        $img_base64 = base64_encode($image);

        view()->share('PDFs.invoice_c');


        // $pdf = PDF::loadView('PDFs.invoice_c', ['img' => $img_base64], ['img_afip' => $img_base64_afip], ['my' => json_encode($dates_proforma_c)])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('PDFs.invoice_c', ['data' => $dates_proforma_c], ['img' => $img_base64, 'img_afip' => $img_base64_afip, 'img_enterprise' => $img_base64_enterprise] )->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->setPaper('A4');

        return $pdf->stream();
        /////////       create_invoice_c
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
