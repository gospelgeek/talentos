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
            
            <div id="div_1" class="col-sm-2" style="display:none">
                <label for="">Desde</label>
                <input  type="date" id="from_date" value="">    
            </div>
            
            <div id="div_2" class="col-sm-2" style="display:none">
                <label for="">Hasta</label>       
                <input  type="date" id="to_date" value="">          
            </div>
            <div id="div_3" class=" col-sm-3" style="display:none">
                <button id="Boton_C" class="btn btn-info sm-3" type="button" onclick="reload_tabla();">Consultar</button>
            </div>  
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
                <td>FISICA</td>
                <td>GEOGRAFIA</td>
                <td>HISTORIA</td>
                <td>INGLES</td>
                <td>LECTURA CRITICA</td>
                <td>MATEMATICAS</td>
                <td>QUIMICA</td>
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
                <td>BIOLOGIA</td>
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

    var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_1')}}",
                "data": function(d){
                        d.from_date = document.getElementById('from_date').value;
                        d.to_date = document.getElementById('to_date').value;
                },            
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
                            contador = contador + parseInt(data.cursos[i].Total)
                            
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

            "deferRender": true,"responsive": true,"processing": true,'serverSider':true,
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
                "data": function(d){
                        d.from_date = document.getElementById('from_date').value;
                        d.to_date = document.getElementById('to_date').value;
                },           
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "FISICA"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
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
                            if( data.cursos[i].fullname.split(" ", 2)[0] == "HISTORIA"){
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
                                //console.log(data.cursos[i].Total);
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
                            contador = contador + parseInt(data.cursos[i].Total)
                            
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

            "deferRender": true,"responsive": true,"processing": false,'serverSider':true,
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
                "data": function(d){
                        d.from_date = document.getElementById('from_date').value;
                        d.to_date = document.getElementById('to_date').value;
                },             
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
                            contador = contador + parseInt(data.cursos[i].Total)
                            
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

            "deferRender": true,"responsive": true,"processing": false,'serverSider':true,
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
       $('#example1').DataTable().ajax.reload(); 
       document.getElementById("tabla_1").removeAttribute('style', 'display:none');
       document.getElementById("div_1").removeAttribute('style', 'display:none');
       document.getElementById("div_2").removeAttribute('style', 'display:none');
       document.getElementById("div_3").removeAttribute('style', 'display:none');
       document.getElementById("from_date").value = "";
       document.getElementById("to_date").value = "";

 
    }else{
 
       document.getElementById("tabla_1").setAttribute('style', 'display:none');
       document.getElementById("div_1").setAttribute('style', 'display:none');
       document.getElementById("div_2").setAttribute('style', 'display:none');
       document.getElementById("div_3").setAttribute('style', 'display:none');
 
    }
    if(event.target.value == 2){
        $('#example2').DataTable().ajax.reload();
       document.getElementById("tabla_2").removeAttribute('style', 'display:none');
       document.getElementById("div_1").removeAttribute('style', 'display:none');
       document.getElementById("div_2").removeAttribute('style', 'display:none');
       document.getElementById("div_3").removeAttribute('style', 'display:none');
       document.getElementById("from_date").value = "";
       document.getElementById("to_date").value = "";
 
    }else{
 
       document.getElementById("tabla_2").setAttribute('style', 'display:none');
 
    }
    if(event.target.value == 3){
        $('#example3').DataTable().ajax.reload();
       document.getElementById("tabla_3").removeAttribute('style', 'display:none');
       document.getElementById("div_1").removeAttribute('style', 'display:none');
       document.getElementById("div_2").removeAttribute('style', 'display:none');
       document.getElementById("div_3").removeAttribute('style', 'display:none');
       document.getElementById("from_date").value = "";
       document.getElementById("to_date").value = "";
 
    }else{
 
       document.getElementById("tabla_3").setAttribute('style', 'display:none');
 
    }
});
function reload_tabla(){
    var tabla= $('#Ecohort').val();
    if(tabla == 1){

        $('#example1').DataTable().ajax.reload();
    }else if(tabla == 2){
        $('#example2').DataTable().ajax.reload();
    }else if(tabla == 3){
        $('#example3').DataTable().ajax.reload();
    }
}
   
</script>
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
