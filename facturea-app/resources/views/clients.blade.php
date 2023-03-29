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


@stop

@section('content_header')
    <h1>Hola Clientes </h1>
@stop

@section('content')
    <a id="btn-new-client" class="btn btn-app bg-primary">
        <i class="fas fa-users"></i> Nuevo Cliente
    </a>

    <div id="view-new-client" >
        <div id="card-form" class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title"> <i class=" fa fa-users"></i> <span id="text-head-form"></span> </h3>
            </div>
            <input hidden type="text" name="idClient" id="idClient" value="1">
            <form id="form-new-client" name="form-new-client" action="">
            <div class="card-body">
                <div class="row">

                    <div class="col-1">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre">
                        <input hidden type="text" name="status" id="status" value="1">
                    </div>
                    <div class="col-2">
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Apellido">
                    </div>
                    <div class="col-1">
                        <input type="text" name="dni" id="dni" class="form-control" placeholder="DNI">
                    </div>
                    <div class="col-2">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-2">
                        <input type="text" name="address" id="address" class="form-control" placeholder="Direccion">
                    </div>
                    <div class="col-2">
                        <input type="text" name="city" id="city" class="form-control" placeholder="Localidad">
                    </div>
                    <div class="col-2">
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefono">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span id='btn-form'></span>
                <button id="close-form" class="btn btn-default">Cerrar</button>
            </div>
            </form>
        </div>

        <hr>
    </div>

    <table id="clients" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Direccion</th>
                <th>Localidad</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Status</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr id="{{ 'row'.$client['id'] }}">
                        <td>{{ $client['name'] }} {{ $client['lastname'] }}</td>
                        <td>{{ $client['dni'] }}</td>
                        <td>{{ $client['address'] }}</td>
                        <td>{{ $client['city'] }}</td>
                        <td>{{ $client['phone'] }}</td>
                        <td>{{ $client['email'] }}</td>
                        <td id="{{ 'date_expired'.$client['id'] }}"></td>
                        <td>
                            <button id='btn_update' value="{{ $client['id'] }}" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-pen text-default'> </i>
                            </button>
                            <button id='btn_delete' value="{{ $client['id'] }}" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-trash text-danger '></i>
                            </button>
                            {{-- <a href="{{url('client_acount',$client['id'])}}" class="btn" role="button" aria-pressed="true">
                                <i class='fa fa-eye '></i>
                            </a> --}}

                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>


@stop



@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/notifications.js') }}"></script>

    <script src="{{ asset('my/js/clients.js') }}"></script>

    <script>
        $(document).ready(function() {
            //$('#clients').DataTable();
            $('#clients').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

        });
    </script>

@stop
