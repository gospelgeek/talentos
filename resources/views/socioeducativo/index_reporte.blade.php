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
    @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)         
        <div class="btn-group">
            <div class="col-xs-6 col-md-12 col-sm-6">
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('reporte_socioeducativo')}}">Descargar todos los seguimientos socioeducativos</a>
            </div>
        </div>
    @endif
    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        <caption>Ultimo Seguimiento registrado: {{ $ultimo_seguimiento }}<br>
        S.F: Salud Fisica<br>
        S.M: Salud Mental<br>
        R.Ps: Riesgo Psicosocial<br>
        R.I: Riesgo Individual<br> 
        R.A: Riesgo Academico<br>
        R.F: Riesgo Familiar<br>
        R.E: Riesgo Economico<br>
        R.V: Riesgo Vida Universitaria y ciudad</caption>
        <thead>
            <tr>
                <td><b>Nombres</b></td>
                <td><b>Nº Documento</b></td>
                <td><b>Cohorte</b></td>
                <td><b>Grupo</b></td>
                <td><b>Estado</b></td>
                <td><b>Clasificación</b></td>
                <td><b>Trabajador</b></td>
                <td title="Salud Fisica"><b>S. F</b></td>
                <td title="Salud Mental"><b>S. M</b></td>
                <td title="Riesgo Psicosocial"><b>R. Ps</b></td>
                <td><b>Prof. Acompañamiento</b></td>
                <td><b>Cant. Seguimientos</b></td>
                <td title="Riesgo Idividual"><b>R.I</b></td>
                <td title="Riesgo Academico"><b>R.A</b></td>
                <td title="Riesgo Familiar"><b>R.F</b></td>
                <td title="Riesgo Economico"><b>R.E</b></td>
                <td title="Riesgo Vida universitaria y ciudad"><b>R.V</b></td>
                <td width="15%"><b>Acciones</td>
            </tr>
        </thead>
        <thead>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="0">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="1">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="2">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="3">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="4">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="5">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="6">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="7">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="8">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="9">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="10">
            </td>
            <td>
                <input type="text" class="form-control filter" placeholder="Search" data-column="11">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="12">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="13">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="14">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="15">
            </td>
            <td>
                <input type="text" style="width:50px" class="form-control filter" placeholder="Search" data-column="16">
            </td>
            <td></td> 
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
                {data: 'estado'},
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
                {data: 'trabajador', render:function(data, type, row, meta){
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
                {data: 'salud_fisica', render:function(data, type, row, meta){
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
                {data: 'salud_mental', render:function(data, type, row, meta){
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
                {data: 'riesgo_psicosocial', render:function(data, type, row, meta){
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

                    if(rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                        "</div>"; 
                        return mstr;
                    }else{

                        return null;    
                    }
                }
            }
                
            ],
            
            "responsive": false, "lengthChange": false, "autoWidth": false, "fixedHeader": true, "orderCellsTop": true,
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

        $('.filter').keyup(function(){
            table.column($(this).data('column'))
            .search($(this).val())
            .draw();
        });

        /*$('#example1 thead tr').clone(true).appendTo('#example1 thead');

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
        });*/
    });


    function redireccionar(id){
        console.log($(id).attr("id"));
        location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-4#ttlo-4`;
    }

    </script>
 
@endpush
@endsection
