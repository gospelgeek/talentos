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
                <label>AGOSTO</label>&nbsp;<input type="radio" name="filtro" value="8" id="agosto">
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
                <th colspan="3">ACCION CIUDADANA</th>
                <th colspan="3">ARTES</th>
                <th colspan="3">BIOLOGIA</th>
                <th colspan="3">CULTURA DEMOCRATICA</th>
                <th colspan="3">DEPORTE</th>
                <th colspan="3">DIALOGO</th>
                <th colspan="3">FILOSOFIA</th>
                <th colspan="3">FISICA</th>
                <th colspan="3">GEOGRAFIA</th>
                <th colspan="3">HISTORIA</th>
                <th colspan="3">INGLES</th>
                <th colspan="3">LECTURA CRITICA</th>
                <th colspan="3">MATEMATICAS</th>
                <th colspan="3">QUIMICA</th>
                <th colspan="3">TIC</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2">VER DETALLE</th>
            </tr>
            <tr>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>
            </tr>
        </thead> 
      </table>
    </div>

    <div id="tabla_2" class="table-responsive" style='display:none'>
     <table id="example2" class="table table-bordered table-striped">
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
                <th colspan="3">ACCION CIUDADANA</th>
                <th colspan="3">ARTES</th>
                <th colspan="3">BIOLOGIA</th>
                <th colspan="3">DEPORTE</th>
                <th colspan="3">DIALOGO</th>
                <th colspan="3">CONSTITUCION</th>
                <th colspan="3">FISICA</th>
                <th colspan="3">GEOGRAFIA</th>
                <th colspan="3">HISTORIA</th>
                <th colspan="3">INGLES</th>
                <th colspan="3">LECTURA CRITICA</th>
                <th colspan="3">MATEMATICAS</th>
                <th colspan="3">QUIMICA</th>
                <th colspan="3">TIC</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2">VER DETALLES</th>
            </tr>
            <tr>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_3" class="table-responsive" style='display:none'>
     <table id="example3" class="table table-bordered table-striped">
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
                <th colspan="3">BIOLOGIA</th>
                <th colspan="3">CONSTITUCION</th>
                <th colspan="3">FISICA</th>
                <th colspan="3">GEOGRAFIA</th>
                <th colspan="3">HISTORIA</th>
                <th colspan="3">INGLES</th>
                <th colspan="3">LECTURA CRITICA</th>
                <th colspan="3">MATEMATICAS</th>
                <th colspan="3">QUIMICA</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2">ACCIONES</th>
            </tr>
            <tr>
                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

                <th>Virtual</th>
                <th>Presencial</th>
                <th>Total</th>

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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                            var contador = 0;
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                },{data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                },{data: null, render:function(data, type, row, meta){
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
            "buttons": [
                "copy",
                "csv",
                {
                extend: 'excelHtml5',
                autoFilter: true
                }, 
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print",
                "colvis"
                
            ]
        });
        
        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();
            
            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([7,9]).visible(false);
                        table.columns([10,12]).visible(false);
                        table.columns([13,15]).visible(false);
                        table.columns([16,18]).visible(false);
                        table.columns([19,21]).visible(false);
                        table.columns([22,24]).visible(false);
                        table.columns([25,27]).visible(false);
                        table.columns([28,30]).visible(false);
                        table.columns([31,33]).visible(false);
                        table.columns([34,36]).visible(false);
                        table.columns([37,39]).visible(false);
                        table.columns([40,42]).visible(false);
                        table.columns([43,45]).visible(false);
                        table.columns([46,48]).visible(false);
                        table.columns([49,51]).visible(false);

                    }else if(virtual){
                        table.columns(7).visible(true);
                        table.columns(10).visible(true);
                        table.columns(13).visible(true);
                        table.columns(16).visible(true);
                        table.columns(19).visible(true);
                        table.columns(22).visible(true);
                        table.columns(25).visible(true);
                        table.columns(28).visible(true);
                        table.columns(31).visible(true);
                        table.columns(34).visible(true);      
                        table.columns(37).visible(true);
                        table.columns(40).visible(true);
                        table.columns(43).visible(true);
                        table.columns(46).visible(true);      
                        table.columns(49).visible(true);       
                    }
                    if(!presencial){ 
                        table.columns([8,9]).visible(false);
                        table.columns([11,12]).visible(false);
                        table.columns([14,15]).visible(false);
                        table.columns([17,18]).visible(false);
                        table.columns([20,21]).visible(false);
                        table.columns([23,24]).visible(false);
                        table.columns([26,27]).visible(false);
                        table.columns([29,30]).visible(false);
                        table.columns([32,33]).visible(false);
                        table.columns([35,36]).visible(false);
                        table.columns([38,39]).visible(false);
                        table.columns([41,42]).visible(false);
                        table.columns([44,45]).visible(false);
                        table.columns([47,48]).visible(false);
                        table.columns([50,51]).visible(false);
                    }else if(presencial){
                        table.columns(8).visible(true);
                        table.columns(11).visible(true);
                        table.columns(14).visible(true);
                        table.columns(17).visible(true);
                        table.columns(20).visible(true);
                        table.columns(23).visible(true);
                        table.columns(26).visible(true);
                        table.columns(29).visible(true);
                        table.columns(32).visible(true);
                        table.columns(35).visible(true);     
                        table.columns(38).visible(true);
                        table.columns(41).visible(true);
                        table.columns(44).visible(true);
                        table.columns(47).visible(true);     
                        table.columns(50).visible(true);      
                    }
                    if(presencial && virtual){
                        table.columns([7,8,9]).visible(true);
                        table.columns([10,11,12]).visible(true);
                        table.columns([13,14,15]).visible(true);
                        table.columns([16,17,18]).visible(true);
                        table.columns([19,20,21]).visible(true);
                        table.columns([22,23,24]).visible(true);
                        table.columns([25,26,27]).visible(true);
                        table.columns([28,29,30]).visible(true);
                        table.columns([31,32,33]).visible(true);
                        table.columns([34,35,36]).visible(true); 
                        table.columns([37,38,39]).visible(true);
                        table.columns([40,41,42]).visible(true);
                        table.columns([43,44,45]).visible(true);
                        table.columns([46,47,48]).visible(true); 
                        table.columns([49,50,51]).visible(true);  
                    }

                    break;
                case '2':
                    //alert("d")
                    if(!virtual){
                        
                        table2.columns([7,9]).visible(false);
                        table2.columns([10,12]).visible(false);
                        table2.columns([13,15]).visible(false);
                        table2.columns([16,18]).visible(false);
                        table2.columns([19,21]).visible(false);
                        table2.columns([22,24]).visible(false);
                        table2.columns([25,27]).visible(false);
                        table2.columns([28,30]).visible(false);
                        table2.columns([31,33]).visible(false);
                        table2.columns([34,36]).visible(false);
                        table2.columns([37,39]).visible(false);
                        table2.columns([40,42]).visible(false);
                        table2.columns([43,45]).visible(false);
                        table2.columns([46,48]).visible(false);
                    }else if(virtual){
                        table2.columns(7).visible(true);
                        table2.columns(10).visible(true);
                        table2.columns(13).visible(true);
                        table2.columns(16).visible(true);
                        table2.columns(19).visible(true);
                        table2.columns(22).visible(true);
                        table2.columns(25).visible(true);
                        table2.columns(28).visible(true);
                        table2.columns(31).visible(true);
                        table2.columns(34).visible(true);
                        table2.columns(37).visible(true);
                        table2.columns(40).visible(true);
                        table2.columns(43).visible(true);
                        table2.columns(46).visible(true);
                    }

                    if(!presencial){ 
                        table2.columns([8,9]).visible(false);
                        table2.columns([11,12]).visible(false);
                        table2.columns([14,15]).visible(false);
                        table2.columns([17,18]).visible(false);
                        table2.columns([20,21]).visible(false);
                        table2.columns([23,24]).visible(false);
                        table2.columns([26,27]).visible(false);
                        table2.columns([29,30]).visible(false);
                        table2.columns([32,33]).visible(false);
                        table2.columns([35,36]).visible(false);
                        table2.columns([38,39]).visible(false);
                        table2.columns([41,42]).visible(false);
                        table2.columns([44,45]).visible(false);
                        table2.columns([47,48]).visible(false);
                    }else if(presencial){
                        table2.columns(8).visible(true);
                        table2.columns(11).visible(true);
                        table2.columns(14).visible(true);
                        table2.columns(17).visible(true);
                        table2.columns(20).visible(true);
                        table2.columns(23).visible(true);
                        table2.columns(26).visible(true);
                        table2.columns(29).visible(true);
                        table2.columns(32).visible(true);
                        table2.columns(35).visible(true);
                        table2.columns(38).visible(true);
                        table2.columns(41).visible(true);
                        table2.columns(44).visible(true);
                        table2.columns(47).visible(true);
                    }

                    if(presencial && virtual){
                        table2.columns([7,8,9]).visible(true);
                        table2.columns([10,11,12]).visible(true);
                        table2.columns([13,14,15]).visible(true);
                        table2.columns([16,17,18]).visible(true);
                        table2.columns([19,20,21]).visible(true);
                        table2.columns([22,23,24]).visible(true);
                        table2.columns([25,26,27]).visible(true);
                        table2.columns([28,29,30]).visible(true);
                        table2.columns([31,32,33]).visible(true);
                        table2.columns([34,35,36]).visible(true);
                        table2.columns([37,38,39]).visible(true);
                        table2.columns([40,41,42]).visible(true);
                        table2.columns([43,44,45]).visible(true);
                        table2.columns([46,47,48]).visible(true);
                    }
                    break;
                case '3':
                    if(!virtual){
                        table3.columns([7,9]).visible(false);
                        table3.columns([10,12]).visible(false);
                        table3.columns([13,15]).visible(false);
                        table3.columns([16,18]).visible(false);
                        table3.columns([19,21]).visible(false);
                        table3.columns([22,24]).visible(false);
                        table3.columns([25,27]).visible(false);
                        table3.columns([28,30]).visible(false);
                        table3.columns([31,33]).visible(false);
                    }else if(virtual){
                        table3.columns(7).visible(true);
                        table3.columns(10).visible(true);
                        table3.columns(13).visible(true);
                        table3.columns(16).visible(true);
                        table3.columns(19).visible(true);
                        table3.columns(22).visible(true);
                        table3.columns(25).visible(true);
                        table3.columns(28).visible(true);
                        table3.columns(31).visible(true);       
                    }
                    if(!presencial){ 
                        table3.columns([8,9]).visible(false);
                        table3.columns([11,12]).visible(false);
                        table3.columns([14,15]).visible(false);
                        table3.columns([17,18]).visible(false);
                        table3.columns([20,21]).visible(false);
                        table3.columns([23,24]).visible(false);
                        table3.columns([26,27]).visible(false);
                        table3.columns([29,30]).visible(false);
                        table3.columns([32,33]).visible(false);                       
                    }else if(presencial){
                        table3.columns(8).visible(true);
                        table3.columns(11).visible(true);
                        table3.columns(14).visible(true);
                        table3.columns(17).visible(true);
                        table3.columns(20).visible(true);     
                        table3.columns(23).visible(true);
                        table3.columns(26).visible(true);
                        table3.columns(29).visible(true);     
                        table3.columns(32).visible(true);     
                    }
                    if(presencial && virtual){
                        table3.columns([7,8,9]).visible(true);
                        table3.columns([10,11,12]).visible(true);
                        table3.columns([13,14,15]).visible(true);
                        table3.columns([16,17,18]).visible(true);
                        table3.columns([19,20,21]).visible(true); 
                        table3.columns([22,23,24]).visible(true);
                        table3.columns([25,26,27]).visible(true);
                        table3.columns([28,29,30]).visible(true); 
                        table3.columns([31,32,33]).visible(true);  
                    }

                    break;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                            var contador = 0;
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CULTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FILOSOFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                //console.log(data.cursos[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
                        if(data.cursos_virtuales == null){
                            return 0;
                        }else{
                        var contador = 0;
                        for(const i in data.cursos_virtuales){
                            if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                //console.log(data.cursos_virtuales[i].Total);
                                contador = data.cursos_virtuales[i].Total;
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
            "buttons": [
                "copy",
                "csv",
                {
                extend: 'excelHtml5',
                autoFilter: true
                }, 
                "pdf",
                "print",
                "colvis"
                
            ]
        });

        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();

            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([6,8]).visible(false);
                        table.columns([9,11]).visible(false);
                        table.columns([12,14]).visible(false);
                        table.columns([15,17]).visible(false);
                        table.columns([18,20]).visible(false);
                        table.columns([21,23]).visible(false);
                        table.columns([24,26]).visible(false);
                        table.columns([27,29]).visible(false);
                        table.columns([30,32]).visible(false);
                        table.columns([33,35]).visible(false);
                        table.columns([36,38]).visible(false);
                        table.columns([39,41]).visible(false);
                        table.columns([42,44]).visible(false);
                        table.columns([45,47]).visible(false);
                        table.columns([48,50]).visible(false);
                    }else if(virtual){
                        table.columns(6).visible(true);
                        table.columns(9).visible(true);
                        table.columns(12).visible(true);
                        table.columns(15).visible(true);
                        table.columns(18).visible(true);
                        table.columns(21).visible(true);
                        table.columns(24).visible(true);
                        table.columns(27).visible(true);
                        table.columns(30).visible(true);
                        table.columns(33).visible(true);
                        table.columns(36).visible(true);
                        table.columns(39).visible(true);
                        table.columns(42).visible(true);
                        table.columns(45).visible(true);
                        table.columns(48).visible(true);
                    }
            
                    if(!presencial){ 
                        table.columns([7,8]).visible(false);
                        table.columns([10,11]).visible(false);
                        table.columns([13,14]).visible(false);
                        table.columns([16,17]).visible(false);
                        table.columns([19,20]).visible(false);
                        table.columns([22,23]).visible(false);
                        table.columns([25,26]).visible(false);
                        table.columns([28,29]).visible(false);
                        table.columns([31,32]).visible(false);
                        table.columns([34,35]).visible(false);
                        table.columns([37,38]).visible(false);
                        table.columns([40,41]).visible(false);
                        table.columns([43,44]).visible(false);
                        table.columns([46,47]).visible(false);
                        table.columns([49,50]).visible(false);
                    }else if(presencial){
                        table.columns(7).visible(true);
                        table.columns(10).visible(true);
                        table.columns(13).visible(true);
                        table.columns(16).visible(true);
                        table.columns(19).visible(true);
                        table.columns(22).visible(true);
                        table.columns(25).visible(true);
                        table.columns(28).visible(true);
                        table.columns(31).visible(true);
                        table.columns(34).visible(true);
                        table.columns(37).visible(true);
                        table.columns(40).visible(true);
                        table.columns(43).visible(true);
                        table.columns(46).visible(true);
                        table.columns(49).visible(true);
                    }

                    if(presencial && virtual){
                        table.columns([6,7,8]).visible(true);
                        table.columns([9,10,11]).visible(true);
                        table.columns([12,13,14]).visible(true);
                        table.columns([15,16,17]).visible(true);
                        table.columns([18,19,20]).visible(true);
                        table.columns([21,22,23]).visible(true);
                        table.columns([24,25,26]).visible(true);
                        table.columns([27,28,29]).visible(true);
                        table.columns([30,31,32]).visible(true);
                        table.columns([33,34,35]).visible(true); 
                        table.columns([36,37,38]).visible(true);
                        table.columns([39,40,41]).visible(true);
                        table.columns([42,43,44]).visible(true);
                        table.columns([45,46,47]).visible(true); 
                        table.columns([48,49,50]).visible(true); 
                    }

                    break;
                case '2':
                    if(!virtual){
                        table2.columns([6,8]).visible(false);
                        table2.columns([9,11]).visible(false);
                        table2.columns([12,14]).visible(false);
                        table2.columns([15,17]).visible(false);
                        table2.columns([18,20]).visible(false);
                        table2.columns([21,23]).visible(false);
                        table2.columns([24,26]).visible(false);
                        table2.columns([27,29]).visible(false);
                        table2.columns([30,32]).visible(false);
                        table2.columns([33,35]).visible(false);
                        table2.columns([36,38]).visible(false);
                        table2.columns([39,41]).visible(false);
                        table2.columns([42,44]).visible(false);
                        table2.columns([45,47]).visible(false);
                    }else if(virtual){
                        table2.columns(6).visible(true);
                        table2.columns(9).visible(true);
                        table2.columns(12).visible(true);
                        table2.columns(15).visible(true);
                        table2.columns(18).visible(true);
                        table2.columns(21).visible(true);
                        table2.columns(24).visible(true);
                        table2.columns(27).visible(true);
                        table2.columns(30).visible(true);
                        table2.columns(33).visible(true);
                        table2.columns(36).visible(true);
                        table2.columns(39).visible(true);
                        table2.columns(42).visible(true);
                        table2.columns(45).visible(true);
                    }
            
                    if(!presencial){ 
                        table2.columns([7,8]).visible(false);
                        table2.columns([10,11]).visible(false);
                        table2.columns([13,14]).visible(false);
                        table2.columns([16,17]).visible(false);
                        table2.columns([19,20]).visible(false);
                        table2.columns([22,23]).visible(false);
                        table2.columns([25,26]).visible(false);
                        table2.columns([28,29]).visible(false);
                        table2.columns([31,32]).visible(false);
                        table2.columns([34,35]).visible(false);
                        table2.columns([37,38]).visible(false);
                        table2.columns([40,41]).visible(false);
                        table2.columns([43,44]).visible(false);
                        table2.columns([46,47]).visible(false);
                    }else if(presencial){
                        table2.columns(7).visible(true);
                        table2.columns(10).visible(true);
                        table2.columns(13).visible(true);
                        table2.columns(16).visible(true);
                        table2.columns(19).visible(true);
                        table2.columns(22).visible(true);
                        table2.columns(25).visible(true);
                        table2.columns(28).visible(true);
                        table2.columns(31).visible(true);
                        table2.columns(34).visible(true);
                        table2.columns(37).visible(true);
                        table2.columns(40).visible(true);
                        table2.columns(43).visible(true);
                        table2.columns(46).visible(true);
                    }

                    if(presencial && virtual){
                        table2.columns([6,7,8]).visible(true);
                        table2.columns([9,10,11]).visible(true);
                        table2.columns([12,13,14]).visible(true);
                        table2.columns([15,16,17]).visible(true);
                        table2.columns([18,19,20]).visible(true);
                        table2.columns([21,22,23]).visible(true);
                        table2.columns([24,25,26]).visible(true);
                        table2.columns([27,28,29]).visible(true);
                        table2.columns([30,31,32]).visible(true);
                        table2.columns([33,34,35]).visible(true);
                        table2.columns([36,37,38]).visible(true);
                        table2.columns([39,40,41]).visible(true);
                        table2.columns([42,43,44]).visible(true);
                        table2.columns([45,46,47]).visible(true);    
                    }

                    break;
                case '3':
                    if(!virtual){
                        table.columns([6,8]).visible(false);
                        table.columns([9,11]).visible(false);
                        table.columns([12,14]).visible(false);
                        table.columns([15,17]).visible(false);
                        table.columns([18,20]).visible(false);
                        table.columns([21,23]).visible(false);
                        table.columns([24,26]).visible(false);
                        table.columns([27,29]).visible(false);
                        table.columns([30,32]).visible(false);
                    }else if(virtual){
                        table.columns(6).visible(true);
                        table.columns(9).visible(true);
                        table.columns(12).visible(true);
                        table.columns(15).visible(true);
                        table.columns(18).visible(true);
                        table.columns(21).visible(true);
                        table.columns(24).visible(true);
                        table.columns(27).visible(true);
                        table.columns(30).visible(true);
                    }
            
                    if(!presencial){ 
                        table.columns([7,8]).visible(false);
                        table.columns([10,11]).visible(false);
                        table.columns([13,14]).visible(false);
                        table.columns([16,17]).visible(false);
                        table.columns([19,20]).visible(false);
                        table.columns([22,23]).visible(false);
                        table.columns([25,26]).visible(false);
                        table.columns([28,29]).visible(false);
                        table.columns([31,32]).visible(false);
                    }else if(presencial){
                        table.columns(7).visible(true);
                        table.columns(10).visible(true);
                        table.columns(13).visible(true);
                        table.columns(16).visible(true);
                        table.columns(19).visible(true);
                        table.columns(22).visible(true);
                        table.columns(25).visible(true);
                        table.columns(28).visible(true);
                        table.columns(31).visible(true);
                    }

                    if(presencial && virtual){
                        table.columns([6,7,8]).visible(true);
                        table.columns([9,10,11]).visible(true);
                        table.columns([12,13,14]).visible(true);
                        table.columns([15,16,17]).visible(true);
                        table.columns([18,19,20]).visible(true); 
                        table.columns([21,22,23]).visible(true);
                        table.columns([24,25,26]).visible(true);
                        table.columns([27,28,29]).visible(true); 
                        table.columns([30,31,32]).visible(true);  
                    }

                    break;
            }   
        });
    }    
    

    $('#Ecohort').change(function(event){
        //alert(event.target.value);
        if(event.target.value == 1){
            //$('#example1').DataTable().ajax.reload(); 
            document.getElementById("tabla_1").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
            
        }else{
 
            document.getElementById("tabla_1").setAttribute('style', 'display:none');
            document.getElementById("div_1").setAttribute('style', 'display:none');
            
        }
        if(event.target.value == 2){
            //$('#example2').DataTable().ajax.reload();
            document.getElementById("tabla_2").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
            
        }else{
 
            document.getElementById("tabla_2").setAttribute('style', 'display:none');
        }
        if(event.target.value == 3){
            //$('#example3').DataTable().ajax.reload();
            document.getElementById("tabla_3").removeAttribute('style', 'display:none');
            document.getElementById("div_1").removeAttribute('style', 'display:none');
            document.getElementById("todos").checked = true;
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
