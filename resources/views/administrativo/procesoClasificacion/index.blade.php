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
            		<label>SI</label>&nbsp;<label>({{$si}})</label>&nbsp;<input type="radio" name="filtro" id="yes" checked>&nbsp;&nbsp;&nbsp;&nbsp;
            		<label>NO</label>&nbsp;<label>({{$no}})</label><input type="radio" name="filtro" id="not">
            	</div>
            </div>
            <div style="float:right;">
                <table id="resumen" class="table-bordered table-striped">
                    <label>RESUMEN PROGRAMAS</label>
                    <thead>
                	    <tr>
                            <th rowspan="2">PROGRAMA</th>
                            <th colspan="3">SEMESTRE I</th>
                            <th colspan="3">SEMESTRE II</th>
                        </tr>
                        <tr>
                           	<th>Cupos Otorgados</th>
                           	<th>Cupos Asignados</th>
                           	<th>Cupos Restantes</th>
                           	
                           	<th>Cupos Otorgados</th>
                           	<th>Cupos Asignados</th>
                           	<th>Cupos Restantes</th>
                           	
                        </tr>
                    </thead>
                    <tfoot>
                        <th>TOTAL</th>
                        <td></td>
                        <td></td>
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
								<th>SEMESTRE ORIGINAL</th>
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
								<th>SEMESTRE ORIGINAL</th>
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
        	{data: null, render:function(data, row, meta, type){
        			total = parseInt(data.quotas_I_2023) - parseInt(data.remaining_quotas_I_2023)
        			return total 
        		}
        	},
        	{data: 'remaining_quotas_I_2023'},
        	
        	{data: 'quotas_II_2023'},
        	{data: null, render:function(data, row, meta, type){
        			total = parseInt(data.quotas_II_2023) - parseInt(data.remaining_quotas_II_2023)
        			return total 
        		}
        	},
        	{data: 'remaining_quotas_II_2023'},
        	
        ],
        	"footerCallback": function( tfoot, data, start, end, display ) {
              var api = this.api();
              $( api.column( 1 ).footer() ).html(
                api.column( 1 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
              var res1 = 0
              $( api.column( 2 ).footer() ).html(
                api.column( 2 ).data().reduce( function ( a, b ) {
                  res1 = res1 + parseInt(b.quotas_I_2023 - b.remaining_quotas_I_2023);
                  return res1
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
              var res = 0
              $( api.column( 5 ).footer() ).html(
                api.column( 5 ).data().reduce( function ( a, b ) {
                	//console.log(a,b)
                  res = res + parseInt(b.quotas_II_2023 - b.remaining_quotas_II_2023);
                  return res
                }, 0 )
              );
              $( api.column( 6 ).footer() ).html(
                api.column( 6 ).data().reduce( function ( a, b ) {
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
            {data: 'semestre_ingreso_org'},
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

	$('#clasificados thead tr').clone(true).appendTo('#clasificados thead');

    $('#clasificados thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');
            $('input', this).on('keyup change', function () {
            if(table_1.column(i).search() !== this.value) {
                table_1
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
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

            		if(data.opc1 != null){
            			var opc1 = data.opc1 
            		}else{
            			var opc1 = 'Sin opción';
            		}
            		if(data.opc2 != null){
            			var opc2 = data.opc2 
            		}else{
            			var opc2 = 'Sin opción';
            		}
            		if(data.opc3 != null){
            			var opc3 = data.opc3 
            		}else{
            			var opc3 = 'Sin opción';
            		}
            		if(data.opc4 != null){
            			var opc4 = data.opc4 
            		}else{
            			var opc4 = 'Sin opción';
            		}
            		if(data.opc5 != null){
            			var opc5 = data.opc5 
            		}else{
            			var opc5 = 'Sin opción';
            		}
            		if(opc1 == 'Sin opción' && opc2 == 'Sin opción' && opc3 == 'Sin opción' && opc4 == 'Sin opción' && opc5 == 'Sin opción'){
            			return 'Sin opciones';
            		}else{
            			mostrar = '1: '+opc1+'\n,'+'2: '+opc2+'\n,'+'3: '+opc3+'\n,'+'4: '+opc4+'\n,'+'5: '+opc5
            			return mostrar
            		}
            	}
        	},
            {data: 'semestre_ingreso'},
            {data: 'semestre_ingreso_org'},
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

	$('#no_clasificados thead tr').clone(true).appendTo('#no_clasificados thead');

    $('#no_clasificados thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');
            $('input', this).on('keyup change', function () {
            if(table_2.column(i).search() !== this.value) {
                table_2
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
	

	

	
</script>
@endpush
@endsection
