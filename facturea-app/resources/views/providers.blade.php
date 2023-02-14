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


@stop

@section('content_header')
    <h1>Hola provideres </h1>
@stop

@section('content')
    <a id="btn-new-provider" class="btn btn-app bg-primary">
        <i class="fas fa-truck"></i> Nuevo proveedor
    </a>

    <div id="view-new-provider">
        <div id="card-form" class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title"> <i class=" fa fa-truck"></i> <span id="text-head-form"></span> </h3>
            </div>
            <input hidden type="text" name="idProvider" id="idProvider" value="1">
            <form id="form-new-provider" name="form-new-provider" action="">
                <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-2">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre">

                        </div>
                        <div class="col-2">
                            <input type="text" name="cuit" id="cuit" class="form-control" placeholder="CUIT">
                        </div>

                        <div class="col-2">
                            <input type="text" name="address" id="address" class="form-control"
                                placeholder="Direccion">
                        </div>
                        <div class="col-2">
                            <input type="text" name="city" id="city" class="form-control"
                                placeholder="Localidad">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-2">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefono">
                        </div>
                        <div class="col-2">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-2">
                            <input type="text" name="percent" id="percent" class="form-control form-control-lg is-invalid" placeholder="% de Aumento">
                        </div>
                        <div class="col-2" id="checkes_select">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="inlineCheckbox3">Estado del proveedor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_check" id="status_a" value="1" checked>
                                <label class="form-check-label" >Activo</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_check" id="status_i" value="0" >
                                <label class="form-check-label">Inactivo</label>
                                <input type="text" name="status" id="status" value="1" hidden>
                            </div>


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

    <table id="providers" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>CUIT</th>
                <th>Direccion</th>
                <th>Localidad</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>status</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($providers as $provider)
                <tr id="{{ 'row' . $provider['id'] }}">
                    <td>{{ $provider['name'] }}</td>
                    <td>{{ $provider['cuit'] }}</td>
                    <td>{{ $provider['address'] }}</td>
                    <td>{{ $provider['city'] }}</td>
                    <td>{{ $provider['phone'] }}</td>
                    <td>{{ $provider['email'] }}</td>
                    <td>
                        @if ($provider['status'] == 1)
                            <span class="right badge badge-success">Activo</span>
                        @else
                            <span class="right badge badge-danger">Inactivo</span>
                        @endif
                    </td>

                    <td>
                        <button id='btn_update' value="{{ $provider['id'] }}" class='btn' type="button"
                            data-toggle="modal" data-target="#updateModal">
                            <i class='fa fa-pen text-info'> </i>
                        </button>
                        <button id='btn_delete' value="{{ $provider['id'] }}" class='btn' type="button"
                            data-toggle="modal" data-target="#updateModal">
                            <i class='fa fa-trash text-danger '></i>
                        </button>
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

    <script src="{{ asset('my/js/providers.js') }}"></script>

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
