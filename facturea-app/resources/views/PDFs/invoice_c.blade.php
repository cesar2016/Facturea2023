
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FACTUREA C </title>

<style type="text/css">

    .cabezal{
        text-align: center;
        width: 100%;
        border-top: 1px solid black;
        border-right: 0.1px solid black;
        border-left: 0.1px solid black;
        border-bottom: 0px;
        padding: 7px;

    }

    .box-right{

        border-right: 0.1px solid black;
        border-left: 0.1px solid black;
        border-bottom: 0.1px solid black;
        width:50%;
        border-left:0.1px solid black;
        float:left;

    }

    .box-left{

        border-right: 0.1px solid black;
        border-left: 0.1px solid black;
        border-bottom: 0.1px solid black;
        width:50%;
        border-left:0.1px solid black;
        float:left;

    }

    .box-small {
        position: absolute;
        left: 50%;
        top: 7.1%;

        transform: translate(-50%,-50%);
        width: 65px;
        height: 60px;
        border: 0.1px solid black;
        background-color: #fff;
        text-align: center;

    }
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border: 1px solid black;
    }


    @page {
        margin-top: 0.8cm;
		margin-left: 0.5cm;
		margin-right: 0.5cm;
	}

    /* Salto de pagina */
    .salto{
        page-break-after:always;
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }

    body {
        margin-bottom: 30%; /* ajusta el valor para que coincida con la altura de tu footer */
    }

</style>

