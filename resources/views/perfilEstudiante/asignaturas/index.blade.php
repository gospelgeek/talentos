@extends('layouts.dashboard')

@section('title', 'Asignaturas')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">ASIGNATURAS</h1>
    <div class="card">        
    	<div class="card-body">
        	@if(auth()->user()->rol_id == 1)
       		<div class="row">
            	<div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class=" disabled btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Crear Asignatura</a>            
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
                    		<td>{{ $asignatura->cohortcourse ? $asignatura->cohortcourse->name : null}}</td>                                  
                    		<td>
                        		<div class="row">                                  
                            		<div class="col-xs-6 col-sm-6">
                                		<a title="Ver Informacion" href="{{ route('grupos', $asignatura->id) }}" class="btn btn-block btn-sm  fa fa-eye"> grupos</a>    
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
<div id="images"></div>

@push('scripts')

{!!Html::script('/js/asignaturas.js')!!}
@endpush
@endsection