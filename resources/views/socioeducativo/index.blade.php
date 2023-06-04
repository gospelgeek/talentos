@extends('layouts.dashboard')
@section('title', 'Socioeducatico')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">
    <h1 style="text-align:center;">ASIGNACION DE ESTUDIANTES</h1>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class=" table table-bordered table-striped">
                    <caption>Ultima modificación en asignaciones: {{ $ultima_asignacion }}</caption>
                    <thead>
                        <tr>
                            <td><b>Nombres</b></td>
                            <td><b>Apellidos</b></td>
                            <td><b>Documento</b></td>
                            <td><b>Codigo</b></td>
                            <td><b>Cohorte</b></td>
                            <td><b>Acompañante</b></td>
                            <td><b>Acciones</b></td>
                        </tr>
                    </thead>
                    <thead>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="0">
                        </td>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="1">
                        </td>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="2">
                        </td>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="3">
                        </td>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="4">
                        </td>
                        <td>
                            <input type="text" class="form-control filter" placeholder="Search" data-column="5">
                        </td>
                        <td></td>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<!-- Page specific script -->
<script>

$(document).ready(function(){
    var table = $("#example1").DataTable({
        "ajax": {
            "method": "GET",
            "url": "{{route('data.asignacion')}}"
        },
        "columns": [{
                data: 'name'
            },
            {
                data: 'lastname'
            },
            {
                data: 'tipoDocumento'
            },
            {
                data: 'codigo'
            },
            {
                data: 'grupo'
            },
            {
                data: null,
                render: function(data, type, row, meta){
                    var apel;
                  
                    if(data.nameUser === null && data.apellidosUser === null){
                        apel = `<div id="nameapel${data.id}">
                            <td></td>
                            </div>`

                        return apel
                    }
                    apel = `<div id="nameapel${data.id}">
                            <td><strong>${data.nameUser} ${data.apellidosUser}</strong></td>
                            </div>`
                    
                    return apel
                }
            },


            {
                data: null,
                render: function(data, type, row, meta) {
                    var mstr;
                    if(data.nameUser === null && data.apellidosUser === null){
                        mstr = `<div class="row">
                                    <div class="col-xs-4 col-sm-4" id="user${data.id}">
                                        <button data-toggle="modal" data-target="#exampleModal${data.id}" title="Editar informacion" class="btn btn-sm btn-block fa fa-pencil">

                                        </button>
                                    </div>
                                   
                                    <div class="modal fade" id="exampleModal${data.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Asignar/Actualizar profesional de Acompañamiento para el estudiante</h5>
                                                    <br>
                                                    <p> <strong>${data.name} ${data.lastname}</strong> C.C/TI: <strong>${data.tipoDocumento}</strong>
                                                        de la linea <strong>${data.grupo}</strong>
                                                    </p>
                                                    <br>
                                                    <p><Strong>Asignar A: </Strong></p>
                                                    <select name="id_user" id="userId${data.id}">
                                                        <option value="" selected></option>
                                                        @foreach ($user as $u)
                                                        <option value="{{$u->id}}">{{$u->name}} {{$u->apellidos_user}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    @method('PUT')
                                                    @csrf
                                                    <button onclick="actualizarDato('${data.id}')" data-dismiss="modal" type="button" class="btn btn-primary fa fa-floppy-o">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>`

                    return mstr;
                    }
                    mstr = `<div class="row">
                                    <div class="col-xs-4 col-sm-4" id="user${data.id}">
                                        <button data-toggle="modal" data-target="#exampleModal${data.id}" title="Editar informacion" class="btn btn-sm btn-block fa fa-pencil">

                                        </button>
                                    </div>
                                   
                                    <div class="modal fade" id="exampleModal${data.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Asignar/Actualizar profesional de Acompañamiento para el estudiante</h5>
                                                    <br>

                                                    <p> <strong>${data.name} ${data.lastname}</strong> C.C/TI: <strong>${data.tipoDocumento}</strong>

                                                        de la linea <strong>${data.grupo}</strong>
                                                    </p>
                                                    <br>
                                                    <p><Strong>Asignar A: </Strong></p>
                                                    <select name="id_user" id="userId${data.id}">
                                                        <option value="" selected>${data.nameUser} ${data.apellidosUser}</option>
                                                        @foreach ($user as $u)
                                                        <option value="{{$u->id}}">{{$u->name}} {{$u->apellidos_user}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    @method('PUT')
                                                    @csrf
                                                    <button onclick="actualizarDato('${data.id}')" data-dismiss="modal" type="button" class="btn btn-primary fa fa-floppy-o">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>`

                    return mstr;
                }
            }

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
    
    $('.filter').keyup(function(){
            table.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });
    
});
</script>

{!!Html::script('/js/socioeducativo.js')!!}">
@endpush
@endsection
