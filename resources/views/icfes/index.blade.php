@extends('layouts.dashboard')
@section('title', 'Icfes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <h1 style="text-align:center;">ICFES</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td >Nombres</td>
                                <td >Apellidos</td>
                                <td >Nº documento</td>
                                <td >Linea</td>
                                <td >Grupo</td>
                                <td >Icfes Entrada</td>
                                <td >Simulacro 1</td>
                                <td >Simulacro 2</td>
                                <td >Icfes De Salida</td>
                                <td >Ver Detalle</td>

                               
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    var table = $("#example1").DataTable({
        "ajax": {
            "method": "GET",
            "url": "{{route('datos_icfes')}}"
        },
        "columns": [{
                data: 'nombre'
            },
            {
                data: 'apellidos'
            },
            {
                data: 'documento'
            },
            {
                data: 'linea'
            },
            {
                data: 'grupo'
            },
            {
                data: 'total_score'
            },
            {
                data: null,
                render:function(data, type, row, meta){
                     return "--"
                }
            },
            {
                data: null,
                render:function(data, type, row, meta){
                     return "--"
                }
            },
            {
                data: null,
                render:function(data, type, row, meta){
                     return "--"
                }
            },
            {
                data: null,
                render:function(data, type, row, meta){
                     return "--"
                }
            },

        ],

        "deferRender": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    });
</script>

@endpush
@endsection