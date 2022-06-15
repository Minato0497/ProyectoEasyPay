@extends('adminlte::page')

@section('title', 'Operation Type')

@section('content_header')
    <h1>Movimientos</h1>

@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                    </div>
                    <div class="row mt-2 filters">
                        <div class="col-md-1 col-sm-12">
                            <i class="fas fa-search" style="font-size: 2em;"></i>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="filter_emisor">Emisor</label>
                            <p>
                                <select class="movement_filters" name="filter_emisor" id="filter_emisor">
                                    <option value="xxx"> -- --</option>
                                    @foreach ($users as $model)
                                        <option value="{{ $model->id }}">
                                            {{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </p>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="filter_receptor">Receptor</label>
                            <p>
                                <select class="movement_filters" name="filter_receptor" id="filter_receptor">
                                    <option value="xxx"> -- --</option>
                                    @foreach ($users as $model)
                                        <option value="{{ $model->id }}">
                                            {{ $model->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </p>
                        </div>
                        <div class="col-md-1 col-sm-12">
                            <label><b>Filtar</b></label>
                            <p>
                                <button id="reseteador" class="btn btn-secondary">Reset&nbsp;filters</button>
                            </p>
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
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                    url: "{{ route('admin.movements.getMovementDatatable') }}",
                    data: function(d) {
                        d.filter_emisor = $('#filter_emisor').val();
                        d.filter_receptor = $('select[name=filter_receptor] option').filter(
                            ':selected').val();
                    }
                },
                columns: [{
                        data: 'codMovement',
                        name: 'codMovement',
                        title: '#'
                    },
                    {
                        data: 'date_movement',
                        name: 'date_movement',
                        title: 'Fecha&nbsp;movement'
                    },
                    {
                        data: 'operation_type',
                        name: 'operation_type',
                        title: 'Tipo&nbsp;de&nbsp;operatcíon'
                    },
                    {
                        data: 'emisor',
                        name: 'emisor',
                        title: 'Emisor'
                    },
                    {
                        data: 'receptor',
                        name: 'receptor',
                        title: 'Receptor'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        title: 'Cantidad'
                    },
                    {
                        data: 'success',
                        name: 'success',
                        title: 'Success'
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
            $('.movement_filters').select2({
                multiple: false,
                // allowClear: true,   SI LO DESCOMENTAS SE PUEDE QUITAR LA OPCION DEFAULT ( -- ) DEL FILTRO Y EXPLOTA AL DESCARGAR
                width: '100%'
            });
            //Resfrescar cada vez que filtran
            $('.movement_filters').on('select2:select', function() {
                dataTable.ajax.reload(null,
                    false); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
            });
            //Resetear filtros custom datatable
            $("#reseteador").click(function(e) {
                //.change()  no le metas, porque salta 4 veces!
                $('.movement_filters').val('xxx').change();
                dataTable.colReorder.reset()
                    .search('')
                    .columns().search('')
                    .draw();
                dataTable.ajax.reload(null,
                    false); //los parámetros permiten que aunque se refresque, te quedes en la misma página;
            });
        });
    </script>
@stop
