@extends('adminlte::page')

@section('title', 'Clientes')

@section('css')
    {{-- Aca se definen los CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('my/css/...') }}"> --}}

    {{-- Data Tablet --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"> --}}

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet" />

      {{-- Slect inptus --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>

@stop


@section('content_header')
    @if (!@$payments['msg'])
        <h1>Historial de cuenta de: {{ $payments[0]['client']['name'] }} {{ $payments[0]['client']['lastname'] }} </h1>
    @endif
@stop

@section('content')

    @if (!@$payments['msg'])

        <h1><span id="view_total_debt"></span> </h1>
        <div class="row">
            <div class="col-12">
                <form class="form-inline" name="form_insert_pay" id="form_insert_pay">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="sr-only">pay</label>
                    </div>
                    <input type="datetime-local" class="form-control" value="<?php echo date('Y-m-d h:m:s'); ?>" name="date_pay"
                        id="date_pay" placeholder="Fecha. Cpra.">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="inputPassword2" class="sr-only">$ Insertar pago</label>
                        <input type="number" name="importe" id="importe" class="form-control"
                            placeholder="$ Insertar pago">
                        <input type="text" hidden name="client_id" id="client_id"
                            value="{{ $payments[0]['client']['id'] }} ">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2" id="btn-form-new-pay">
                        Enviar <i class="fa fa-money-bill"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr>
        <table id="payments" class="table table-striped table-bordered table" style="width:100%">
            <thead>
                <tr>
                    <th>Venta N° | Pago</th>
                    <th>Importe cpra.</th>
                    <th>Entrega</th>
                    <th>Descuento</th>
                    <th>Fecha cpra.</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)

                    @php
                         $row = $payment['identificator_sale'] ? $payment['identificator_sale'] : $payment['id'];
                    @endphp

                    <tr id="{{ 'row' . $row }}" @if (!$payment['identificator_sale'])  @endif>
                        <td>

                            @if (!$payment['identificator_sale'])
                                <i class="fa fa-check text-success"></i>
                            @else
                                {{ $payment['identificator_sale'] }}
                            @endif

                        </td>
                        <td>{{ $payment['debt'] == 0 ? ' - ' : ' $ ' . $payment['debt'] }}</td>
                        <td>{{ $payment['payment'] == 0 ? ' - ' : ' $ ' . $payment['payment'] }}</td>
                        <td>{{ $payment['countdown'] == 0 ? ' - ' : ' $ ' . $payment['countdown'] }}</td>
                        <td>{{ date('d-m-Y h:m:s', strtotime($payment['date_payment'])) }}</td>
                        <td>

                            @if ($payment['identificator_sale'])
                                <button id='btn_view_buy' name="btn_view_buy" value="{{ $payment['identificator_sale'] }}"
                                    class='btn btn-sm' type="button" data-toggle="modal"
                                    data-target=".bd-example-modal-lg">
                                    <i class='fa fa-file-invoice'> </i>
                                </button>
                            @endif

                            {{-- Este elimina la venta completa --}}
                            @if ($payment['identificator_sale'])
                                <button id='btn_delete' value="{{ $payment['identificator_sale'] }}" class='btn btn-sm'
                                    type="button" data-toggle="modal" data-target="#updateModal">
                                    <i class='fa fa-trash text-danger '></i>
                                </button>
                            @else

                            {{-- Este Elimina un pago --}}
                                <button id='btn_delete_pay' value="{{ $payment['id'] }}" class='btn btn-sm'
                                    type="button" data-toggle="modal" data-target="#updateModal">
                                    <i class='fa fa-trash text-danger '></i>
                                </button>

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

    @if (@$payments['msg'])
        <strong> El cliente aun no tiene movimientos en su cuenta </strong>
    @endif



    <!-- Modal del detalle de la compra -->
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de la compra # <span id="number_buy"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="capa-form-update" class="container jumbotron p-2">
                        <form id="form-update-sale">

                            <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label for="date">Fecha</label>
                                    <input class="form-control" id="date" name="date_sale" type="datetime-local">
                                  </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="detail">Detalle</label>

                                    <select class="form-control miSelect1" name="product_id" id="product_id" style='width: 650px;  padding-top:5px;'>
                                        <option disabled selected value="0" id='default1' style="display:none" > Elija categoría... </option>
                                        @foreach($products as $product)
                                            <option value="{{$product['id']}}">{{$product['name']}} <small class="text-sm-danger"> - ${{$product['price_sale']}} </small></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="quantity">Cantidad</label>
                                    <input type="number" class="form-control" id="cuantity" name="cuantity">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label for="unit_price">Precio unitario</label>
                                    <input type="number" class="form-control" id="unit_price" name="unit_price">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label for="total_price">Precio total</label>
                                    <input type="number" class="form-control" id="total_price" name="total_price">
                                  </div>

                            </div>
                            <div class="form-group pt-4">
                                <label for="total_price"></label>
                                <button type="buttom" class="btn btn-primary mb-2" id="btn-form-update-sale">
                                    Enviar <i class="fa fa-money-bill"></i>
                                </button>
                              </div>
                        </form>
                    </div>


                    <table id="table_detail" class="table table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha Cpra</th>
                                <th>Cantidad</th>
                                <th>Detalle</th>
                                <th>Precio U</th>
                                <th>Sub total.</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="buy">
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>



@stop



@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <!-- Toastr.js Después -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/notifications.js') }}"></script>

    <script src="{{ asset('my/js/payments.js') }}"></script>

    <script>

        $(document).ready(function() {
            //$('#payments').DataTable();
            $('#payments').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

        });
    </script>


@stop
