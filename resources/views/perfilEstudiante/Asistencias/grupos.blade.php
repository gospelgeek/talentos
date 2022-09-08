@extends('layouts.dashboard')

@section('title', 'Grupos')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">{{ $name->name}} <br> {{$name->cohortcourse->name}}</h1>
    <script id="json" type="text" src="/students.json"></script>
    
    <input type="hidden" id="code_curse"  data-name="{{ $name->name}}" data-cohort="{{ $name->cohortcourse->id}}" data-courseid="{{$name->id}}">
    <div class="card">        
    	<div class="card-body">
    		<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td>Nombre</td>
                            <td>Docente</td>
                			<td>SESIONES CALIFICADAS</td>
                            <td>SESIONES PROGRAMADAS</td>
               				<td>Acciones</td>
            			</tr>
        			</thead> 
        			<tbody>
           	 			@foreach ($grupos as $grupo)
                		<tr data-id="grupo-id">
                    		<td>{{ $grupo->name}}</td>
                            <td>{{ $grupo->docente}}</td>
                    		<td>{{ $grupo->sesiones}}</td>
                            <td>{{ $grupo->programadas}}</td>                               
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
<script type="module" src="/js/grupos_asistencias.js"></script>
@endpush
@endsection
