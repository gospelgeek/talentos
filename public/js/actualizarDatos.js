//ACTUALIZAR DATOS ACADEMICOS PREVIOS
//Abrir modal
$('.abrir_modal_actualizar_previos').click(function(e) { 
      e.preventDefault();
        $('#modal_actualizar_datos_academicos_previos').modal('show');
        //alert(cod)
});

//Actualizar datos
$('.boton_update_datos_academicos_previos').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idap').val();
  //alert(idDatos);
  $.ajax({
  //ruta manual
    url:'/updatedatosacademicosprevios/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'institution_name': $("#colegio").val(),
      'year_graduation': $("#graduacion").val(),
      'bachelor_title': $("#bachiller").val(),
      'icfes_date': $("#fechaIcfes").val(),
      'snp_register': $("#snpRegistro").val(),
      'icfes_score': $("#icfesPuntaje").val(),
  
    },
    success:function(result) {
      $('#modal_actualizar_datos_academicos_previos').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});

//Actualizar datos academicos previos de la otra vista
$('.boton_update_academicos_previos').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idPaD').val();
  //alert($("#icfesscore").val());
  $.ajax({
  //ruta manual
    url:'/updatedatosacademicosprevios/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'institution_name': $("#institutionname").val(),
      'year_graduation': $("#yeargraduation").val(),
      'bachelor_title': $("#snpregister").val(),
      'icfes_date': $("#icfesdate").val(),
      'snp_register': $("#bachelortitle").val(),
      'icfes_score': $("#icfesscore").val(),
  
    },
    success:function(result) {
      $('#contenido-2').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});


//ACTUALIZAR DATOS GENERALES
//Abrir modal
$('.abrir_modal_actualizar').click(function(e) { 
      e.preventDefault();
        $('#modal_actualizar_datos_generales').modal('show');
        //alert(cod)
});


//Actualiazr datos 
$('.boton_update_datos_generales').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idG').val();
  //alert($("#direccion12").val());
  $.ajax({
  //ruta manual
    url:'/updatedatosgenerales/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'name': $("#nombre1").val(),
      'lastname': $("#apellido").val(),
      'id_document_type': $("#tipoDocumento").val(),
      'document_number': $("#numeroDocumento").val(),
      'document_expedition_date': $("#fechaExpedicion").val(),
      'id_birth_city': $("#ciudadNacimiento").val(),
      'email': $("#correo").val(),
      'birth_date': $("#fechaNacimiento").val(),
      'sex': $("#sexo1").val(),
      'id_gender': $("#generoE").val(),
      'cellphone': $("#celular").val(),
      'phone': $("#telefono").val(),
      'id_neighborhood': $("#barrioV").val(),
      'direction': $("#direccion12").val(),
      'student_code': $('#codEstu').val(),
      'first_name': $('#nombre_pilA').val(),
      'emergency_contact_name': $('#emergencia_nombre').val(),
      'relationship': $('#parentezco').val(),
      'emergency_contact': $('#emergencia').val(),
    },
    success:function(result) {
      $('#modal_actualizar_datos_generales').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});

//actualizar datos generales de la otra vista
$('.boton_update_generales').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idGeN').val();
  //alert(idDatos);
  $.ajax({
  //ruta manual
    url:'/updatedatosgenerales/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'name': $("#nombres123").val(),
      'lastname': $("#apellidosG").val(),
      'id_document_type': $("#tipodocumento").val(),
      'document_number': $("#numerodocumento").val(),
      'document_expedition_date': $("#expedition").val(),
      'id_birth_city': $("#ciudadnacimiento").val(),
      'email': $("#elctrncO").val(),
      'birth_date': $("#fechanacimientoG").val(),
      'sex': $("#sexoGeN").val(),
      'id_gender': $("#gen").val(),
      'cellphone': $("#telefono11").val(),
      'phone': $("#telefono22").val(),
      'id_neighborhood': $("#barrioresidencia").val(),
      'direction': $("#direccionnnnn").val(),
      'student_code': $('#codEstudiante').val(),
      'first_name': $('#npila').val(),
      'emergency_contact_name': $('#nmbre_emrgncia').val(),
      'relationship': $('#prntzco').val(),
      'emergency_contact': $('#emergency').val(),
    },
    success:function(result) {
      $('#contenido-1').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});




