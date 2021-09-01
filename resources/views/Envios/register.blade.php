@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envío Basicos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Envia</th>
                        <th>Recibe</th>
                        <th>Monto</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $regiter_transfer_user->email_envia }}</td>
                        <td>{{ $regiter_transfer_user->email_recibe }}</td>
                        <td>{{ $regiter_transfer_user->monto }}</td>
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
