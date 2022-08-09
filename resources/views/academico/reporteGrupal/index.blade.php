@extends('layouts.dashboard')
@section('title', 'Seguimiento Academico')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<h1 style="text-align:center;">SEGUIMIENTO ACADEMICO</h1>
	<div class="card">
		<div class="card-body">
			<form method="POST" action="cargar_seguimientos" accept-charset="UTF-8" enctype="multipart/form-data"> 
                   {{ csrf_field() }}
                    <div class="row">
                        <div class=" col-xs-4 col-md-4">
                            {!!Form::label('archivo','Subir archivo JSON de seguimientos:')!!}                            
                            {!!Form::file('grades',[ 'accept'=>'.json','class'=>'form-control-file form-group','required'])!!} 
                            <button type="submit" class="btn btn-danger ">Enviar</button>
                        </div>
                    </div>    
                </form>
            <hr>
			<br>
			<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td width="30%">Nombre</td>
                			<td>Area Asignatura</td>
                			<td>Cohorte</td>
               				<td>Acciones</td>
            			</tr>
        			</thead> 
        			<tbody>
           	 			@foreach ($asignaturas as $asignatura)
                		<tr  data-id="{{$asignatura->id}}">
                    		<td>{{ $asignatura->name}}</td>
                    		<td>{{ $asignatura->area}}</td>
                    		<td>{{ $asignatura->cohortcourse ? $asignatura->cohortcourse->name : null}}</td>                                  
                    		<td>
                        		<div class="row">                                  
                            		<div class="col-xs-6 col-sm-6">
                                		<a title="Ver Grupos" href="{{ route('seguimientos_academicos.grupos', $asignatura->id) }}" class="btn btn-block btn-sm  fa fa-eye"> grupos</a>    
                            		</div>
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

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
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
                "paginate":{
                    "next" : "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    });


      
</script>
@endpush
@endsection