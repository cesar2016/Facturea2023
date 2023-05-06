@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Bienvenido ...</h1>
@stop

@section('content')
    <p>Mis datos</p>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white"><h4>{{ __('Panel de control') }}</h4></div>

                    <div class="card-body">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error )
                                <div class="alert alert-danger" role="alert">
                                    <li>* {{ $error }}</li>
                                </div>
                            @endforeach
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{{ Session::get('success') }}</li>
                                </ul>
                            </div>
                        @endif
                            <h1>
                                {{ __('Bienvenido a Facturea ') }}
                            </h1>
                            <strong>Estamos para ayudarte</strong>





                        <br>


                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">
@stop

@section('js')
    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/products.js') }}"></script>
    <script src="{{ asset('my/js/api_afip/test.js') }}"></script>

@stop
