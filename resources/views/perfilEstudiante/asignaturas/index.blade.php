@extends('layouts.dashboard')

@section('title', 'Asignaturas')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">ASIGNATURAS</h1>
    <div class="card">        
    	<div class="card-body">
        	@if(auth()->user()->rol_id == 4)
       		<div class="row">
            	<div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class="btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Crear Asignatura</a>            
            	</div>
        	</div>
        	@endif

    		<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td>Nombre</td>
                			<td>Codigo Asignatura</td>
                			<td>Cohorte</td>
               				<td>Acciones</td>
            			</tr>
        			</thead> 
        			<tbody>
           	 			@foreach ($asignaturas as $asignatura)
                		<tr data-id="{{$asignatura->id}}">
                    		<td>{{ $asignatura->name}}</td>
                    		<td>{{ $asignatura->course_code}}</td>
                    		<td>{{ $asignatura->cohortcourse->name}}</td>                                  
                    		<td>
                        		<div class="row">                                  
                            		<div class="col-xs-6 col-sm-6">
                                		<a title="Ver Informacion" href="{{ route('grupos', $asignatura->id_cohort) }}" class="btn btn-block btn-sm  fa fa-eye"> grupos</a>    
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

    <!-- Page specific script -->
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