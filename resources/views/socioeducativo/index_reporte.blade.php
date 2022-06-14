@extends('layouts.dashboard')
@section('title', 'Reporte socioeducativo')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">REPORTE SOCIOEDUCATIVO</h1>
    <div class="card">         
    <div class="card-body">
         
        <div class="btn-group">
            <div class="col-xs-6 col-md-12 col-sm-6">
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('reporte_socioeducativo')}}">EXCEL SOCIOEDUCATIVO</a>
            </div>
        </div>
       
    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        
        <thead>
            <tr>
                <td>Nombres</td>
                <td>Nº Documento</td>
                <td>Cohorte</td>
                <td>Grupo</td>
                <td>Clasificación</td>
                <td>Caso Especial</td>
                <td>Salud Mental</td>
                <td>Prof. Acompañamiento</td>
                <td>Cant. Seguimientos</td>
                <td id="r1">R.I</td>
                <td>R.A</td>
                <td>R.F</td>
                <td>R.E</td>
                <td>R.V</td>
                <td width="15%">Acciones</td>
            </tr>
        </thead>
        
    </table>
      </div>
    </div>
    </div>
</div>

@push('scripts') 

    <script>

        
         $("#example1").DataTable({
            "ajax": "{{route('datos.reporte.socioeducativo')}}",
            "columns": [
                {data: null, render:function(data, type, row, meta) {
                        if(data.name !== null){
                            var celda;
                            celda = '<div>'+
                                    '<td>'+data.name+' '+data.lastname+'</td>'+
                                '</div>';
                            return celda;
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'document_number'},
                {data: 'cohorte'},
                {data: 'grupo'},
                {data: null, render:function(data, type, row, meta){
                        
                        if(data.id_state == 1 || data.id_state == 4){
                            if(data.aceptacion1 === null && data.aceptacion2 === null){
                                return 'ADMITIDO';
                            }else if(data.aceptacion1 !== null || data.aceptacion2 !== null){
                                return 'ACTIVO';
                            }
                        }else if(data.id_state == 2 || data.id_state == 3 || data.id_state == 5){
                            return 'INACTIVO';
                        }
                    }
                },
                {data: 'caso_especial', render:function(data, type, row, meta){
                        if(data !== null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado"></button>';
                                return si;
                            }else if(data == 0) {
                                var no = '<button class="btn text-danger btn-block fa fa-times title="No Realizado"></button>';
                                return no;
                            }
                        }else{
                            return null;
                        }    
                    }
                }, 
                {data: 'salud_mental', render:function(data, type, row, meta){
                        if(data !== null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado"></button>';
                                return si;
                            }else if(data == 0) {
                                var no = '<button class="btn text-danger btn-block fa fa-times title="No Realizado"></button>';
                                return no;
                            }
                        }else{
                            return null;
                        }    
                    }
                },
                {data: null, render:function(data, type, row, meta){

                        if(data.nombre_profesional !== null){
                            var celda;
                            celda = '<div>'+
                                    '<td>'+data.nombre_profesional+' '+data.apellido_profesional+'</td>'+
                                '</div>';
                            return celda;
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'cantidad_seguimientos'},
                {data: null, render:function(data, type, row, meta){
                        var celda;
                        if(data.riesgo_indivdual !== null){
                           if(data.riesgo_indivdual === "alto"){
                                
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_indivdual === "medio"){

                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_indivdual === "bajo"){

                                celda = '<div style="background-color: green;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;
                            } 
                        }else{
                            return '--';
                        }    
                    }
                },            
                {data: null, render:function(data, type, row, meta){

                        var celda;
                        if(data.riesgo_academico !== null){
                           if(data.riesgo_academico === "alto"){
                                
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_academico === "medio"){

                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_academico === "bajo"){

                                celda = '<div style="background-color: green;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;
                            } 
                        }else{
                            return '--';
                        }    
                    }
                }, 
                {data: null, render:function(data, type, row, meta){
                        
                        var celda;
                        if(data.riesgo_familiar !== null){
                           if(data.riesgo_familiar === "alto"){
                                
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_familiar === "medio"){

                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_familiar === "bajo"){

                                celda = '<div style="background-color: green;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;
                            } 
                        }else{
                            return '--';
                        }    
                    }
                }, 
                {data: null, render:function(data, type, row, meta){
                        
                        var celda;
                        if(data.riesgo_economico !== null){
                           if(data.riesgo_economico === "alto"){
                                
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_economico === "medio"){

                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_economico === "bajo"){

                                celda = '<div style="background-color: green;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;
                            } 
                        }else{
                            return '--';
                        }    
                    }
                }, 
                {data: null, render:function(data, type, row, meta){
                        
                        var celda;
                        if(data.riesgo_Uc !== null){
                           if(data.riesgo_Uc === "alto"){
                                
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_Uc === "medio"){

                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }
                            if(data.riesgo_Uc === "bajo"){

                                celda = '<div style="background-color: green;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;
                            } 
                        }else{
                            return '--';
                        }    
                    }
                },  
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 4 || rol == 1 || rol == 2){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a id="'+data.id+'" onclick="redireccionaredit(this);" class="btn btn-block fa fa-pencil-square-o fa" title="Editar seguimiento"></a>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a id="'+data.id+'" onclick="redireccionar(this);" class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></a>'+
                          "</div>"+
                        "</div>";
                    }

                    return mstr;
                }
            }
                
            ],

          

            
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print",
                "colvis",
            ]
        });


    function redireccionar(id){
        console.log($(id).attr("id"));
        location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-4#ttlo-4`;
    }

    function redireccionaredit(id){
        console.log($(id).attr("id"));
        location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-4#ttlo-4`;
    }
    </script>
 
@endpush
@endsection
