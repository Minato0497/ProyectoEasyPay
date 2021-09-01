@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
    <h1>Tarjetas de Crédito</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Lista de tarjetas</h4>
            <a href="{{ route('creditCard.create') }}" class="btn btn-primary float-right">Añadir tarjeta</a>
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Tarjeta</th>
                        <th>Tipo de tarjeta</th>
                        <th>Fecha de caducidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ Auth::user()->credit_card->credit_card_numbers }}</td>
                        <td>{{ Auth::user()->credit_card->credit_card_type }}</td>
                        <td>{{ Auth::user()->credit_card->credit_card_expiration_date }}</td>
                        <td><a href="{{ route('transfercreditcard.edit', Auth::user()->credit_card) }}">Usar tarjeta</a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
