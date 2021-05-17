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
<div class="modal-body">

    <div class="form-group">
        <p class="h5">Nombre:</p>
        <p class="form-control">{{$user->name}}</p>
        <h2 class="h5">Lista de roles</h2>
        <form action="{{route('roleUser.update',$user)}}" method="POST">
            @csrf
            @method('PUT')
            @foreach ($roles as $role )
            <div>
                <label for="role">
                    <input type="checkbox" name="roles" id="roles" value="{{$role->id}}">{{$role->name}}
                </label>
            </div>
            @endforeach
            @error('roles') <span class="text-danger">{{ $message }}</span>@enderror
            <input type="submit" value="Asignar rol" class="btn btn-primary mt-2">
        </form>
    </div>

</div>@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

<script>
    console.log('Hi!');

</script>
@stop
