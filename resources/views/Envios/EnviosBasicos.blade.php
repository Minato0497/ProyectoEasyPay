@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envios Basicos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (!empty($info))
                {{ $info }}
            @endif
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
