@extends('layouts.dashboard')
@section('title', 'Proceso de clasificación 2023-2')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
@if(auth()->user()->rol_id == 1)
<div class="col-xs-12 col-md-8">
    <form method="POST" action="store/save/usuarios" accept-charset="UTF-8" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class=" col-xs-12 col-md-8">
                  {!!Form::label('archivo','Seleccione Archivo:')!!}                            
                  {!!Form::file('file',[ 'accept'=>'.xls,.xlsx','class'=>'form-control-file form-group','required'])!!}
                        
                        <button type="submit" class="btn btn-danger bg-lg form-group btn-block">Enviar</button>
                      </div>
    </form>
</div>
</div>
@endif
<div class="container-fluid">
	<input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">PROCESO DE CLASIFICACIÓN 2023-2</h1>
	<div class="card">
		<div class="card-body">
            @if(auth()->user()->rol_id == 1)
			<div class="btn-group">
                <div class="col-xs-6 col-md-12 col-sm-6">
                    <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('proceso_clasificacion2')}}">CORRER SCRIPT DE SELECCIÓN</a>
                </div>
            </div>
            @endif
            <div class="btn-group">
                
            </div>
            <center><div class="btn-group">
                <div class="estado_clasi">
                    <label>CLASIFICADOS:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>SI II-2023:</label>&nbsp;<label>({{$si}})</label>&nbsp;<input type="radio" name="filtro" id="yes" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>NO II-2023:</label>&nbsp;<label>({{$no}})</label>&nbsp;<input type="radio" name="filtro" id="not_yes">&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div></center>
            <hr>

            <center><div style="width:40%">        
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left abrir_modal">DETALLE  ESTADISTICO</a>
                <table id="resumen" class="table-bordered table-striped">
                    <thead>
                        <label>RESUMEN PROGRAMAS</label>
                	    <tr>
                            <th rowspan="2">COD.</th>
                            <th rowspan="2">PROGRAMA</th>
                            <th rowspan="2">JORNADA</th>
                            <th colspan="3">SEMESTRE II</th>
                        </tr>
                        <tr>
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
                    </tfoot>
                </table>
            </div></center>
            <hr>
            
			<br><div class="table-responsive">
				<div id="si_cla">
					<table id="clasificados" class=" table table-bordered table-striped">
						<thead>
							<tr>
                                <th>PUESTO</th>
                                <th>RONDA</th>
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>Nº.DOCUMENTO</th>
								<th>LINEA</th>
								<th>GRUPO</th>
                                <th title="Codigo Programa">COD. PRO..</th>
								<th>PROGRAMA</th>
                                <th>JORNADA</th>
								<th>TOTAL PONDERADO</th>
								<th>PONDERADO POR AREAS</th>
								<th>PROMEDIO NOTAS</th>
								<th>OPCIONES</th>
								<th>SEMESTRE INGRESO</th>
                                <th>PUNTAJE ICFES</th>
                                <th>PRIORIDAD</th>
							</tr>
						</thead>
					</table>
				</div>
				<div id="no_cla2" style="display:none;">
					<table id="no_clasificados2" class=" table table-bordered table-striped">
						<thead>
							<tr>
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>Nº.DOCUMENTO</th>
								<th>LINEA</th>
								<th>GRUPO</th>
								<th>PROGRAMA</th>
								<th>PUESTO</th>
								<th>RONDA</th>
								<th>TOTAL PONDERADO</th>
								<th>PONDERADO POR AREAS</th>
								<th>PROMEDIO NOTAS</th>
								<th>OPCIONES</th>
								<th>SEMESTRE INGRESO</th>
                                <th>PUNTAJE ICFES</th>
                                <th>PRIORIDAD</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@push('scripts')
@include('administrativo.procesoClasificacion2.modal.detalle_programa')
@include('administrativo.procesoClasificacion2.modal.grafica_programas')

<script>

	$('.estado_clasi').on('change', function() {
    	var yes = $('#yes').is(":checked");
    	var not_yes = $('#not_yes').is(":checked");
        var not_not = $('#not_not').is(":checked");
        var pndntes = $('#pndntes').is(":checked");

    	if(yes){
    		document.getElementById("no_cla2").setAttribute('style', 'display:none');
    		document.getElementById("si_cla").removeAttribute('style', 'display:none');
    	}
        if(not_yes){
    		document.getElementById("si_cla").setAttribute('style', 'display:none');
    		document.getElementById("no_cla2").removeAttribute('style', 'display:none');
    	}       
    });

