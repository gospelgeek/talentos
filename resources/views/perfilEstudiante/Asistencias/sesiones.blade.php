@extends('layouts.dashboard')

@section('title', $name->name ." ". $grupo->name)
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<script id="json" type="text" src="/json/students.json"></script>
<script id="asisten" type="text" src="/json/asistencias.json"></script>
<h1 id="num_sesiones" style="text-align: center;">{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}<br> Total Sesiones </h1>
<input type="hidden" id="code_curse" data-id="{{$grupo->id}}" data-name="{{ $name->name}}" data-cohort="{{ $grupo->cohort->id}}" data-group="{{$grupo->name}}" data-courseid="{{$name->id}}">
<input type="hidden" id="moodle" name="quotation" data-datos="{{json_encode($id_moole,TRUE)}}">
<div class="table-responsive" id="datos">
	<table id="example1" class="table table-bordered table-striped">
					<div id="carga" class="d-flex justify-content-center">
						<strong>Procesando&nbsp;</strong>
                    	<div class="spinner-border spinner-border-sm" role="status">					
						</div>
					</div>	
                    <thead>
                        <tr>
                            <td>Fecha</td>
                            <td>Asistieron</td>
                            <td>No asistieron</td>
                            <td width="15%">Accion</td>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                    	
                    </tbody>
    </table>                
</div>
<a href="{{route('asistencias.grupos',$name->id)}}" class="fa fa-arrow-left">Regresar</a>
{!!Form::open(['id'=>'form-edit','route'=>['asistencias.asignatura',$name->id,$grupo->id,':SESSIONID'], 'method'=>'GET'])!!}
{!!Form::close()!!}
@push('scripts')
<script type="module" src="/js/asignaturas.js"></script>
@endpush
@endsection