@extends('layouts.dashboard')
@section('title', 'Reporte General de notas individuales')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">REPORTE GENERAL DE NOTAS INDIVIDUALES</h1>
	<div class="card">
		<div class="card-body">
			<div class="btn-group">
				<div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
          {!!Form::label('cohorte','Linea: ')!!}
       	  {!!Form::select('cohorte', $cohorte, null,['id'=>'cohorTe','class'=>	'form-control','required', 'placeholder'=>'Seleccione una opción'])!!}
        </div>
      </div>
      <div id="export_1" class="btn-group" style="display:none;">
				<div class="col-xs-6 col-md-12 col-sm-6">
          <a class="btn btn-primary btn-sm mt-3 mb-3 float-right" href="	
          	{{route('sabana_notas_linea_1')}}">EXPORTAR SÁBANA LINEA 1</a>
        </div>
      </div>
      <div id="export_2" class="btn-group" style="display:none;">
				<div class="col-xs-6 col-md-12 col-sm-6">
          <a class="btn btn-primary btn-sm mt-3 mb-3 float-right" href="{{route('sabana_notas_linea_2')}}">EXPORTAR SÁBANA LINEA 2</a>
        </div>
      </div>
      <div id="export_3" class="btn-group" style="display:none;">
				<div class="col-xs-6 col-md-12 col-sm-6">
          <a class="btn btn-primary btn-sm mt-3 mb-3 float-right" href="{{route('sabana_notas_linea_3')}}">EXPORTAR SÁBANA LINEA 3</a>
        </div>
      </div>
			<br>
			<div class="table-responsive">
				<div id="tabla_1" class="table-responsive" style='display:none'>
				  <table id="linea_1" class="table table-bordered table-striped">
				  <caption>Fecha ultima carga: {{ $carga }}</caption>	
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			<th rowspan="2">Estado</th>
                			<th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			<th colspan="6">ACCION CIUDADANA</th>
                			<th colspan="6">ARTES: CONOCIMIENTO EN ACCIÓN</th>
                			<th colspan="6">BIOLOGIA</th>
                			<th colspan="6">CULTURA DEMOCRATICA</th>
                			<th colspan="6">DEPORTE</th>
                			<th colspan="6">DIALOGO</th>
                			<th colspan="6">FILOSOFIA</th>
                			<th colspan="6">FISICA</th>
                			<th colspan="6">GEOGRAFIA</th>
                			<th colspan="6">HISTORIA</th>
                			<th colspan="6">INGLES</th>
                			<th colspan="6">LECTURA CRITICA</th>
                			<th colspan="6">MATEMATICAS</th>
                			<th colspan="6">QUIMICA</th>
                			<th colspan="6">TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES</th>
                			<th rowspan="2">VER DETALLE</th>	
						</tr>
						<tr>
							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
							
							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
						
							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
						</tr>
					</thead>
				  </table>
				</div>
				<div id="tabla_2" class="table-responsive" style='display:none'>
				  <table id="linea_2" class=" table table-bordered table-striped">
					<caption>Fecha ultima carga: {{ $carga }}</caption>
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			<th rowspan="2">Estado</th>
                			<th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			<th colspan="6">BIOLOGIA</th>
                			<th colspan="6">ARTES: CONOCIMIENTO EN ACCIÓN</th>
                			<th colspan="6">DEPORTE</th>
                			<th colspan="6">DIALOGO</th>
                			<th colspan="6">CONSTITUCION</th>
                			<th colspan="6">FISICA</th>
                			<th colspan="6">GEOGRAFIA</th>
                			<th colspan="6">HISTORIA</th>
               			 	<th colspan="6">INGLES</th>
                			<th colspan="6">LECTURA CRITICA</th>
                			<th colspan="6">MATEMATICAS</th>
                			<th colspan="6">QUIMICA</th>
                			<th colspan="6">TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES</th>
                			<th rowspan="2">VER DETALLES</th>			
						</tr>
						<tr>
							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
						</tr>
					</thead>
				  </table>
				</div>
				<div id="tabla_3" class="table-responsive" style='display:none'>
				  <table id="linea_3" class=" table table-bordered table-striped">
					<caption>Fecha ultima carga: {{ $carga }}</caption>
					<thead>
						<tr>
							<th rowspan="2">Nombres</th>
                			<th rowspan="2">Apellidos</th>
                			<th rowspan="2">Tipo Documento</th>
                			<th rowspan="2">Nº documento</th>
                			<th rowspan="2">Grupo</th>
                			<th rowspan="2">Estado</th>
                		    <th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                			<th colspan="6">BIOLOGIA</th>
                			<th colspan="6">CONSTITUCION</th>
                			<th colspan="6">FISICA</th>
                			<th colspan="6">GEOGRAFIA</th>
                			<th colspan="6">HISTORIA</th>
                			<th colspan="6">INGLES</th>
                			<th colspan="6">LECTURA CRITICA</th>
                			<th colspan="6">MATEMATICAS</th>
                			<th colspan="6">QUIMICA</th>
                			<th colspan="6">TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES</th>
                			<th colspan="6">DIÁLOGO DE SABERES</th>
                            <th colspan="6">PRACTICAS ARTISTICAS</th>
                			<th rowspan="2">ACCIONES</th>	
						</tr>
						<tr>
							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>

							<th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
                            
                            <th>Docente</th>
							<th>Asistencia participativa</th>
							<th>Seguimiento academico</th>
							<th>Autoevaluación</th>
							<th>Item huerfano</th>
							<th>Total curso</th>
						</tr>
					</thead>
				  </table>
				</div>  
			</div>
		</div>
	</div>
