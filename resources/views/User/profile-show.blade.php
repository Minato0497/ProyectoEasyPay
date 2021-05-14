@extends('adminlte::page')

@section('title', 'User/show')

@section('content_header')
<h1>{{Auth::user()->name}}</h1>
@stop
@section('content')
@if( Session::has('info') )
<div class="alert alert-success alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ Session::get('info') }}
</div>
@endif

@if (!empty($current_user))
@foreach ($current_user as $user )

<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title">Email</h1>
                    <p class="card-text">{{$user->email}}</p>
                    <a href="{{route('email.edit',Auth::user()->email)}}" class="btn btn-primary">Cambiar Correo</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title">Monedero</h1>
                    <p class="card-text">{{$user->monedero}}€</p>
                    <a href="#" class="btn btn-primary">Agregar al monedero</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    @if (empty($address_user))
                    <a href="{{route('address.create')}}" class="btn btn-primary">Añadir
                        direccion</a>
                    @else
                    @foreach ($address_user as $address )
                    <h1 class="card-title">Direccion</h1>
                    <p class="card-text">Nombre: {{$address->name}}</p>
                    <p class="card-text">Direccion: {{$address->addressPrimary}}</p>
                    <p class="card-text">Direccion: {{$address->addressSecundary}}</p>
                    <p class="card-text">Codigo Postal: {{$address->postal_code}}</p>
                    <p class="card-text">Ciudad: {{$address->city}}</p>
                    <p class="card-text">Provincia: {{$address->state}}</p>
                    <p class="card-text">Pais: {{$address->country->country}}</p>
                    <a href="{{route('address.edit',$address)}}" class="btn btn-primary">Cambiar
                        direccion</a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="row mb">
            <div class="col-12">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        @if (empty($user->phoneNumber))
                        <a href="#" class="btn btn-primary">Añadir Movil</a>
                        @else
                        <h1 class="card-title">Movil</h1>
                        <p class="card-text">{{$user->phoneNumber}}</p>
                        <a href="{{route('phone.edit',Auth::user()->id)}}" class="btn btn-primary">Cambiar Movil</a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                        @if ($credit_cards_user='NULL')
                        <div class="card-body">
                            <a href="{{route('creditCard.create')}}" class="btn btn-primary">Añadir Tarjeta</a>
                        </div>
                        @else
                        @foreach ($credit_cards_user as $creditCard )
                        <div class="card-body">
                            <h1 class="card-title">Tarjeta de Credito</h1>
                            <p class="card-text">{{$creditCard->credit_card_numbers}}</p>
                            <p class="card-text">{{$creditCard->credit_card_expiration_date}}</p>
                            <a href="creditCard.create" class="btn btn-primary">Añadir Tarjeta</a>
                            <form action="{{route('creditCard.destroy',$creditCard)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    @stop

    @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
    <script>
        console.log('Hi!');
    </script>
    @stop
