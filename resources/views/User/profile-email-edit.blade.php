@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
    <h1>Editar Correo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('email.update', Auth::user()->email) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="emailOld">Correo antiguo</label>
                    <br>
                    <label for="emailold">{{ Auth::user()->email }}</label>
                    <br>
                    <label for="emailNew">Correo nuevo</label>
                    <br>
                    <input type="text" name="emailNew" class="form-control" placeholder="Nuevo Correo">
                    @error('emailNew')
                        <small <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <button type="submit" class="btn btn-primary">Modificar email</button>
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
