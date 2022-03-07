@extends('layouts.dashboard')
@section('title', 'Socioeducatico')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">
    <div class="card">


        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-md-3 col-sm-3">
                    <h3>ASIGNACION DE ESTUDIANTES</h3>
                </div>
            </div>

            <div class="table-responsive">
                <table id="example1" class=" table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>Nombres</td>
                            <td>Apellidos</td>
                            <td>Documento</td>
                            <td>Codigo</td>
                            <td>Cohorte</td>
                            <td>Usuario Acompañante</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asignaciones as $asignacion)
                        <tr data-id="{{$asignacion->id}}">
                            <td>{{ $asignacion->StudentInfo['name']}} </td>
                            <td>{{ $asignacion->StudentInfo['lastname']}} </td>
                            <td>{{ $asignacion->StudentInfo['document_number']}}</td>
                            <td>{{ $asignacion->StudentInfo['student_code']}}</td>
                            <td>{{ $asignacion->StudentInfo['studentGroup']['group']['cohort']['name']}}</td>
                            <td id="user{{$asignacion->id}}">{{ $asignacion->UserInfo['name']}} {{ $asignacion->UserInfo['apellidos_user']}}</td>
                            <td>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4">
                                        <button data-toggle="modal" data-target="#exampleModal{{$asignacion->id}}" title="Editar informacion" class="btn btn-sm btn-block fa fa-pencil">

                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$asignacion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <p> <strong>{{ $asignacion->StudentInfo['name']}} {{ $asignacion->StudentInfo['lastname']}}</strong> C.C/TI: <strong>{{ $asignacion->StudentInfo['document_number']}}</strong>
                                                        de la linea <strong>{{ $asignacion->StudentInfo['studentGroup']['group']['cohort']['name']}}</strong>
                                                    </p>
                                                    <br>
                                                    <p><Strong>Asignar A: </Strong></p>
                                                    <select name="id_user" id="userId{{$asignacion->id}}">
                                                        <option value="" selected>{{ $asignacion->UserInfo['name']}} {{ $asignacion->UserInfo['apellidos_user']}}</option>
                                                        @foreach ($user as $u)
                                                        <option value="{{$u->id}}">{{$u->name}} {{$u->apellidos_user}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    @method('PUT')
                                                    @csrf
                                                    <button onclick="actualizarDato('{{$asignacion->id}}')" data-dismiss="modal" type="button" class="btn btn-primary fa fa-floppy-o">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--- 
                                    
                                    <div class="col-xs-4 col-sm-4">

                                        @method('PUT')
                                        @csrf
                                        <button onclick="actualizarDato('{{$asignacion->id}}')" id="edit{{$asignacion->id}}" data-toggle="modal" data-target="#exampleModal" hidden title="Editar Informacion " class="btn btn-sm btn-block fa fa-floppy-o">

                                        </button>
                                    </div>
                                    -->
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron coincidencias",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    });
</script>

{!!Html::script('/js/socioeducativo.js')!!}">
@endpush
@endsection