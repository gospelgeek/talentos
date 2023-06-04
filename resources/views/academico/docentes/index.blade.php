@extends('layouts.dashboard')
@section('title', 'Reporte docentes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
	<h1 style="text-align:center;">DOCENTES</h1>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NOMBRE DOCENTE</th>
                            <th>ASIGNATURA</th>
                            <th>GRUPOS</th>
                            <th width="15%">DETALLE ASISTENCIAS</th>
                            <th width="15%">DETALLE SEGUIMIENTOS</th>
                        </tr>
                    </thead>
      			</table>
      		</div>
		</div>
	</div>
</div>

@push('scripts')

<script>
    $(document).ready(function(){
        var table = $("#example1").DataTable({
            "ajax":{
                "method":"GET",
                "url":"{{route('datos_docentes')}}",
            },
            "columns": [
                {data:'docente_name'},
                {data: null, render:function(data, type, row, meta){
                        let indice = data.asignatura[0].fullname.indexOf("-");
                        let materia = data.asignatura[0].fullname.substring(0, indice);
                        return materia;
                    }
                },
                {data: null, render:function(data, type, row, meta){
                            var retornar = '';
                            var valores_l1 = '';
                            var valores_l2 = '';
                            var valores_l3 = '';
                            if(data !== null){
                                if(data.asignatura.length !== 0){
                                    data.asignatura.forEach(function(grupo){
                                        if(grupo.id_cohort == 1){
                                            let indice = grupo.name.indexOf("r");
                                            let p1 = grupo.name.substring(0, indice);
                                            let p2 = grupo.name.slice(-2);

                                            var grupos_l1 = " "+'L1'+"-"+p1+""+p2+" ";
                                            valores_l1 += ""+grupos_l1+""+","+"";
                                        }
                                        if(grupo.id_cohort == 2){
                                            let indice = grupo.name.indexOf("r");
                                            let p1 = grupo.name.substring(0, indice);
                                            let p2 = grupo.name.slice(-2);

                                            var grupos_l2 = " "+'L2'+"-"+p1+""+p2+" ";
                                            valores_l2 += ""+grupos_l2+""+","+"";
                                        }
                                        if(grupo.id_cohort == 3){
                                            let indice = grupo.name.indexOf("r");
                                            let p1 = grupo.name.substring(0, indice);
                                            let p2 = grupo.name.slice(-2);

                                            var grupos_l3 = " "+'L3'+"-"+p1+""+p2+" ";
                                            valores_l3 += ""+grupos_l3+""+","+"";
                                        }   
                                    });
                                    retornar = ""+valores_l1+""+valores_l2+""+valores_l3+""
                                    retornar = retornar.slice(0, -1)
                                    return retornar;    
                                }else{
                                    return null;
                                }
                            }else{
                                return null;
                            }
                        }
                    },
                    {data: null, render:function(data, type, row, meta){
                            var rol = document.getElementById('roles').value;
                            var mstr;
                            let indice = data.asignatura[0].fullname.indexOf("-");
                            let materia = data.asignatura[0].fullname.substring(0, indice);
                            mstr =  '<div class="row">'+                                  
                                        '<div class="col-xs-6 col-sm-6">'+
                                            '<a title="Ver Grupos" href="docentes_grupos_asistencias/'+data.docente_name+'/'+materia+'" class="btn btn-block btn-sm  fa fa-eye"> Detalle</a>'+   
                                        '</div>'+
                                    '</div>';
                            return mstr;
                        }
                    },
                    {data: null, render:function(data, type, row, meta){
                            var rol = document.getElementById('roles').value;
                            var mstr;
                            let indice = data.asignatura[0].fullname.indexOf("-");
                            let materia = data.asignatura[0].fullname.substring(0, indice);
                            mstr =  '<div class="row">'+                                  
                                        '<div class="col-xs-6 col-sm-6">'+
                                            '<a title="Ver Grupos" href="docentes_grupos_seguimientos/'+data.docente_name+'/'+materia+'" class="btn btn-block btn-sm  fa fa-eye"> Detalle</a>'+   
                                        '</div>'+
                                    '</div>';
                            return mstr;
                        }
                    }
                ],
                "deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false,
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
</script>
@endpush
@endsection
