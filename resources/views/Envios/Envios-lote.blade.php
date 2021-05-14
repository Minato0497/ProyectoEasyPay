@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
<h1>Envios Basicos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => ['envio.store']) !!}
        @include('Transaction.partials.form')
        {!! Form::submit('Enviar dinero', ['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
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
