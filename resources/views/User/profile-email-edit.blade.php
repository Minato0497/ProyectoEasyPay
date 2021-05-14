@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Phone edit</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::model(Auth::user(),['route'=>['email.update',Auth::user()->email],'method'=>'put']) !!}
        <div class="form-group">
            {!! Form::label('emailOld', 'Correo antiguo') !!}
            <br>
            {!! Form::label('emailold', Auth::user()->email) !!}
            <br>
            {!! Form::label('emailNew', 'Correo nuevo') !!}
            {!! Form::text('emailNew', null, ['class'=>'form-control','placeholder'=>'Nuevo Correo']) !!}
            @error('emailNew')
            <small <small class="text-danger">
                {{$message}}
            </small>
            @enderror
            {!! Form::submit('Modificar movil', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
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
