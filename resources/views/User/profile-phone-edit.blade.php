@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
    <h1>Editar Móvil</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('phone.update', Auth::user()->phoneNumber) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="phone">Móvil antiguo</label>
                    <br>
                    <label for="phoneOld">
                        @if (Auth::user()->phoneNumber == 'NULL')
                            ------
                        @else
                            {{ Auth::user()->phoneNumber }}
                        @endif
                    </label>
                    <br>
                    <label for="phoneNew">Móvil nuevo</label>
                    <br>
                    <input type="telNo" name="phoneNumberNew" class="form-control" placeholder="Móvil nuevo">
                    @error('phoneNumberNew')
                        <small <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <button type="submit" class="btn btn-primary">Modificar Móvil</button>
                </div>
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
