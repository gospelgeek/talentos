@extends('layouts.dashboard')
@section('title', 'Proceso de clasificación')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
	<input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">PROCESO DE CLASIFICACIÓN</h1>
	<div class="card">
		<div class="card-body">
			<div class="btn-group">
                <div class="col-xs-6 col-md-12 col-sm-6">
                    <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('proceso_clasificacion')}}">CORRER SCRIPT DE SELECCIÓN</a>
                </div>
            </div>
            <div class="btn-group">
            	<div class="estado_clasi">
            		<label>CLASIFICADOS:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            		<label>SI</label>&nbsp;<input type="radio" name="filtro" id="yes" checked>&nbsp;&nbsp;&nbsp;&nbsp;
            		<label>NO</label>&nbsp;<input type="radio" name="filtro" id="not">
            	</div>
            </div>
            <div style="float:right;">
                <table id="resumen" class="table-bordered table-striped">
                    <label>RESUMEN PROGRAMAS</label>
                    <thead>
                	    <tr>
                            <th rowspan="2">PROGRAMA</th>
                            <th colspan="2">SEMESTRE I</th>
                            <th colspan="2">SEMESTRE II</th>
                        </tr>
                        <tr>
                           	<th>Cupos Otorgados</th>
                           	<th>Cupos Restantes</th>
                           	<th>Cupos Otorgados</th>
                           	<th>Cupos Restantes</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>TOTAL</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>  
                    </tfoot>
                </table>
            </div>
			<!--<div class="btn-group">
				<div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
          			<select id="intentos" class="form-control">
                        <option>SELECCIONE SEMESTRE 2023</option>
                        <option value="1">Semestre I-2023</option>
                        <option value="2">Semestre II-2023</option>
                    </select>
        		</div>
      		</div>-->
			<br><div class="table-responsive">
				<div id="si_cla">
					<table id="clasificados" class=" table table-bordered table-striped">
						<thead>
							<tr>
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>Nº.DOCUMENTO</th>
								<th>LINEA</th>
								<th>GRUPO</th>
								<th>PROGRAMA</th>
								<th>PUESTO</th>
								<th>OPCIÓN</th>
								<th>TOTAL PONDERADO</th>
								<th>PONDERADO POR AREAS</th>
								<th>PROMEDIO NOTAS</th>
								<th>OPCIONES</th>
								<th>SEMESTRE INGRESO</th>
							</tr>
						</thead>
					</table>
				</div>
				<div id="no_cla" style="display:none;">
					<table id="no_clasificados" class=" table table-bordered table-striped">
						<thead>
							<tr>
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>Nº.DOCUMENTO</th>
								<th>LINEA</th>
								<th>GRUPO</th>
								<th>PROGRAMA</th>
								<th>PUESTO</th>
								<th>OPCIÓN</th>
								<th>TOTAL PONDERADO</th>
								<th>PONDERADO POR AREAS</th>
								<th>PROMEDIO NOTAS</th>
								<th>OPCIONES</th>
								<th>SEMESTRE INGRESO</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@push('scripts')

<script>

	$('.estado_clasi').on('change', function() {
    	var yes = $('#yes').is(":checked");
    	var not = $('#not').is(":checked");

    	if(yes){
    		document.getElementById("no_cla").setAttribute('style', 'display:none');
    		document.getElementById("si_cla").removeAttribute('style', 'display:none');
    	}else{
    		document.getElementById("si_cla").setAttribute('style', 'display:none');
    		document.getElementById("no_cla").removeAttribute('style', 'display:none');
    	}        
    });
	

	var table_3 = $("#resumen").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.resumen')}}",
        },

        "columns": [
        	{data: 'name_program'},
        	{data: 'quotas_I_2023'},
        	{data: 'remaining_quotas_I_2023'},
        	{data: 'quotas_II_2023'},
        	{data: 'remaining_quotas_II_2023'},
        ],
        	"footerCallback": function( tfoot, data, start, end, display ) {
              var api = this.api();
              $( api.column( 1 ).footer() ).html(
                api.column( 1 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
              $( api.column( 2 ).footer() ).html(
                api.column( 2 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
              $( api.column( 3 ).footer() ).html(
                api.column( 3 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
              $( api.column( 4 ).footer() ).html(
                api.column( 4 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
        },
        	"Paging": true, "searching": false, "info": false,"pageLength": 5,
            
	});
	

	var table_1 = $("#clasificados").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.clasificados')}}",
        },

        "columns": [
        	{data: 'name'},
        	{data: 'lastname'},
        	{data: 'document_number'},
        	{data: 'cohorte'},
            {data: 'grupo'},
            {data: 'name_program'},
            {data: 'position'},
            {data: 'iteration'},
            {data: 'weighted_total'},
            {data: 'weighted_areas'},
            {data: 'average_grades'},
            {data: null, render:function(data,row,meta, type){
            		//console.log(data);
            		mostrar = '1: '+data.opc1+'\n'+'2: '+data.opc2+'\n'+'3: '+data.opc3+'\n'+'4: '+data.opc4+'\n'+'5: '+data.opc5
            		return mostrar
            	}
        	},
            {data: 'semestre_ingreso'},
        ],
        "deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false, "order":[[4, 'asc']],
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

	var table_2 = $("#no_clasificados").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.no_clasificados')}}",
        },

        "columns": [
        	{data: 'name'},
        	{data: 'lastname'},
        	{data: 'document_number'},
        	{data: 'cohorte'},
            {data: 'grupo'},
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, visible:false, render:function(data,row,meta, type){
            		return '-';
            	}
            },
            {data: null, render:function(data,row,meta, type){
            		//console.log(data);
            		mostrar = '1: '+data.opc1+'\n,'+'2: '+data.opc2+'\n,'+'3: '+data.opc3+'\n,'+'4: '+data.opc4+'\n,'+'5: '+data.opc5
            		return mostrar
            	}
        	},
            {data: 'semestre_ingreso'},
        ],
        "deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false, "order":[[4, 'asc']],
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

	

	

	
</script>
@endpush
@endsection