</head>
<body>




    @php
        $page = 1;
    @endphp
    @foreach ($data['details'] as $detail )


    <div class="box-small">

        <div style="font-size:40px; height:70%;"><strong>{{ $data['type_invoice'] }}</strong></div>
        <div style="font-size:12px; padding-bottom:2px;"><strong>COD. {{ $data['code_type_invoice'] }}</strong></div>

    </div>

    <table class="cabezal">
        <tr>
            <strong style="font-size:20px">ORIGINAL</strong>
        </tr>
    </table>
    <div style="margin-bottom: 162px;">
        <table class="box-left">
            {{--  LOGO OPCIONAL--}}
                <img style="margin-left: 38%; margin-right:2%; margin-top: 5px;" src="data:image/png;base64,{{ $img_enterprise }}" alt="image" width='62' height='63'/>

            {{-- <h1 style="margin-left: 8%; margin-right:12%; text-transform: uppercase;">{{ $data['razon_social'] }}</h1> --}}
            <tr>
                <div style="margin-top: 10px; margin-left:7px;"> <b>Razon Social:</b> {{ $data['razon_social'] }}</div>
                <div style="margin-top: 16px; margin-left:7px;"> <b>Domicilio Comercial:</b> {{ $data['domicilio'] }}</div>
                <div style="margin-top: 16px; margin-left:7px;"> <b>Condicion frente al IVA: {{ $data['condicion_iva_vendedor'] }} </b></div>

            </tr>
        </table>
        <table class="box-right">
            <h1 style="margin-left: 15%; margin-right:10%;">FACTURA</h1>
            <tr>
                <div style="margin-left:15%;"> <b>Punto de Venta: {{ $data['pto_venta'] }} &nbsp;&nbsp;&nbsp;&nbsp; Comp. Nro. {{ $data['numero_cvte'] }}</b></div>
                <div style="margin-top: 8px; margin-left:15%;"> <b>Fecha de Emision: &nbsp;&nbsp; {{ $data['date_emition'] }}</b></div>
                <div style="margin-top: 8px; margin-left:15%;"> <b>CUIT: </b> {{ $data['cuit'] }}</div>
                <div style="margin-left:15%;"> <b>Ingresos Brutos: </b> {{ $data['iibb'] }} </div>
                <div style="margin-bottom:3px ;margin-left:15%;"> <b>Fecha de Inicio de Actividad:</b>  &nbsp;&nbsp;&nbsp;&nbsp; {{ $data['date_init_actividad'] }}</div>

            </tr>
        </table>
    </div>

    @if ( $data['type_concep'] > 1)
        <div>
            <table width="100%; padding-left: 7px; padding-top: 4px; padding-bottom: 4px;">
                <tr>
                    <td style="width: 33.33%;"><b>Periodo Facturado desde: </b> {{ $data['date_init'] }}</td>
                    <td style="width: 20.33%;"><b>Hasta:</b> {{ $data['date_end'] }} </td>
                    <td style="width: 33.33%;"><b>Fecha de Vto. para el pago</b> {{ $data['date_expired'] }} </td>

                </tr>
            </table>
        </div>
    @endif

    <div style="margin-top:2px">
        <table style="100%; padding-left: 7px; padding-top: 7px; width: 100%; border-bottom:0px;"  >
            <tr>
                <td width="37%">
                    <b>CUIT:</b> {{ $data['number_document'] }}
                </td>
                <td width="63%">
                    <b>Apellido y Nombre / Razón Social:</b> {{ $data['firstname'] }} {{ $data['lastname'] }} </b>
                </td>
            </tr>

        </table>
        <table style="100%; padding-left: 7px; padding-top: 7px; width: 100%; border-top:0px;">
            <tr>
                <td width="52%">
                    <b>Condicion Frente al IVA:</b> {{ $data['condition_iva_buy'] }}
                </td>
                <td width="48%">
                   <b>Domicilio: </b> {{ $data['address_comerce'] }}
                </td>
            </tr>
            <br>
            <tr> <td><b>Condición de venta: </b> {{ $data['condition_sale'] }} </td></tr>

        </table>
    </div>

    <table width='100%' style="margin-top:4px; border-collapse: collapse; border: 0px;" >

        <thead style="background-color: #cccccc; font-size:10px; border: 0.1px solid black; ">

            <td width='11%' style="border-right: 0.1px solid black; padding: 4px; text-align:center;"><b>Código</b></td>
            <td width='35%' style="border-right: 0.1px solid black; padding: 4px;"><b>Producto / Servicio</b></td>
            <td width='16%' style="border-right: 0.1px solid black; padding: 4px; text-align:center;"><b>Cantidad</b></td>
            <td width='11%' style="border-right: 0.1px solid black; padding: 1px; text-align:center;"><b>U. Medida</b></td>
            <td width='25%' style="border-right: 0.1px solid black; padding: 1px; text-align:center;"><b>Precio Unit.</b></td>
            <td width='9%' style="border-right: 0.1px solid black; padding: 2px; text-align:center;"><b>% Bonif</b></td>
            <td width='25%' style="border-right: 0.1px solid black; padding: 4px; text-align:center;"><b>Imp. Bonif.</b></td>
            <td width='25%' style="border-right: 0.1px solid black; padding: 4px; text-align:center;"><b>Subtotal</b></td>

        </thead>

            @for ($i=0; $i < count($detail) ; $i++)

                <thead style="font-size:9.5px;">

                <td width='11%' style="padding-top: 6px; text-align: left">{{ $detail[$i]['code'] }}</td>
                <td width='35%' style="padding-top: 6px; text-align: left">{{ $detail[$i]['prod_serv'] }}</td>
                <td width='16%' style="padding-top: 6px; text-align: right">{{ $detail[$i]['quantity'] }}</td>
                <td width='11%' style="padding-top: 6px; text-align: center">{{ $detail[$i]['unit_extent'] }}</td>
                <td width='25%' style="padding-top: 6px; text-align: right">{{ $detail[$i]['unit_price'] }}</td>
                <td width='9%' style="padding-top: 6px; text-align: center">{{ $detail[$i]['bonus'] }}</td>
                <td width='25%' style="padding-top: 6px; text-align: right">{{ $detail[$i]['imp_bonus'] }}</td>
                <td width='25%' style="padding-top: 6px; text-align: right">{{ $detail[$i]['sub_total'] }}</td>

            </thead>

            @endfor

    </table>


        <footer>
            <table width='100%' style="border: solid 1.5px black; font-size: 13px; padding-top: 35px; padding-bottom: 8px">

                <tr>
                    <th width='85%' style="text-align: right; padding: 5px;"> Subtotal: $ </th>
                    <th width='15%' style="text-align: right; padding: 5px;"> {{ $data['total_amount'] }} </th>

                </tr>
                <tr>
                    <th width='85%' style="text-align: right; padding: 5px;"> Importe Otros Tributos: $ </th>
                    <th width='15%' style="text-align: right; padding: 5px;">0,00 </th>

                </tr>
                <tr>
                    <th width='85%' style="text-align: right; padding: 5px;"> Importe Total: $ </th>
                    <th width='15%' style="text-align: right; padding: 5px;"> {{ $data['total_amount'] }} </th>

                </tr>
            </table>

            <table width="100%" style="border: 0px;" >
                <tr>
                <td rowspan="3" width='30'>

                        <img src="data:image/png;base64,{{ $img }}" alt="image" width='100' height='100'/>

                </td>
                <td rowspan="2" width='30'>

                        <img src="data:image/png;base64,{{ $img_afip }}" alt="image" width='130' height='40'/>

                </td>

                <td></td>
                <td style="text-align: right; font-size: 12px;"><b> Pág. {{ $page ++; }} / {{ count($data['details'])  }} </b></td>
                <td style="text-align: right; font-size: 12px;"><b>CAE N°: <br> Fecha de Vto. de CAE: </b> </td> <td style="font-size: 14px;">&nbsp; {{ $data['cae'] }} <br> &nbsp; {{ $data['expire_cae'] }}</td>
                </tr>
                <tr>
                <td></td>
                <td></td>
                <td></td> <td>&nbsp;</td>

                </tr>
                <tr>
                    <td colspan="4"><b><i>Comprobante Autorizado </i></b><br>
                        <span style="font-size: 9px" >
                            <b><i>Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación</i></b>
                        </span>
                    </td>
                <td>&nbsp;</td>
                </tr>
            </table>
        </footer>
        @if ( $page <= count($data['details']) )

            <div style="page-break-after:always;"></div>

        @endif



    @endforeach





</body>
</html>


