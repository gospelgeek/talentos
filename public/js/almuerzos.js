//ACCIONES DE LOS ALMUERZOS
//Abrir modal
$('.abrir_modal_almuerzos').click(function(e) { 
      e.preventDefault();
        $('#modal_crear_almuerzo').modal('show');
        //alert(cod)
});


//Almacenar registro
$('.boton_almacenar_almuerzos').click(function(e) { 
  e.preventDefault();
    
       var form = $('#form-almacenar-almuerzos');
       var ruta = form.attr('action');
       var datos = form.serialize();
      
      $.ajax({
        url:ruta,
        type:'POST',
        data:datos,
        success:function(msj) {
          $('#modal_crear_almuerzo').modal('hide');
          //document.getElementById("form-almacenar-almuerzos").reset();
          toastr.success(msj);
          setTimeout("location.reload()", 2000);
        },

         error:function(msj) {
          var mensajeError = "";
          $.each(msj.responseJSON.errors,function(i,field){
            mensajeError += "<li>"+field+"</li>"
           //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
           console.log(mensajeError)
                 });
          $("#msj-error").html("<ul>"+mensajeError+"</ul>").fadeIn();
          

        },
       
      });
});

//actualizar registro almuerzo
$('.actualizar_registro_almuerzo').click(function(e) { 
  e.preventDefault();
  var idregistro = $('#idregistro').val();
  
    $.ajax({
  //ruta manual
    url:'/actualizar_registro_almuerzos/'+ idregistro,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'date': $("#fechaAlmuerzo").val(),
      'number_lunches_line1': $("#cantLinea1").val(),
      'number_lunches_line2': $("#cantLinea2").val(),
      'number_lunches_line3': $("#cantLinea3").val(),
  
    },
    success:function(result) {
      $('#modal_editar_almuerzo').modal('hide');
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

//Eliminar registro almuerzos(funcion onclick desde el modal con parametro)
function boton_delete_registro_almuerzos(id) {

        var data = $(id).attr("data-id");
        //var data = document.querySelector('#id_registro');
        console.log(data);
        
        var form = $('#form-delete');
        var url = form.attr('action').replace(':ALMUERZO_ID', data);
        var data = form.serialize();

        $.post(url, data, function(result){
          
          toastr.warning(result); 
          setTimeout("location.reload()", 2000);
       });
}; 

$('.cerrar_modal').click(function(e) { 
  e.preventDefault();

  $('#modal_alerta_almuerzos').modal('hide');
});
