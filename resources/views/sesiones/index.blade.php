@extends('layouts.dashboard')
@section('title', 'Sesiones')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">SESIONES</h1>
	<div class="card">
		<div class="card-body">
			<div class="btn-group">
				<div class="col-xs-12 col-md-12 col-sm-3">
					{!!link_to('#',$title = 'NUEVA SESIÓN', $attributes = ['class'=>'btn btn-primary abrir_modal_sesiones'],$secure = null)!!}
				</div>
			</div><br>
			<br><div class="table-responsive">
				<table id="example1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<td>LINEA</td>
							<td>GRUPO</td>
							<td>ASIGNATURA</td>
							<td>FECHA</td>
							<td>ACCIONES</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@include('sesiones.modal.create')
@include('sesiones.modal.edit')
@include('sesiones.modal.alerta')

{!!Form::open(['id'=>'form-edit','route'=>['editar_registro_sesion',':SESION_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}

{!!Form::open(['id'=>'form-delete','route'=>['eliminar_registro_sesion',':SESION_ID'], 'method'=>'DELETE'])!!}
{!!Form::close()!!}
@push('scripts')

{!!Html::script('/js/sesiones.js')!!}

<script>

	
	
	var table = $("#example1").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.sessiones')}}",
        },

        "columns": [
        	{data: 'cohorte'},
        	{data: 'grupo'},
        	{data: 'course'},
        	{data: 'date_session'},
            {data: null, render:function(data, type, row, meta){

            	var rol = document.getElementById('roles').value;
            	
            	if(rol == 1 || rol == 2 || rol == 3){
            		mstr = '<div class="col-xs-6 col-sm-6 btn-group">'+
            			
                            '<a class="btn btn-block fa fa-pencil-square-o" title="Editar sesión" onclick="editar_registro_sesion('+data.id+', '+data.idcohorte+')"></a>'+
                        '</div>'+
                        '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn text-danger btn-block fa fa-trash fa" title="Eliminar sesión" onclick="eliminar_registro_sesion('+data.id+', \''+data.date_session+'\')" id="boton"></button>'+
                          "</div>"+
                	"</div>";
                }else{
                	mstr = '';	
                }
            	return mstr;

            	}
            }

        ],
        "deferRender": true,"responsive": true, "lengthChange": false, "autoWidth": false,
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print",
                "colvis"
                
         	]

	});

	
	/*
	*/

	
</script>
@endpush
@endsection
