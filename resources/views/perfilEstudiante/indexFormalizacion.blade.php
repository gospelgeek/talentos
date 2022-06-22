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
            <div class="table-responsive">
                <center><div class="btn-group">
                    <div class="dtlle col-xs-6 col-md-12 col-sm-6">
                        <label>DETALLES DE ESTADO</label>&nbsp;<input type="checkbox" name="detalleS" id="detalleS">
                    </div>
                </div></center>
                <table id="example1" class=" table table-bordered table-striped">
                <caption>Ultimo registro formalización actualizado: {{ $update_formalizacion }}</caption>
                    <thead>
                        <tr>
                            <td>Nombres</td>
                            <td>Tipo Doc.</td>
                            <td>Nº Documento</td>
                            <td>Email</td>
                            <td>Tel.</td>
                            <td>Grupo</td>
                            <td>Cohorte</td>
                            <td>Estado</td>
                            <td>Aceptación</td>
                            <td>Fecha Aceptación</td>
                            <td>Tablet</td>
                            <td>Serial Tablet</td>
                            <td>Regresó Tablet</td>
                            <td>Prestó Tablet</td>
                            <td>Serial Tablet Prestada</td>
                            <td>Fecha Kit</td>
                            <td>Pre-registro-ICFES</td>
                            <td>Registro-ICFES</td>
                            <td>Presentó-ICFES</td>
                            <td>URL Prestamo</td>
                            <td>Prof. Acomp.</td>
                            <td>Motivo</td>
                            <td>Fecha</td>
                            <td>URL</td>
                            <td id="botons" width="15%">Acciones</td>
                        </tr>
                    </thead>       
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

   $(document).ready(function(){
       var table = $("#example1").DataTable({
            
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.formalizacion')}}",
            },

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
                {data: 'tipodocumento'},
                {data: 'document_number'},
                {data: 'email'},
                {data: 'cellphone'},
                {data: 'grupo'},
                {data: 'cohorte'},
                {data: 'estado'},
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
                {data: 'acceptance_date'},
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
                {data: 'returned_tablet', render:function(data, type, row, meta){
                        if(data != null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'loan_tablet', render:function(data, type, row, meta){
                        if(data != null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }
                        }else{
                            return null;
                        }
                    }
                },
                {data:'serial_loan_tablet'},
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
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }else if(data == 0) {
                                var no = '<button class="btn text-danger btn-block fa fa-times title="No Realizado">NO</button>';
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
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }else if(data == 0) {
                                var no = '<button class="btn text-danger btn-block fa fa-times title="No Realizado">NO</button>';
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
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }else if(data == 0) {
                                var no = '<button class="btn text-danger btn-block fa fa-times title="No Realizado">NO</button>';
                                return no;
                            }
                        }else{
                            return null;
                        }    
                    }
                },
                {data: 'loan_document_url', visible:false},
                {data: null, visible:false, render:function(data, type, row, meta) {
                        if(data.name_profesional !== null){
                            var celda;
                            celda = '<div>'+
                                    '<td>'+data.name_profesional+' '+data.lastname_profesional+'</td>'+
                                '</div>';
                            return celda;
                        }else{
                            return null;
                        }              
                    }
                },
                {data: 'motivo', visible:false},
                {data: 'fecha', visible:false},
                {data: 'url', visible:false},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
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
        
        $('#example1 thead tr').clone(true).appendTo('#example1 thead');

        $('#example1 thead tr:eq(1) td').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('.dtlle').on('change', function() {
            var chek_detalle = $('#detalleS').is(":checked");
            //alert(chek_detalle)
            if(chek_detalle){
                var column2 = table.column(20);
                var column3 = table.column(21);
                var column4 = table.column(22);
                var column5 = table.column(23);
                
                column2.visible(!column2.visible());
                column3.visible(!column3.visible());
                column4.visible(!column4.visible());
                column5.visible(!column5.visible());

            }else if(!chek_detalle){
                

                var column2 = table.column(20);
                var column3 = table.column(21);
                var column4 = table.column(22);
                var column5 = table.column(23);
                
                column2.visible(!column2.visible());
                column3.visible(!column3.visible());
                column4.visible(!column4.visible());
                column5.visible(!column5.visible());
            }
        });
    });

    function redireccionar(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-6#ttlo-6`;
    }   
    function redireccionar_edit(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-6#ttlo-6`;
    }
                
</script>

 
@endpush
@endsection
