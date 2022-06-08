@extends('layouts.dashboard')

@section('title', $name->name ." ". $grupo->name)
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<h1 id="num_sesiones" style="text-align: center;">{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}<br> Total Sesiones </h1>
<div class="table-responsive" >
	<table id="example1" class="table table-bordered table-striped">
					{{--<div id="carga" class="d-flex justify-content-center">
						<strong>Procesando&nbsp;</strong>
                    	<div class="spinner-border spinner-border-sm" role="status">					
						</div>
					</div>--}}
                    <thead>
                        <tr>
                            <td>Fecha</td>
                            <td>Asistieron</td>
                            <td>No asistieron</td>
                            <td width="15%">Accion</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sesiones as $sesion)
                    	<tr>
                            <td>{{$sesion->sessdate}}</td>
                            <td>{{$sesion->asistieron}}</td>
                            <td>{{$sesion->no_asistieron}}</td>
                            <td>
                                <div >                                  
                                    <div class="col-xs-12 col-sm-12">
                                        <a title="Ver Informacion" href="/Asistencias/{{$name->id}}/grupo/{{$grupo->id}}/session/{{$sesion->session_id}}" class="btn  btn-sm  fa fa-eye">Lista</a>    
                    
                                        <a title="Enlace Campus virtual" href="https://campusvirtual.univalle.edu.co/moodle/mod/attendance/take.php?id={{$course->instance_id}}&sessionid={{$sesion->session_id}}&grouptype=0" class="btn btn-sm fa fa-external-link" target="_blank">Campus</a>    
                                    </div>
                                </div>
                            </td>   
                        </tr>
                        @endforeach
                    </tbody>
    </table>                
</div>
<a href="{{route('asistencias.grupos',$name->id)}}" class="fa fa-arrow-left">Regresar</a>
@push('scripts')
<script type="module" src="/js/asignaturas.js"></script>
@endpush
@endsection
