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
                {!!Form::select('id_cohorte', $cohorte, null,['id'=>'Ecohort','class'=>'form-control','placeholder'=>'Seleccione una Linea', 'display'=>'inline-block'])!!}
            </div>
            {{--&nbsp;{!!Form::label('desde','desde:')!!}
            <div class="col-sm-2">
                {!!Form::date('id_fecha_desde',null,['id'=>'EfechaD','class'=>'form-control','placeholder'=>'Seleccione un mes', 'display'=>'inline-block'])!!}    
            </div>
            &nbsp;{!!Form::label('hasta','hasta:')!!}
            <div class="col-sm-2">        
                {!!Form::date('id_fecha_hasta',null,['id'=>'EfechaH','class'=>'form-control','placeholder'=>'Seleccione un mes', 'display'=>'inline-block'])!!}           
            </div>
            <div class="col-sm-2">
                <button class="btn btn-danger sm-3"type="button" onclick="mostrar_tabla();">Consultar</button>
            </div> --}}   
        </div>
        
        <br>
    <div id="tabla_1" class="table-responsive" style="display:none">
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
                <td>ACCIONES</td>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_2" class="table-responsive" style='display:none'>
     <table id="example2" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº documento</td>
                <td>Grupo</td>
                <td>BIOLOGIA</td>
                <td>CONSTITUCION</td>
                <td>INGLES</td>
                <td>LECTURA CRITICA</td>
                <td>MATEMATICAS</td>
                <td>TOTAL</td>
                <td >ACCIONES</td>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_3" class="table-responsive" style='display:none'>
     <table id="example3" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº documento</td>
                <td>Grupo</td>
                <td>CONSTITUCION</td>
                <td>INGLES</td>
                <td>LECTURA CRITICA</td>
                <td>MATEMATICAS</td>
                <td>QUIMICA</td>
                <td>TOTAL</td>
                <td>ACCIONES</td>
            </tr>
        </thead> 
      </table>
    </div>
    </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

function mostrar_tabla() {
var fecha = $('#EfechaD').val();
console.log(fecha)
}
    var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_1')}}",
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
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
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

    var table2 = $("#example2").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_2')}}",
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "INGLES"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "LECTURA"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
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
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
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

    var table3 = $("#example3").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_3')}}",
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "INGLES"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "LECTURA"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "QUIMICA"){
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
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
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
 
       document.getElementById("tabla_1").removeAttribute('style', 'display:none');
 
    }else{
 
       document.getElementById("tabla_1").setAttribute('style', 'display:none');
 
    }
    if(event.target.value == 2){
 
       document.getElementById("tabla_2").removeAttribute('style', 'display:none');
 
    }else{
 
       document.getElementById("tabla_2").setAttribute('style', 'display:none');
 
    }
    if(event.target.value == 3){
 
       document.getElementById("tabla_3").removeAttribute('style', 'display:none');
 
    }else{
 
       document.getElementById("tabla_3").setAttribute('style', 'display:none');
 
    }
});   
</script>
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
