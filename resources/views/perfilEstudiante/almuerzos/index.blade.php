@extends('layouts.dashboard')
@section('title', 'Almuerzos')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
<input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">ALMUERZOS</h1>
	<div class="card">
		<div class="card-body">
			<div class="btn-group">
				<div class="col-xs-12 col-md-12 col-sm-3">
					{!!link_to('#',$title = 'NUEVO REGISTRO', $attributes = ['class'=>'btn btn-primary abrir_modal_almuerzos'],$secure = null)!!}
				</div>
			</div><br>
			<br><div class="table-responsive">
				<table id="example1" class=" table table-bordered table-striped">
                    <table id="example1" class=" table table-bordered table-striped">
					<thead>
						<tr>
							<td>FECHA</td>
							<td>ALMUERZOS LINEA 1</td>
							<td>ALMUERZOS LINEA 2</td>
							<td>ALMUERZOS LINEA 3</td>
							<td>TOTAL</td>
							<td>ACCIONES</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@include('perfilEstudiante.almuerzos.modal.create')
@include('perfilEstudiante.almuerzos.modal.edit')
@include('perfilEstudiante.almuerzos.modal.alerta')

{!!Form::open(['id'=>'form-edit','route'=>['editar_registro_almuerzo',':ALMUERZO_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}

{!!Form::open(['id'=>'form-delete','route'=>['eliminar_registro_almuerzo',':ALMUERZO_ID'], 'method'=>'DELETE'])!!}
{!!Form::close()!!}

@push('scripts')
{!!Html::script('/js/almuerzos.js')!!}

<script>

$(document).ready(function(){
	var table = $("#example1").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.almuerzos')}}",
        },

        "columns": [
        	{data: 'date'},
        	{data: 'number_lunches_line1'},
        	{data: 'number_lunches_line2'},
            {data: 'number_lunches_line3'},
            {data: 'total'},
            {data: null, render:function(data, type, row, meta){

            	var rol = document.getElementById('roles').value;
            	if(rol == 1 || rol == 2 || rol == 4){
            		mstr = '<div class="col-xs-6 col-sm-6 btn-group">'+
            			
                            '<a class="btn btn-block fa fa-pencil-square-o" title="Editar seguimiento" onclick="editar_registro_almuerzo('+data.id+')"></a>'+
                        '</div>'+
                        '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn text-danger btn-block fa fa-trash fa" title="Eliminar seguimiento" onclick="eliminar_registro_almuerzo('+data.id+', \''+data.date+'\')" id="boton"></button>'+
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
    
});

	function editar_registro_almuerzo(dato){

		var form = $('#form-edit');
        var url = form.attr('action').replace(':ALMUERZO_ID', dato);
		var data = form.serialize();
		

		$.get(url, function(result){
        //alert(result.calendario_nombre);
       
        $("#idregistro").val(result.id);
        $('#fechaAlmuerzo').val(result.date);  
        $('#cantLinea1').val(result.number_lunches_line1);       
        $('#cantLinea2').val(result.number_lunches_line2); 
        $("#cantLinea3").val(result.number_lunches_line3);       
        
        $('#modal_editar_almuerzo').modal('show');

       });
		
	}

	function eliminar_registro_almuerzo(id, date){
		
		$('#fecha_almuerzo').empty();
		//$('#id_registro').empty();
		let h8 = document.createElement('h8');
        h8.innerHTML = date;
        document.getElementById('fecha_almuerzo').appendChild(h8);
		document.getElementById('id_registro').setAttribute('data-id', id);

	    $('#modal_alerta_almuerzos').modal('show');

	}

	
</script>
@endpush
@endsection
