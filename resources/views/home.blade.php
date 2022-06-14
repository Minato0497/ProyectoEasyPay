@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')

@stop

@section('content')

    @if (Session::has('info'))
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('info') }}
        </div>
    @endif
    @if (!empty($current_user))
        @foreach ($current_user as $user)
            <div class="wallet-container text-center">
                <div class="d-flex justify-content-center">
                    <div class="img-container">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="ez money" class="rounded" width="350">
                    </div>
                </div>
                {{-- <p class="page-title"><i class="fa fa-align-left"></i>My E-wallet<i class="fa fa-user"></i></p> --}}
                <p><b>{{ auth()->user()->name }}</b></p>
                <div class="amount-box text-center">
                    <img src="https://lh3.googleusercontent.com/ohLHGNvMvQjOcmRpL4rjS3YQlcpO0D_80jJpJ-QA7-fQln9p3n7BAnqu3mxQ6kI4Sw"
                        alt="wallet">
                    <p>Balance total</p>
                    <p class="amount">{{ auth()->user()->monedero }} €</p>
                </div>

                <div class="btn-group text-center">
                    <a href="{{ route('user.ingress.index') }}" class="btn btn-outline-light">Añadir al monedero</a>
                    <a href="{{ route('user.retire.index') }}" class="btn btn-outline-light">Retirar del monedero</a>

                    {{-- <button type="button" class="btn btn-outline-light">Añadir al monedero</button>
                    <button type="button" class="btn btn-outline-light">Retirar del monedero</button> --}}
                </div>

                <div class="txn-history">
                    <p><b>Historial</b></p>

                    @php
                        $count = 0;
                    @endphp

                    @foreach ($movements as $model)
                        @php
                            $count++;
                        @endphp
                        @if ($count < 6)
                            @if ($model->codOperationType == 1)
                                <p class="txn-list">
                                    {{ $model->has_operation_type->operation_type }}
                                    <span class="credit-amount">+{{ $model->amount }}€</span>
                                </p>
                            @elseif ($model->codOperationType == 2)
                                <p class="txn-list">
                                    {{ $model->has_operation_type->operation_type }}<span
                                        class="debit-amount">-{{ $model->amount }} €</span>
                                </p>
                            @elseif ($model->codOperationType == 3)
                                <p class="txn-list">
                                    {{ $model->has_receptor?->name }}
                                    ({{ $model->has_operation_type->operation_type }})
                                    <span class="debit-amount">-{{ $model->amount }}€</span>
                                </p>
                            @endif
                        @endif
                    @endforeach
                    <p><a href="{{ route('user.movements.index') }}" class="btn btn-outline-light">Ver historial
                            completo</a></p>

                    {{-- <p class="txn-list">Payment to xyz shop<span class="debit-amount">-$100</span></p>

                    <p class="txn-list">Payment to abc shop<span class="debit-amount">-$150</span></p>

                    <p class="txn-list">Credit From abc ltd<span class="credit-amount">+$300</span></p>

                    <p class="txn-list">Transfer From John Doe<span class="credit-amount">+$100</span></p> --}}
                </div>

                {{-- <div class="footer-menu">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <i class="fa fa-home"></i>
                            <p>Home</p>
                        </div>

                        <div class="col-md-3">
                            <i class="fa fa-inbox"></i>
                            <p>Inbox</p>
                        </div>

                        <div class="col-md-3">
                            <i class="fa fa-university"></i>
                            <p>Bank</p>
                        </div>

                        <div class="col-md-3">
                            <i class="fa fa-barcode"></i>
                            <p>Scan</p>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="container fondo">
                <div class="row">
                    <div class="col-6">
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('img/registro.png') }}" class="card-img-top" alt="imgen registro"
                                    width="200">
                                <div class="card-body">
                                    <h5 class="card-title">Registro de Movimentos </h5><br>
                                    <div class="button mt d-flex flex-row align-items-center"> <a
                                            href="{{ route('user.movements.index') }}"
                                            class="btn btn-sm btn-primary w-100 ml-2">Ver registro de transferencias</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        @endforeach
    @endif

@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        body {
            background-color: #3fb0ef !important;

        }

        .wallet-container {
            background: linear-gradient(rgba(189, 18, 204, 0.6), rgba(0, 0, 0, 0.6)), url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjOvSperRYjHH9-EHlKZJBfwvXy4rJpyerzHQsnp8DuuycYU5_);
            width: 75%;
            color: #fff;
            font-size: 15px;
            padding: 20px 20px 0;
            top: 50%;
            left: 55%;
            transform: translate(-50%, -50%);
            position: absolute;


        }

        .page-title {
            text-align: left;
        }

        .fa-user {
            float: right;
        }

        .fa-align-left {
            margin-right: 15px;
        }

        .amount-box img {
            width: 50px;
        }

        .amount {
            font-size: 35px;
        }

        .amount-box p {
            margin-top: 10px;
            margin-bottom: -10px;
        }

        .btn-group {
            margin: 20px 0;
        }

        .btn-group .btn {
            margin: 8px;
            border-radius: 20px !important;
            font-size: 12px;
        }

        .txn-history {
            text-align: left;
        }

        .txn-list {
            background-color: #fff;
            padding: 12px 10px;
            color: #777;
            font-size: 14px;
            margin: 7px 0;
        }

        .debit-amount {
            color: red;
            float: right;
        }

        .credit-amount {
            color: green;
            float: right;

        }

        .footer-menu {
            margin: 20px -20px 0;
            bottom: 0;
            border-top: 1px solid #ccc;
            padding: 10px 10px 0;
        }

        .footer-menu p {
            font-size: 12px;
        }

        @media screen and (max-width: 800px) {
            .wallet-container {
                height: 115%;
                bottom: 20px;
                margin-top: 100px;
            }

        }
    </style>
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