</div>

@push('scripts')
@include('academico.reporteGeneral.modal.modal_huerfanos')
@include('academico.reporteGeneral.modal.modal_categorias')
<script>

	$('#cohorTe').on('change', function() {
        var linea = $('#cohorTe').val();
        if(linea == 1){
        	document.getElementById("tabla_1").removeAttribute('style', 'display:none');
        	document.getElementById("export_1").removeAttribute('style', 'display:none');
        }
        else{
        	document.getElementById("tabla_1").setAttribute('style', 'display:none');
        	document.getElementById("export_1").setAttribute('style', 'display:none');	
        }
        if(linea == 2){
        	document.getElementById("tabla_2").removeAttribute('style', 'display:none');
        	document.getElementById("export_2").removeAttribute('style', 'display:none');	
        }else{
        	document.getElementById("tabla_2").setAttribute('style', 'display:none');
        	document.getElementById("export_2").setAttribute('style', 'display:none');
        }
        if(linea == 3){
        	document.getElementById("tabla_3").removeAttribute('style', 'display:none');
        	document.getElementById("export_3").removeAttribute('style', 'display:none');	
        }else{
        	document.getElementById("tabla_3").setAttribute('style', 'display:none');
        	document.getElementById("export_3").setAttribute('style', 'display:none');
        }
    });

    $(document).ready(function(){
    	var table_1 = $("#linea_1").DataTable({
    		"ajax":{
    			"method":"GET",
    			"url":"{{route('datos_notas_individuales_linea1')}}",
    		},
    		"columns": [
            {data: 'name'},
            {data: 'lastname'},
            {data: 'tipo_documento'},
            {data: 'document_number'},
            {data: 'grupo_name'},
            {data: 'estado'},
            {data: 'encargado'},
            
            {data: 'docente_accion_ciudadana'},
            {data: null, render:function(data, type, row, meta){
            		if(data.accionciudadana_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_accion_ciudadana+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"ACCION CIUDADANA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.accionciudadana_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.accionciudadana_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_accion_ciudadana+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"ACCION CIUDADANA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.accionciudadana_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.accionciudadana_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_accion_ciudadana+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"ACCION CIUDADANA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.accionciudadana_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.accionciudadana_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_accion_ciudadana+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"ACCION CIUDADANA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'accionciudadana_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

        	{data: 'docente_artes'},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_artes+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.artes_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
       		},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_artes+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.artes_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_artes+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.artes_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.artes_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_artes+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'artes_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_biologia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_biologia+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.biologia_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_biologia+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.biologia_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_biologia+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.biologia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.biologia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_biologia+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'biologia_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_cultura'},
            {data: null, render:function(data, type, row, meta){
            		if(data.cultura_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_cultura+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"CULTURA DEMOCRATICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.cultura_asistencias+'</u></button class="btn" type="button">';
            		}else{
            			return '-';            		
                    }
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.cultura_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_cultura+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"CULTURA DEMOCRATICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.cultura_seguimientos+'</u></button >';
            		}else{
            			 return '-';
                    }
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.cultura_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_cultura+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"CULTURA DEMOCRATICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.cultura_autoevaluacion+'</u></button>';
            		}else{
            			 return '-';
                    }
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.cultura_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_cultura+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"CULTURA DEMOCRATICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'cultura_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_deporte'},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_deporte+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.deporte_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_deporte+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.deporte_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_deporte+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.deporte_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.deporte_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_deporte+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'deporte_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_dialogo'},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_dialogo+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.dialogo_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_dialogo+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.dialogo_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_dialogo+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.dialogo_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.dialogo_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_dialogo+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'dialogo_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_filosofia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.filosofia_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_filosofia+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"FILOSOFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.filosofia_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.filosofia_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_filosofia+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"FILOSOFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.filosofia_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.filosofia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_filosofia+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"FILOSOFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.filosofia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.filosofia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_filosofia+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"FILOSOFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'filosofia_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_fisica'},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_fisica+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.fisica_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_fisica+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.fisica_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_fisica+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.fisica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.fisica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_fisica+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'fisica_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_geografia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_geografia+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.geografia_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_geografia+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.geografia_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_geografia+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.geografia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.geografia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_geografia+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'geografia_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_historia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_historia+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.historia_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_historia+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.historia_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_historia+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.historia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.historia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_historia+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'historia_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_ingles'},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_ingles+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.ingles_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_ingles+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.ingles_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_ingles+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.ingles_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.ingles_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_ingles+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'ingles_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_lectura'},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_lectura+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.lectura_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_lectura+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.lectura_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_lectura+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.lectura_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.lectura_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_lectura+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'lectura_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_matematicas'},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_matematicas+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.matematicas_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_matematicas+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.matematicas_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_matematicas+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.matematicas_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.matematicas_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_matematicas+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'matematicas_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_quimica'},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_quimica+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.quimica_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_quimica+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.quimica_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_quimica+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.quimica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.quimica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_quimica+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'quimica_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_tic'},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_asistencias != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_tic+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.tic_asistencias+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_seguimientos != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_tic+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.tic_seguimientos+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.courseid_tic+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\', \''+"Autoevaluación"+'\');"><u>'+data.tic_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.tic_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.courseid_tic+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 1"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'tic_totalcurso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            				var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 1 || rol == 2 || rol == 3 || rol == 4 || rol == 5 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    	return mstr;
                    }
                }
            }
        ],
        "deferRender": true,"responsive": false,"processing": false,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "buttons": [
                "copy",
                "csv",
                "pdf",
                "print",
                "colvis"
                
            ]
    	});

    	var table_2 = $("#linea_2").DataTable({
    		"ajax":{
    			"method":"GET",
    			"url":"{{route('datos_notas_individuales_linea2')}}",
    		},
    		"columns": [
            {data: 'name'},
            {data: 'lastname'},
            {data: 'tipo_documento'},
            {data: 'document_number'},
            {data: 'grupo_name'},
            {data: 'estado'},
            {data: 'encargado'},
            {data: 'docente_biologia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.biologia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.biologia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.biologia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.biologia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.biologia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'biologia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_artes'},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.artes_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.artes_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.artes_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.artes_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.artes_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.artes_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.artes_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.artes_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.artes_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"ARTES: CONOCIMIENTO EN ACCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'artes_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
                }
        	},

            {data: 'docente_deporte'},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.deporte_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.deporte_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.deporte_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.deporte_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.deporte_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.deporte_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.deporte_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.deporte_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.deporte_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"DEPORTE Y SALUD INTEGRAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'deporte_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_dialogo'},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.dialogo_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.dialogo_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.dialogo_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.dialogo_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.dialogo_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.dialogo_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO DE SABERES Y ORIENTACION VOCACIONAL"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'dialogo_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_constitucion'},
            {data: null, render:function(data, type, row, meta){
            		if(data.constitucion_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.constitucion_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.constitucion_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.constitucion_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.constitucion_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.constitucion_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.constitucion_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.constitucion_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'constitucion_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_fisica'},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.fisica_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.fisica_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.fisica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.fisica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.fisica_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'fisica_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
                }
        	},

            {data: 'docente_geografia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.geografia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.geografia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.geografia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.geografia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.geografia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'geografia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_historia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.historia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.historia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.historia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
                    }
                }    
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.historia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.historia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'historia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_ingles'},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.ingles_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.ingles_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.ingles_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.ingles_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.ingles_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
                }
        	},
            {data: 'ingles_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_lectura'},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.lectura_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.lectura_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.lectura_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.lectura_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.lectura_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'lectura_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_matematicas'},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.matematicas_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.matematicas_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.matematicas_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.matematicas_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.matematicas_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'matematicas_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_quimica'},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.quimica_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.quimica_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.quimica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.quimica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.quimica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.quimica_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'quimica_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

            {data: 'docente_tic'},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.tic_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.tic_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.tic_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\', \''+"Autoevaluación"+'\');"><u>'+data.tic_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.tic_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.tic_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES"+'\',\''+data.grupo_name+'\', \''+"LINEA 2"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'tic_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},
            {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 1 || rol == 2 || rol == 3 || rol == 4 || rol == 5 || rol == 6){
                       mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    	return mstr;
                    }
                }
            }
        ],
        "deferRender": true,"responsive": false,"processing": false,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "buttons": [
                "copy",
                "csv",
                "pdf",
                "print",
                "colvis"
                
            ]
    	});

    	var table_3 = $("#linea_3").DataTable({
    		"ajax":{
    			"method":"GET",
    			"url":"{{route('datos_notas_individuales_linea3')}}",
    		},
    		"columns": [
            {data: 'name'},
            {data: 'lastname'},
            {data: 'tipo_documento'},
            {data: 'document_number'},
            {data: 'grupo_name'},
            {data: 'estado'},
            {data: 'encargado'},
            {data: 'docente_biologia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.biologia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.biologia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.biologia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
        	{data: null, render:function(data, type, row, meta){
            	    if(data.biologia_autoevaluacion != 0){
            		    return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.biologia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.biologia_autoevaluacion+'</u></button>';
            	    }else{
            		    return '-';
            	    }
                }
        	},
            {data: null, render:function(data, type, row, meta){
            		//console.log(data.biologia_course_id);
            		if(data.biologia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.biologia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"BIOLOGIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'biologia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
        	},

			{data: 'docente_constitucion'},
			{data: null, render:function(data, type, row, meta){
            		if(data.constitucion_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.constitucion_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.constitucion_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.constitucion_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.constitucion_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.constitucion_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.constitucion_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.constitucion_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.constitucion_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"CONSTITUCION"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'constitucion_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
          	},

            {data: 'docente_fisica'},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.fisica_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.fisica_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.fisica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.fisica_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.fisica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.fisica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.fisica_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"FISICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'fisica_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },

            {data: 'docente_geografia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.geografia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.geografia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.geografia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.geografia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.geografia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.geografia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.geografia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"GEOGRAFIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'geografia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },
            
            {data: 'docente_historia'},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.historia_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.historia_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.historia_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.historia_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.historia_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.historia_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.historia_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"HISTORIA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'historia_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },
            
            {data: 'docente_ingles'},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.ingles_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.ingles_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.ingles_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.ingles_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.ingles_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.ingles_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.ingles_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"INGLES"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'ingles_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },
            
            {data: 'docente_lectura'},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.lectura_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_seguimiento_academico != 0){
            			return '<button  class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.lectura_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.lectura_autoevaluacion != 0){
            			return '<button  class="btn" type="button" onclick="abrir_modal_categorias('+data.lectura_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.lectura_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.lectura_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.lectura_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"LECTURA CRITICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'lectura_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },
            
            {data: 'docente_matematicas'},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.matematicas_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.matematicas_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){
            		if(data.matematicas_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.matematicas_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.matematicas_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
            {data: null, render:function(data, type, row, meta){		
            		if(data.matematicas_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.matematicas_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"MATEMATICAS"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
            {data: 'matematicas_total_curso', render:function(data, type, row, meta){
            		return '<b>'+data+'</b>';
            	}
            },
          	
            {data: 'docente_quimica'},
          	{data: null, render:function(data, type, row, meta){
            		if(data.quimica_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.quimica_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
        		{data: null, render:function(data, type, row, meta){
            		if(data.quimica_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.quimica_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.quimica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.quimica_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.quimica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.quimica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.quimica_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"QUIMICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
          	{data: 'quimica_total_curso', render:function(data, type, row, meta){
          			return '<b>'+data+'</b>';
           		}
          	},
          	
          	{data: 'docente_tic'},
          	{data: null, render:function(data, type, row, meta){
            		if(data.tic_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"TIC"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.tic_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
        	{data: null, render:function(data, type, row, meta){
            		if(data.tic_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"TIC"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.tic_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.tic_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.tic_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"TIC"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.tic_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.tic_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.tic_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"TIC"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
          	{data: 'tic_total_curso', render:function(data, type, row, meta){
          			return '<b>'+data+'</b>';
          		}
          	},
          	
          	{data: 'docente_dialogo'},
          	{data: null, render:function(data, type, row, meta){
            		if(data.dialogo_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.dialogo_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
        	{data: null, render:function(data, type, row, meta){
            		if(data.dialogo_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.dialogo_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.dialogo_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.dialogo_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.dialogo_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.dialogo_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.dialogo_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"DIALOGO"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
          	{data: 'dialogo_total_curso', render:function(data, type, row, meta){
          			return '<b>'+data+'</b>';
           		}
          	},
            
            {data: 'docente_practica'},
          	{data: null, render:function(data, type, row, meta){
            		if(data.practica_asistencia != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.practica_course_id+','+data.id_moodle+', 1,\''+data.name+'\', \''+data.lastname+'\', \''+"PRACTICA ARTISTICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Asistencia Participativa"+'\');"><u>'+data.practica_asistencia+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
        	{data: null, render:function(data, type, row, meta){
            		if(data.practica_seguimiento_academico != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.practica_course_id+','+data.id_moodle+', 2,\''+data.name+'\', \''+data.lastname+'\', \''+"PRACTICA ARTISTICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Seguimiento Academico"+'\');"><u>'+data.practica_seguimiento_academico+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.practica_autoevaluacion != 0){
            			return '<button class="btn" type="button" onclick="abrir_modal_categorias('+data.practica_course_id+','+data.id_moodle+', 3,\''+data.name+'\', \''+data.lastname+'\', \''+"PRACTICA ARTISTICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\', \''+"Autoevaluación"+'\');"><u>'+data.practica_autoevaluacion+'</u></button>';
            		}else{
            			return '-';
            		}
            	}
        	},
          	{data: null, render:function(data, type, row, meta){
            		if(data.practica_item_huerfano != 0){
            			return mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a class="ver btn btn-block fa fa-eye fa" title="Ver item huerfanos" type="button" onclick="abrir_modal_huerfanos('+data.practica_course_id+','+data.id_moodle+',\''+data.name+'\', \''+data.lastname+'\', \''+"PRACTICA ARTISTICA"+'\',\''+data.grupo_name+'\', \''+"LINEA 3"+'\');"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          "</div>";
            		}else{
            			return mostrar = '--';
            		}
            	}
        	},
          	{data: 'practica_total_curso', render:function(data, type, row, meta){
          			return '<b>'+data+'</b>';
           		}
          	},
          	{data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 1 || rol == 2 || rol == 3 || rol == 4 || rol == 5 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr>'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar Seguimiento Academico"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    	return mstr;
                    }
                }
            }
        ],
        "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "buttons": [
                "copy",
                "csv", 
                "pdf",
                "print",
                "colvis"
                
            ]
    	});
	});

	function abrir_modal_huerfanos(course_id, id_moodle, name, lastname, asignatura, grupo, linea){

		var nombre_completo = ""+name+" "+lastname+""
		var campo = document.getElementById("nombre");
		campo.innerHTML = nombre_completo;
		var curso = ""+asignatura+" - "+grupo+" - "+linea+""
		var campo2 = document.getElementById("curso");
		campo2.innerHTML = curso;
		var tabla = $("#huerfanos").DataTable({
        	"ajax":{
          		"method": "GET",
          		"url": "{{route('datos.huerfanos.linea3')}}",
          		"data": function(d){
              		d.course_id = course_id;
              		d.id_moodle = id_moodle;
          		},
        	},
        	"columns":[
        		{data: 'item_name'},
        		{data: 'grade', render:function(data, type, row, meta){
        				if(data != null){
        					return data;
        				}else{
        					return '--';
        				}
        			}
        		},
        	],
        	"deferRender": true,"responsive": false,"processing": false,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,
            "destroy":true,"searching": false,
    	});
        $('#modal_huerfanos').modal('show');
	}

	function abrir_modal_categorias(course_id, id_moodle, tipo, name, lastname, asignatura, grupo, linea, categoria){
		var nombre_completo = ""+name+" "+lastname+""
		var curso = ""+asignatura+" - "+grupo+" - "+linea+""
		var categoria = ""+categoria+""
		var campo = document.getElementById("nombreS");
		campo.innerHTML = nombre_completo;
		var campo2 = document.getElementById("cursoS");
		campo2.innerHTML = curso;
		var campo3 = document.getElementById("category");
		campo3.innerHTML = categoria;

		var tabla = $("#categorias").DataTable({
        	"ajax":{
          		"method": "GET",
          		"url": "{{route('datos.categorias')}}",
          		"data": function(d){
              		d.course_id = course_id;
              		d.id_moodle = id_moodle;
              		d.tipo = tipo;
          		},
        	},
        	"columns":[
        		{data: 'item_name'},
        		{data: 'grade', render:function(data, type, row, meta){
        				if(data != null){
        					return data;
        				}else{
        					return '--';
        				}
        			}
        		},
        	],
        	"deferRender": true,"responsive": false,"processing": false,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,
            "destroy":true,"searching": false,
            
        });
        $('#modal_categorias').modal('show');
	}
    
    function redireccionar(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-8#ttlo-8`;
    }   
    function redireccionar_edit(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-8#ttlo-8`;
    }
	
</script>
@endpush
@endsection
