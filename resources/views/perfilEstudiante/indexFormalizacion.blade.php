@extends('layouts.dashboard')

@section('title', 'Formalizacion estudiante')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<!--<div class="col-xs-12 col-md-8">
    <form method="POST" action="store/save/usuarios" accept-charset="UTF-8" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class=" col-xs-12 col-md-8">
                  {!!Form::label('archivo','Seleccione Archivo:')!!}                            
                  {!!Form::file('file',[ 'accept'=>'.xls,.xlsx','class'=>'form-control-file form-group','required'])!!}
                        
                        <button type="submit" class="btn btn-danger bg-lg form-group btn-block">Enviar</button>
                      </div>
    </form>
</div>-->          
                      


<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">FORMALIZACIÓN ESTUDIANTE</h1>
    <div class="card">         
        <div class="card-body">
            @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1) 
            <div class="row">
            
            
            </div>

        
            @endif
            <div class="table-responsive">
                <table id="example1" class=" table table-bordered table-striped">
                    <thead>
                        <tr>
                           <td>Nombres</td>
                            <td>Apellidos</td>
                            <td>Nº Documento</td>
                            <td>Grupo</td>
                            <td>Cohorte</td>
                            <td>Aceptación</td>
                            <td>Tablet</td>
                            <td>Serial Tablet</td>
                            <td>Fecha Kit</td>
                            <td>Pre-registro-ICFES</td>
                            <td>Registro-ICFES</td>
                            <td>Presentó-ICFES</td>
                            <td id="botons" width="15%">Acciones</td>
                        </tr>
                    </thead>       
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <!-- Page specific script -->
<script>

/*$('input[type="checkbox"]').change(function (){
    var ver = $("input[name=filtro]:checked").val();
});*/
     
       var table = $("#example1").DataTable({
            
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.formalizacion')}}",
            },

            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'document_number'},
                {data: 'grupo'},
                {data: 'cohorte'},
                {data: 'acceptance_v2', render:function(data, type, row, meta){

                        if(data !== ""){

                            if(data !== null){

                                if(data != 'SI'){
                                    var url = '<a href="'+data+'" target="blank">SI, CON URL</a>';
                                    return url;    
                                }else{
                                    var url = '<a target="blank">'+data+'</a>';
                                    return url;
                                }
                                
                            }else{
                                var url = '';
                                return url;
                            }


                        }

                    
                    }
                },
                {data: 'tablets_v2', render:function(data, type, row, meta){
                        if(data !== ""){

                            if(data !== null){

                                if(data != 'SI'){
                                    var url = '<a href="'+data+'" target="blank">SI, CON URL</a>';
                                    return url;    
                                }else{
                                    var url = '<a target="blank">'+data+'</a>';
                                    return url;
                                }
                                
                            }else{
                                var url = ' ';
                                return url;
                            }
                        }
                    }
                },
                {data: 'serial_tablet'},
                {data: 'kit_date', render:function(data, type, row, meta){
                        if(data !== ""){
                            if(data !== null){
                                var si = 'SI';
                                return si;
                            }else{
                                return "";
                            }
                        }else{
                            return "";
                        }

                    }
                },
                {data: 'pre_registration_icfes', render:function(data, type, row, meta){
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
                {data: 'inscription_icfes', render:function(data, type, row, meta){
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
                {data: 'presented_icfes', render:function(data, type, row, meta){
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
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td">'+'<a href="ver_estudiante/'+data.id+'" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a href="editar_estudiante/'+data.id+'" class="btn btn-block fa fa-pencil-square-o fa" title="Editar seguimiento"></a>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a href="ver_estudiante/'+data.id+'" class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></a>'+
                          "</div>"+
                        "</div>";
                    }

                    return mstr;
                }
            }
                    
            ],

            "deferRender": true,"responsive": true, "lengthChange": false, "autoWidth": false,
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
    

        
    

                
</script>

 
@endpush
@endsection
