<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RECIBO</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"><img src="data:image/jpg;base64,  {{ $data['img'] }} " alt="" width="150"></td>
        <td align="center">
            <h1>R E C I B O</h1>
            <small>No valido como factura</small>
        </td>
        <td align="right">
            <pre>
                Facturea SA.
                OnLyne 123
                3408675665
                Argentina
                CUIT: 20-29850521-6
            </pre>
        </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td>
            <strong>De:</strong> Facturea SA <br>
            <strong>CUIT:</strong> 20-2985052-1 <br>

        </td>
        <td>
            <strong>Para:</strong> {{ $data['name'] }} <br>
            <strong>CUIT/L:</strong> 23-39058125-4  <br>
        </td>
        <td><strong>Fecha:</strong> {{ $data['date_sale'] }} </td>
    </tr>

  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Precio U $</th>
        <th>Total $</th>
      </tr>
    </thead>
    <tbody>


        @for ($i = 0 ;  $i < $data['cant_input'] ; $i ++)
            <tr>
                <td align="left">{{ $data["detail-".$i.""] }}</td>
                <td align="right">{{ $data["cant-".$i.""] }}</td>
                <td align="right">{{ $data["price_unit-".$i.""] }} </td>
                <td align="right">{{ $data["sub_total-".$i.""] }}</td>
            </tr>

        @endfor
      <tr><td><p></p></td></tr>
    </tbody>
    <p><strong>Tipo de venta: </strong> {{ $data['type_sale'] }}

        @if ($data['type_sale'] == 'CREDITO')

            <strong>/ Entrega: </strong> {{ '$ '.$data['delivery'] }} /
            <strong>Saldo a pagar:  </strong>
                {{

                    $data["total"] > $data["delivery"]   ?
                    '$ '.$data["total"] - $data["delivery"]
                    : 0
                }}
    @endif
    </p>
    <tfoot style="border: solid 0.5px #ccc;">
        <tr>
            <td colspan="2"> </td>
            <td align="right">Sub total $</td>
            <td align="right">{{ $data["total"] }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right">Descuento</td>
            <td align="right">{{ $data["countdown"] == 0 ? ' - ' : $data["countdown"] }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right">  Total $ </td>
            <td align="right" class="gray"> {{ $data["total"] - $data["countdown"] }}</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>