//ACTUALIZAR DATOS SOCIOECONOMICOS
//Abrir modal
$('.abrir_modal_socioeconomico').click(function(e) { 
      e.preventDefault();
        $('#modal_actualizar').modal('show');
        //alert(cod)
});


//Actualizar datos
$('.boton_update_datos_socioeconomicos').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idSx').val();
  //alert(idDatos);
  $.ajax({
  //ruta manual
    url:'/updatedatossocioeconomicos/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'id_ocupation': $("#ocupacion").val(),
      'id_civil_status': $("#estadoCivil").val(),
      'children_number': $("#hijosNumero").val(),
      'id_residence_time': $("#residencia1").val(),
      'id_housing_type': $("#vivienda").val(),
      'id_health_regime': $("#regimen").val(),
      'sisben_category': $("#categoriaSisben").val(),
      'id_benefits': $("#beneficiosD").val(),
      'household_people': $("#personasFamilia").val(),
      'economic_possition': $("#posicionE").val(),
      'dependent_people': $("#personasCargo").val(),
      'internet_zon': $("#internetZona").val(),
      'internet_home': $("#internetHogar").val(),
      'sex_document_identidad': $("#sexoD").val(),
      'id_social_conditions': $("#socialC").val(),
      'id_disability': $("#discapacidadS").val(),
      'id_ethnicity': $("#etnia").val(),
      'eps_name': $("#eps").val(),  
    },
    success:function(result) {
      $('#modal_actualizar').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});


//Actualizar datos socioeconomicos de la otra vista
$('.boton_update_socioeconomicos').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idSd').val();
  //alert($("#idethnicity").val());
  $.ajax({
  //ruta manual
    url:'/updatedatossocioeconomicos/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'id_ocupation': $("#idocupation").val(),
      'id_civil_status': $("#idcivilstatus").val(),
      'children_number': $("#childrennumber").val(),
      'id_residence_time': $("#idresidencetime").val(),
      'id_housing_type': $("#idhousingtype").val(),
      'id_health_regime': $("#idhealthregime").val(),
      'sisben_category': $("#sisbencategory").val(),
      'id_benefits': $("#idbenefits").val(),
      'household_people': $("#householdpeople").val(),
      'economic_possition': $("#economicpossition").val(),
      'dependent_people': $("#dependentpeople").val(),
      'internet_zon': $("#internetzon").val(),
      'internet_home': $("#internethome").val(),
      'sex_document_identidad': $("#sexdocumentidentidad").val(),
      'id_social_conditions': $("#idsocialconditions").val(),
      'id_disability': $("#iddisability").val(),
      'id_ethnicity': $("#idethnicity").val(),
      'eps_name': $("#epS").val(),
    },
    success:function(result) {
      $('#contenido-3').modal('hide');
      //window.location.reload(); 
      toastr.success(result);
      setTimeout("location.reload()", 2000);
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});

//ACCIONES PARA EDITAR GRUPO Y COHORTE
//Abrir modal
$('.boton_cambiar_cohorte_grupo').click(function(e) { 
      e.preventDefault();
        $('#modal_cambiar_cohorte_grupo').modal('show');               
});

//funcion para traer los grupos de cada cohorte seleccionada
$(function () {
     $('#cohorT').change(function(event)
      {
    //console.log(event.target.value);
    
    $.get("/grupos/"+event.target.value+"",function(response,grpos)
    {
    //console.log(grpos)
      $('#grupOm').html('<option value="" selected="true"> Seleccione una opción </option>');
      response.forEach(element => {
          $('#grupOm').append('<option  value='+element.id+'> '+element.name+' </option>')
        });         
                 
    });

    
  });
 });

