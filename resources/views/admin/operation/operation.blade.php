@extends('adminlte::page')

@section('title', 'Tipo de operacíon')

@section('content_header')
    <h1>Tipo de operacíon</h1>

@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a class="btn btn-success" href="javascript:void(0)" id="createNewOperationType"> <i
                                class="fas fa-plus"></i>
                            Add</a><br><br>

                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped datatable">
                            <!-- table-bordered  -->
                            <tfoot>
                                <tr>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="mySearchIcon"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Article Modal -->
    <div class="modal fade" id="modalOperationType" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading">Dep Create</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form id="OperationTypeForm">
                    @csrf
                    <input type="hidden" name="codOperationType" id="codOperationType">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tipo de operacíon</label>
                            <input type="text" name="operation_type" id="operation_type" class="form-control">
                            <span class="text-danger error-text operation_type_error"></span>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="SubmitOperationTypeForm">OK</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </di    v>
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
            dataTable = $('#datatable').DataTable({
                dom: 'RlBfrtip',

                colReorder: true,
                autoWidth: false,
                //serverSide:true,
                stateSave: true,
                //orderable: false,
                processing: true,
                responsive: true,
                bLengthChange: false,
                lengthMenu: [
                    [25, 40, 50],
                    ['25 rows', '40 rows', '50 rows']
                ],
                buttons: [
                    //'copy',
                    'colvis',
                    'pageLength',
                    'excel',
                    /*
                    {
                        extend: 'excel',
                        action: function(data, type, full, row, meta) {
                            var filter = $('input[name=cod_filter]:checked').val();
                            window.location.href = 'archiveExcel/' + filter;
                        }
                    },
                    */
                    {
                        text: function(dt) {
                            return 'Refresh';
                        },
                        //fuera filtros
                        action: function(e, dt, node, config) {
                            dataTable
                                .colReorder.reset()
                                .search('')
                                .columns().search('')
                                .draw();
                            dataTable.ajax.reload(null,
                                false
                            ); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
                        }
                    },
                ],
                ajax: {
                    url: "{{ route('admin.operationTypes.getOperationTypeDatatable') }}",
                    /* data: function(d) {
                        d.estadoContactoFiltrado = $('input[name=cod_filter]:checked').val();
                    } */
                },
                columns: [{
                        data: 'codOperationType',
                        name: 'codOperationType',
                        title: '#'
                    },
                    {
                        data: 'operation_type',
                        name: 'operation_type',
                        title: 'Operation&nbsp;Type'
                    },
                    {
                        data: 'Actions',
                        name: 'Actions',
                        orderable: false,
                        searchable: false,
                        sClass: 'text-center',
                    },
                ],
            });
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Casilleros de búsqueda por columnas
            // SI AÑADES ESTE FOOTER; LAS COLUMNAS SE VUELVEN TODAS DEL MISMO ANCHOOOOOOOOOOOOOO
            $('#datatable tfoot th').each(function(i) {
                if ($(this).hasClass("searchable")) {
                    var title = $('#datatable tfoot th').eq($(this).index()).text();
                    if (title == "#") {
                        $(this).html('<input type="text" size="2" placeholder="" data-index="' + i +
                            '" value=""/>');
                    } else {
                        $(this).html('<input type="text" size="10" placeholder="" data-index="' + i +
                            '" value=""/>');
                    }
                } else if ($(this).hasClass("mySearchIcon")) {
                    $(this).html('<i class="fas fa-search" style="font-size: 2em;"></i>');
                }
            });
            // Busqueda por columnas TANTO POR INTRO COMO POR TABULADOR //////////
            $("#datatable tfoot input").on('keyup change', function(e) {
                if (e.keyCode === 13) {
                    dataTable
                        .column($(this).parent().index() + ':visible')
                        .search(this.value)
                        .draw();
                }
            });
            $("#datatable tfoot input").on('focusout', function(e) {
                dataTable
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
            });
            ////
            // Restaurar la busqueda por columnas al refrescar o volver a la pagina
            var state = dataTable.state.loaded();
            if (state) {
                dataTable.columns().eq(0).each(function(colIdx) {
                    var colSearch = state.columns[colIdx].search;
                    if (colSearch.search) {
                        console.log("State: " + colSearch.search);
                        //esto pega este error: jquery.min.js:2 Uncaught DOMException: Failed to set the 'value' property on 'HTMLInputElement': This input element accepts a filename, which may only be programmatically set to the empty string.
                        //$('input', dataTable.column(colIdx).footer()).val(colSearch.search);
                        $("input", $("#datatable tfoot th")[colIdx]).val(colSearch.search);
                    }
                });
                dataTable.draw();
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $('input[name=cod_filter]').on('change', function() {
                dataTable.ajax.reload(null,
                    false); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
            });
            $('#createNewOperationType').click(function() {
                // $('#SubmitOperationTypeForm').html("create Status");
                clean_fields()
                $('#modalHeading').html("Crear un nuevo Tipo de operacíon");
                $('#modalOperationType').modal('show');
            });
            $('body').on('click', '.edit', function() {
                $('#OperationTypeForm').trigger("reset");
                $('#modalHeading').html("Edit Tipo de operacíon");
                var codoperationtype = $(this).data("codoperationtype");
                var url = "{{ route('admin.operationTypes.edit', ':id') }}";
                url = url.replace(':id', codoperationtype);
                clean_fields();
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(data) {
                        $('#codOperationType').val(codoperationtype).change();
                        $('#operation_type').val(data.operation_type).change();
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
                $('#modalOperationType').modal('show');
            });
            $('body').on('click', '.delete', function() {
                var codoperationtype = $(this).data("codoperationtype");
                var confir = confirm("Are you sure you want to delete the record?");
                if (confir == true) {
                    var url = "{{ route('admin.operationTypes.destroy', ':id') }}";
                    url = url.replace(':id', codoperationtype);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(data) {
                            if ($.isEmptyObject(data.submit_delete_error)) {
                                dataTable.ajax.reload(null,
                                    false
                                ); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
                                toastr.info(data.submit_delete_success, '', {
                                    "positionClass": "toast-top-right",
                                    "timeOut": "3000",
                                });
                            } else {
                                //Si al guardar salta el catch (foreign key o cualquier exception sql)
                                if (!$.isEmptyObject(data.submit_delete_error)) {
                                    toastr.warning(data.submit_delete_error, '', {
                                        "positionClass": "toast-top-right",
                                        "timeOut": "3000",
                                    });
                                } else {
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
                }
            });
            $('#SubmitOperationTypeForm').click(function(e) {
                var that = $(this);
                e.preventDefault();
                $.ajax({
                    data: $('#OperationTypeForm').serialize(),
                    url: "{{ route('admin.operationTypes.store') }}",
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
                            $('#OperationTypeForm').trigger("reset");
                            $('#modalOperationType').modal('hide');
                            dataTable.ajax.reload(null,
                                false
                            ); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
                            clean_fields();
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
        });

        function clean_fields() {
            $('#OperationTypeForm').trigger("reset");
            resetErrorMsg();
            $('#OperationTypeForm').find('input[type=hidden]').each(function() {
                this.value = null;
            });
        }

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
