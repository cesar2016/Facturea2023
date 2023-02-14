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

@stop


@section('content_header')
    <h1>Lista de Productos</h1>
@stop

@section('content')
    <a id="btn-new-product" class="btn btn-app bg-primary">
        <i class="fas fa-users"></i> Nuevo producto
    </a>

    <div id="view-new-product" >
        <div id="card-form" class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title"> <i class=" fa fa-users"></i> <span id="text-head-form"></span> </h3>
            </div>
            <input hidden type="text" name="idproduct" id="idproduct" value="1">
            <form id="form-new-product" name="form-new-product" action="">
            <div class="card-body">
                <div class="form-group row">

                    <div class="col-1">
                        <input type="text" name="code" id="code" class="form-control" placeholder="code">
                        <input hidden type="text" name="status" id="status" value="1">
                    </div>
                    <div class="col-4">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre/Desc.">
                    </div>
                    <div class="col-2">
                        <input type="text" name="stock" id="stock" class="form-control" placeholder="Stock">
                    </div>
                    <div class="col-2">
                        <input type="text" name="price_purchase" id="price_purchase" class="form-control" placeholder="Precio Cpra.">
                    </div>
                    <div class="col-2">
                        <input type="text" name="price_sale" id="price_sale" class="form-control" placeholder="precio Vta.">
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-2">
                        <input type="date" name="date_purchase" id="date_purchase" class="form-control" placeholder="Fecha Cpra." value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-2">

                        <select name="category_id" id="category_id"  class="miSelect1" style='width: 250px; margin-left:5px;' name="state">
                            <option disabled selected value="0" id='default1' style="display:none"> Elija categoría... </option>
                            @foreach($categories as $categorie)
                                <option value="{{$categorie['id']}}">{{$categorie['name']}}</option>
                            @endforeach
                        </select>


                    </div>
                    <div class="col-6">

                        <select name="brand_product_id" id="brand_product_id" class="miSelect2" style='width: 250px; margin-left:5px' name="state">
                            <option disabled selected value="0" id='default2' style="display:none"> Elija marca... </option>
                            @foreach($brandProducts as $brandProducts)
                                <option value="{{$brandProducts['id']}}">{{$brandProducts['name']}}</option>
                            @endforeach
                        </select>

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






    <table id="products" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>STOCK</th>
                <th>PRECIO/Cpra</th>
                <th>PRECIO/Vta</th>
                <th>FECHA/Cpra</th>
                {{-- <th>STATUS</th> --}}
                <th>CATEGORIA</th>
                <th>MARCA</th>

                <th>ACCIONES</th>
            </tr>
        </thead>

            <tbody>
                @foreach ($products as $product)
                    <tr id="{{ 'row'.$product['id'] }}">
                        <td>{{ $product['code'] }}</td>
                        <td>{{ $product['name'] }} </td>
                        <td>{{ $product['stock'] }}</td>
                        <td>$ {{ $product['price_purchase'] }}</td>
                        <td>$ {{ $product['price_sale'] }}</td>
                        <td>{{ $product['date_purchase'] }}</td>
                        {{-- <td>{{ $product['status'] }}</td> --}}
                        <td>{{ $product['category']['name'] }}</td>
                        <td>{{ $product['brand_product']['name'] }}</td>

                        <td>
                            <button id='btn_update' value="{{ $product['id'] }}" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-pen text-info'> </i>
                            </button>
                            <button id='btn_delete' value="{{ $product['id'] }}" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-trash text-danger '></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>


@stop



@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <!-- Toastr.js Después -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/notifications.js') }}"></script>

    <script src="{{ asset('my/js/products.js') }}"></script>

    <script>
        $(document).ready(function() {
            //$('#products').DataTable();
            $('#products').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

        });
    </script>

@stop
