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
        <div class="btn-group">
            <div class="filtroCohortes col-xs-6 col-md-12 col-sm-6">
                <label>PRESENCIAL</label>&nbsp;<input type="checkbox" name="check" value="PRESENCIAl" id="presencial" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>VIRTUAL</label>&nbsp;<input type="checkbox" name="check" value="VIRTUAl" id="virtual" checked>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        <br>
    <div id="tabla_1" class="table-responsive" style='display:none'>
     <table id="example1" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td rowspan="2">Nombres</td>
                <td rowspan="2">Apellidos</td>
                <td rowspan="2">Nº documento</td>
                <td rowspan="2">Grupo</td>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <td rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado">Encargado</td>
                @endif
                <td colspan="3" >ACCION CIUDADANA</td>
                <td colspan="3" >ARTES</td>
                <td colspan="3">DEPORTE</td>
                <td colspan="3">DIALOGO</td>
                <td colspan="3">TIC</td>
                <td rowspan="2">TOTAL</td>
                <td rowspan="2">VER DETALLE</td>
            </tr>
            <tr>
                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>
            </tr>
        </thead> 
      </table>
    </div>

    <div id="tabla_2" class="table-responsive" style='display:none'>
     <table id="example2" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td rowspan="2">Nombres</td>
                <td rowspan="2">Apellidos</td>
                <td rowspan="2">Nº documento</td>
                <td rowspan="2">Grupo</td>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <td rowspan="2">Encargado</td>
                @endif
                <td colspan="3">BIOLOGIA</td>
                <td colspan="3">CONSTITUCION</td>
                <td colspan="3">FISICA</td>
                <td colspan="3">GEOGRAFIA</td>
                <td colspan="3">HISTORIA</td>
                <td colspan="3">INGLES</td>
                <td colspan="3">LECTURA CRITICA</td>
                <td colspan="3">MATEMATICAS</td>
                <td colspan="3">QUIMICA</td>
                <td rowspan="2">TOTAL</td>
                <td rowspan="2">VER DETALLES</td>
            </tr>
            <tr>
                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>
            </tr>
        </thead> 
      </table>
    </div>
    <div id="tabla_3" class="table-responsive" style='display:none'>
     <table id="example3" class="table table-bordered table-striped">
        <thead >
            <tr >
                <td rowspan="2">Nombres</td>
                <td rowspan="2">Apellidos</td>
                <td rowspan="2">Nº documento</td>
                <td rowspan="2">Grupo</td>
                @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                <td rowspan="2">Encargado</td>
                @endif
                <td colspan="3">BIOLOGIA</td>
                <td colspan="3">CONSTITUCION</td>
                <td colspan="3">INGLES</td>
                <td colspan="3">LECTURA CRITICA</td>
                <td colspan="3">MATEMATICAS</td>
                <td colspan="3">QUIMICA</td>
                <td rowspan="2">TOTAL</td>
                <td rowspan="2">ACCIONES</td>
            </tr>
            <tr>
                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>

                <th>virtual</th>
                <th>presencial</th>
                <th>total</th>
            </tr>
        </thead> 
      </table>
    </div>
    </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

    
    var encargado = $('#encargado').data('condition');
    if(encargado == 1 || encargado == 2)
    {
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
                {data: 'encargado'},
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                {data: 'encargado'},   
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                {data: 'encargado'},
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
        
        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();
            
            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([5,7]).visible(false);
                        table.columns([8,10]).visible(false);
                        table.columns([11,13]).visible(false);
                        table.columns([14,16]).visible(false);
                        table.columns([17,19]).visible(false);
                    }else if(virtual){
                        table.columns(5).visible(true);
                        table.columns(8).visible(true);
                        table.columns(11).visible(true);
                        table.columns(14).visible(true);
                        table.columns(17).visible(true);      
                    }
                    if(!presencial){ 
                        table.columns([6,7]).visible(false);
                        table.columns([9,10]).visible(false);
                        table.columns([12,13]).visible(false);
                        table.columns([15,16]).visible(false);
                        table.columns([18,19]).visible(false);
                    }else if(presencial){
                        table.columns(6).visible(true);
                        table.columns(9).visible(true);
                        table.columns(12).visible(true);
                        table.columns(15).visible(true);
                        table.columns(18).visible(true);     
                    }
                    if(presencial && virtual){
                        table.columns([5,6,7]).visible(true);
                        table.columns([8,9,10]).visible(true);
                        table.columns([11,12,13]).visible(true);
                        table.columns([14,15,16]).visible(true);
                        table.columns([17,18,19]).visible(true); 
                    }

                    break;
                case '2':
                    //alert("d")
                    if(!virtual){
                        
                        table2.columns([5,7]).visible(false);
                        table2.columns([8,10]).visible(false);
                        table2.columns([11,13]).visible(false);
                        table2.columns([14,16]).visible(false);
                        table2.columns([17,19]).visible(false);
                        table2.columns([20,22]).visible(false);
                        table2.columns([23,25]).visible(false);
                        table2.columns([26,28]).visible(false);
                        table2.columns([29,31]).visible(false);
                    }else if(virtual){
                        table2.columns(5).visible(true);
                        table2.columns(8).visible(true);
                        table2.columns(11).visible(true);
                        table2.columns(14).visible(true);
                        table2.columns(17).visible(true);
                        table2.columns(20).visible(true);
                        table2.columns(23).visible(true);
                        table2.columns(26).visible(true);
                        table2.columns(29).visible(true);
                    }

                    if(!presencial){ 
                        table2.columns([6,7]).visible(false);
                        table2.columns([9,10]).visible(false);
                        table2.columns([12,13]).visible(false);
                        table2.columns([15,16]).visible(false);
                        table2.columns([18,19]).visible(false);
                        table2.columns([21,22]).visible(false);
                        table2.columns([24,25]).visible(false);
                        table2.columns([27,28]).visible(false);
                        table2.columns([30,31]).visible(false);
                    }else if(presencial){
                        table2.columns(6).visible(true);
                        table2.columns(9).visible(true);
                        table2.columns(12).visible(true);
                        table2.columns(15).visible(true);
                        table2.columns(18).visible(true);
                        table2.columns(21).visible(true);
                        table2.columns(24).visible(true);
                        table2.columns(27).visible(true);
                        table2.columns(30).visible(true);
                    }

                    if(presencial && virtual){
                        table2.columns([5,6,7]).visible(true);
                        table2.columns([8,9,10]).visible(true);
                        table2.columns([11,12,13]).visible(true);
                        table2.columns([14,15,16]).visible(true);
                        table2.columns([17,18,19]).visible(true);
                        table2.columns([20,21,22]).visible(true);
                        table2.columns([23,24,25]).visible(true);
                        table2.columns([26,27,28]).visible(true);
                        table2.columns([29,30,31]).visible(true);
                    }
                    break;
                case '3':
                    if(!virtual){
                        table3.columns([5,7]).visible(false);
                        table3.columns([8,10]).visible(false);
                        table3.columns([11,13]).visible(false);
                        table3.columns([14,16]).visible(false);
                        table3.columns([17,19]).visible(false);
                        table3.columns([20,22]).visible(false);
                    }else if(virtual){
                        table3.columns(5).visible(true);
                        table3.columns(8).visible(true);
                        table3.columns(11).visible(true);
                        table3.columns(14).visible(true);
                        table3.columns(17).visible(true);
                        table3.columns(20).visible(true);      
                    }
                    if(!presencial){ 
                        table3.columns([6,7]).visible(false);
                        table3.columns([9,10]).visible(false);
                        table3.columns([12,13]).visible(false);
                        table3.columns([15,16]).visible(false);
                        table3.columns([18,19]).visible(false);
                        table3.columns([21,22]).visible(false);                       
                    }else if(presencial){
                        table3.columns(6).visible(true);
                        table3.columns(9).visible(true);
                        table3.columns(12).visible(true);
                        table3.columns(15).visible(true);
                        table3.columns(18).visible(true);     
                        table3.columns(21).visible(true);     
                    }
                    if(presencial && virtual){
                        table3.columns([5,6,7]).visible(true);
                        table3.columns([8,9,10]).visible(true);
                        table3.columns([11,12,13]).visible(true);
                        table3.columns([14,15,16]).visible(true);
                        table3.columns([17,18,19]).visible(true); 
                        table3.columns([20,21,22]).visible(true); 
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "JORNADAS"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "ARTES:"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DEPORTE"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "DIALOGO"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "TECNOLOGIA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "FISICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "GEOGRAFIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "HISTORIA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "BIOLOGIA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "CONSTITUCION"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "INGLES"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "LECTURA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "MATEMATICAS"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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
                            return 0;
                        }else{
                        var contador = 0;
                        if(data.cursos_virtuales != null){
                            for(const i in data.cursos_virtuales){
                                if( data.cursos_virtuales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos_virtuales[i].Total);
                                    contador += parseInt(data.cursos_virtuales[i].Total);
                                }      
                            }    
                        }
                        if(data.cursos_presenciales != null){
                            for(const i in data.cursos_presenciales){
                                if( data.cursos_presenciales[i].fullname.split(" ", 2)[0] == "QUIMICA"){
                                    //console.log(data.cursos_presenciales[i].Total);
                                    contador += parseInt(data.cursos_presenciales[i].Total);
                                }      
                            }    
                        }
                        
                        return contador;
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

        $('.filtroCohortes').on('change',function(){

            var virtual = $("#virtual").is(":checked");

            var presencial = $("#presencial").is(":checked");

            var tabla= $('#Ecohort').val();

            switch(tabla){
                case '1':
                    if(!virtual){
                        table.columns([4,6]).visible(false);
                        table.columns([7,9]).visible(false);
                        table.columns([10,12]).visible(false);
                        table.columns([13,15]).visible(false);
                        table.columns([16,18]).visible(false);
                    }else if(virtual){
                        table.columns(4).visible(true);
                        table.columns(7).visible(true);
                        table.columns(10).visible(true);
                        table.columns(13).visible(true);
                        table.columns(16).visible(true);
                    }
            
                    if(!presencial){ 
                        table.columns([5,6]).visible(false);
                        table.columns([8,9]).visible(false);
                        table.columns([11,12]).visible(false);
                        table.columns([14,15]).visible(false);
                        table.columns([17,18]).visible(false);
                    }else if(presencial){
                        table.columns(5).visible(true);
                        table.columns(8).visible(true);
                        table.columns(11).visible(true);
                        table.columns(14).visible(true);
                        table.columns(17).visible(true);
                    }

                    if(presencial && virtual){
                        table.columns([4,5,6]).visible(true);
                        table.columns([7,8,9]).visible(true);
                        table.columns([10,11,12]).visible(true);
                        table.columns([13,14,15]).visible(true);
                        table.columns([16,17,18]).visible(true); 
                    }

                    break;
                case '2':
                    if(!virtual){
                        table2.columns([4,6]).visible(false);
                        table2.columns([7,9]).visible(false);
                        table2.columns([10,12]).visible(false);
                        table2.columns([13,15]).visible(false);
                        table2.columns([16,18]).visible(false);
                        table2.columns([19,21]).visible(false);
                        table2.columns([22,24]).visible(false);
                        table2.columns([25,27]).visible(false);
                        table2.columns([28,30]).visible(false);
                    }else if(virtual){
                        table2.columns(4).visible(true);
                        table2.columns(7).visible(true);
                        table2.columns(10).visible(true);
                        table2.columns(13).visible(true);
                        table2.columns(16).visible(true);
                        table2.columns(19).visible(true);
                        table2.columns(22).visible(true);
                        table2.columns(25).visible(true);
                        table2.columns(28).visible(true);
                    }
            
                    if(!presencial){ 
                        table2.columns([5,6]).visible(false);
                        table2.columns([8,9]).visible(false);
                        table2.columns([11,12]).visible(false);
                        table2.columns([14,15]).visible(false);
                        table2.columns([17,18]).visible(false);
                        table2.columns([20,21]).visible(false);
                        table2.columns([23,24]).visible(false);
                        table2.columns([26,27]).visible(false);
                        table2.columns([29,30]).visible(false);
                    }else if(presencial){
                        table2.columns(5).visible(true);
                        table2.columns(8).visible(true);
                        table2.columns(11).visible(true);
                        table2.columns(14).visible(true);
                        table2.columns(17).visible(true);
                        table2.columns(20).visible(true);
                        table2.columns(23).visible(true);
                        table2.columns(26).visible(true);
                        table2.columns(29).visible(true);
                    }

                    if(presencial && virtual){
                        table2.columns([4,5,6]).visible(true);
                        table2.columns([7,8,9]).visible(true);
                        table2.columns([10,11,12]).visible(true);
                        table2.columns([13,14,15]).visible(true);
                        table2.columns([16,17,18]).visible(true);
                        table2.columns([19,20,21]).visible(true);
                        table2.columns([22,23,24]).visible(true);
                        table2.columns([25,26,27]).visible(true);
                        table2.columns([28,29,30]).visible(true);  
                    }

                    break;
                case '3':
                    if(!virtual){
                        table.columns([4,6]).visible(false);
                        table.columns([7,9]).visible(false);
                        table.columns([10,12]).visible(false);
                        table.columns([13,15]).visible(false);
                        table.columns([16,18]).visible(false);
                        table.columns([19,21]).visible(false);
                    }else if(virtual){
                        table.columns(4).visible(true);
                        table.columns(7).visible(true);
                        table.columns(10).visible(true);
                        table.columns(13).visible(true);
                        table.columns(16).visible(true);
                        table.columns(19).visible(true);
                    }
            
                    if(!presencial){ 
                        table.columns([5,6]).visible(false);
                        table.columns([8,9]).visible(false);
                        table.columns([11,12]).visible(false);
                        table.columns([14,15]).visible(false);
                        table.columns([17,18]).visible(false);
                        table.columns([20,21]).visible(false);
                    }else if(presencial){
                        table.columns(5).visible(true);
                        table.columns(8).visible(true);
                        table.columns(11).visible(true);
                        table.columns(14).visible(true);
                        table.columns(17).visible(true);
                        table.columns(20).visible(true);
                    }

                    if(presencial && virtual){
                        table.columns([4,5,6]).visible(true);
                        table.columns([7,8,9]).visible(true);
                        table.columns([10,11,12]).visible(true);
                        table.columns([13,14,15]).visible(true);
                        table.columns([16,17,18]).visible(true); 
                        table.columns([19,20,21]).visible(true); 
                    }

                    break;
            }   
        });
    }    
    

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
