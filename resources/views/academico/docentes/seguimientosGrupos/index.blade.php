@extends('layouts.dashboard')
@section('title', 'Seguimiento Academico Grupal')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<h1 style="text-align:center;">{{ $name }}<br>SEGUIMIENTO ACADEMICO GRUPAL<br> {{ $materia }}</h1>
	<div class="card">
		<div class="card-body">
			<br><div class="table-responsive">
				<table id="example1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Linea</th>
							<th>Docente</th>
							<th>Promedio Asistencia Participativa</th>
							<th>Promedio Seguimientos Académicos</th>
							<th>Promedio Autoevaluación</th>
							<th>Items Huerfanos</th>
							<th style="width: 15%;">Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach($info_grupos as $grupo)
						<tr>
							<td>{{$grupo->name_grupo}}</td>
							<td>{{$grupo->linea}}</td>
							<td>{{$grupo->docente_name}}</td>
							<td>{{$grupo->promedio_asistencia}}</td>
							<td>{{$grupo->promedio_seguimientos}}</td>
							<td>{{$grupo->promedio_autoevaluacion}}</td>
							<td>{{$grupo->items_huerfanos}}</td>
							<td>
							    <div class="row">
								<div class="col-xs-9 col-sm-9">
                                				     <a title="Ver Informacion Detallada" href="/detalle_seguimiento_academico_docentes/grupo/{{$grupo->group_id}}/{{$materia}}" class="btn btn-block btn-sm  fa fa-eye">detalles</a>    
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
<a class="fa fa-arrow-left" href="{{route('docentes')}}">Regresar</a>

@push('scripts')
<script>
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
