@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
    <h1>Transferencia al monedoro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('transfercreditcard.update', $creditCard) }}" method="POST">
                @csrf
                @method('PUT')
                @include('creditcard.partials.transferForm')
                <br>
                <button type="submit" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm">Tranferir</button>
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
