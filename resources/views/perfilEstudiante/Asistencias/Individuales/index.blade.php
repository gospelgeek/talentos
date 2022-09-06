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
            <div id="div_1" class="col-sm-8 asistencias_mes" style="display:none">
            <form name="mes">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>TODOS</label>&nbsp;<input type="radio" name="filtro" value="1" id="todos" checked="">&nbsp;&nbsp;
                <label>FEBRERO</label>&nbsp;<input type="radio" name="filtro" value="2" id="febrero">&nbsp;&nbsp;
                <label>MARZO</label>&nbsp;<input type="radio" name="filtro" value="3" id="marzo">&nbsp;&nbsp;
                <label>ABRIL</label>&nbsp;<input type="radio" name="filtro" value="4" id="abril">&nbsp;&nbsp;
                <label>MAYO</label>&nbsp;<input type="radio" name="filtro" value="5" id="mayo">&nbsp;&nbsp;
                <label>JUNIO</label>&nbsp;<input type="radio" name="filtro" value="6" id="junio">&nbsp;&nbsp;
                <label>JULIO</label>&nbsp;<input type="radio" name="filtro" value="7" id="julio">&nbsp;&nbsp;
                <label>AGOSTO</label>&nbsp;<input type="radio" name="filtro" value="8" id="agosto">&nbsp;&nbsp;
                <label>SEPTIEMBRE</label>&nbsp;<input type="radio" name="filtro" value="9" id="septiembre">
            </form>                     
            </div>  
        </div>
        <div class="btn-group">
            <div class="filtroCohortes col-xs-6 col-md-12 col-sm-6">
                <label>PRESENCIAL</label>&nbsp;<input type="checkbox" name="check" value="PRESENCIAl" id="presencial" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>VIRTUAL</label>&nbsp;<input type="checkbox" name="check" value="VIRTUAl" id="virtual" checked>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        <br>
    <div id="tabla_1" class="table-responsive" style='display:none'>
     <table id="example1" class="table table-bordered table-striped">
        <caption>Fecha ultima carga: {{ $carga }}</caption>
        <thead >
            <tr >
                <th rowspan="2">Nombres</th>
                <th rowspan="2">Apellidos</th>
                <th rowspan="2">Tipo Documento</th>
                <th rowspan="2">Nº documento</th>
                <th rowspan="2">Grupo</th>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                @endif
                <th rowspan="2">Estado</th>
                <th colspan="4">ACCION CIUDADANA</th>
                <th colspan="4">ARTES</th>
                <th colspan="4">BIOLOGIA</th>
                <th colspan="4">CULTURA DEMOCRATICA</th>
                <th colspan="4">DEPORTE</th>
                <th colspan="4">DIALOGO</th>
                <th colspan="4">FILOSOFIA</th>
                <th colspan="4">FISICA</th>
                <th colspan="4">GEOGRAFIA</th>
                <th colspan="4">HISTORIA</th>
                <th colspan="4">INGLES</th>
                <th colspan="4">LECTURA CRITICA</th>
                <th colspan="4">MATEMATICAS</th>
                <th colspan="4">QUIMICA</th>
                <th colspan="4">TIC</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2" id="ultima1">VER DETALLE</th>
            </tr>
            <tr>
                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_2" class="table-responsive" style='display:none'>
     <table id="example2" class="table table-bordered table-striped">
        <caption>Fecha ultima carga: {{ $carga }}</caption>
        <thead >
            <tr >
                <th rowspan="2">Nombres</th>
                <th rowspan="2">Apellidos</th>
                <th rowspan="2">Tipo Documento</th>
                <th rowspan="2">Nº documento</th>
                <th rowspan="2">Grupo</th>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <th rowspan="2">Profesional Encargado</th>
                @endif
                <th rowspan="2">Estado</th>
                <th colspan="4">ACCION CIUDADANA</th>
                <th colspan="4">ARTES</th>
                <th colspan="4">BIOLOGIA</th>
                <th colspan="4">DEPORTE</th>
                <th colspan="4">DIALOGO</th>
                <th colspan="4">CONSTITUCION</th>
                <th colspan="4">FISICA</th>
                <th colspan="4">GEOGRAFIA</th>
                <th colspan="4">HISTORIA</th>
                <th colspan="4">INGLES</th>
                <th colspan="4">LECTURA CRITICA</th>
                <th colspan="4">MATEMATICAS</th>
                <th colspan="4">QUIMICA</th>
                <th colspan="4">TIC</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2" id="ultima2">VER DETALLES</th>
            </tr>
            <tr>
                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_3" class="table-responsive" style='display:none'>
     <table id="example3" class="table table-bordered table-striped">
        <caption>Fecha ultima carga: {{ $carga }}</caption>
        <thead >
            <tr >
                <th rowspan="2">Nombres</th>
                <th rowspan="2">Apellidos</th>
                <th rowspan="2">Tipo Documento</th>
                <th rowspan="2">Nº documento</th>
                <th rowspan="2">Grupo</th>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <th rowspan="2">Profesional Encargado</th>
                @endif
                <th rowspan="2">Estado</th>
                <th colspan="4">BIOLOGIA</th>
                <th colspan="4">DIALOGO</th>
                <th colspan="4">CONSTITUCION</th>
                <th colspan="4">FISICA</th>
                <th colspan="4">GEOGRAFIA</th>
                <th colspan="4">HISTORIA</th>
                <th colspan="4">INGLES</th>
                <th colspan="4">LECTURA CRITICA</th>
                <th colspan="4">MATEMATICAS</th>
                <th colspan="4">PRACTICAS ARTISTICAS</th>
                <th colspan="4">QUIMICA</th>
                <th colspan="4">TIC</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2" id="ultima3">ACCIONES</th>
            </tr>
            <tr>
                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Docente</th>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>
            </tr>
        </thead> 
      </table>
    </div>
    </div>
    </div>
