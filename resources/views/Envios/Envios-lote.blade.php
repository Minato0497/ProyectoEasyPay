@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envios Multiples</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (!empty($info))
                {{ $info }}
            @endif
            <form action="{{ route('envioMulti.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Correo a enviar</label>
                    <div class="row">
                        <div class="col-11">
                            <div class="correo">
                                <input type="email" name="email[]" id="email" class="form-control"
                                    placeholder="Correo a enviar" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="col-1">
                            <a href="javascript:void(0);" class="add_button" title="Add field"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <label for="monto">Cantidad</label>
                    <input type="number" name="monto" id="monto" placeholder="Ingrese el cantidad a enviar"
                        class="form-control">
                </div>
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
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.correo'); //Input field wrapper
            var fieldHTML =
                '<div><input type="email" name="email[]" class="form-control" placeholder="Correo a enviar"/><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fas fa-times"></i></a><br></div>'; //New input field html
            var x = 1; //Initial field counter is 1
            $(addButton).click(function() { //Once add button is clicked
                if (x < maxField) { //Check maximum number of input fields
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
                }
            });
            $(wrapper).on('click', '.remove_button', function(e) { //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

    </script>
@endsection
