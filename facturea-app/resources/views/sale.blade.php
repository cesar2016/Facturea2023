@extends('adminlte::page')

@section('title', 'VENTAS')

@section('content_header')
    <h1>GENERACION DE COMPROBANTES</h1>
@stop

@section('css')

    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">

    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .ui-menu-item {
            padding: 10px 25px;
            font-size: 16px;
            color: #3d3d3d;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            transition: all 0.2s ease-in-out;
            cursor: pointer;

            &:hover {
                background-color: #e0e0e0;
                color: #3d3d3d;
            }
        }
    </style>

@stop

@section('content')
    <p>Generar Recibos/facturas/Ventas</p>

    <div class="row">
        <div class="col-12">
            <h4>En esta seccion podra generar recibos y facturas de tipo A, B o C, segun le corresponda</h4>
            <span>Tambien es esta seccion se iran registrando tanto las ventas de contado como a credito</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="recibo" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill"
                                href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay"
                                aria-selected="true">RECIBO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="factiraA" data-toggle="pill" href="#custom-tabs-five-overlay-dark"
                                role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">FACTURA
                                A</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="facturaB" data-toggle="pill" href="#custom-tabs-five-normal"
                                role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">FACTURA B</a>
                        </li>
                    </ul>
                </div>


                <div class="card-body">
                    <div class="tab-content" id="reciboContent">
                        <div class="tab-pane fade show active" id="custom-tabs-five-overlay" role="tabpanel"
                            aria-labelledby="custom-tabs-five-overlay-tab">
                            <div class="overlay-wrapper">

                                <form action="{{ route('recive') }}" method="POST" id="form-dates-recive">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail4">Fecha</label>
                                            <input type="datetime-local" class="form-control" value="<?php echo date('Y-m-d h:m:s'); ?>"
                                                name="date_sale" id="date_sale" placeholder="Fecha. Cpra.">
                                        </div>
                                        <div class="form-group col-md-7">
                                            <label for="inputPassword4">Cliente - Nombre, Apellido, Razon Soc, DNI,
                                                CUIT/L</label>
                                            <input type="search" class="form-control" name="name" id="tags"
                                                placeholder="Cliente">
                                            <input type="text" name="client_id" id="client_id" hidden>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="inputEmail4" style="color: #fff">.</label>
                                             <a href="/clients" class="btn btn-success form-control">
                                                <i class="fa fa-user-plus"></i>
                                             </a>
                                        </div>
                                    </div>

                                    <span id="body_recive" hidden='true'>
                                        <div class="form-row">

                                            <div class="form-group col-md-1">
                                                <label for="inputAddress">Cant.</label>
                                                <input type="number" class="form-control cant" id="cant-0"
                                                    name="cant-0" value="1" placeholder="Cant.">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputAddress2">Detalle de la compra</label>
                                                <input type="search" class="form-control detail" id="detail-0"
                                                    name="detail-0" placeholder="Detalle de la compra">
                                                <input type="text" name="product_id-0" id="product_id-0" hidden>

                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="inputCity">$ Precio U</label>
                                                <input type="number" class="form-control" id="price_unit-0"
                                                    name="price_unit-0" placeholder="Precio U">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputZip">$ Precio T</label>
                                                <input type="number" class="form-control sub_total_0" id="sub_total-0"
                                                    name="sub_total-0" readonly placeholder="Precio T">
                                            </div>

                                            {{-- En este input mandamos la cantidad de inputs agregados --}}
                                            <input type="number" hidden id="cant_input" name="cant_input">

                                            <div class="form-group col-md-1">
                                                <p></p>
                                                <a href="#" id="add_input" class="btn btn-sm mt-3" role="button"
                                                    aria-pressed="true"> <i class="fa fa-plus"></i></a>
                                            </div>

                                        </div>
                                        {{-- Aca aparecen los inputs dinamicos --}}
                                        <div class="form-row" id="inputBoxes"></div>

                                         {{-- ENTREGA y DESCUENTOS--}}
                                         <div class="form-row text-center">
                                            <div class="col-md-9 pt-4 control-label"></div>

                                            <div class="col-md-2 pt-4 control-label radius">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" checked
                                                        name="type_sale" id="type_sale_cont" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Contado</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="type_sale" id="type_sale_cred" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">Credito</label>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-9 pt-4 control-label"></div>

                                            <div class="col-md-2 control-label">
                                                <label for="validationCustomUsername"></label>
                                                <div class="input-group div_delivery" hidden='true'>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupPrepend">Entrega</span>
                                                    </div>
                                                    <input type="text" class="form-control text-center"
                                                        id="delivery" name="delivery" id="validationCustomUsername"
                                                        placeholder="Entrega $" aria-describedby="inputGroupPrepend" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-9 pt-4 control-label"></div>

                                            <div class="col-md-1 control-label float-left">
                                                <label for="validationCustomUsername"></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                                    </div>
                                                    <input type="text" class="form-control text-center"
                                                        id="countdown" name="countdown" id="validationCustomUsername"
                                                        placeholder="Desc." aria-describedby="inputGroupPrepend" value="">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- .END/ ENTREGA y DESCUENTOS--}}

                                        <div class="form-row text-right" id="form-recive">

                                            <div class="col-md-9 mb-3 control-label">
                                                <label for="validationCustomUsername"></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">

                                                    </div>
                                                    <input type="number" class="form-control float-right bg-white" style="border: #faf6f6"
                                                        id="validationCustomUsername" aria-describedby="inputGroupPrepend"
                                                       readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-3 control-label">
                                                <label for="validationCustomUsername"></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupPrepend">$</span>
                                                    </div>
                                                    <input readonly type="text" class="form-control text-left"
                                                        id="total" name="total" id="validationCustomUsername"
                                                        placeholder="Total" aria-describedby="inputGroupPrepend" required>
                                                </div>
                                            </div>


                                        </div>
                                            <div class="modal-footer" style="margin-right: 7%">
                                                <button id="btn_genenerate_recive" type="submit" class="btn btn-primary">Gnerar Recibo</button>
                                            </div>
                                    </span>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel"
                            aria-labelledby="factiraA">
                            <div class="overlay-wrapper">
                                Factura A
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-five-normal" role="tabpanel"
                            aria-labelledby="facturaB">
                            Factura B
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.row -->




@stop


@section('js')
    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/sales/sales_recive.js') }}"></script>

    {{-- AUTOCOMPLETE --}}

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Jquery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


@stop
