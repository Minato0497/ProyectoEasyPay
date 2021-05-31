@extends('adminlte::page')

@section('title', 'Home')

@section('style')
    <style>
        .img-container {
            text-align: center;
            display: block;
        }

        body {
            background-image: asset('img/logo.jpeg')
        }

    </style>
@endsection
@section('content_header')

@stop

@section('content')

    @if (Session::has('info'))
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('info') }}
        </div>
    @endif
    <div class="img-container">
        <img src="{{ asset('img/logo.jpeg') }}" alt="lo ez money" class="rounded" width="450">
    </div>
    @if (!empty($current_user))
        @foreach ($current_user as $user)
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('img/registro.png') }}" class="card-img-top" alt="imgen registro"
                                    width="350" height="350">
                                <div class="card-body">
                                    <h5 class="card-title">Registro de Trasnferencia </h5><br>
                                    <div class="button mt d-flex flex-row align-items-center"> <a
                                            href="{{ route('trasnfer-register.show', Auth::user()) }}"
                                            class="btn btn-sm btn-primary w-100 ml-2">Ver registro de transferencias</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('img/1295584.png') }}" class="card-img-top" alt="imgen registro"
                                    width="350" height="350">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $user->monedero }} € </h5><br>
                                    <div class="button mt d-flex flex-row align-items-center">
                                        <a href="{{ route('transfercreditcard.index') }}"
                                            class="btn btn-sm btn-primary w-100 ml-2">Agregar al
                                            monedero</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('img/credit.jpg') }}" class="card-img-top" alt="imgen tarjeta"
                                    width="350" height="350">
                                <div class="card-body">
                                    <h5 class="card-title">Tarjeta de credito </h5><br>
                                    <div class="button mt d-flex flex-row align-items-center"> <a
                                            href="{{ route('transfercreditcard.index') }}"
                                            class="btn btn-sm btn-primary w-100 ml-2">Ver tarjetas de credito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
