@extends('layouts.dashboard')
@section('title', 'Reporte General de notas individuales')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<h1 style="text-align:center;">REPORTE GENERAL DE NOTAS INDIVUDALES</h1>
	<div class="card">
		<div class="card-body">
			<div class="btn-group">
				<div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                	{!!Form::label('cohorte','Linea: ')!!}
       	        	{!!Form::select('cohorte', $cohorte, null,['id'=>'cohorTe','class'=>	'form-control','required', 'placeholder'=>'Seleccione una opción'])!!}
            	</div>
           	</div>
			<br>
			<div class="table-responsive">
				<table id="linea_1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			@if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                				<th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			@endif
                			<th rowspan="2">Estado</th>
                			<th colspan="4">ACCION CIUDADANA</th>
                			<th colspan="4">ARTES</th>
                			<th colspan="4">CULTURA DEMOCRATICA</th>
                			<th colspan="4">DEPORTE</th>
                			<th colspan="4">DIALOGO</th>
                			<th colspan="4">FILOSOFIA</th>
                			<th colspan="4">FISICA</th>
                			<th colspan="4">INGLES</th>
                			<th colspan="4">LECTURA CRITICA</th>
                			<th colspan="4">MATEMATICAS</th>
                			<th colspan="4">TIC</th>
               	 			<th rowspan="2">TOTAL</th>
                			<th rowspan="2">VER DETALLE</th>	
						</tr>
						<tr>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>
						</tr>
					</thead>
				</table>
				<table id="linea_2" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			@if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                				<th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			@endif
                			<th rowspan="2">Estado</th>
                			<th colspan="4">ARTES</th>
                			<th colspan="4">BIOLOGIA</th>
                			<th colspan="4">DEPORTE</th>
                			<th colspan="4">DIALOGO</th>
                			<th colspan="4">CONSTITUCION</th>
                			<th colspan="4">FISICA</th>
                			<th colspan="4">GEOGRAFIA</th>
                			<th colspan="4">HISTORIA</th>
               			 	<th colspan="4">INGLES</th>
                			<th colspan="4">LECTURA CRITICA</th>
                			<th colspan="4">MATEMATICAS</th>
                			<th colspan="4">QUIMICA</th>
                			<th colspan="4">TIC</th>
                			<th rowspan="2">TOTAL</th>
                			<th rowspan="2">VER DETALLES</th>			
						</tr>
						<tr>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>
						</tr>
					</thead>
				</table>
				<table id="linea_3" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			@if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                				<th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			@endif
                			<th rowspan="2">Estado</th>
                			<th colspan="4">BIOLOGIA</th>
                			<th colspan="4">CONSTITUCION</th>
                			<th colspan="4">FISICA</th>
                			<th colspan="4">GEOGRAFIA</th>
                			<th colspan="4">HISTORIA</th>
                			<th colspan="4">INGLES</th>
                			<th colspan="4">LECTURA CRITICA</th>
                			<th colspan="4">MATEMATICAS</th>
                			<th colspan="4">QUIMICA</th>
                			<th rowspan="2">TOTAL</th>
                			<th rowspan="2">ACCIONES</th>	
						</tr>
						<tr>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>

							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Total curso</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@push('scripts')

<script>

	$('#linea_1').hide();
	$('#linea_2').hide();
	$('#linea_3').hide();

	$('#cohorTe').on('change', function() {
        var linea = $('#cohorTe').val();
        if(linea == 1){
        	$('#linea_1').show();
        	$('#linea_2').hide();
        	$('#linea_3').hide();
        }
        if(linea == 2){
        	$('#linea_2').show();
        	$('#linea_1').hide();
        	$('#linea_3').hide();	
        }
        if(linea == 3){
        	$('#linea_3').show();
        	$('#linea_1').hide();
        	$('#linea_2').hide();	
        }
        
    });
	
</script>
@endpush
@endsection