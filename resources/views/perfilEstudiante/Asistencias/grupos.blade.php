@extends('layouts.dashboard')

@section('title', 'Grupos')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">{{ $name->name}}</h1>
    <div class="card">        
    	<div class="card-body">
        	@if(auth()->user()->rol_id == 4)
       		<div class="row">
            	<div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class="btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Crear Grupo</a>            
            	</div>
        	</div>
        	@endif

    		<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td>Nombre</td>
                			<td>Cohorte</td>
               				<td>Acciones</td>
            			</tr>
        			</thead> 
        			<tbody>
           	 			@foreach ($grupos as $grupo)
                		<tr data-id="grupo-id">
                    		<td>{{ $grupo->name}}</td>
                    		<td>{{ $grupo->cohort->name}}</td>                                  
                    		<td>
                        		<div class="row">                                  
                            		<div class="col-xs-6 col-sm-6">
                                		<a title="Ver Informacion" href="/Asistencias/{{$name->id}}/grupo/{{$grupo->id}}" class="btn btn-block btn-sm  fa fa-eye">Lista Sesiones</a>    
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
<a href="{{route('asistencias')}}">Regresar</a>
@push('scripts')
<script type="text/javascript">
$("#example1").DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "language": {
                                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        "dom": 'Bfrtip',
                        "buttons": ["copy", "csv", "excel", "pdf", "print"]
                });   
</script>
@endpush
@endsection