//Abrir mensaje de alerta
$('.boton_mensaje_alerta').click(function(e) {

    var grupo = document.getElementById('grupOm').value;
    var cohorte = document.getElementById('cohorT').value;
    
    if(grupo === ""){     
        toastr.warning('DEBE DILIGENCIAR UN GRUPO');
    }else if (grupo != "") {
        //alert('siga');
        $.get("/datos/"+grupo+"",function(response,array) {
        //console.log(response.grupo);
        var grupo = response.grupo;
        var cohorte = response.cohorte;

        let h8 = document.createElement('h8');
        h8.innerHTML = cohorte;
        document.getElementById('mstrchrte').appendChild(h8); 

        let h9 = document.createElement('h8');
        h9.innerHTML = grupo;
        document.getElementById('mstrgrpo').appendChild(h9);       

        e.preventDefault();
        $('#modal_alerta').modal('show');
        //console.log(grupo);   
      });  
    }
                   
});


//Actualizando campos
$('.boton_actualizar').click(function(e) { 
  e.preventDefault();
  
  var idgroup = $('#idGr').val();

  $.ajax({
  //ruta manual
    url:'/updatecohortegrupo/'+ idgroup,
    type:'POST',
    data:{
      '_token': $('input[name=_token]').val(),
      'grupo': $("#grupOm").val(),
      'cohorte': $("#cohorT").val(),
      'group_change_date': $("#fecha_cambio").val(),
    },
    success:function(result) {
       
      if(result == 'El grupo seleccionado debe pertenecer a la cohorte correspondiente'){
        toastr.warning(result); 
      }

      if(result == 'Datos actualizados correctamente!!'){
        toastr.success(result);
        setTimeout("location.reload()", 2000);
      }

      if(result == 2){
       toastr.warning('Debe diligenciar todos los campos'); 
      }
      
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});


//Cerrar alerta
$('.cerrar_modal').click(function(e) { 
      e.preventDefault();
        $('#modal_alerta').modal('hide'); 
        $('#mstrchrte').html(' ');
        $('#mstrgrpo').html(' ');              
});

//Cerrar modal actualizar cohorte-grupo
$('.boton_cancelar').click(function(e) { 
      e.preventDefault();
        $('#modal_cambiar_cohorte_grupo').modal('hide');               
});

//ACCIONES APOYO ECONOMICO
//poner inputs 
function apoyo_economico(){
    
    $('#inputs').append('<div class="col-xs-4 col-md-2">'+
                          '<p style="text-align: right"><label for="date">Fecha:</label></p>'+
                        '</div>'+
                        '<div class="col-xs-4 col-md-2">'+
                          '<div class="row">'+
                            '<div class="col-xs-4 col-md-12">'+
                              '<input class="form-control" type="date" name="date" id="date_supporT">'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="col-xs-4 col-md-2">'+
                          '<p style="text-align: right"><label for="url_banco">URL banco:</label></p>'+
                        '</div>'+
                        '<div class="col-xs-4 col-md-2">'+
                          '<div class="row">'+
                            '<div class="col-xs-4 col-md-12">'+
                              '<input class="form-control" type="text" name="url_banco" id="url_banco">'+
                            '</div>'+
                          '</div>'+  
                        '</div>'+
                        '<div class="col-xs-4 col-md-2">'+
                          '<p style="text-align: right"><label for="monto">Monto:</label></p>'+
                        '</div>'+
                        '<div class="col-xs-4 col-md-2">'+
                          '<div class="row">'+
                            '<div class="col-xs-4 col-md-12">'+
                              '<input class="form-control" type="number" name="monto" id="monto">'+
                            '</div>'+
                          '</div>'+                  
                        '</div>');

    $('#nuevo_registro').addClass('disabled');
}

//Guardar formalizacion
$('.boton_update_formalizacion').click(function(e) { 
  e.preventDefault();   
  
  var idDatos = $('#idfLz').val();
  
  var checkAcptacon = $('#aceptacion_check').is(":checked");
  var checkTablet = $('#tablet_check').is(":checked");


$.ajax({
  //ruta manual
    url:'/updateformalizacion/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'acceptance_v1': $("#acceptancev1").val(),
      'acceptance_v2': $("#acceptancev2").val(),
      'tablets_v1': $("#tabletsv1").val(),
      'tablets_v2': $("#tabletsv2").val(),
      'serial_tablet': $("#serialtablet").val(),
      'date_kit' : $("#kit_fecha").val(),
      'pre_registro_icfes': $('input[name="pre_registration_icfes"]:checked').val(),
      'inscripcion_icfes': $('input[name="inscription_icfes"]:checked').val(),
      'presento_icfes': $('input[name="presented_icfes"]:checked').val(),
      'observaciones': $('textarea[id="observacionestext"]').val(),
      'checkAceptacion': checkAcptacon,
      'checkTablet': checkTablet,
      'fecha_apoyo': $("#date_supporT").val(),
      'banco_url': $("#url_banco").val(),  
      'monto': $("#monto").val(),
      'id': $("#estudiantE").val(),
      'fecha_aceptacion': $("#acceptance_date").val(),
      'observacion_aceptacion': $("#acceptance_observation").val(),
      'prestamo_tablet': $('input[name="loan_tablet"]:checked').val(),
      'devolvio_tablet': $('input[name="returned_tablet"]:checked').val(),
      'serial_tablet_prestada': $("#serial_loan_tablet").val(),
      'observacion_prestamo': $("#observation_loan").val(),
      'url_documento_prestamo': $("#loan_document_url").val(),
      'cambio_de_linea': $('input[name="transfer_line2_to_line1"]:checked').val(),
    },
    success:function(result) {
      $('#contenido-1').modal('hide');
      if(result == 1){
        toastr.info('FORMALIZACION NO DILIGENCIADA');  
      }else if(result == 2){
        toastr.success('FORMALIZACIÓN GENERADA CORRECTAMENTE');
        setTimeout("location.reload()", 2000);  
      } 
      
      
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});

//actualizar registro apoyo economico
$('.actualizar_apoyo_economico').click(function(e) { 
  e.preventDefault();

  var idDatos = $('#idapyoEcnmco').val();

  $.ajax({
  //ruta manual
    url:'/update_apoyo_economico/'+ idDatos,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'date': $("#fchaApyo").val(),
      'url_banco': $("#urlbnco").val(),
      'monto': $("#mnto").val(),
    },
    success:function(result) {
      $('#contenido-1').modal('hide');
      if(result == 1){
        toastr.success('Apoyo economico actualizado correctamente');  
        setTimeout("location.reload()", 2000);
      }
      
    },

    error:function(result) {          
      var mensajeError = "";
      $.each(result.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
});

//ACCIONES DE VER Y EDITAR DATOS EN FORMALIZACION
$(function() {
    $('#mostrar_registros').empty();
    $('#inputs').empty();
    $('#nuevo_registro').removeClass('disabled');  
});

$(function() {    
    $('#aceptacion_check').change(function(event) {        
      var checkAcptacon = $('#aceptacion_check').is(":checked");
        if(checkAcptacon) {
          document.getElementById('acceptancev2').disabled = false;
        }else{
          document.getElementById('acceptancev2').disabled = true;
        }                
    });
});

$(function() {
    $('#tablet_check').change(function(event) {
      var checkTablets = $('#tablet_check').is(":checked");
      if(checkTablets) {
        document.getElementById('tabletsv2').disabled = false;
        document.getElementById('serialtablet').disabled = false;
      }else{
        document.getElementById('tabletsv2').disabled = true;
        document.getElementById('serialtablet').disabled = true;
      }
    });
});
    
$(function() {
    //marcar checks y radios segun lo que venga de la BD(ambas vistas)
      var registro = $("#rgstraton").val();
      var inscripcion = $("#inscrpton").val();
      var presento = $("#icfes_presented").val();

      if(registro == '' || registro == 0){
        document.getElementById('pre_registration').checked = false;
      }else if(registro == 1){
        document.getElementById('pre_registration').checked = true;
      }

      if(inscripcion == '' || inscripcion == 0){
        document.getElementById('inscription').checked = false;
      }else if(inscripcion == 1){
        document.getElementById('inscription').checked = true;
      }

      if(presento == '' || presento == 0){
        document.getElementById('presented').checked = false;
      }else if(presento == 1){
        document.getElementById('presented').checked = true;
      }
    //
      
    //poner info en text area(vista verDatos)
      var observaciones = $("#obser").val();
      $('textarea[id="observacionestext"]').val(observaciones);
    //

    //mostrar registros de apoyos economicos en la tabla
      //let array = document.getElementById('apoyos').value;
      const datos_json = JSON.parse(array);
      var rol = document.getElementById('rol_login').value;
      
      $.each(datos_json, function(index, value) {

          //sacar mes de la fecha para mostar en campo(ambas vistas)
          let fecha = value.date;
          let fecha_convertida = new Date(fecha);
          //garantizo que la zona horaria no me reste un dia en la fercha
          fecha_convertida.setMinutes(fecha_convertida.getMinutes() + fecha_convertida.getTimezoneOffset());
          const mes_fecha = fecha_convertida.toLocaleString("es-ES", { month: "long" });
          //*/
          if(rol == 1 || rol == 4){

            $('#mostrar_registros').append('<tr data-id='+value.id+'>'+"<td>"+mes_fecha+"</td>"+
                    "<td>"+value.url_banco+"</td>"+
                    "<td>"+value.monto+"</td>"+
                    "<td>"+'<center>'+'<div class="btn-group">'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn btn-block fa fa-pencil-square-o fa editar_registro_apoyo_economico" title="Editar registro"></button>'+
                          '</div>'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn text-danger btn-block fa fa-trash fa delete_registro_apoyo_economico" title="Eliminar registro"></button>'+
                          "</div>"+
                      "</div>"+'</center>'+"</td>"+
                    "</tr>");
          }else{

            $('#mostrar_registros').append('<tr data-id='+value.id+'>'+"<td>"+mes_fecha+"</td>"+
                    "<td>"+value.url_banco+"</td>"+
                    "<td>"+value.monto+"</td>"+
                    "<td>"+'<center>'+'<div class="btn-group">'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button disabled class="btn btn-block fa fa-pencil-square-o fa editar_registro_apoyo_economico" title="Editar registro"></button>'+
                          '</div>'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button disabled class="btn text-danger btn-block fa fa-trash fa delete_registro_apoyo_economico" title="Eliminar registro"></button>'+
                          "</div>"+
                      "</div>"+'</center>'+"</td>"+
                    "</tr>");
          }
            
      });
      //

      //editar registro de apoyo economico
      $('.editar_registro_apoyo_economico').click(function(e) {
            e.preventDefault();
            
            var row = $(this).parents('tr');
            var id = row.data('id');
            var form = $('#form-edit-apoyo_economico');
            var url = form.attr('action').replace(':APOYO_ID', id);
            var data = form.serialize();

            $.get(url, function(result){
              
              $("#idapyoEcnmco").val(result.id);
              $('#fchaApyo').val(result.date);  
              $('#urlbnco').val(result.url_banco);       
              $('#mnto').val(result.monto);

              $('#modal_editar_apoyo_economico').modal('show');
            
            });
      });
      //

      //eliminar registro apoyo economico
      $('.delete_registro_apoyo_economico').click(function(e) {       
          e.preventDefault();

          var row = $(this).parents('tr');
          var id = row.data('id');
          var form = $('#form-delete_apoyo_economico');
          var url = form.attr('action').replace(':APOYO_ID', id);
          var data = form.serialize();
       
          $.post(url, data, function(result){
            row.fadeOut();
            toastr.success(result); 
            //setTimeout("location.reload()", 2000);
          });
      }); 
});




