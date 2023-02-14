@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Home ...</h1>
@stop

@section('content')
    <p>Generar Recibos/facturas/Ventas</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">
@stop

@section('js')
    <script src="{{ asset('my/js/config.js') }}"></script>
    <script src="{{ asset('my/js/products.js') }}"></script>

@stop
