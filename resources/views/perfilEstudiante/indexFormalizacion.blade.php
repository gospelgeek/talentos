@extends('layouts.dashboard')

@section('title', 'Formalizacion estudiante')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">FORMALIZACIÓN ESTUDIANTE</h1>
    <div class="card">       
        <div class="card-body">
            <div class="table-responsive">
                <center><div class="btn-group">
                    <div class="dtllE col-xs-6 col-md-12 col-sm-6">
                        <label>DETALLES DE ESTADO</label>&nbsp;<input type="checkbox" name="detalle_estado" id="detalle_estado">
                    </div>
                </div></center>  
                <table id="example1" class=" table table-bordered table-striped">
                    <caption>Ultimo registro formalización actualizado: {{ $update_formalizacion }}</caption>
                    <thead>                    
                        <tr>
                            <td><b>Nombres</b></td>
                            <td><b>Tipo Doc.</b></td>
                            <td><b>Nº Documento</b></td>
                            <td><b>Email</b></td>
                            <td><b>Tel.</b></td>
                            <td><b>Grupo</b></td>
                            <td><b>Cohorte</b></td>
                            <td><b>Camb. Linea</b></td>
                            <td><b>Estado</b></td>
                            <td><b>Aceptación</b></td>
                            <td><b>Fecha Aceptación</b></td>
                            <td><b>Tablet</b></td>
                            <td><b>Serial Tablet</b></td>
                            <td><b>Regresó Tablet</b></td>
                            <td><b>Prestó Tablet</b></td>
                            <td><b>Serial Tablet Prestada</b></td>
                            <td><b>Fecha Kit</b></td>
                            <td><b>Pre-registro-ICFES</b></td>
                            <td><b>Registro-ICFES</b></td>
                            <td><b>Presentó-ICFES</b></td>
                            <td><b>URL Prestamo</b></td>
                            <td class="prfsnal"><b>Prof. Acomp.</b></td>
                            <td class="mtvo"><b>Motivo</b></td>
                            <td class="fcha"><b>Fecha</b></td>
                            <td class="urlrtro"><b>URL Retiro</b></td>
                            <td><b>Acciones</b></td>
                        </tr>
                    </thead>
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
                {data: 'tipo_documento', render:function(data, type, row, meta){
                        if(data !== null){
                            return data;
                        }else{
                            return '';
                        }
                    }
                },
                {data: 'document_number'},
                {data: 'email', width: '50px'},
                {data: 'cellphone'},
                {data: 'grupo'},
                {data: 'cohorte'},
                {data: 'cambio_linea', render:function(data, type, row, meta){
                        if(data != ''){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }
                        }else{
                            return null;
                        }
                    }
                },
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
                {data: 'loan_document_url', render:function(data, type, row, meta){
                        if(data !== null){
                            var url = '<a href="'+data+'" target="blank">ENLACE URL</a>';
                            return url;    
                        }else{
                            return null;
                        }
                    }
                },
                {data: null, render:function(data, type, row, meta) {
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
                {data: 'motivo'},
                {data: 'fecha'},
                {data: 'url', render:function(data, type, row, meta){
                        if(data !== "" && data !== null){
                            
                                var url = '<a href="'+data+'" target="blank">ENLACE URL</a>';
                                return url;    
                            }else{
                                var url = "";
                                return url;
                            }
                        }
                    
                },                
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

            "deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false,
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print"
                
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
        
        
        document.getElementById('detalle_estado').checked = true;

        $('.dtllE').on('change', function() {

            var chek_detalle = $('#detalle_estado').is(":checked");
            if(chek_detalle){
                var column2 = table.column(21);
                var column3 = table.column(22);
                var column4 = table.column(23);
                var column5 = table.column(24);
                
                column2.visible(true);
                column3.visible(true);
                column4.visible(true);
                column5.visible(true);

                $(".prfsnal").show();
                $(".mtvo").show();
                $(".fcha").show();
                $(".urlrtro").show();

            }else if(!chek_detalle){
                $(".prfsnal").hide();
                $(".mtvo").hide();
                $(".fcha").hide();
                $(".urlrtro").hide();
                var column2 = table.column(21);
                var column3 = table.column(22);
                var column4 = table.column(23);
                var column5 = table.column(24);
                
                column2.visible(false);
                column3.visible(false);
                column4.visible(false);
                column5.visible(false);
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
