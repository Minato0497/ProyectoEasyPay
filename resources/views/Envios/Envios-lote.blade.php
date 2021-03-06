@extends('adminlte::page')

@section('title', 'Envio de dinero')

@section('content_header')
    <h1>Envío Múltiple</h1>
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
            <form id="TransMultiForm">
                @csrf
                @include('Envios.partials.formMulti')
                {{-- <button type="submit" class="btn btn-primary">Enviar</button> --}}
                <button type="submit" class="btn btn-success" id="SubmitTransMultiForm">Enviar dinero</button>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#SubmitTransMultiForm').click(function(e) {
                var that = $(this);
                e.preventDefault();
                $.ajax({
                    data: $('#TransMultiForm').serialize(),
                    url: "{{ route('user.envioMulti.store') }}",
                    type: "post",
                    dataType: 'json',
                    beforeSend: function(data) {
                        that.hide();
                    },
                    complete: function(data) {
                        that.show();
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.validation_error) &&
                            $.isEmptyObject(data.submit_store_error)) {
                            $('#TransMultiForm').trigger("reset");
                            resetErrorMsg();
                            // $('#modalMovement').modal('hide');
                            toastr.success(data.submit_store_success, '', {
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                            });
                        } else {
                            //Si falla la validación de campos
                            if (!$.isEmptyObject(data.validation_error)) {
                                printErrorMsg(data.validation_error);
                            }
                            //Si al guardar salta el catch (foreign key o cualquier exception sql)
                            else if (!$.isEmptyObject(data.submit_store_error)) {
                                printErrorMsg(data.validation_error);
                                toastr.warning(data.submit_store_error, '', {
                                    "positionClass": "toast-top-right",
                                    "timeOut": "3000",
                                });
                            }
                            //Si el cancel trait está activado inhabilitando la edición
                            else {
                                toastr.error(
                                    'Uncaught error, please contact with administrators',
                                    '', {
                                        "positionClass": "toast-top-right",
                                        "timeOut": "3000",
                                    });
                            }
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        toastr.error(
                            'Not expected error!, please contact with administrators',
                            '', {
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                            }
                        );
                    }
                });
            });
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

        function printErrorMsg(msg) {
            $('.error-text').text('');
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_error').text(value);
            });
        }

        function resetErrorMsg() {
            $('.error-text').text('');
        }
    </script>
@endsection
