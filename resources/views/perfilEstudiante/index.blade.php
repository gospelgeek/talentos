@extends('layouts.dashboard')

@section('title', 'Perfil Estudiante')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
{{--<div class="col-xs-12 col-md-8">
    <form method="POST" action="store/save/usuarios" accept-charset="UTF-8" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class=" col-xs-12 col-md-8">
                  {!!Form::label('archivo','Seleccione Archivo:')!!}                            
                  {!!Form::file('file',[ 'accept'=>'.xls,.xlsx','class'=>'form-control-file form-group','required'])!!}
                        
                        <button type="submit" class="btn btn-danger bg-lg form-group btn-block">Enviar</button>
                      </div>
    </form>
</div>         
                      
</div>--}}

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">ESTUDIANTES</h1>
    <div class="card">         
    <div class="card-body">
        @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 5) 
        <div class="btn-group">
            {!!link_to('#',$title = 'NUEVO REGISTRO', $attributes = ['class'=>'btn btn-primary btn-sm mt-3 mb-3 float-left abrir_modal_estudiante'],$secure = null)!!}
        </div>
        @endif
        @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 3 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 5 || auth()->user()->rol_id == 6)
        <div class="btn-group">
            <div class="col-xs-6 col-md-12 col-sm-6">
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('sabana_completa_export')}}">EXPORTAR SÁBANA COMPLETA</a>
            </div>
        </div>
        <div class="btn-group">
            <div class="col-xs-6 col-md-12 col-sm-6">
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('sabana_export')}}">EXPORTAR SÁBANA SECRETARÍA</a>
            </div>
        </div>
        <div class="btn-group">
            <div class="filtroCohortes col-xs-6 col-md-12 col-sm-6">
                <label>LINEA 1</label>&nbsp;<input type="checkbox" name="check" value="LINEA 1" id="linea_1">&nbsp;&nbsp;&nbsp;&nbsp;
                <label>LINEA 2</label>&nbsp;<input type="checkbox" name="check" value="LINEA 2" id="linea_2">&nbsp;&nbsp;&nbsp;&nbsp;
                <label>LINEA 3</label>&nbsp;<input type="checkbox" name="check" value="LINEA 3" id="linea_3">
            </div>
        </div>
        <div class="btn-group">
            <div class="inactivos_activos_student">                  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>TODOS</label>&nbsp;<input type="radio" name="filtro" value="TODOS" id="todos" checked>&nbsp;&nbsp;
                <label>ADMITIDOS</label>&nbsp;<input type="radio" name="filtro" value="ADMITIDOS" id="admitidos">&nbsp;&nbsp;
                <label>SÓLO ACTIVOS</label>&nbsp;<input type="radio" name="filtro" value="INACTIVO" id="activos">&nbsp;&nbsp;
                <label>SÓLO INACTIVOS</label>&nbsp;<input type="radio" name="filtro" value="ACTIVO" id="inactivos">
            </div>
        </div>
        <div class="row justify-content-md-center">
                <col-sm>
                    <h5 class="mr-3 mt-2">DESCARGAR LISTADO DE GRUPOS DE:</h5>
                </col-sm>
                <div class="col-sm">
                    <a class="btn btn-primary btn-sm mr-3 mb-3 float-left" href="/listado_estudiantes_grupo/1">Linea 1</a>  
                     <a class="btn btn-primary btn-sm mr-3 mb-3 float-left" href="/listado_estudiantes_grupo/2">Linea 2</a>
                     <a class="btn btn-primary btn-sm mr-3 mb-3 float-left" href="/listado_estudiantes_grupo/3">Linea 3</a>
                </div>
         </div>
        @endif
        
    <div class="table-responsive">
        <table id="example1" class=" table table-bordered table-striped">
        <caption>Ultima modificación del estado de los estudiante: {{ $valor_ultimo }}</caption>
        <thead>
            <tr>
                <td>Nombres</td>
                <td>Tipo Doc.</td>
                <td>Nº Doc.</td>
                <td>Codigo</td>
                <td>Email</td>
                <td>Tel.</td>
                <td>Grupo</td>
                <td>Cohorte</td>
                <td>Clasificación</td>
                <td>Estado</td>
                <td>EPS</td>
                <td id="botons" width="15%">Acciones</td>
            </tr>
        </thead>       
    </table>
      </div>
    </div>
    </div>