var programas=[];
var cupos_otorgados=[];
var cupos_asignados=[];	
$(document).ready(function(){
	var table_3 = $("#resumen").DataTable({
		"ajax":{
            "method":"GET",
            "url": "{{route('datos.resumen')}}",
        },
        "columns": [
            {data: 'code_program'},
        	{data: 'name_program'},
            {data: null, render:function(data, row, meta, type){
                    if(data.working_day == 'D'){
                        return 'Diurna';
                    }
                    if(data.working_day == 'N'){
                        return 'Nocturna';
                    }
                    if(data.working_day == 'V'){
                        return 'Verpentina';
                    }
                }
            },
        	{data: 'quotas_II_2023'},
        	{data: null, render:function(data, row, meta, type){
        			total = parseInt(data.quotas_II_2023) - parseInt(data.remaining_quotas_II_2023)
        			if(total != 0){
        				return '<button class="btn" type="button" onclick="abrir_modal_detalle('+data.id+',\''+"II-2023"+'\',\''+data.name_program+'\');"><u>'+total+'</u></button>';
        			}else{
						return '<button class="btn" type="button");">'+total+'</button>';	 
        			}
        		}
        	},
        	{data: 'remaining_quotas_II_2023'},
        	
        ],
        	"footerCallback": function( tfoot, data, start, end, display ) {
              var api = this.api();
              $( api.column( 3 ).footer() ).html(
                api.column( 3 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
              var res1 = 0
              $( api.column( 4 ).footer() ).html(
                api.column( 4 ).data().reduce( function ( a, b ) {
                  res1 = res1 + parseInt(b.quotas_II_2023 - b.remaining_quotas_II_2023);
                  return res1
                }, 0 )
              );
              $( api.column( 5 ).footer() ).html(
                api.column( 5 ).data().reduce( function ( a, b ) {
                  return parseInt(a) + parseInt(b);
                }, 0 )
              );
        },
        "pageLength": 10, "searching": true, "info": false,"Paging": true,
        "dom":'Bfrtip',
            "buttons": [    
                "csv",
                "excel", 
                "pdf",
            ]
	});

    $.ajax({
        url: '/datos.resumen',
        method: 'GET'

    }).done(function(res){
        //const arr = objetoJson.map(res => Object.entries(res));
        for(var i = 0; i < res.data.length; i++) {
            if(res.data[i].remaining_quotas_II_2023 > 0 || res.data[i].quotas_II_2023 > 0){
                programas.push(res.data[i].name_program + " " + res.data[i].working_day);
                cupos_otorgados.push(res.data[i].quotas_II_2023);
                cupos_asignados.push(parseInt(res.data[i].quotas_II_2023) - parseInt(res.data[i].remaining_quotas_II_2023));
            }
            
        }
        
        generar_grafica();

        $('.abrir_modal').click(function(e) { 
            e.preventDefault();
            $('#modal_detalle_grafica').modal('show');
            //alert(cod)
        });
    });	

	var table_1 = $("#clasificados").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.clasificados2')}}",
        },

        "columns": [
            {data: 'position'},
            {data: 'iteration'},
        	{data: 'name'},
        	{data: 'lastname'},
        	{data: 'document_number'},
        	{data: 'cohorte'},
            {data: 'grupo'},
            {data: 'code_program'},
            {data: 'name_program'},
            {data: null, render:function(data, row, meta, type){
                    if(data.working_day == 'D'){
                        return 'Diurna';
                    }
                    if(data.working_day == 'N'){
                        return 'Nocturna';
                    }
                    if(data.working_day == 'V'){
                        return 'Verpentina';
                    }
                }
            },
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
            {data: 'icfes'},
        ],
        "deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false, "order":[[7, 'asc'], [0, 'asc']],
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

	var table_2 = $("#no_clasificados2").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.no_clasificados2')}}",
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
            {data: 'icfes'},
            {data: 'prioridad'}
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

	$('#no_clasificados2 thead tr').clone(true).appendTo('#no_clasificados2 thead');

    $('#no_clasificados2 thead tr:eq(1) th').each(function (i) {
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

});

	function abrir_modal_detalle(id_programa, semestre, programa){
		
        var campo = document.getElementById("smstre");
        var campo_prgrma = document.getElementById("prgrma");
        
        campo.innerHTML = "SEMESTRE "+semestre;
		campo_prgrma.innerHTML = programa;
        var tabla_detalle = $("#detalle_programa").DataTable({
        	"ajax":{
          		"method": "GET",
          		"url": "{{route('datos.detalle_programas2')}}",
          		"data": function(d){
              		d.id_programa = id_programa;
              		d.semestre = semestre;
          		},
        	},
        	"columns":[
                {data: 'position'},
                {data: 'iteration'},
        		{data: 'name'},
        		{data: 'lastname'},
        		{data: 'weighted_total'},
        		{data: 'weighted_areas'},
        		{data: 'average_grades'},
        	],
        	"deferRender": true,"responsive": false,"processing": false,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,
            "destroy":true,"searching": true, "order":[[0, 'asc']],
    	});
		$('#modal_detalle_programa').modal('show');
	}

    function generar_grafica(){
        programas.sort();
        const ctx = document.getElementById('grafica_programas');

        new Chart(ctx, {
            type: 'bar',
            data: {
              labels: programas,
              datasets: [{
                label: '# Cupos Otorgados',
                data: cupos_otorgados,
                borderWidth: 1,
                backgroundColor:[
                    'rgba(46, 134, 193, 0.8)',
                ],
              },
              {
                label: '# Cupos asignados',
                data: cupos_asignados,
                borderWidth: 1,
                backgroundColor:[
                    'rgba(0, 255, 51, 0.8)',
                ],
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
        });
        //$('#modal_detalle_grafica').modal('show');
    }

</script>
@endpush
@endsection
