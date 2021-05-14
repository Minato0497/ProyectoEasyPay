@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
<h1>Envios Basicos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(! empty($info))
        {{ $info }}
        @endif
        {!! Form::model($email_envia,['route' => ['envio_basico.store',$email_envia],'method'=>'POST']) !!}
        @include('Envios.partials.form')
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
