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
            <center><div style="width:40%">
                <table id="resumen" class="table-bordered table-striped">
                    <thead>
                        <label>RESUMEN PROGRAMAS</label>
                	    <tr>
                            <th rowspan="2">PROGRAMA</th>
                            <th colspan="3">SEMESTRE I</th>
                            <!--<th colspan="3">SEMESTRE II</th>-->
                        </tr>
                        <tr>
                           	<th>Cupos Otorgados</th>
                           	<th>Cupos Asignados</th>
                           	<th>Cupos Restantes</th>
                           	
                           	<!--<th>Cupos Otorgados</th>
                           	<th>Cupos Asignados</th>
                           	<th>Cupos Restantes</th>-->
                           	
                        </tr>
                    </thead>
                    <tfoot>
                        <th>TOTAL</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!--<td></td>
                        <td></td>
                        <td></td>-->  
                    </tfoot>
                </table>
            </div></center>
			<!--<div class="btn-group">
				<div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
          			<select id="intentos" class="form-control">
                        <option>SELECCIONE SEMESTRE 2023</option>
                        <option value="1">Semestre I-2023</option>
                        <option value="2">Semestre II-2023</option>
                    </select>
        		</div>
      		</div>-->
            <hr>
            <center><div class="btn-group">
                <div class="estado_clasi">
                    <label>CLASIFICADOS:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>SI I-2023 </label>&nbsp;<label>({{$si}})</label>&nbsp;<input type="radio" name="filtro" id="yes" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>NO I-2023 </label>&nbsp;<label>({{$no}})</label>&nbsp;<input type="radio" name="filtro" id="not">&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>Pendientes II-2023 </label>&nbsp;<label>({{$pendientes}})</label>&nbsp;<input type="radio" name="filtro" id="pndntes">
                </div>
                <!--<div class="semestres">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>Semestre:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>I-2023</label>&nbsp;<input type="checkbox" name="check" value="I-2023" id="smstre_1">&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>II-2023</label>&nbsp;<input type="checkbox" name="check" value="II-2023" id="smstre_2">&nbsp;&nbsp;&nbsp;&nbsp;
                </div>-->
            </div></center>
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
								<th>PROGRAMA</th>
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
								<th>RONDA</th>
								<th>TOTAL PONDERADO</th>
								<th>PONDERADO POR AREAS</th>
								<th>PROMEDIO NOTAS</th>
								<th>OPCIONES</th>
								<th>SEMESTRE INGRESO</th>
							</tr>
						</thead>
					</table>
				</div>
                <div id="pendientes" style="display:none;">
                    <table id="pendiente_2023" class=" table table-bordered table-striped">
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
                            </tr>
                        </thead>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>


@push('scripts')
@include('administrativo.procesoClasificacion.modal.detalle_programa')

<script>

	$('.estado_clasi').on('change', function() {
    	var yes = $('#yes').is(":checked");
    	var not = $('#not').is(":checked");
        var pndntes = $('#pndntes').is(":checked");

    	if(yes){
    		document.getElementById("no_cla").setAttribute('style', 'display:none');
            document.getElementById("pendientes").setAttribute('style', 'display:none');
    		document.getElementById("si_cla").removeAttribute('style', 'display:none');
    	}
        if(not){
    		document.getElementById("si_cla").setAttribute('style', 'display:none');
            document.getElementById("pendientes").setAttribute('style', 'display:none');
    		document.getElementById("no_cla").removeAttribute('style', 'display:none');
    	}
        if(pndntes){
            document.getElementById("si_cla").setAttribute('style', 'display:none');
            document.getElementById("pendientes").removeAttribute('style', 'display:none');
            document.getElementById("no_cla").setAttribute('style', 'display:none');
        }        
    });
	
$(document).ready(function(){
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
        			if(total != 0){
        				return '<button class="btn" type="button" onclick="abrir_modal_detalle('+data.id+',\''+"I-2023"+'\',\''+data.name_program+'\');"><u>'+total+'</u></button>';	
        			}else{
        			 	return '<button class="btn" type="button");">'+total+'</button>';
        			}
        		}
        	},
        	{data: 'remaining_quotas_I_2023'},
        	
        	/*{data: 'quotas_II_2023'},
        	{data: null, render:function(data, row, meta, type){
        			total = parseInt(data.quotas_II_2023) - parseInt(data.remaining_quotas_II_2023)
        			if(total != 0){
        				return '<button class="btn" type="button" onclick="abrir_modal_detalle('+data.id+',\''+"II-2023"+'\',\''+data.name_program+'\');"><u>'+total+'</u></button>';
        			}else{
						return '<button class="btn" type="button");">'+total+'</button>';	 
        			}
        		}
        	},
        	{data: 'remaining_quotas_II_2023'},*/
        	
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
              /*$( api.column( 4 ).footer() ).html(
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
              );*/
        },
        "pageLength": 10, "searching": true, "info": false,"Paging": true,
            
	});
	

	var table_1 = $("#clasificados").DataTable({

		"ajax":{
            "method":"GET",
            "url": "{{route('datos.clasificados')}}",
        },

        "columns": [
            {data: 'position'},
            {data: 'iteration'},
        	{data: 'name'},
        	{data: 'lastname'},
        	{data: 'document_number'},
        	{data: 'cohorte'},
            {data: 'grupo'},
            {data: 'name_program'},
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

    /*document.getElementById('smstre_1').checked = true;
    document.getElementById('smstre_2').checked = true;

    $('.semestres').on('change', function() {   
        var smstre_1 = $('#smstre_1').is(":checked");
        var smstre_2 = $('#smstre_2').is(":checked");
        //alert(smstre_1);
        if(smstre_1){
            if(!smstre_2){
                var filtro = $('input:checkbox[id="smstre_2"]').map(function() {
                        return this.value;
                    }).get().join('|');
                    table_1.column(12).search(filtro ? '^((?!' + filtro + ').*)$' : '', true, false, false).draw(false);
            }
            table_1.draw();     
        }
        if(!smstre_1){
            if(smstre_2){
                table_1.columns(12).search('II-2023');    
            }
            table_1.draw();    
        }
        if(smstre_1 && smstre_2){
            var offices = $('input:checkbox[name="check"]:checked').map(function() {
                return this.value;
            }).get().join('|');
            table_1.column(12).search(offices, true, false, false).draw(false);
            table_1.draw();
        }
    });*/

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

    var table_4 = $("#pendiente_2023").DataTable({

        "ajax":{
            "method":"GET",
            "url": "{{route('datos.pendientes_2023_II')}}",
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
});

	function abrir_modal_detalle(id_programa, semestre, programa){
		
        var campo = document.getElementById("smstre");
        var campo_prgrma = document.getElementById("prgrma");
        
        campo.innerHTML = "SEMESTRE "+semestre;
		campo_prgrma.innerHTML = programa;
        var tabla_detalle = $("#detalle_programa").DataTable({
        	"ajax":{
          		"method": "GET",
          		"url": "{{route('datos.detalle_programas')}}",
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
            "destroy":true,"searching": false, "order":[[0, 'asc']],
    	});
		$('#modal_detalle_programa').modal('show');
	}

</script>
@endpush
@endsection
