@extends('layouts.dashboard')

@section('title', 'Asistencias')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
@include('../alerts.errors')

<h1 style="text-align:center;">ASISTENCIAS</h1>
<script id="json" type="text" src="/students.json"></script>

<div class="container-fluid">    
    <div class="card">        
    	<div class="card-body">
        	            @if((auth()->user()->rol_id == 1) || auth()->user()->cedula == 14837069) 
            
                <form method="POST" action="store/save/json" accept-charset="UTF-8" enctype="multipart/form-data"> 
                   {{ csrf_field() }}
                    <div class="row">
                        <div class=" col-xs-4 col-md-4">
                            {!!Form::label('archivo','Seleccione Archivo:')!!}                            
                            {!!Form::file('sesiones',[ 'accept'=>'.json','class'=>'form-control-file form-group','required'])!!} 
                            <button type="submit" class="btn btn-danger ">Enviar</button>
                        </div>
                    </div>    
                </form>
                <br>
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('crear_excel_json')}}">EXPORTAR REPORTE GENERAL</a>
            <br>
            @endif
            @if(auth()->user()->rol_id == 4)
            <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('crear_excel_json')}}">EXPORTAR REPORTE GENERAL</a>
            @endif
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
                                		<a title="Ver Informacion" href="{{ route('asistencias.grupos', $asignatura->id) }}" class="btn btn-block btn-sm  fa fa-eye"> grupos</a>    
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
