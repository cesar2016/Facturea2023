@extends('adminlte::page')

@section('title', 'productes')

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




<title>Toaster</title>

@stop


@section('content_header')
    <h1>Marcas y Categorias</h1>
@stop


@section('content')

<div class="content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header mb-3">
                        <a id="btn-new-brandProducts" class="btn btn-app bg-primary">
                            <i class="fas fa-users"></i> Nuevo Marca
                        </a>
                    </div>


                    <!-- /.card-header -->
                    <div class="container" id="view-new-brandProducts">
                        <div id="card-form" class="card card-primary ">
                            <div class="card-header">
                                <h3 class="card-title"> <i class=" fa fa-truck"></i> <span id="text-head-form"></span> </h3>
                            </div>
                            <input hidden type="text" name="idBrandProduct" id="idBrandProduct" value="1">
                            <form id="form-new-brandProducts" name="form-new-brandProducts" action="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre marca">
                                            <input hidden type="text" name="status" id="status" value="1">
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-2">

                                                <select name="provider_id" id="provider_id"  class="miSelect1" style='width: 250px; margin-left:5px;' name="state">
                                                    <option disabled selected value="0" id='default1' style="display:none"> Elija Proveedor... </option>
                                                    @foreach($providers as $provider)
                                                        <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                                    @endforeach
                                                </select>
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



                    {{-- TABLA DE LARCAS --}}
                    <div class="container">
                        <table id="brandProducts" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Marca</th>
                                    <th>Proveedor</th>
                                    <th>status</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($brandProducts as $brandProduct)
                                        <tr id="{{ 'row'.$brandProduct['id'] }}">
                                            <td>{{ $brandProduct['name'] }}</td>
                                            <td>{{ $brandProduct['provider']['name']}}</td>
                                            <td>

                                                @if ($brandProduct['status'] == 1)
                                                    <span class="right badge badge-success">Activo</span>
                                                @else
                                                    <span class="right badge badge-danger">Inactivo</span>
                                                @endif

                                            </td>
                                            <td>
                                                <button id='btn_update' value="{{ $brandProduct['id'] }}" class='btn' type="button" data-toggle="modal"
                                                    data-target="#updateModal">
                                                    <i class='fa fa-pen text-info'> </i>
                                                </button>
                                                <button id='btn_delete' value="{{ $brandProduct['id'] }}" class='btn' type="button" data-toggle="modal"
                                                    data-target="#updateModal">
                                                    <i class='fa fa-trash text-danger '></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>

                    {{-- ./ TABLA DE LARCAS --}}


                </div>
                <!-- /.card -->
            </div>


            <!-- DIVISION de LAS DOS TABLAS -->


            <!-- /.col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header mb-3">
                        <a id="btn-new-category" class="btn btn-app bg-primary">
                            <i class="fas fa-users"></i> Nueva Categoria
                        </a>
                    </div>


                    <!-- /.card-header -->
                    <div class="container" id="view-new-category">
                        <div id="card-form" class="card card-primary ">
                            <div class="card-header">
                                <h3 class="card-title"> <i class=" fa fa-truck"></i> <span id="text-head-form"></span> </h3>
                            </div>
                            {{-- <form id="form-new-category" name="form-new-category" action=""> --}}
                                <input hidden type="text" name="idCategory" id="idCategory" value="1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text"  autocapitalize="characters" name="name_category" id="name_category" class="form-control" placeholder="Nombre marca">
                                            <input hidden type="text" name="status_category" id="status_category" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <span id='btn-form_category'></span>
                                    <button id="close-form_category" class="btn btn-default">Cerrar</button>
                                </div>
                            {{-- </form> --}}
                        </div>

                        <hr>
                    </div>



                    {{-- TABLA DE LARCAS --}}
                    <div class="container">
                        <table id="category" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr id="{{ 'row_category'.$category['id'] }}">
                                            <td>{{ $category['name'] }}</td>
                                            <td>
                                                <button id='btn_update_category_category' value="{{ $category['id'] }}" class='btn' type="button" data-toggle="modal"
                                                    data-target="#updateModal">
                                                    <i class='fa fa-pen text-info'> </i>
                                                </button>
                                                <button value="{{ $category['id'] }}" class='btn' type="button" data-toggle="modal"
                                                    data-target="#updateModal">
                                                    <i class='fa fa-trash text-danger '></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>

                    {{-- ./ TABLA DE LARCAS --}}


                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div><!-- /.row -->

    </div><!-- /.container-fluid -->

</div><!-- /.content -->

@stop



@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<!-- Toastr.js Después -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/notifications.js') }}"></script>

    <script src="{{ asset('my/js/brandProducts.js') }}"></script>
    <script src="{{ asset('my/js/categories.js') }}"></script>

    <script>
        $(document).ready(function() {
            //$('#products').DataTable();
            $('#category').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            $('#brandProducts').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

        });
    </script>

@stop
