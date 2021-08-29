@extends('adminlte::page')

@section('title', 'User/show')

@section('content_header')
    <h1>Perfil: {{ Auth::user()->name }}</h1>
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Email</h1>
                                <p class="card-text">{{ $user->email }}</p>
                                <a href="{{ route('email.edit', Auth::user()->email) }}" class="btn btn-primary">Cambiar
                                    Correo</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Monedero</h1>
                                <p class="card-text">{{ $user->monedero }}€</p>
                                <a href="{{ route('transfercreditcard.index') }}" class="btn btn-primary">Agregar al
                                    monedero</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                @if (empty($address_user))
                                    <a href="{{ route('address.create') }}" class="btn btn-primary">Añadir
                                        dirección</a>
                                @else
                                    @foreach ($address_user as $address)
                                        <h1 class="card-title">dirección</h1>
                                        <p class="card-text">Nombre: {{ $address->name }}</p>
                                        <p class="card-text">dirección: {{ $address->addressPrimary }}</p>
                                        <p class="card-text">dirección: {{ $address->addressSecundary }}</p>
                                        <p class="card-text">Código Postal: {{ $address->postal_code }}</p>
                                        <p class="card-text">Ciudad: {{ $address->city }}</p>
                                        <p class="card-text">Provincia: {{ $address->state }}</p>
                                        <p class="card-text">País: {{ $address->country->country }}</p>
                                        <a href="{{ route('address.edit', $address) }}" class="btn btn-primary">Cambiar
                                            dirección</a>
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
                                        <a href="#" class="btn btn-primary">Añadir Móvil</a>
                                    @else
                                        <h1 class="card-title">Móvil</h1>
                                        <p class="card-text">{{ $user->phoneNumber }}</p>
                                        <a href="{{ route('phone.edit', Auth::user()->id) }}"
                                            class="btn btn-primary">Cambiar Móvil</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('transfercreditcard.index') }}" class="btn btn-primary">Ver
                                            tarjetas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                                                <path
                                                    d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                                            </svg></a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('creditCard.create') }}" class="btn btn-primary">Añadir
                                            Tarjeta<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                                                <path
                                                    d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                                            </svg></a>
                                    </div>
                                </div>
                                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                                    @if ($credit_cards_user == 'NULL')
                                        <form action="{{ route('creditCard.destroy', $creditCard) }}" method="POST">
                                            <div class="card-body">
                                                <a href="{{ route('creditCard.create') }}" class="btn btn-primary">Añadir
                                                    Tarjeta<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                                                        <path
                                                            d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                                                    </svg></a>
                                            </div>
                                        @else
                                            @foreach ($credit_cards_user as $creditCard)
                                                <div class="card-body">
                                                    <h1 class="card-title">Tarjeta de crédito</h1>
                                                    <br>
                                                    <p class="card-text">{{ $creditCard->credit_card_type }}</p>
                                                    <p class="card-text">{{ $creditCard->credit_card_numbers }}</p>
                                                    <p class="card-text">{{ $creditCard->credit_card_expiration_date }}
                                                    </p>
                                                </div>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            @endforeach
                                        </form>
                                    @endif
                                </div>
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
