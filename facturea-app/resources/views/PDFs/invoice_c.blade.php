{{-- @php
    echo "<img src='data:image/jpg;base64, ".$img_afip." alt='' width='80'>";
    return;

@endphp --}}

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RECIBO</title>

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





</style>

</head>
<body>

    <div class="box-small">

        <div style="font-size:40px; height:70%;"><strong>C</strong></div>
        <div style="font-size:12px; padding-bottom:2px;"><strong>COD. 011</strong></div>

    </div>

    <table class="cabezal">
        <tr>
            <strong style="font-size:20px">ORIGINAL</strong>
        </tr>
    </table>
    <div style="margin-bottom: 162px;">
        <table class="box-left">
            <h1 style="margin-left: 8%; margin-right:12%;">CESAR RENE SANCHEZ</h1>
            <tr>
                <div style="margin-top: 16px; margin-left:7px;"> <b>Razon Social:</b> SANCHEZ CESAR RENE</div>
                <div style="margin-top: 16px; margin-left:7px;"> <b>Domicilio Comercial:</b> Chacabuco 1563 - San Cristobal, Santa Fe</div>
                <div style="margin-top: 16px; margin-left:7px;"> <b>Condicion frente al IVA: Responsable de Monotributo </b></div>

            </tr>
        </table>
        <table class="box-right">
            <h1 style="margin-left: 15%; margin-right:10%;">FACTURA</h1>
            <tr>
                <div style="margin-left:15%;"> <b>Punto de Venta: 0000x &nbsp;&nbsp;&nbsp;&nbsp; Comp. Nro. 0000000X</b></div>
                <div style="margin-top: 8px; margin-left:15%;"> <b>Fecha de Emision: &nbsp;&nbsp; xx/xx/xxxx</b></div>
                <div style="margin-top: 8px; margin-left:15%;"> <b>CUIT: </b> xx-xxxxxxxx-x</div>
                <div style="margin-left:15%;"> <b>Ingresos Brutos: </b> xx-xxxxxxxx </div>
                <div style="margin-bottom:3px ;margin-left:15%;"> <b>Fecha de Inicio de Activedad:</b>  &nbsp;&nbsp;&nbsp;&nbsp; xx/xx/xxxx</div>

            </tr>
        </table>
    </div>

    <div>
        <table width="100%; padding-left: 7px; padding-top: 4px; padding-bottom: 4px;">
              <tr>
                <td style="width: 33.33%;"><b>Periodo Facturado desde: </b> 13/12/2022 </td>
                <td style="width: 20.33%;"><b>Hasta:</b> 13/12/2022 </td>
                <td style="width: 33.33%;"><b>Fecha de Vto. para el pago</b> 13/12/2022 </td>

              </tr>
        </table>
    </div>

    <div style="margin-top:2px">
        <table style="100%; padding-left: 7px; padding-top: 7px; width: 100%; border-bottom:0px;"  >
            <tr>
                <td width="37%">
                    <b>CUIT:</b> 20-26358789-6
                </td>
                <td width="63%">
                    <b>Apellido y Nombre / Razón Social:</b> ARGENTINA CLAIMS SERVICES S.A
                </td>
            </tr>

        </table>
        <table style="100%; padding-left: 7px; padding-top: 7px; width: 100%; border-top:0px;">
            <tr>
                <td width="52%">
                    <b>Condicion Frente al IVA:</b> IVA Responsable Inscripto
                </td>
                <td width="48%">
                   <b>Domicilio: </b> Callao Av. 569 Piso:4 - Capital Federal, Ciudad de Buenos Aires
                </td>
            </tr>
            <tr> <td><b>Condición de venta: </b> Contado </td></tr>

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
        @for ($i = 0 ; $i < 14  ; $i ++ )
            <tbody style="font-size:9.5px;">

                <td style="padding-top: 6px; text-align: left"> 001 </td>
                <td style="padding-top: 6px; text-align: left"> Servicios Profesionales - Desarrollo de Software </td>
                <td style="padding-top: 6px; text-align: right"> 1,00 </td>
                <td style="padding-top: 6px; text-align: center"> otras unidades </td>
                <td style="padding-top: 6px; text-align: right"> 300000,00 </td>
                <td style="padding-top: 6px; text-align: center"> 0,00 </td>
                <td style="padding-top: 6px; text-align: right"> 0,00 </td>
                <td style="padding-top: 6px; text-align: right"> 300000,00 </td>

            </tbody>
        @endfor

    </table>

    <footer style="position:fixed; left:0; bottom:0; width:100%;">
        <table width='100%' style="border: solid 1.5px black; font-size: 13px; padding-top: 35px; padding-bottom: 8px">

             <tr>
                 <th width='85%' style="text-align: right; padding: 5px;"> Subtotal: $ </th>
                 <th width='15%' style="text-align: right; padding: 5px;"> 300000,00 </th>

             </tr>
             <tr>
                 <th width='85%' style="text-align: right; padding: 5px;"> Importe Otros Tributos: $ </th>
                 <th width='15%' style="text-align: right; padding: 5px;"> 0,00 </th>

             </tr>
             <tr>
                 <th width='85%' style="text-align: right; padding: 5px;"> Importe Total: $ </th>
                 <th width='15%' style="text-align: right; padding: 5px;"> 300000,00 </th>

             </tr>
        </table>

        <table width="100%" style="border: 0px;" >
            <tr>
              <td rowspan="3" width='30'>
                @php
                    echo "<img src='data:image/jpg;base64, ".$img." alt='' width='100' height='100' >";

                @endphp
              </td>
              <td rowspan="2" width='30'>
                @php
                    echo "<img src='data:image/jpg;base64, ".$img_afip." alt='' width='130' height='40' >";

                @endphp

              </td>

              <td></td>
              <td style="text-align: right; font-size: 14px;"><b> Pág. 1/1 </b></td>
              <td style="text-align: right; font-size: 14px;"><b>CAE N°: <br> Fecha de Vto. de CAE: </b> </td> <td style="font-size: 14px;">&nbsp; 72506465134705 <br> &nbsp; 23/12/2022</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td> <td>&nbsp;</td>

            </tr>
            <tr>
                <td colspan="4"><b><i>Comprobante Autorizado</i></b><br>
                    <span style="font-size: 9px" >
                        <b><i>Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación</i></b>
                    </span>
                </td>
               <td>&nbsp;</td>
            </tr>
          </table>
    </footer>




</body>
</html>


