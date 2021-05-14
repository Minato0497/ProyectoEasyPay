@extends('adminlte::page')

@section('title', 'User/phone/edit')

@section('content_header')
<h1>Phone edit</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::model(Auth::user(),['route'=>['phone.update',Auth::user()->phoneNumber],'method'=>'put']) !!}
        <div class="form-group">
            {!! Form::label('phone', 'Movil antiguo') !!}
            <br>
            {!! Form::label('phoneOld', Auth::user()->phoneNumber) !!}
            <br>
            {!! Form::label('phoneNew', 'Movil nuevo') !!}
            {!! Form::text('phoneNumberNew', null, ['class'=>'form-control','placeholder'=>'Nuevo Movil']) !!}
            @error('phoneNumberNew')
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
