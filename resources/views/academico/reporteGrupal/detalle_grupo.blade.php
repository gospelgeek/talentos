@extends('layouts.dashboard')
@section('title', 'Seguimiento Academico Grupal/Detalle')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<h1 style="text-align: center;">{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}<br>
		<a title="Enlace Campus virtual" href="https://campusvirtual.univalle.edu.co/moodle/grade/report/grader/index.php?id={{$course_moodle->course_id}} "class="btn fa fa-external-link primary" target="_blank" style="color: #0d6efd;">Campus</a>
	</h1>

	<div class="card">
		<div class="card-body">
			<br><div class="table-responsive">
				<table id="example1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Documento</th>
                            <th>Docente</th>
							<th>Asistencia Participativa</th>
							<th>Seguimiento Academico</th>
							<th>Autoevaluación</th>
							<th>Item Huerfanos</th>
							<th style="width=20%">Total Curso</th>
						</tr>
					</thead>
					<tbody>
						@foreach($estudiantes as $estudiante)
						<tr>
							<td>{{$estudiante->name}}</td>
							<td>{{$estudiante->lastname}}</td>
							<td>{{$estudiante->document_number}}</td>
                            <td>{{$estudiante->docente}}</td>
							@if(is_numeric($estudiante->asistencia))
							<td><a data-tipo="1" data-name_curso="{{$name->name}} - {{$grupo->name}} - {{$grupo->cohort->name}}" data-name="{{$estudiante->name.' '.$estudiante->lastname}}" data-course="{{$course_moodle->course_id}}" data-idmoodle="{{$estudiante->id_moodle}}" data-categoria="Asistencia Participativa" type="button" onclick="abrirmodal(this);" ><u>{{$estudiante->asistencia}}</u></a></td>
							@else
							<td>{{$estudiante->asistencia}}</td>
							@endif

							@if(is_numeric($estudiante->seguimientos))
							<td><a data-tipo="2" data-name_curso="{{$name->name}} - {{$grupo->name}} - {{$grupo->cohort->name}}" data-name="{{$estudiante->name.' '.$estudiante->lastname}}" data-course="{{$course_moodle->course_id}}" data-idmoodle="{{$estudiante->id_moodle}}" data-categoria="Seguimiento Academico" type="button" onclick="abrirmodal(this);"><u>{{$estudiante->seguimientos}}</u></a></td>
							@else
							<td>{{$estudiante->seguimientos}}</td>
							@endif

							@if(is_numeric($estudiante->autoevaluacion))
							<td><a data-tipo="3" data-name_curso="{{$name->name}} - {{$grupo->name}} - {{$grupo->cohort->name}}"data-name="{{$estudiante->name.' '.$estudiante->lastname}}" data-course="{{$course_moodle->course_id}}" data-idmoodle="{{$estudiante->id_moodle}}" data-categoria="Autoevaluación" type="button" onclick="abrirmodal(this);"><u>{{$estudiante->autoevaluacion}}</u></a></td>
							@else
							<td>{{$estudiante->autoevaluacion}}</td>
							@endif

							@if($items_huerfanos > 0)
							<td><a data-tipo="4" data-name_curso="{{$name->name}} - {{$grupo->name}} - {{$grupo->cohort->name}}"data-name="{{$estudiante->name.' '.$estudiante->lastname}}" data-course="{{$course_moodle->course_id}}" data-idmoodle="{{$estudiante->id_moodle}}" data-categoria="Items Huerfanos" type="button" onclick="abrirmodal(this);" ><i class="fa fa-eye" aria-hidden="true"></i>Detalles</a></td>
							@else
							<td>-</td>
							@endif
							<th>{{$estudiante->total_curso}}</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<a href="/seguimiento_academico/{{$name->id}}" class="fa fa-arrow-left">Regresar</a>
@include('academico.reporteGrupal.modal.itemshuerfanos')
@push('scripts')

<script>

	function abrirmodal(e){
		var id_moodle = $(e).attr("data-idmoodle");
		var id_curso = $(e).attr("data-course");
		//console.log(id_moodle,id_curso);
		var nombre = $(e).attr("data-name");
		$("#nombre").text(nombre);
		var tipo =  $(e).attr("data-tipo");
		var curso_categoria = $(e).attr("data-name_curso");
		$("#curso").text(curso_categoria);
		var categoria = $(e).attr("data-categoria");
		$("#categoria").text(categoria);
	
		if(tipo == 4){
			$("#title").text("REPORTE DE ITEMS HUERFANOS");
		}else{
			$("#title").text("SEGUIMIENTOS ACADEMICOS");
		}

		var table = $("#example2").DataTable({
				"ajax":{
                "method":"GET",
                "url": "{{route('estudiante.itemshuerfanos')}}",
                "data": function(d){
                    
                    d.id_moodle = id_moodle;
                    d.id_curso = id_curso;
                    d.tipo = tipo;                
                	},
                },	
                "columns": [
                {data: 'item_name'},
                {data: 'grade'}
                ],
                "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            	"paging": true, "lengthChange": false, "autoWidth": false,"ordering": false,
            	"destroy": true,"searching": false,      
       	});

       	$('#modal_items_huerfanos').modal('show');
	}

	$("#example1").DataTable({
            "processing": true,
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            buttons: [     
                      {
                        extend: 'excel',
                        text: 'EXPORTAR EXCEL',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current',

                                                  }
                                        }
                      },
                      {
                        extend: 'pdf',
                        text: 'EXPORTAR PDF',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                      {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                    ]
      });
</script>
@endpush
@endsection
