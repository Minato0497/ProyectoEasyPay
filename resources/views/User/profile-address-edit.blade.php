@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Editar Direccion</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('address.update',$address)}}" method="POST">
            @method('PUT')
            @include('User.partials.addressform')
            <br>
            <button type="submit" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm"> Modificar direccion </button>
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
