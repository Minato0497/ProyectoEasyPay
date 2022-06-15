@extends('adminlte::page')

@section('title', 'List users')

@section('content_header')
    <h1>Lista de usuarios</h1>
@stop

@section('content')

    @if (Session::has('info'))
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('info') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-title">

                    <div class="row mt-2">

                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped datatable">
                        <!-- table-bordered  -->
                        <tfoot>
                            <tr>
                                <th class="searchable"></th>
                                <th class="searchable"></th>
                                <th class="searchable"></th>
                                <th class="searchable"></th>
                                <th class="xxx"></th>
                                {{-- <th class="searchable"></th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- @livewire('admin.user.role-user-index') --}}
    <!-- Create Article Modal -->
    <div class="modal fade" id="modalRoleForm" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading">Role Create</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form id="Roleform" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">User</label>
                            <input type="text" id="email" name="email" class="form-control form-control-sm" readonly>
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select multiple
                                class="js-example-basic-single js-states form-control form-control-sm roles-permissions"
                                style="width: 100%" id="roles" name="roles[]" required>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text roles_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="permissions">Permissions</label>
                            <select multiple
                                class="js-example-basic-single js-states form-control form-control-sm roles-permissions"
                                style="width: 100%" id="permissions" name="permissions[]">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text permissions_error"></span>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="SubmitRoleForm">OK</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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
                    url: "{{ route('admin.roleUsers.getUserDatatable') }}",
                    data: function(d) {}
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        title: '#'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        title: 'Roles'
                    },
                    {
                        data: 'directPermisions',
                        name: 'directPermisions',
                        title: 'Direct Permisions'
                    },
                    /* {
                        data: 'allPermisions',
                        name: 'allPermisions',
                        title: 'All Permisions'
                    }, */
                    {
                        data: 'Actions',
                        name: 'Actions',
                        title: 'Action'
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
            $('.roles-permissions').select2({
                allowClear: true,
                // minimumResultsForSearch: -1,
                // multiple: true,
                placeholder: 'Selec one'
            });
            $('#SubmitRoleForm').click(function(e) {
                var that = $(this);
                e.preventDefault();
                var data = new FormData($('#Roleform')[0]);
                $.ajax({
                    data: data,
                    url: "{{ route('admin.roleUsers.store') }}",
                    type: "post",
                    dataType: 'json',
                    processData: false, //NECESARIO PARA EL FormData
                    contentType: false, //NECESARIO PARA EL AFormData
                    beforeSend: function(data) {
                        that.hide();
                    },
                    complete: function(data) {
                        that.show();
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.validation_error) &&
                            $.isEmptyObject(data.submit_store_error) &&
                            $.isEmptyObject(data.cancel_store_trait_error)) {
                            $('#Roleform').trigger("reset");
                            $('#modalRoleForm').modal('hide');
                            dataTable.ajax.reload(null,
                                false
                            ); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
                            toastr.success(data.submit_store_success, '', {
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                            });
                        } else {
                            // $('#name').attr('readonly', true);
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
                            else if (!$.isEmptyObject(data.cancel_store_trait_error)) {
                                toastr.error(data.cancel_store_trait_error, '', {
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
                        toastr.error(
                            'Uncaught error, please contact with administrators',
                            '', {
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                            });
                    }
                });
            });
            $('body').on('click', '.edit', function() {
                // $('#name').attr('readonly', true);
                $('#Roleform').trigger("reset");
                $('#modalHeading').html("Edit User Role");
                $('#SubmitRoleForm').html("Save");
                clean_fields();
                var modelid = $(this).data("modelid");
                var rolesSelected = [];
                var permissionsSelected = [];
                var url = "{{ route('admin.roleUsers.edit', ':id') }}";
                url = url.replace(':id', modelid);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(data) {
                        $.each(data.roles, function(k, v) {
                            rolesSelected.push(v.id);
                        });
                        $.each(data.permissions, function(k, v) {
                            permissionsSelected.push(v.id);
                        });
                        $('#id').val(modelid).change();
                        $('#email').val(data.user.email).change();
                        $('#roles').val(rolesSelected).change();
                        $('#permissions').val(permissionsSelected).change();
                    }
                });
                $('#modalRoleForm').modal('show');
            });

        });

        function printErrorMsg(msg) {
            $('.error-text').text('');
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_error').text(value);
            });
        }

        function clean_fields() {
            $('#Roleform').trigger("reset");
            //limpiar
            $('.error-text').text('');
            $('.roles-permissions').change();
            $('#Roleform').find('input[type=hidden]').each(function() {
                this.value = null;
            });
        }
    </script>
@stop
