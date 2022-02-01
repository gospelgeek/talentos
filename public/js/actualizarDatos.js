$('.abrir_modal_actualizar_previos').click(function(e) { 
      e.preventDefault();
        $('#modal_actualizar_datos_academicos_previos').modal('show');
        //alert(cod)
});


$('.boton_update_datos_academicos_previos').click(function(e) { 
  e.preventDefault();   
  var idDatos = $('#idap').val();
  alert(idDatos);
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
      toastr.info(result);
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