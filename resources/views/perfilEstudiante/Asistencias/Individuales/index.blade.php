@extends('layouts.dashboard')

@section('title', 'Asistencias Estudiantes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">    
    <h1 style="text-align:center;">REPORTE GENERAL DE ASISTENCIAS INDIVIDUALES</h1>
    <div class="card">         
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
                &nbsp;{!!Form::label('cohorte','Linea:')!!}
                {!!Form::select('id_cohorte', $cohorte, null,['id'=>'Ecohort','class'=>'form-control','placeholder'=>'Seleccione una Linea', 'display'=>'inline-block'])!!}
            </div>
            {{--<div class="col-sm-6">
                &nbsp;{!!Form::label('cohorte','fecha:')!!}<br>
                &nbsp;{!!Form::label('cohorte','desde:')!!}
                {!!Form::date('id_fecha_desde',null, null,['class'=>'form-control','placeholder'=>'Seleccione un mes', 'display'=>'inline-block'])!!}
                &nbsp;{!!Form::label('cohorte','hasta:')!!}
                {!!Form::date('id_fecha_hasta',null, null,['class'=>'form-control','placeholder'=>'Seleccione un mes', 'display'=>'inline-block'])!!}
                <button class="btn btn-danger"type="button">Consultar</button>
            </div>--}}
        </div>
        
        <br>
    <div id="tabla_1" class="table-responsive" hidden>
     <table id="example1" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº documento</td>
                <td>Grupo</td>
                <td>ARTES</td>
                <td>DEPORTE</td>
                <td>DIALOGO</td>
                <td>TIC</td>
                <td>TOTAL</td>
            </tr>
        </thead> 
      </table>
      </div>
    </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

   var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('inasistencias')}}",
                "dataSrc": 'data'            
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos == null){
                            return 0;
                        }else{
                        var cero = 0;
                        for(const i in data.cursos){
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                cero = data.cursos[i].Total;
                            }      
                        }
                        return cero;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos == null){
                            return 0;
                        }else{
                        var cero = 0;    
                        for(const i in data.cursos){
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                cero = data.cursos[i].Total;
                            }
                               
                        }
                        return cero;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos == null){
                            return 0;
                        }else{
                        var cero = 0; 
                        for(const i in data.cursos){
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                cero = data.cursos[i].Total;
                            }   
                        }
                        return cero;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){

                        if(data.cursos == null){
                            return 0;
                        }else{
                        var cero = 0;     
                        for(const i in data.cursos){
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                cero = data.cursos[i].Total;
                            }    
                        }
                        return cero;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var contador=0;
                        for(const i in data.cursos){
                            contador = contador + data.cursos[i].Total
                            
                        }
                        return contador;
                    }
                }       
            ],

            "deferRender": true,"responsive": true,"processing": false,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
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
$('#Ecohort').change(function(event){
    //alert(event.target.value);
    if(event.target.value == 1){
 
       document.getElementById("tabla_1").removeAttribute("hidden");
 
    }else{
 
       $('#tabla_1').css('display','none');
 
     }
});   
</script>
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
