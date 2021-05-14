@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Address edit</h1>
@stop

@section('content')
<!-- Credit card form content -->
<div class="tab-content">
    <!-- credit card info-->
    <div id="nav-tab-card" class="tab-pane fade show active">
        <form action="{{route('address.store')}}" method="post">
            @include('User.partials.addressform')
            <br>
            <button type="submit" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm"> Añadir direccion </button>
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
