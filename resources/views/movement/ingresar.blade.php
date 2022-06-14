@extends('adminlte::page')

@section('title', 'Ingress')

@section('content_header')
    <h1>Ingresar</h1>
    <p> Monedero: <input type="number" class="form-control" name="monedero" id="monedero"
        value="{{ auth()->user()->monedero }}" readonly></p>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                    </div>
                    <form id="IngressForm" action="{{ route('user.ingress.store') }}">
                        @csrf
                        {{-- <input type="hidden" name="codIngress" id="codIngress"> --}}
                        <div class="form-group">
                            <label for="amount">Cantidad</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control">
                            <span class="text-danger error-text amount_error"></span>
                        </div>
                        <!-- Modal footer -->
                        <button type="submit" class="btn btn-success" id="SubmitIngressForm">OK</button>
                        {{-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> --}}
                    </form>

                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script type="text/javascript">
        var currentLang = "{{ strtoupper(app()->getLocale()) }}";
        var dataTable;
        var request_fields;
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Casilleros de búsqueda por columnas
            // SI AÑADES ESTE FOOTER; LAS COLUMNAS SE VUELVEN TODAS DEL MISMO ANCHOOOOOOOOOOOOOO
            $('#SubmitIngressForm').click(function(e) {
                var that = $(this);
                e.preventDefault();
                $.ajax({
                    data: $('#IngressForm').serialize(),
                    url: "{{ route('user.ingress.store') }}",
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
                            $('#IngressForm').trigger("reset");
                            $('#modalIngress').modal('hide');
                            toastr.success(data.submit_store_success, '', {
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                            });
                            location.reload();

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
        });

        /* function clean_fields() {
            $('#IngressForm').trigger("reset");
            resetErrorMsg();
            $('#IngressForm').find('input[type=hidden]').each(function() {
                this.value = null;
            });
        } */

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
@stop