</div>
@include('perfilEstudiante.Asistencias.Individuales.modal.detalles_sesiones')
@push('scripts')
<script type="text/javascript">

    
    var encargado = $('#encargado').data('condition');
    if(encargado == 1 || encargado == 2){
        var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_1')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;                 
                },            
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'encargado'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                            var contador = 0;
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                            return contador; 
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_presenciales[i].Total);
                               contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var virtual=0;
                        var presencial=0;
                        for(const i in data.cursos_virtuales){
                            virtual = virtual + parseInt(data.cursos_virtuales[i].Total)    
                        }

                        for(const i in data.cursos_presenciales){
                            presencial = presencial + parseInt(data.cursos_presenciales[i].Total)
                            
                        }

                        return virtual+presencial;
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

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 1",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima1")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);
                            
                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 1 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Profesional Encargado" }])
                            var r8 = Addrow(2, [{ key: 'G', value: "Estado" }])
                            var r9 = Addrow(2, [{ key: 'H', value: "ACCION CIUDADANA" }])
                            var r10 = Addrow(2, [{ key: 'L', value: "ARTES" }])
                            var r11 = Addrow(2, [{ key: 'P', value: "BIOLOGIA" }])
                            var r12 = Addrow(2, [{ key: 'T', value: "CULTURA DEMOCRATICA" }])
                            var r13 = Addrow(2, [{ key: 'X', value: "DEPORTE" }])
                            var r14 = Addrow(2, [{ key: 'AB', value: "DIALOGO" }])
                            var r15 = Addrow(2, [{ key: 'AF', value: "FILOSOFIA" }])
                            var r16 = Addrow(2, [{ key: 'AJ', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'AN', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AR', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AV', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AZ', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'BD', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'BH', value: "QUIMICA" }])
                            var r23 = Addrow(2, [{ key: 'BL', value: "TIC" }])
                            var r24 = Addrow(2, [{ key: 'BP', value: "TOTAL" }])

                            sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7 +r8+ r9 +r10 +r11+ r12+r13 +r14+ r15+r16+r17 +r18+ r19 + r20+r21+r22+r23+r24+sheet.childNodes[0].childNodes[1].innerHTML;

                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="H2"]', sheet).attr( 's', '2' );
                            $('row c[r="L2"]', sheet).attr( 's', '2' );
                            $('row c[r="P2"]', sheet).attr( 's', '2' );
                            $('row c[r="T2"]', sheet).attr( 's', '2' );
                            $('row c[r="X2"]', sheet).attr( 's', '2' );
                            $('row c[r="AB2"]', sheet).attr( 's', '2' );
                            $('row c[r="AF2"]', sheet).attr( 's', '2' );
                            $('row c[r="AJ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AN2"]', sheet).attr( 's', '2' );
                            $('row c[r="AR2"]', sheet).attr( 's', '2' );
                            $('row c[r="AV2"]', sheet).attr( 's', '2' );
                            $('row c[r="AZ2"]', sheet).attr( 's', '2' );
                            $('row c[r="BD2"]', sheet).attr( 's', '2' );
                            $('row c[r="BH2"]', sheet).attr( 's', '2' );
                            $('row c[r="BL2"]', sheet).attr( 's', '2' );
                            $('row c[r="BP2"]', sheet).attr( 's', '2' );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BP1',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:G3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'H2:k2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'L2:O2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'P2:S2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'T2:W2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'X2:AA2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AB2:AE2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AF2:AI2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AJ2:AM2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AN2:AQ2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AR2:AU2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AV2:AY2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AZ2:BC2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BD2:BG2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BH2:BK2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BL2:BO2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BP2:BP3',
                                }
                            } ) );

                            mergeCells.attr('count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }     
                        },
                    }
                ]
            }
        });

        var table2 = $("#example2").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_2')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;
                },           
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'encargado'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },   
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },   
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var virtual=0;
                        var presencial=0;
                        for(const i in data.cursos_virtuales){
                            virtual = virtual + parseInt(data.cursos_virtuales[i].Total)    
                        }

                        for(const i in data.cursos_presenciales){
                            presencial = presencial + parseInt(data.cursos_presenciales[i].Total)
                            
                        }

                        return virtual+presencial;
                    }
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" target="_blank" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
                }
            }
            ],

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 2",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima2")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BL1',
                                }
                            } ) );
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:G3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'H2:K2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'L2:O2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'P2:S2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'T2:W2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'X2:AA2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AB2:AE2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AF2:AI2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AJ2:AM2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AN2:AQ2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AR2:AU2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AV2:AY2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AZ2:BC2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BD2:BG2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BH2:BK2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BL2:BL3',
                                }
                            } ) );

                            mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }

                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 2 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Profesional Encargado" }])
                            var r8 = Addrow(2, [{ key: 'G', value: "Estado" }])
                            var r9 = Addrow(2, [{ key: 'H', value: "ACCION CIUDADANA" }])
                            var r10 = Addrow(2, [{ key: 'L', value: "ARTES" }])
                            var r11 = Addrow(2, [{ key: 'P', value: "BIOLOGIA" }])
                            var r13 = Addrow(2, [{ key: 'T', value: "DEPORTE" }])
                            var r14 = Addrow(2, [{ key: 'X', value: "DIALOGO" }])
                            var r15 = Addrow(2, [{ key: 'AB', value: "CONSTITUCION" }])
                            var r16 = Addrow(2, [{ key: 'AF', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'AJ', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AN', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AR', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AV', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'AZ', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'BD', value: "QUIMICA" }])
                            var r23 = Addrow(2, [{ key: 'BH', value: "TIC" }])
                            var r24 = Addrow(2, [{ key: 'BL', value: "TOTAL" }])
                            sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7 +r8+ r9 +r10 +r11+r13 +r14+ r15+r16+r17 +r18+ r19 + r20+r21+r22+r23+r24+sheet.childNodes[0].childNodes[1].innerHTML;

                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="H2"]', sheet).attr( 's', '2' );
                            $('row c[r="L2"]', sheet).attr( 's', '2' );
                            $('row c[r="P2"]', sheet).attr( 's', '2' );
                            $('row c[r="T2"]', sheet).attr( 's', '2' );
                            $('row c[r="X2"]', sheet).attr( 's', '2' );
                            $('row c[r="AB2"]', sheet).attr( 's', '2' );
                            $('row c[r="AF2"]', sheet).attr( 's', '2' );
                            $('row c[r="AJ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AN2"]', sheet).attr( 's', '2' );
                            $('row c[r="AR2"]', sheet).attr( 's', '2' );
                            $('row c[r="AV2"]', sheet).attr( 's', '2' );
                            $('row c[r="AZ2"]', sheet).attr( 's', '2' );
                            $('row c[r="BD2"]', sheet).attr( 's', '2' );
                            $('row c[r="BH2"]', sheet).attr( 's', '2' );
                            $('row c[r="BL2"]', sheet).attr( 's', '2' );
                        },
                    }
                ]
            }
        });

        var table3 = $("#example3").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_3')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;
                },             
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'encargado'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador = data.cursos_presenciales[i].Total;
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var contador=0;

                        for(const i in data.cursos_virtuales){
                            contador = contador + parseInt(data.cursos_virtuales[i].Total)
                        }
                        for(const i in data.cursos_presenciales){
                            contador = contador + parseInt(data.cursos_presenciales[i].Total)
                        }
                        return contador;
                    }
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" target="_blank" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
                }
            }

            ],

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 3",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima3")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BD1',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:G3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'H2:K2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'L2:O2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'P2:S2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'T2:W2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'X2:AA2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AB2:AE2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AF:AI2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AJ2:AM2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AN2:AQ2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AR2:AU2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AV2:AY2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AZ2:BC2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BD2:BD3',
                                }
                            } ) );
                            mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }

                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 3 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Profesional Encargado" }])
                            var r8 = Addrow(2, [{ key: 'G', value: "Estado" }])
                            var r11 = Addrow(2, [{ key: 'H', value: "BIOLOGIA" }])
                            var r14 = Addrow(2, [{ key: 'L', value: "DIALOGO" }])
                            var r15 = Addrow(2, [{ key: 'P', value: "CONSTITUCION" }])
                            var r16 = Addrow(2, [{ key: 'T', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'X', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AB', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AF', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AJ', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'AN', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'AR', value: "PRACTICAS ARTISTICAS" }])
                            var r23 = Addrow(2, [{ key: 'AV', value: "QUIMICA" }])
                            var r24 = Addrow(2, [{ key: 'AZ', value: "TIC" }])
                            var r25 = Addrow(2, [{ key: 'BD', value: "TOTAL" }])
                            sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7 +r8+r11+r14+ r15+r16+r17 +r18+ r19 + r20+r21+r22+r23+r24+r25+sheet.childNodes[0].childNodes[1].innerHTML;
                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="H2"]', sheet).attr( 's', '2' );
                            $('row c[r="L2"]', sheet).attr( 's', '2' );
                            $('row c[r="P2"]', sheet).attr( 's', '2' );
                            $('row c[r="T2"]', sheet).attr( 's', '2' );
                            $('row c[r="X2"]', sheet).attr( 's', '2' );
                            $('row c[r="AB2"]', sheet).attr( 's', '2' );
                            $('row c[r="AF2"]', sheet).attr( 's', '2' );
                            $('row c[r="AJ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AN2"]', sheet).attr( 's', '2' );
                            $('row c[r="AR2"]', sheet).attr( 's', '2' );
                            $('row c[r="AV2"]', sheet).attr( 's', '2' );
                            $('row c[r="AZ2"]', sheet).attr( 's', '2' );
                            $('row c[r="BD2"]', sheet).attr( 's', '2' );

                        },
                    }
                ]
            }
        });
        
        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();
            
            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([8,10]).visible(false);
                        table.columns([12,14]).visible(false);
                        table.columns([16,18]).visible(false);
                        table.columns([20,22]).visible(false);
                        table.columns([24,26]).visible(false);
                        table.columns([28,30]).visible(false);
                        table.columns([32,34]).visible(false);
                        table.columns([36,38]).visible(false);
                        table.columns([40,42]).visible(false);
                        table.columns([44,46]).visible(false);
                        table.columns([48,50]).visible(false);
                        table.columns([52,54]).visible(false);
                        table.columns([56,58]).visible(false);
                        table.columns([60,62]).visible(false);
                        table.columns([64,66]).visible(false);

                    }else if(virtual){
                        table.columns(8).visible(true);
                        table.columns(12).visible(true);
                        table.columns(16).visible(true);
                        table.columns(20).visible(true);
                        table.columns(24).visible(true);
                        table.columns(28).visible(true);
                        table.columns(32).visible(true);
                        table.columns(36).visible(true);
                        table.columns(40).visible(true);
                        table.columns(44).visible(true);      
                        table.columns(48).visible(true);
                        table.columns(52).visible(true);
                        table.columns(56).visible(true);
                        table.columns(60).visible(true);      
                        table.columns(64).visible(true);       
                    }
                    if(!presencial){ 
                        table.columns([9,10]).visible(false);
                        table.columns([13,14]).visible(false);
                        table.columns([17,18]).visible(false);
                        table.columns([21,22]).visible(false);
                        table.columns([25,26]).visible(false);
                        table.columns([29,30]).visible(false);
                        table.columns([33,34]).visible(false);
                        table.columns([37,38]).visible(false);
                        table.columns([41,42]).visible(false);
                        table.columns([45,46]).visible(false);
                        table.columns([49,50]).visible(false);
                        table.columns([53,54]).visible(false);
                        table.columns([57,58]).visible(false);
                        table.columns([61,62]).visible(false);
                        table.columns([65,66]).visible(false);
                    }else if(presencial){
                        table.columns(9).visible(true);
                        table.columns(13).visible(true);
                        table.columns(17).visible(true);
                        table.columns(21).visible(true);
                        table.columns(25).visible(true);
                        table.columns(29).visible(true);
                        table.columns(33).visible(true);
                        table.columns(37).visible(true);
                        table.columns(41).visible(true);
                        table.columns(45).visible(true);     
                        table.columns(49).visible(true);
                        table.columns(53).visible(true);
                        table.columns(57).visible(true);
                        table.columns(61).visible(true);     
                        table.columns(65).visible(true);      
                    }
                    if(presencial && virtual){
                        table.columns([8,9,10]).visible(true);
                        table.columns([12,13,14]).visible(true);
                        table.columns([16,17,18]).visible(true);
                        table.columns([20,21,22]).visible(true);
                        table.columns([24,25,26]).visible(true);
                        table.columns([28,29,30]).visible(true);
                        table.columns([32,33,34]).visible(true);
                        table.columns([36,37,38]).visible(true);
                        table.columns([40,41,42]).visible(true);
                        table.columns([44,45,46]).visible(true); 
                        table.columns([48,49,50]).visible(true);
                        table.columns([52,53,54]).visible(true);
                        table.columns([56,57,58]).visible(true);
                        table.columns([60,61,62]).visible(true); 
                        table.columns([64,65,66]).visible(true);  
                    }

                    break;
                case '2':
                    if(!virtual){
                        table2.columns([8,10]).visible(false);
                        table2.columns([12,14]).visible(false);
                        table2.columns([16,18]).visible(false);
                        table2.columns([20,22]).visible(false);
                        table2.columns([24,26]).visible(false);
                        table2.columns([28,30]).visible(false);
                        table2.columns([32,34]).visible(false);
                        table2.columns([36,38]).visible(false);
                        table2.columns([40,42]).visible(false);
                        table2.columns([44,46]).visible(false);
                        table2.columns([48,50]).visible(false);
                        table2.columns([52,54]).visible(false);
                        table2.columns([56,58]).visible(false);
                        table2.columns([60,62]).visible(false);
                        
                    }else if(virtual){
                        table2.columns(8).visible(true);
                        table2.columns(12).visible(true);
                        table2.columns(16).visible(true);
                        table2.columns(20).visible(true);
                        table2.columns(24).visible(true);
                        table2.columns(28).visible(true);
                        table2.columns(32).visible(true);
                        table2.columns(36).visible(true);
                        table2.columns(40).visible(true);
                        table2.columns(44).visible(true);      
                        table2.columns(48).visible(true);
                        table2.columns(52).visible(true);
                        table2.columns(56).visible(true);
                        table2.columns(60).visible(true);
                    }
                    if(!presencial){ 
                        table2.columns([9,10]).visible(false);
                        table2.columns([13,14]).visible(false);
                        table2.columns([17,18]).visible(false);
                        table2.columns([21,22]).visible(false);
                        table2.columns([25,26]).visible(false);
                        table2.columns([29,30]).visible(false);
                        table2.columns([33,34]).visible(false);
                        table2.columns([37,38]).visible(false);
                        table2.columns([41,42]).visible(false);
                        table2.columns([45,46]).visible(false);
                        table2.columns([49,50]).visible(false);
                        table2.columns([53,54]).visible(false);
                        table2.columns([57,58]).visible(false);
                        table2.columns([61,62]).visible(false);
                    }else if(presencial){
                        table2.columns(9).visible(true);
                        table2.columns(13).visible(true);
                        table2.columns(17).visible(true);
                        table2.columns(21).visible(true);
                        table2.columns(25).visible(true);
                        table2.columns(29).visible(true);
                        table2.columns(33).visible(true);
                        table2.columns(37).visible(true);
                        table2.columns(41).visible(true);
                        table2.columns(45).visible(true);     
                        table2.columns(49).visible(true);
                        table2.columns(53).visible(true);
                        table2.columns(57).visible(true);
                        table2.columns(61).visible(true);
                    }
                    if(presencial && virtual){
                        table2.columns([8,9,10]).visible(true);
                        table2.columns([12,13,14]).visible(true);
                        table2.columns([16,17,18]).visible(true);
                        table2.columns([20,21,22]).visible(true);
                        table2.columns([24,25,26]).visible(true);
                        table2.columns([28,29,30]).visible(true);
                        table2.columns([32,33,34]).visible(true);
                        table2.columns([36,37,38]).visible(true);
                        table2.columns([40,41,42]).visible(true);
                        table2.columns([44,45,46]).visible(true); 
                        table2.columns([48,49,50]).visible(true);
                        table2.columns([52,53,54]).visible(true);
                        table2.columns([56,57,58]).visible(true);
                        table2.columns([60,61,62]).visible(true);
                    }

                    break;
                case '3':
                    if(!virtual){
                        table3.columns([8,10]).visible(false);
                        table3.columns([12,14]).visible(false);
                        table3.columns([16,18]).visible(false);
                        table3.columns([20,22]).visible(false);
                        table3.columns([24,26]).visible(false);
                        table3.columns([28,30]).visible(false);
                        table3.columns([32,34]).visible(false);
                        table3.columns([36,38]).visible(false);
                        table3.columns([40,42]).visible(false);
                        table3.columns([44,46]).visible(false);
                        table3.columns([48,50]).visible(false);
                        table3.columns([52,54]).visible(false);
                        
                    }else if(virtual){
                        table3.columns(8).visible(true);
                        table3.columns(12).visible(true);
                        table3.columns(16).visible(true);
                        table3.columns(20).visible(true);
                        table3.columns(24).visible(true);
                        table3.columns(28).visible(true);
                        table3.columns(32).visible(true);
                        table3.columns(36).visible(true);
                        table3.columns(40).visible(true);
                        table3.columns(44).visible(true);      
                        table3.columns(48).visible(true);
                        table3.columns(52).visible(true);
                    }
                    if(!presencial){ 
                        table3.columns([9,10]).visible(false);
                        table3.columns([13,14]).visible(false);
                        table3.columns([17,18]).visible(false);
                        table3.columns([21,22]).visible(false);
                        table3.columns([25,26]).visible(false);
                        table3.columns([29,30]).visible(false);
                        table3.columns([33,34]).visible(false);
                        table3.columns([37,38]).visible(false);
                        table3.columns([41,42]).visible(false);
                        table3.columns([45,46]).visible(false);
                        table3.columns([49,50]).visible(false);
                        table3.columns([53,54]).visible(false);
                    }else if(presencial){
                        table3.columns(9).visible(true);
                        table3.columns(13).visible(true);
                        table3.columns(17).visible(true);
                        table3.columns(21).visible(true);
                        table3.columns(25).visible(true);
                        table3.columns(29).visible(true);
                        table3.columns(33).visible(true);
                        table3.columns(37).visible(true);
                        table3.columns(41).visible(true);
                        table3.columns(45).visible(true);     
                        table3.columns(49).visible(true);
                        table3.columns(53).visible(true);
                    }
                    if(presencial && virtual){
                        table3.columns([8,9,10]).visible(true);
                        table3.columns([12,13,14]).visible(true);
                        table3.columns([16,17,18]).visible(true);
                        table3.columns([20,21,22]).visible(true);
                        table3.columns([24,25,26]).visible(true);
                        table3.columns([28,29,30]).visible(true);
                        table3.columns([32,33,34]).visible(true);
                        table3.columns([36,37,38]).visible(true);
                        table3.columns([40,41,42]).visible(true);
                        table3.columns([44,45,46]).visible(true); 
                        table3.columns([48,49,50]).visible(true);
                        table3.columns([52,53,54]).visible(true);
                    }

                    break;
                default:
                console.log("ERROR CONTACTE AL ADMINISTRADOR");
            }  
        });
    }else{
        var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_1')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;
                },            
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                            var contador = 0;
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                            return contador; 
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_presenciales[i].Total);
                               contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var virtual=0;
                        var presencial=0;
                        for(const i in data.cursos_virtuales){
                            virtual = virtual + parseInt(data.cursos_virtuales[i].Total)    
                        }

                        for(const i in data.cursos_presenciales){
                            presencial = presencial + parseInt(data.cursos_presenciales[i].Total)
                            
                        }

                        return virtual+presencial;
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

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 1",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima1")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BO1',
                                }
                            } ) );
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );


                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:J2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'K2:N2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'O2:R2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'S2:V2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'W2:Z2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AA2:AD2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AE2:AH2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AI2:AL2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AM2:AP2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AQ2:AT2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AU2:AX2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AY2:BB2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BC2:BF2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BG2:BJ2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BK2:BN2',
                                }
                            } ) );

                             mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BO2:BO3',
                                }
                            } ) );
                            
                            mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }

                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 1 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Estado" }])
                            var r9 = Addrow(2, [{ key: 'G', value: "ACCION CIUDADANA" }])
                            var r10 = Addrow(2, [{ key: 'K', value: "ARTES" }])
                            var r11 = Addrow(2, [{ key: 'O', value: "BIOLOGIA" }])
                            var r12 = Addrow(2, [{ key: 'S', value: "CULTURA DEMOCRATICA" }])
                            var r13 = Addrow(2, [{ key: 'W', value: "DEPORTE" }])
                            var r14 = Addrow(2, [{ key: 'AA', value: "DIALOGO" }])
                            var r15 = Addrow(2, [{ key: 'AE', value: "FILOSOFIA" }])
                            var r16 = Addrow(2, [{ key: 'AI', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'AM', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AQ', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AU', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AY', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'BC', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'BG', value: "QUIMICA" }])
                            var r23 = Addrow(2, [{ key: 'BK', value: "TIC" }])
                            var r24 = Addrow(2, [{ key: 'BO', value: "TOTAL" }])
                            sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7+ r9 +r10 +r11+ r12+r13 +r14+ r15+r16+r17 +r18+ r19 + r20+r21+r22+r23+r24+sheet.childNodes[0].childNodes[1].innerHTML;
                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="K2"]', sheet).attr( 's', '2' );
                            $('row c[r="O2"]', sheet).attr( 's', '2' );
                            $('row c[r="S2"]', sheet).attr( 's', '2' );
                            $('row c[r="W2"]', sheet).attr( 's', '2' );
                            $('row c[r="AA2"]', sheet).attr( 's', '2' );
                            $('row c[r="AE2"]', sheet).attr( 's', '2' );
                            $('row c[r="AI2"]', sheet).attr( 's', '2' );
                            $('row c[r="AM2"]', sheet).attr( 's', '2' );
                            $('row c[r="AQ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AU2"]', sheet).attr( 's', '2' );
                            $('row c[r="AY2"]', sheet).attr( 's', '2' );
                            $('row c[r="BC2"]', sheet).attr( 's', '2' );
                            $('row c[r="BG2"]', sheet).attr( 's', '2' );
                            $('row c[r="BK2"]', sheet).attr( 's', '2' );
                            $('row c[r="BO2"]', sheet).attr( 's', '2' );
                        },
                    }
                ]
            }
        });

        var table2 = $("#example2").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_2')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;
                },           
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },   
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },   
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var virtual=0;
                        var presencial=0;
                        for(const i in data.cursos_virtuales){
                            virtual = virtual + parseInt(data.cursos_virtuales[i].Total)    
                        }

                        for(const i in data.cursos_presenciales){
                            presencial = presencial + parseInt(data.cursos_presenciales[i].Total)
                            
                        }

                        return virtual+presencial;
                    }
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" target="_blank" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
                }
            }
            ],

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 2",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima2")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BK1',
                                }
                            } ) );
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );


                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:J2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'K2:N2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'O2:R2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'S2:V2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'W2:Z2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AA2:AD2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AE2:AH2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AI2:AL2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AM2:AP2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AQ2:AT2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AU2:AX2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AY2:BB2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BC2:BF2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BG2:BJ2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BK2:BK3',
                                }
                            } ) );

                            mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }

                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 2 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Estado" }])
                            var r9 = Addrow(2, [{ key: 'G', value: "ACCION CIUDADANA" }])
                            var r10 = Addrow(2, [{ key: 'K', value: "ARTES" }])
                            var r11 = Addrow(2, [{ key: 'O', value: "BIOLOGIA" }])
                            var r13 = Addrow(2, [{ key: 'S', value: "DEPORTE" }])
                            var r14 = Addrow(2, [{ key: 'W', value: "DIALOGO" }])
                            var r15 = Addrow(2, [{ key: 'AA', value: "FILOSOFIA" }])
                            var r16 = Addrow(2, [{ key: 'AE', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'AI', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AM', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AQ', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AU', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'AY', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'BC', value: "QUIMICA" }])
                            var r23 = Addrow(2, [{ key: 'BG', value: "TIC" }])
                            var r24 = Addrow(2, [{ key: 'BK', value: "TOTAL" }])
                            sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7+ r9 +r10 +r11+r13 +r14+ r15+r16+r17 +r18+ r19 + r20+r21+r22+r23+r24+sheet.childNodes[0].childNodes[1].innerHTML;
                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="K2"]', sheet).attr( 's', '2' );
                            $('row c[r="O2"]', sheet).attr( 's', '2' );
                            $('row c[r="S2"]', sheet).attr( 's', '2' );
                            $('row c[r="W2"]', sheet).attr( 's', '2' );
                            $('row c[r="AA2"]', sheet).attr( 's', '2' );
                            $('row c[r="AE2"]', sheet).attr( 's', '2' );
                            $('row c[r="AI2"]', sheet).attr( 's', '2' );
                            $('row c[r="AM2"]', sheet).attr( 's', '2' );
                            $('row c[r="AQ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AU2"]', sheet).attr( 's', '2' );
                            $('row c[r="AY2"]', sheet).attr( 's', '2' );
                            $('row c[r="BC2"]', sheet).attr( 's', '2' );
                            $('row c[r="BG2"]', sheet).attr( 's', '2' );
                            $('row c[r="BK2"]', sheet).attr( 's', '2' );
                        },
                    }
                ]
            }
        });

        var table3 = $("#example3").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('asistencias_linea_3')}}",
                "data": function(d){
                    var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
                    d.mes = document.mes.filtro[i].value;
                },             
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'tipo_documento'},
                {data: 'document_number'},
                {data: 'grupo_name'},
                {data: 'estado'},
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "PRACTICAS"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador += parseInt(data.cursos_presenciales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            return "-";
                        }else{

                            var docente = "-";

                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_virtuales[i].fullname.split("-", 2)[1] == comparar){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        docente = data.cursos_virtuales[i].docente_name;
                                    }      
                                }
                            }
                            
                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    var comparar = " "+data.grupo_name.toUpperCase()+" ";
                                    if(data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA" && data.cursos_presenciales[i].fullname.split("-", 2)[1] == comparar){
                                     docente = data.cursos_presenciales[i].docente_name;
                                    }      
                                }
                            }
                            return docente;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador += parseInt(data.cursos_virtuales[i].Total);
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_presenciales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_presenciales){
                            if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_presenciales[i].Total);
                                contador = data.cursos_presenciales[i].Total;
                            }      
                        }
                        return contador;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null && data.cursos_presenciales == null){
                            var contador = 0;
                            return '<a class="btn">'+contador+'</a>';
                        }else{
                            var contador = 0;
                            var id = 0;
                            if(data.cursos_virtuales != null){
                                for(const i in data.cursos_virtuales){
                                    if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_virtuales[i].Total);
                                        id = parseInt(data.cursos_virtuales[i].id);
                                        contador += parseInt(data.cursos_virtuales[i].Total);
                                    }      
                                }
                            }

                            if(data.cursos_presenciales != null){
                                for(const i in data.cursos_presenciales){
                                    if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                        //console.log(data.cursos_presenciales[i].Total);
                                        if(id <= 0){
                                            id = parseInt(data.cursos_presenciales[i].id);
                                        }
                                        
                                        contador += parseInt(data.cursos_presenciales[i].Total);
                                    }      
                                }
                            }
                            if(contador > 0){
                                return '<button class="btn" type="button" onclick="abrir_modal('+id+','+data.id+');"><u>'+contador+'</u></button>';
                            }
                            return '<a class="btn"><u>'+contador+'</u></a>';
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta){
                        var contador=0;

                        for(const i in data.cursos_virtuales){
                            contador = contador + parseInt(data.cursos_virtuales[i].Total)
                        }
                        for(const i in data.cursos_presenciales){
                            contador = contador + parseInt(data.cursos_presenciales[i].Total)
                        }
                        return contador;
                    }
                },
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" target="_blank" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 
                    return mstr;
                }
            }

            ],

            "deferRender": true,"responsive": false,"processing": true,'serverSider':true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            buttons:{
                dom:{
                    button:{
                        className:'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excelHtml5",
                        title:"",
                        filename:"Asistencias Estudiantes Linea 3",
                        text:'Exportar a Excel',
                        className: 'btn-outline-success',
                        exportOptions: {
                        
                            columns: 'th:not("#ultima3")'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var mergeCells = $('mergeCells', sheet);
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A1:BC1',
                                }
                            } ) );
                
                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'A2:A3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'B2:B3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'C2:C3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'D2:D3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'E2:E3',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'F2:F3',
                                }
                            } ) );


                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'G2:J2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'K2:N2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'O2:R2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'S2:V2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'W2:Z2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AA2:AD2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AE2:AH2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AI2:AL2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AM2:AP2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AQ2:AT2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AU2:AX2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'AY2:BB2',
                                }
                            } ) );

                            mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                 attr: {
                                    ref: 'BC2:BC3',
                                }
                            } ) );

                            mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                
 
                            function _createNode( doc, nodeName, opts ) {
                                var tempNode = doc.createElement( nodeName );
 
                                if ( opts ) {
                                    if ( opts.attr ) {
                                     $(tempNode).attr( opts.attr );
                                    }
 
                                    if ( opts.children ) {
                                        $.each( opts.children, function ( key, value ) {
                                            tempNode.appendChild( value );
                                        } );
                                    }
 
                                    if ( opts.text !== null && opts.text !== undefined ) {
                                        tempNode.appendChild( doc.createTextNode( opts.text ) );
                                    }
                                }
                                return tempNode;
                            }

                            var numrows = 2;
                            var clR = $('row', sheet);
 
                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r", ind);
                            });
 
                            // Create row before data
                            $('row c ', sheet).each(function () {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });
 
                            function Addrow(index, data) {
                            var msg = '<row r="' + index + '">'
                                for (var i = 0; i < data.length; i++) {
                                    var key = data[i].key;
                                    var value = data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
 
                            var fecha_json = new Date();
                            var titulo = "REPORTE ASISTENCIAS LINEA 3 "+"\n"+"Fecha de generación: "+fecha_json.toLocaleString();
                            var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                            var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                            var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                            var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                            var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                            var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                            var r7 = Addrow(2, [{ key: 'F', value: "Estado" }])
                            var r11 = Addrow(2, [{ key: 'G', value: "BIOLOGIA" }])
                            var r13 = Addrow(2, [{ key: 'K', value: "DIALOGO" }])
                            var r14 = Addrow(2, [{ key: 'O', value: "CONSTITUCION" }])
                            var r16 = Addrow(2, [{ key: 'S', value: "FISICA" }])
                            var r17 = Addrow(2, [{ key: 'W', value: "GEOGRAFIA" }])
                            var r18 = Addrow(2, [{ key: 'AA', value: "HISTORIA" }])
                            var r19 = Addrow(2, [{ key: 'AE', value: "INGLES" }])
                            var r20 = Addrow(2, [{ key: 'AI', value: "LECTURA CRITICA" }])
                            var r21 = Addrow(2, [{ key: 'AM', value: "MATEMATICAS" }])
                            var r22 = Addrow(2, [{ key: 'AQ', value: "PRACTICAS ARTISTICAS" }])
                            var r23 = Addrow(2, [{ key: 'AU', value: "QUIMICA" }])
                            var r24 = Addrow(2, [{ key: 'AY', value: "TIC" }])
                            var r25 = Addrow(2, [{ key: 'BC', value: "TOTAL" }])
                            sheet.childNodes[0].childNodes[1].innerHTML = r1+r2+r3+r4+r5+r6+r7+r11+r13+r14+r16+r17+r18+r19
                            +r20+r21+r22+r23+r24+r25+sheet.childNodes[0].childNodes[1].innerHTML;
                            $('row c[r="A1"]', sheet).attr( 's', '51' );
                            $('row c[r="A2"]', sheet).attr( 's', '2' );
                            $('row c[r="B2"]', sheet).attr( 's', '2' );
                            $('row c[r="C2"]', sheet).attr( 's', '2' );
                            $('row c[r="D2"]', sheet).attr( 's', '2' );
                            $('row c[r="E2"]', sheet).attr( 's', '2' );
                            $('row c[r="F2"]', sheet).attr( 's', '2' );
                            $('row c[r="G2"]', sheet).attr( 's', '2' );
                            $('row c[r="K2"]', sheet).attr( 's', '2' );
                            $('row c[r="O2"]', sheet).attr( 's', '2' );
                            $('row c[r="S2"]', sheet).attr( 's', '2' );
                            $('row c[r="W2"]', sheet).attr( 's', '2' );
                            $('row c[r="AA2"]', sheet).attr( 's', '2' );
                            $('row c[r="AE2"]', sheet).attr( 's', '2' );
                            $('row c[r="AI2"]', sheet).attr( 's', '2' );
                            $('row c[r="AM2"]', sheet).attr( 's', '2' );
                            $('row c[r="AQ2"]', sheet).attr( 's', '2' );
                            $('row c[r="AU2"]', sheet).attr( 's', '2' );
                            $('row c[r="AY2"]', sheet).attr( 's', '2' );
                            $('row c[r="BC2"]', sheet).attr( 's', '2' );
                        },
                    }
                ]
            }
        });

        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();

            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([7,9]).visible(false);
                        table.columns([11,13]).visible(false);
                        table.columns([15,17]).visible(false);
                        table.columns([19,21]).visible(false);
                        table.columns([23,25]).visible(false);
                        table.columns([27,29]).visible(false);
                        table.columns([31,33]).visible(false);
                        table.columns([35,37]).visible(false);
                        table.columns([39,41]).visible(false);
                        table.columns([43,45]).visible(false);
                        table.columns([47,49]).visible(false);
                        table.columns([51,53]).visible(false);
                        table.columns([55,57]).visible(false);
                        table.columns([59,61]).visible(false);
                        table.columns([63,65]).visible(false);
                    }else if(virtual){
                        table.columns(7).visible(true);
                        table.columns(11).visible(true);
                        table.columns(15).visible(true);
                        table.columns(19).visible(true);
                        table.columns(23).visible(true);
                        table.columns(27).visible(true);
                        table.columns(31).visible(true);
                        table.columns(35).visible(true);
                        table.columns(39).visible(true);
                        table.columns(43).visible(true);
                        table.columns(47).visible(true);
                        table.columns(51).visible(true);
                        table.columns(55).visible(true);
                        table.columns(59).visible(true);
                        table.columns(63).visible(true);
                    }
            
                    if(!presencial){ 
                        table.columns([8,9]).visible(false);
                        table.columns([12,13]).visible(false);
                        table.columns([16,17]).visible(false);
                        table.columns([20,21]).visible(false);
                        table.columns([24,25]).visible(false);
                        table.columns([28,29]).visible(false);
                        table.columns([32,33]).visible(false);
                        table.columns([36,37]).visible(false);
                        table.columns([40,41]).visible(false);
                        table.columns([44,45]).visible(false);
                        table.columns([48,49]).visible(false);
                        table.columns([52,53]).visible(false);
                        table.columns([56,57]).visible(false);
                        table.columns([60,61]).visible(false);
                        table.columns([64,65]).visible(false);
                    }else if(presencial){
                        table.columns(8).visible(true);
                        table.columns(12).visible(true);
                        table.columns(16).visible(true);
                        table.columns(20).visible(true);
                        table.columns(24).visible(true);
                        table.columns(28).visible(true);
                        table.columns(32).visible(true);
                        table.columns(36).visible(true);
                        table.columns(40).visible(true);
                        table.columns(44).visible(true);
                        table.columns(48).visible(true);
                        table.columns(52).visible(true);
                        table.columns(56).visible(true);
                        table.columns(60).visible(true);
                        table.columns(64).visible(true);
                    }

                    if(presencial && virtual){
                        table.columns([7,8,9]).visible(true);
                        table.columns([11,12,13]).visible(true);
                        table.columns([15,16,17]).visible(true);
                        table.columns([19,20,21]).visible(true);
                        table.columns([23,24,25]).visible(true);
                        table.columns([27,28,29]).visible(true);
                        table.columns([31,32,33]).visible(true);
                        table.columns([35,36,37]).visible(true);
                        table.columns([39,40,41]).visible(true);
                        table.columns([43,44,45]).visible(true); 
                        table.columns([47,48,49]).visible(true);
                        table.columns([51,52,53]).visible(true);
                        table.columns([55,56,57]).visible(true);
                        table.columns([59,60,61]).visible(true); 
                        table.columns([63,64,65]).visible(true); 
                    }

                    break;
                case '2':
                    if(!virtual){
                        table2.columns([7,9]).visible(false);
                        table2.columns([11,13]).visible(false);
                        table2.columns([15,17]).visible(false);
                        table2.columns([19,21]).visible(false);
                        table2.columns([23,25]).visible(false);
                        table2.columns([27,29]).visible(false);
                        table2.columns([31,33]).visible(false);
                        table2.columns([35,37]).visible(false);
                        table2.columns([39,41]).visible(false);
                        table2.columns([43,45]).visible(false);
                        table2.columns([47,49]).visible(false);
                        table2.columns([51,53]).visible(false);
                        table2.columns([55,57]).visible(false);
                        table2.columns([59,61]).visible(false);
                    }else if(virtual){
                        table2.columns(7).visible(true);
                        table2.columns(11).visible(true);
                        table2.columns(15).visible(true);
                        table2.columns(19).visible(true);
                        table2.columns(23).visible(true);
                        table2.columns(27).visible(true);
                        table2.columns(31).visible(true);
                        table2.columns(35).visible(true);
                        table2.columns(39).visible(true);
                        table2.columns(43).visible(true);
                        table2.columns(47).visible(true);
                        table2.columns(51).visible(true);
                        table2.columns(55).visible(true);
                        table2.columns(59).visible(true);
                    }
            
                    if(!presencial){ 
                        table2.columns([8,9]).visible(false);
                        table2.columns([12,13]).visible(false);
                        table2.columns([16,17]).visible(false);
                        table2.columns([20,21]).visible(false);
                        table2.columns([24,25]).visible(false);
                        table2.columns([28,29]).visible(false);
                        table2.columns([32,33]).visible(false);
                        table2.columns([36,37]).visible(false);
                        table2.columns([40,41]).visible(false);
                        table2.columns([44,45]).visible(false);
                        table2.columns([48,49]).visible(false);
                        table2.columns([52,53]).visible(false);
                        table2.columns([56,57]).visible(false);
                        table2.columns([60,61]).visible(false);
                    }else if(presencial){
                        table2.columns(8).visible(true);
                        table2.columns(12).visible(true);
                        table2.columns(16).visible(true);
                        table2.columns(20).visible(true);
                        table2.columns(24).visible(true);
                        table2.columns(28).visible(true);
                        table2.columns(32).visible(true);
                        table2.columns(36).visible(true);
                        table2.columns(40).visible(true);
                        table2.columns(44).visible(true);
                        table2.columns(48).visible(true);
                        table2.columns(52).visible(true);
                        table2.columns(56).visible(true);
                        table2.columns(60).visible(true);
                    }

                    if(presencial && virtual){
                        table2.columns([7,8,9]).visible(true);
                        table2.columns([11,12,13]).visible(true);
                        table2.columns([15,16,17]).visible(true);
                        table2.columns([19,20,21]).visible(true);
                        table2.columns([23,24,25]).visible(true);
                        table2.columns([27,28,29]).visible(true);
                        table2.columns([31,32,33]).visible(true);
                        table2.columns([35,36,37]).visible(true);
                        table2.columns([39,40,41]).visible(true);
                        table2.columns([43,44,45]).visible(true); 
                        table2.columns([47,48,49]).visible(true);
                        table2.columns([51,52,53]).visible(true);
                        table2.columns([55,56,57]).visible(true);
                        table2.columns([59,60,61]).visible(true); 
                    }

                    break;
                case '3':
                    if(!virtual){
                        table3.columns([7,9]).visible(false);
                        table3.columns([11,13]).visible(false);
                        table3.columns([15,17]).visible(false);
                        table3.columns([19,21]).visible(false);
                        table3.columns([23,25]).visible(false);
                        table3.columns([27,29]).visible(false);
                        table3.columns([31,33]).visible(false);
                        table3.columns([35,37]).visible(false);
                        table3.columns([39,41]).visible(false);
                        table3.columns([43,45]).visible(false);
                        table3.columns([47,49]).visible(false);
                        table3.columns([51,53]).visible(false);
                        table3.columns([55,57]).visible(false);
                        table3.columns([59,61]).visible(false);
                    }else if(virtual){
                        table3.columns(7).visible(true);
                        table3.columns(11).visible(true);
                        table3.columns(15).visible(true);
                        table3.columns(19).visible(true);
                        table3.columns(23).visible(true);
                        table3.columns(27).visible(true);
                        table3.columns(31).visible(true);
                        table3.columns(35).visible(true);
                        table3.columns(39).visible(true);
                        table3.columns(43).visible(true);
                        table3.columns(47).visible(true);
                        table3.columns(51).visible(true);
                        table3.columns(55).visible(true);
                        table3.columns(59).visible(true);
                    }
            
                    if(!presencial){ 
                        table3.columns([8,9]).visible(false);
                        table3.columns([12,13]).visible(false);
                        table3.columns([16,17]).visible(false);
                        table3.columns([20,21]).visible(false);
                        table3.columns([24,25]).visible(false);
                        table3.columns([28,29]).visible(false);
                        table3.columns([32,33]).visible(false);
                        table3.columns([36,37]).visible(false);
                        table3.columns([40,41]).visible(false);
                        table3.columns([44,45]).visible(false);
                        table3.columns([48,49]).visible(false);
                        table3.columns([52,53]).visible(false);
                        table3.columns([56,57]).visible(false);
                        table3.columns([60,61]).visible(false);
                    }else if(presencial){
                        table3.columns(8).visible(true);
                        table3.columns(12).visible(true);
                        table3.columns(16).visible(true);
                        table3.columns(20).visible(true);
                        table3.columns(24).visible(true);
                        table3.columns(28).visible(true);
                        table3.columns(32).visible(true);
                        table3.columns(36).visible(true);
                        table3.columns(40).visible(true);
                        table3.columns(44).visible(true);
                        table3.columns(48).visible(true);
                        table3.columns(52).visible(true);
                        table3.columns(56).visible(true);
                        table3.columns(60).visible(true);
                    }

                    if(presencial && virtual){
                        table3.columns([7,8,9]).visible(true);
                        table3.columns([11,12,13]).visible(true);
                        table3.columns([15,16,17]).visible(true);
                        table3.columns([19,20,21]).visible(true);
                        table3.columns([23,24,25]).visible(true);
                        table3.columns([27,28,29]).visible(true);
                        table3.columns([31,32,33]).visible(true);
                        table3.columns([35,36,37]).visible(true);
                        table3.columns([39,40,41]).visible(true);
                        table3.columns([43,44,45]).visible(true); 
                        table3.columns([47,48,49]).visible(true);
                        table3.columns([51,52,53]).visible(true);
                        table3.columns([55,56,57]).visible(true);
                        table3.columns([59,60,61]).visible(true); 
                    }
                    break;
                default:
                console.log("ERROR CONTACTE AL ADMINISTRADOR");
            }   
        });
    }    
    

    $('#Ecohort').change(function(event){
        //alert(event.target.value);
        if(event.target.value == 1){
            
            document.getElementById("tabla_1").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
            $('#example1').DataTable().ajax.reload(); 
        }else{
 
            document.getElementById("tabla_1").setAttribute('style', 'display:none');
            document.getElementById("div_1").setAttribute('style', 'display:none');
            
        }
        if(event.target.value == 2){
            
            document.getElementById("tabla_2").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
            $('#example2').DataTable().ajax.reload();
            
        }else{
 
            document.getElementById("tabla_2").setAttribute('style', 'display:none');
        }
        if(event.target.value == 3){
            document.getElementById("tabla_3").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
            $('#example3').DataTable().ajax.reload();
        }else{
 
            document.getElementById("tabla_3").setAttribute('style', 'display:none');
        }
    });

    $('.asistencias_mes').on('change', function() {
        var tabla= $('#Ecohort').val();
        if(tabla == 1){
            $('#example1').DataTable().ajax.reload();
            toastr.success("Cambio exitoso!!");
        }else if(tabla == 2){
            $('#example2').DataTable().ajax.reload();
            toastr.success("Cambio exitoso!!");
        }else if(tabla == 3){
            $('#example3').DataTable().ajax.reload();
            toastr.success("Cambio exitoso!!");
        }               
    });

    function abrir_modal(id_course,id_student){
        $("#recargar").load(" #recargar > *");
        var i
                    for (i = 0; i < document.mes.filtro.length; i++){ 
                        if (document.mes.filtro[i].checked) {
                            break; 
                        }
                    }
        var mes = document.mes.filtro[i].value;
        $.get("/detalles_sesiones/"+id_student+"/"+id_course+"/"+mes+"",function(response,municipios){
            //console.log(response)
            if(response.length == 0){
                alert("ESTE CURSO NO TIENE SESIONES REGISTRADAS EN EL SISTEMA")
            }else{
                $('#nombre').append(response[0].estudiante)
                $('#mensaje').append(response[0].curso," ",response[0].grupo_linea);
                $.each(response,function(index,sesiones){
                    //console.log(sesiones)
                    
                    let i = document.createElement('i');
                    let h6 = document.createElement('h6');
                    
                    if(sesiones.asistio == "SI" && sesiones.calificada == "SI"){
                        h6.innerHTML = sesiones.asistio;
                        i.className += "btn  btn-sm  fa fa-check";
                        i.setAttribute('style', "color: #2ECC71");
                    }else if(sesiones.asistio == "NO" && sesiones.calificada == "SI"){
                        h6.innerHTML = sesiones.asistio;
                        i.className += "btn  btn-sm  fa fa-times";
                        i.setAttribute('style', "color: red");
                    }else{
                        i.className += "btn  btn-sm  fa fa-minus";
                        i.setAttribute('style', "color: gray");
                    }
                    h6.appendChild(i);
                    let row_2 = document.createElement('tr');
                    let row_2_data_1 = document.createElement('td');
                    let row_2_data_2 = document.createElement('td');
                    row_2_data_1.innerHTML = sesiones.date_session;
                    row_2_data_2.appendChild(h6);
                    row_2.appendChild(row_2_data_1);
                    row_2.appendChild(row_2_data_2);
                    document.getElementById("sesiones").appendChild(row_2);
                });
                $("#sesiones_tabla").DataTable({
                            "processing": true,
                            "LoadingRecords":true,
                            "paging": true,
                            "deferRender": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "order": [ 0, 'desc'],
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                            },
                            "dom": 'Bfrtip',
                            "buttons": ["copy","excel", "pdf", "print"]
                });
                $('#modal_sesiones').modal('show');
            }
        });
           
    }  
</script>
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
