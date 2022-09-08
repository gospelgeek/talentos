@extends('layouts.dashboard')

@section('title', 'Grupos')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">{{ $name }} <br> {{ $materia }}</h1>
    <script id="json" type="text" src="/students.json"></script>
   
    <div class="card">        
    	<div class="card-body">
    		<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td>Nombre</td>
                			<td>Linea</td>
                            <td>Docente</td>
                			<td>SESIONES CALIFICADAS</td>
                            <td>SESIONES PROGRAMADAS</td>
                            <td>Acciones</td>
            			</tr>
        			</thead> 
        			<tbody>
           	 			@foreach ($info_grupos as $grupo)
                		<tr>
                    		<td>{{ $grupo->name_grupo }}</td>
                            <td>{{ $grupo->linea }}</td>
                            <td>{{ $grupo->docente_name }}</td>
                    		<td>{{ $grupo->sesiones}}</td>
                            <td>{{ $grupo->programadas}}</td>
                            <td>
                                <div class="row">                                  
                                    <div class="col-xs-6 col-sm-6">
                                        <a title="Ver Informacion" href="/sesiones_grupal_asistencias/grupo/{{$grupo->group_id}}/{{$materia}}" class="btn btn-block btn-sm  fa fa-eye">Lista Sesiones</a>    
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
<a href="{{route('docentes')}}">Regresar</a>
@push('scripts')
<script type="module" src="/js/grupos_asistencias.js"></script>
@endpush
@endsection
