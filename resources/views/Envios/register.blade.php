@extends('adminlte::page')

@section('title', 'Registro de transferencia')

@section('content_header')
	<h1>Registro de transferencia</h1>
@stop

@section('content')
	<div class="card">
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th>Envia</th>
						<th>Recibe</th>
						<th>Monto</th>
						<th colspan="3"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($regiter_transfer_user as $register)
						<tr>
							<td>{{ $register->email_envia }}</td>
							<td>{{ $register->email_recibe }}</td>
							<td>{{ $register->monto }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
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
