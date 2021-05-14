@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
<h1>Home</h1>
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
<div class="card text-white bg-dark mb-3 float-right" style="max-width: 18rem;">
    <div class="card-body">
        <h1 class="card-title">Monedero</h1>
        <p class="card-text">{{$user->monedero}} €</p>
        <a href="#" class="btn btn-primary">Agregar al monedero</a>
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