</div>
@include('perfilEstudiante.modal.createStudent')
@push('scripts')
{!!Html::script('/js/dep-mun.js')!!}
    <!-- Page specific script -->
<script>

        $('.inactivos_activos_student').on('change', function() {

            $("#example1").DataTable().ajax.reload();
                
        });

   $(document).ready(function(){
   
        var table = $("#example1").DataTable({
            
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.estudiantes')}}",
                "data": function(d){

                    d.activos = $('#activos').is(":checked");
                    d.inactivos = $('#inactivos').is(":checked");
                    d.admitidos = $('#admitidos').is(":checked");
                    d.todos = $('#todos').is(":checked");
                },
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
                {data: 'student_code'},
                {data: 'email'},
                {data: 'cellphone'},
                {data: 'grupo'},
                {data: 'cohorte'},
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
                {data: 'estado'},
                {data: 'eps', visible:false},
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
  
        
        document.getElementById('linea_1').checked = true;
        document.getElementById('linea_2').checked = true;
        document.getElementById('linea_3').checked = true;
        
        
       $('.filtroCohortes').on('change', function() {
           
            var checkLinea1 = $('#linea_1').is(":checked");
            var checkLinea2 = $('#linea_2').is(":checked");
            var checkLinea3 = $('#linea_3').is(":checked");

            if (!checkLinea1) {
                    if(checkLinea2 && checkLinea3){
                        //filtro por columna excepto el valor de del id del checbox indicado(linea_1)
                        var filtro = $('input:checkbox[id="linea_1"]').map(function() {
                            return this.value;
                        }).get().join('|');
                        table.column(8).search(filtro ? '^((?!' + filtro + ').*)$' : '', true, false, false).draw(false);
                        //
                    }else if (checkLinea2) {
                        //filtros basicos por columna con un solo valor
                        table.columns(8).search('LINEA 2'); 
                        //       
                    }else if (checkLinea3) {
                        table.columns(8).search('LINEA 3');
                    }
                    table.draw();
                        
                }
                if(!checkLinea2){
                    if(checkLinea1 && checkLinea3){
                        var filtro = $('input:checkbox[id="linea_2"]').map(function() {
                            return this.value;
                        }).get().join('|');
                        table.column(8).search(filtro ? '^((?!' + filtro + ').*)$' : '', true, false, false).draw(false);
                    }else if(checkLinea1){
                        table.columns(8).search('LINEA 1');
                    }else if(checkLinea3){
                        table.columns(8).search('LINEA 3');
                    }
                    table.draw();
                }
                if(!checkLinea3){
                    if(checkLinea1 && checkLinea2){
                        var filtro = $('input:checkbox[id="linea_3"]').map(function() {
                            return this.value;
                        }).get().join('|');
                        table.column(8).search(filtro ? '^((?!' + filtro + ').*)$' : '', true, false, false).draw(false);
                    }else if(checkLinea1){
                        table.columns(8).search('LINEA 1');
                    }else if(checkLinea2){
                        table.columns(8).search('LINEA 2');
                    }
                    table.draw();
                }
                if (checkLinea1 && checkLinea2 && checkLinea3) {
                    //filtro por columna con varios valores segun el name de los checbox y su valor correspondiente
                    var offices = $('input:checkbox[name="check"]:checked').map(function() {
                        return this.value;
                    }).get().join('|');
                    table.column(8).search(offices, true, false, false).draw(false);
                    //
                }
        });
   });      
</script>

 
@endpush
@endsection
