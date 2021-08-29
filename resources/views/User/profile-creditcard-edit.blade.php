@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Editar tarjeta de crédito</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('creditCard.update',$creditcard)}}" method="post">
            @include('User.partials.creditcardform')
            <br>
            <button type="submit" class="btn btn-primary">Editar tajeta</button>
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
