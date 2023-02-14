<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReciveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $img_source = public_path('my/images/logo.png');
        $imgbinary = fread(fopen($img_source, "r"), filesize($img_source));
        $img_base64 = base64_encode($imgbinary);

        $data = $request->all();
        $data['img'] = $img_base64; // Agrego al img al array

        $type_sale = [

            1 => 'CONTADO',
            2 => 'CREDITO'
        ];

        $data['type_sale'] = $type_sale[$request->type_sale]; // Agregamos el tipo de vta al array de datos

        is_null($data['delivery']) ? $data['delivery'] = 0 : '';
        is_null($data['countdown']) ? $data['countdown'] = 0 : $data['countdown'] = $data['total'] * $data['countdown']  / 100;

        //return $data;

        view()->share('PDFs.recives',$data);

        $pdf = PDF::loadView('PDFs.recives', ['data' => $data], ['img', $img_base64])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->setPaper('A4','portrait');

        return $pdf->stream();


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
