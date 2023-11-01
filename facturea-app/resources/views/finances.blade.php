@extends('adminlte::page')

@section('title', 'proveedor')

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

    <style>
        .switchBtn {
            margin-bottom: 0;
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switchBtn input {
            display: none;
        }

        .slide {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            padding: 8px;
            color: #fff;
        }

        .slide:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 28px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slide {
            background-color: #8CE196;
            padding-left: 40px;
        }

        input:focus+.slide {
            box-shadow: 0 0 1px #01aeed;
        }

        input:checked+.slide:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            left: -20px;
        }

        .slide.round {
            border-radius: 34px;
        }

        .slide.round:before {
            border-radius: 50%;
        }
    </style>

@stop

@section('content_header')
    <h1>Seccion de finanzas, caja diaria y demas periodos </h1>
@stop

@section('content')

    <hr>
    <div class="row">
        <div class="col-2 pt-5">

            <a id="btn-daily-cash" class="btn btn-app bg-primary">
                <i class="fas fa-comment-dollar"></i> Caja diaria
            </a>

        </div>
        <div class="col-6 pt-4">

            <h4>Elegir periodo para calculo de reporte</h4>
            <form id='form-frame-cahs'>
                <div class="form-row align-items-center">

                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Username</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Desde</div>
                            </div>
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="from" name="from"
                                placeholder="Username">
                        </div>
                    </div>

                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Username</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Hasta</div>
                            </div>
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="until" name="until"
                                placeholder="Username">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">Enviar</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col">
            Loading ...
        </div>
    </div>


    <hr>


    <div id="content-daily-finance" class="alert alert-dismissable ">
        <button type="button" class="close">×</button>
        <div class="row">
            <div class="col-8">

                {{-- INFO IZQUIERDA -TABLE --}}

                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Nombre y Apellido</th>
                            <th scope="col">N° Cpra</th>
                            <th scope="col">Total Cpra</th>
                            <th scope="col">Ent.</th>
                            <th scope="col">Desc</th>
                        </tr>
                    </thead>
                    <tbody id='table-finance'>
                    </tbody>
                </table>

            </div>
            <div class="col-4">
                {{-- INFO DERECHA --}}
                <div class="card" style="width: 18rem;">

                    <div class="card-header">
                        Reporte de <strong id="date_report"></strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Entregaste mercad. por: <strong id="sum_debt"></strong></li>
                        <li class="list-group-item">Recaudaste en efectivo: <strong id="sum_payment"></strong></li>
                        <li class="list-group-item">Desc. aplicados: <strong id="sum_countdown"></strong></li>
                        <li class="list-group-item">Dinero por cobrar: <strong id="street_cash" class="text-danger"></strong></li>

                    </ul>
                </div>

            </div>
        </div>
    </div>







@stop



@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/notifications.js') }}"></script>

    <script src="{{ asset('my/js/finances.js') }}"></script>

    <script>
        $(document).ready(function() {


            //$('#providers').DataTable();
            $('#providers').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

        });
    </script>

@stop
