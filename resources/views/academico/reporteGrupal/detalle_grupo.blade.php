@extends('layouts.dashboard')
@section('title', 'Seguimiento Academico Grupal/Detalle')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<h1 id="num_sesiones" style="text-align: center;">{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}</h1>
	<div class="card">
		<div class="card-body">
			<br><div class="table-responsive">
				<table id="example1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Documento</th>
							<th>Asistencia Participativa</th>
							<th>Seguimiento Academico</th>
							<th>Autoevaluación</th>
							<th>Item Huerfanos</th>
							<th>Total Curso</td>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach($estudiantes as $estudiante)
						<tr>
							<td>{{$estudiante->name}}</td>
							<td>{{$estudiante->lastname}}</td>
							<td>{{$estudiante->document_number}}</td>
							<td>{{$estudiante->asistencia}}</td>
							<td>{{$estudiante->seguimientos}}</td>
							<td>{{$estudiante->autoevaluacion}}</td>
							<td><a class="disabled btn btn-block btn-sm  fa fa-eye" ></a></td>
							<td>{{$estudiante->total_curso}}</td>
							<td><a title="Enlace Campus virtual" href="https://campusvirtual.univalle.edu.co/moodle/grade/report/grader/index.php?id={{$estudiante->id_curso}}"class="btn btn-sm fa fa-external-link" target="_blank">Campus</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<a href="/seguimiento_academico/{{$name->id}}" class="fa fa-arrow-left">Regresar</a>
@push('scripts')

<script>
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