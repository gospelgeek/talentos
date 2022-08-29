@extends('layouts.dashboard')

@section('title', 'Datos Pendientes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">DATOS PENDIENTES</h1>
    <div class="card">       
        <div class="card-body">
            <div class="btn-group">
                <div class="filtros_datos">
                    <label>Filtrar por:</label>&nbsp;&nbsp;&nbsp;
                    <label>Datos generales</label>&nbsp;<input type="radio" name="filtro" id="check_generales" checked>&nbsp;&nbsp;
                    <label>Datos socioeconomicos</label>&nbsp;<input type="radio" name="filtro" id="check_socioeconomicos">&nbsp;&nbsp;
                    <label>Datos academicos</label>&nbsp;<input type="radio" name="filtro" id="check_academicos">&nbsp;&nbsp;
                    <label>Formalización</label>&nbsp;<input type="radio" name="filtro" id="check_formalizacion">
                </div>
            </div>
            <div class="table-responsive">
                <div id="tabla_generales" class="table-responsive">
                  <table id="generales" class="table table-bordered table-striped">                  
                    <thead>
                    	<tr>	
                    	   <th>Enlace foto</th>
                           <th>Nombres</th>
                           <th>Apellidos</th>
                           <th>Linea</th>
                           <th>Grupo</th>
                           <th>Profesional</th>
                           <th>Nombre de pila</th>
                           <th>Tipo documento</th>
                           <th>Enlace documento</th>
                           <th>Numero documento</th>
                           <th>Fecha expedición documento</th>
                           <th>Email</th>
                           <th>Estado</th>
                           <th>Fecha nacimiento</th>
                           <th>Departamento nacimiento</th>
                           <th>Ciudad nacimiento</th>
                           <th>Sexo</th>
                           <th>Genero</th>
                           <th>Telefono fijo</th>
                           <th>Celular</th>
                           <th>Telefono</th>
                           <th>Nombre contacto emergencia</th>
                           <th>Parentezco</th>
                           <th>Numero contacto emergencia</th>
                           <th>Comuna</th>
                           <th>Barrio</th>
                           <th>Codigo estudiante</th>
                           <th>Institución</th>
                           <th>Fecha de registro</th>
                           <th>Dirección</th>
                           <th>Tutor</th>
                           <th>Id moodle</th>
                           <th>ACCIONES</th>
                    	</tr>
                    </thead>    
                  </table>
                </div>
                <div id="tabla_socioeconomicos" class="table-responsive" style='display:none;'>
                  <table id="socioeconomicos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Linea</th>
                            <th>Grupo</th>
                            <th>Profesional</th>
                            <th>Estado</th>
                            <th>Ocupación</th>
                            <th>Estado civil</th>
                            <th>Numero hijos</th>
                            <th>Tiempo en residencia</th>
                            <th>Tipo vivienda</th>
                            <th>Regimen de salud</th>
                            <th>Enlace regimen de salud</th>
                            <th>Categoria sisben</th>
                            <th>Enlace categoria sisben</th>
                            <th>Beneficios</th>
                            <th>Personas en el hogar</th>
                            <th>Posición economica</th>
                            <th>Personas dependientes</th>
                            <th>Internet en la zona</th>
                            <th>Internet en el hogar</th>
                            <th>Sexo en documento</th>
                            <th>Condición social</th>
                            <th>Enlace condición social</th>
                            <th>Estrato</th>
                            <th>Zona rural</th>
                            <th>Discapacidad</th>
                            <th>Etnia</th>
                            <th>Enlace etnia</th>
                            <th>EPS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                  </table>
                </div>
                <div id="tabla_academicos" class="table-responsive" style='display:none;'>
                    <table id="academicos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Linea</th>
                                <th>Grupo</th>
                                <th>Profesional</th>
                                <th>Estado</th>
                                <th>Tipo institución</th>
                                <th>Nombre institucion</th>
                                <th>Año graduación</th>
                                <th>Titulo bachiller</th>
                                <th>Enlace soporte academcio</th>
                                <th>Fecha icfes</th>
                                <th>Registro SNP</th>
                                <th>Puntaje icfes</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="tabla_formalizacion" class="table-responsive" style='display:none;'>
                    <table id="formalizacion" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Linea</th>
                                <th>Grupo</th>
                                <th>Profesional</th>
                                <th>Estado</th>
                                <th>Cambio de linea</th>
                                <th>Aceptación</th>
                                <th>Fecha aceptación</th>
                                <th>Observación aceptación</th>
                                <th>Tablet</th>
                                <th>Serial tablet</th>
                                <th>Regrsó tablet</th>
                                <th>Prestó tablet</th>
                                <th>Serial tablet prestada</th>
                                <th>Observación prestamo</th>
                                <th>Enlace documento de perstamo</th>
                                <th>Fecha kit</th>
                                <th>Pre-registro icfes</th>
                                <th>Inscripción icfes</th>
                                <th>Presentó icfes</th>
                                <th>Observaciones generales</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    
    $('.filtros_datos').on('change', function() {
        var generales = $('#check_generales').is(":checked");
        var socioeconomicos = $('#check_socioeconomicos').is(":checked");
        var academicos = $('#check_academicos').is(":checked");
        var formalizacion = $('#check_formalizacion').is(":checked"); 
        if(generales){
            document.getElementById("tabla_generales").removeAttribute('style', 'display:none');
            document.getElementById("tabla_socioeconomicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_academicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_formalizacion").setAttribute('style', 'display:none');
        }else if(socioeconomicos){
            document.getElementById("tabla_generales").setAttribute('style', 'display:none');
            document.getElementById("tabla_academicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_formalizacion").setAttribute('style', 'display:none');
            document.getElementById("tabla_socioeconomicos").removeAttribute('style', 'display:none');   
        }else if(academicos){
            document.getElementById("tabla_generales").setAttribute('style', 'display:none');
            document.getElementById("tabla_socioeconomicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_formalizacion").setAttribute('style', 'display:none');
            document.getElementById("tabla_academicos").removeAttribute('style', 'display:none');
        }else if(formalizacion){
            document.getElementById("tabla_generales").setAttribute('style', 'display:none');
            document.getElementById("tabla_socioeconomicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_academicos").setAttribute('style', 'display:none');
            document.getElementById("tabla_formalizacion").removeAttribute('style', 'display:none');
        }   
    });

    $(document).ready(function(){
        var table_generales = $("#generales").DataTable({
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.generales')}}",
            },
            "columns": [
                {data: 'photo', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE FOTO</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'name'},
                {data: 'lastname'},
                {data: 'cohorte'},
                {data: 'grupo_name'},
                {data: 'profesional'},
                {data: 'first_name'},
                {data: 'tipo_documento'},
                {data: 'url_document_type', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE DOCUMENTO</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'document_number'},
                {data: 'document_expedition_date'},
                {data: 'email'},
                {data: 'estado'},
                {data: 'birth_date'},
                {data: 'departamento_nacimiento'},
                {data: 'ciudad_nacimiento'},
                {data: 'sex'},
                {data: 'genero'},
                {data: 'landline'},
                {data: 'cellphone'},
                {data: 'phone'},
                {data: 'emergency_contact_name'},
                {data: 'relationship'},
                {data: 'emergency_contact'},
                {data: 'comuna'},
                {data: 'barrio'},
                {data: 'student_code'},
                {data: 'college'},
                {data: 'registration_date'},
                {data: 'direction'},
                {data: 'tutor'},
                {data: 'id_moodle'},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_generales(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit_generales(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_generales(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
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
                "print",
                "colvis"   
            ]
        });

        $('#generales thead tr').clone(true).appendTo('#generales thead');

        $('#generales thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table_generales.column(i).search() !== this.value) {
                    table_generales
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table_socieconomicos = $("#socioeconomicos").DataTable({
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.socioeconomicos')}}",
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'cohorte'},
                {data: 'grupo_name'},
                {data: 'profesional'},
                {data: 'estado'},
                {data: 'ocupacion'},
                {data: 'estado_civil'},
                {data: 'children_number'},
                {data: 'tiempo_residencia'},
                {data: 'tipo_vivienda'},
                {data: 'regimen_salud'},
                {data: 'url_health_regime', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE REGIMEN SALUD</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'sisben_category'},
                {data: 'url_sisben_category', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE CATEGORIA SISBEN</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'beneficios'},
                {data: 'household_people'},
                {data: 'economic_possition'},
                {data: 'dependent_people'},
                {data: 'internet_zon'},
                {data: 'internet_home'},
                {data: 'sex_document_identidad'},
                {data: 'condicion_social'},
                {data: 'url_social_conditions', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE CONDICIOÓN SOCIAL</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'stratum'},
                {data: 'rural_zone'},
                {data: 'discapacidad'},
                {data: 'etnia'},
                {data: 'url_ethnicity', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE ETNIA</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'eps_name'},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_socioeconomicos(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit_socioeconomicos(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_socioeconomicos(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
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
                "print",
                "colvis"   
            ]
        });
        
        $('#socioeconomicos thead tr').clone(true).appendTo('#socioeconomicos thead');

        $('#socioeconomicos thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table_socieconomicos.column(i).search() !== this.value) {
                    table_socieconomicos
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table_academicos = $("#academicos").DataTable({
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.academicos')}}",
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'cohorte'},
                {data: 'grupo_name'},
                {data: 'profesional'},
                {data: 'estado'},
                {data: 'tipo_institucion'},
                {data: 'institution_name'},
                {data: 'year_graduation'},
                {data: 'bachelor_title'},
                {data: 'url_academic_support', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE SOPORTE ACADEMICO</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'icfes_date'},
                {data: 'snp_register'},
                {data: 'icfes_score'},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_academicos(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit_academicos(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_academicos(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
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
                "print",
                "colvis"   
            ]
        });

        $('#academicos thead tr').clone(true).appendTo('#academicos thead');

        $('#academicos thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table_academicos.column(i).search() !== this.value) {
                    table_academicos
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table_formalizacion = $("#formalizacion").DataTable({
            "ajax":{
                "method":"GET",
                "url": "{{route('datos.formalizacion')}}",
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'cohorte'},
                {data: 'grupo_name'},
                {data: 'profesional'},
                {data: 'estado'},
                {data: 'transfer_line2_to_line1', render:function(data, type, row, meta){
                        if(data != null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }else{
                                return null;
                            }
                        }else{
                            return null;
                        }
                    }
                },
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
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'acceptance_date'},
                {data: 'acceptance_observation'},
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
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'serial_tablet'},
                {data: 'returned_tablet', render:function(data, type, row, meta){
                        if(data != null){
                            if(data == 1){
                                var si = '<button class="btn text-success btn-block fa fa-check title="Realizado">SI</button>';
                                return si;
                            }else{
                                return null;    
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
                            }else{
                                return null;
                            }
                        }else{
                            return null;
                        }
                    }
                },
                {data: 'serial_loan_tablet'},
                {data: 'observation_loan'},
                {data: 'loan_document_url', render:function(data, type, row, meta){
                        if(data != null){
                            var url = '<a href="'+data+'" target="blank">ENLACE PRESTAMO</a>';
                            return url;
                        }else{
                            return ' ';
                        }
                    }
                },
                {data: 'kit_date'},
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
                {data: 'observations'},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    if(rol == 4 || rol == 1 || rol == 2 || rol == 6){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_formalizacion(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_edit_formalizacion(this);" class="ver btn btn-block fa fa-pencil fa" title="Editar estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td>'+'<a id="'+data.id+'" onclick="redireccionar_formalizacion(this);" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
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
                "print",
                "colvis"   
            ]
        });

        $('#formalizacion thead tr').clone(true).appendTo('#formalizacion thead');

        $('#formalizacion thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table_formalizacion.column(i).search() !== this.value) {
                    table_formalizacion
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    });

    function redireccionar_generales(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-1#ttlo-1`;
    }   
    function redireccionar_edit_generales(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-1#ttlo-1`;
    }

    function redireccionar_socioeconomicos(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-3#ttlo-3`;
    }   
    function redireccionar_edit_socioeconomicos(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-3#ttlo-3`;
    }

    function redireccionar_academicos(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-2#ttlo-2`;
    }   
    function redireccionar_edit_academicos(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-2#ttlo-2`;
    }

    function redireccionar_formalizacion(id){
            console.log($(id).attr("id"));
            location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-6#ttlo-6`;
    }   
    function redireccionar_edit_formalizacion(id){
            console.log($(id).attr("id"));
            location.href=`../editar_estudiante/${$(id).attr("id")}?css=titulo-6#ttlo-6`;
    }            
</script>
@endpush
@endsection
