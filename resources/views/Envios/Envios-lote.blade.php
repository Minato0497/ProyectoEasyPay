@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envios Multiples</h1>
@stop

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('envioMulti.store') }}" method="post">
                @csrf
                @include('Envios.partials.formMulti')
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 30; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.correos'); //Input field wrapper
            var fieldHTML = `<div class="row">
                                    <div class="col-11">
                                        <div class="correo">
                                            <input type="email" name="email[]" id="email" class="form-control" placeholder="Correo a enviar"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>`;
            var x = 1; //Initial field counter is 1
            $(addButton).click(function() { //Once add button is clicked
                if (x < maxField) { //Check maximum number of input fields
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
                }
            });
            $(wrapper).on('click', '.remove_button', function(e) { //Once remove button is clicked
                e.preventDefault();
                $(this).closest('.row').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

    </script>
@endsection
