@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envios Basicos</h1>
@stop

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('envioBasico.store') }}" method="post">
                @csrf
                @include('Envios.partials.form')
                <button type="submit" class="btn btn-primary">Enviar dinero</button>
            </form>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
