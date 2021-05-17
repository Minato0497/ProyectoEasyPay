@extends('adminlte::page')

@section('title', 'listUsers')

@section('content_header')
<h1>Admin</h1>
@stop

@section('content')

@if (Session::has('info'))
<div class="alert alert-success alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ Session::get('info') }}
</div>
@endif
@livewire('admin.user.role-user-index')
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

<script>
    console.log('Hi!');
</script>
@stop
