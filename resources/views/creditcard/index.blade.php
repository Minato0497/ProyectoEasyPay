@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Address edit</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Lista de tarjetas</h4>
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr>
                    <th>Tarjeta</th>
                    <th>Tipo de tarjeta</th>
                    <th>Fecha de caducidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($creditCards as $creditCard)
                <tr>
                    <td>{{ $creditCard->credit_card_numbers }}</td>
                    <td>{{$creditCard->credit_card_type}}</td>
                    <td>{{ $creditCard->credit_card_expiration_date }}</td>
                    <td><a href="{{ route('transfercreditcard.edit', $creditCard) }}">Usar tarjeta</a></td>
                </tr>
                @endforeach
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
