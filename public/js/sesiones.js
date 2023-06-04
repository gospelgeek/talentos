//ACCIONES DE SESIONES
//Abrir modal
$('.abrir_modal_sesiones').click(function(e) { 
      e.preventDefault();

        $('#modal_crear_sesion').modal('show');
        //alert(cod)
});

//funcion para traer los grupos de cada cohorte seleccionada

    $('#cohorTe').change(function(event)
      {
    //console.log(event.target.value);
      
      $.get("/grupos_to_sesion/"+event.target.value+"",function(response,grupos)
      {
        var div = document.getElementById('grupotoSesion');
    
        div.removeAttribute('disabled');
        $('#grupotoSesion').html('<option value="" selected="true"> Seleccione una opción</option>');
            response.forEach(element => {
            $('#grupotoSesion').append('<option  value='+element.id+'> '+element.name+' </option>')
          });         
        
      });

    
    });
 
//funcion para traer las asignaturas de cada cohorte seleccionada

    $('#cohorTe').change(function(event)
      {
    
    
      $.get("/asignatura_to_sesion/"+event.target.value+"",function(response,asignaturas)
      {
        var div = document.getElementById('asigtoSesion');
    
        div.removeAttribute('disabled');
        $('#asigtoSesion').html('<option value="" selected="true"> Seleccione una opción </option>');
            response.forEach(element => {
            $('#asigtoSesion').append('<option  value='+element.id+'> '+element.name+' </option>')
          });         
                 
      });

    
    });
 
//Almacenar registro
$('.boton_almacenar_sesion').click(function(e) { 
  e.preventDefault();
    
       var form = $('#form-almacenar-sesion');
       var ruta = form.attr('action');
       var datos = form.serialize();
      
      $.ajax({
        url:ruta,
        type:'POST',
        data:datos,
        success:function(msj) {
          $('#modal_crear_sesion').modal('hide');
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



  //funcion para traer los grupos de cada cohorte seleccionada

    $('#cohorT_e').change(function(event)
      {
    //console.log(event.target.value);
      
      $.get("/grupos_to_sesion/"+event.target.value+"",function(response,grupos)
      {
        
        $('#grupoto_Sesion').html('<option value="" selected="true"> Seleccione una opción</option>');
            response.forEach(element => {
            $('#grupoto_Sesion').append('<option  value='+element.id+'> '+element.name+' </option>')
          });         
        
      });

    
    });
 
//funcion para traer las asignaturas de cada cohorte seleccionada

    $('#cohorT_e').change(function(event)
      {
    
    
      $.get("/asignatura_to_sesion/"+event.target.value+"",function(response,asignaturas)
      {
        
        $('#asigto_Sesion').html('<option value="" selected="true"> Seleccione una opción </option>');
            response.forEach(element => {
            $('#asigto_Sesion').append('<option  value='+element.id+'> '+element.name+' </option>')
          });         
                 
      });

    
    });

    function editar_registro_sesion(dato, cohorteid){
    

    var form = $('#form-edit');
    var url = form.attr('action').replace(':SESION_ID', dato);
    var data = form.serialize();
    
        $.get("/grupos_to_sesion/"+cohorteid+"",function(response,grupos)
        {
        
            $('#grupoto_Sesion').html('<option value="" selected="true"> Seleccione una opción</option>');
                response.forEach(element => {
                $('#grupoto_Sesion').append('<option  value='+element.id+'> '+element.name+' </option>')
            });         
        
        });

        $.get("/asignatura_to_sesion/"+cohorteid+"",function(response,asignaturas)
        {
        
          $('#asigto_Sesion').html('<option value="" selected="true"> Seleccione una opción </option>');
            response.forEach(element => {
            $('#asigto_Sesion').append('<option  value='+element.id+'> '+element.name+' </option>')
          });         
                 
        });
        $.get(url, function(sesiones){
  
        //console.log(sesiones);


       
        $("#idsesion").val(sesiones.id);  
        $('#cohorT_e').val(sesiones.name_linea);
        $('#asigto_Sesion').val(sesiones.name_curso);
        $('#grupoto_Sesion').val(sesiones.name_grupo); 
        $("#dateSesion").val(sesiones.fecha);
        $('#modal_editar_sesion').modal('show');

       });


    
  }

//actualizar registro sesion
$('.actualizar_registro_sesion').click(function(e) { 
  e.preventDefault();
  var idregistro = $('#idsesion').val();
  //alert(idregistro);

  $.ajax({
  //ruta manual
    url:'/actualizar_registro_sesion/'+ idregistro,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'cohorte': $("#cohorT_e").val(),
      'id_course': $("#asigto_Sesion").val(),
      'id_group': $("#grupoto_Sesion").val(),
      'date_session': $("#dateSesion").val(),
  
    },
    success:function(result) {
      $('#modal_editar_sesion').modal('hide');
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

function eliminar_registro_sesion(id, date){
    
    

    let h8 = document.createElement('h8');
    h8.innerHTML = date;
    document.getElementById('fecha_sesion').appendChild(h8);
    document.getElementById('id_sesion').setAttribute('data-id', id);

    $('#modal_alerta_sesion').modal('show');

}

//Eliminar registro sesiones(funcion onclick desde el modal con parametro)
function boton_delete_registro_sesion(id) {

        var data = $(id).attr("data-id");
        //var data = document.querySelector('#id_registro');
        console.log(data);
        
        var form = $('#form-delete');
        var url = form.attr('action').replace(':SESION_ID', data);
        var data = form.serialize();

        $.post(url, data, function(result){
          
          toastr.warning(result); 
          setTimeout("location.reload()", 2000);
       });
}; 

$('.cerrar_modal_sesion').click(function(e) { 
  e.preventDefault();

  $('#fecha_sesion').empty();
  //$('#id_sesion').empty();

  $('#modal_alerta_sesion').modal('hide');
});


//filtro grupos vista sesiones
$(document).on('change', '#cohorTe', function(event) {
      
      var linea_select = document.getElementById('cohorTe').value;
      
      $.get("/grupos_to_filter/"+linea_select+"", function(response, grupos)
      {

        var div = document.getElementById('grupotoFilter');
        div.removeAttribute('disabled');
        $('#grupotoFilter').html('<option value="" selected="true"> Seleccione una opción</option>');
            response.forEach(element => {
            $('#grupotoFilter').append('<option  value='+element.id+'> '+element.name+' </option>')
        });  

      });
  });
//

//filtro asignaturas
$(document).on('change', '#cohorTe', function(event) {
      
      var linea_select = document.getElementById('cohorTe').value;
      
      $.get("/asignaturas_to_filter/"+linea_select+"", function(response, grupos)
      {

        var div = document.getElementById('asigtoFilter');
        div.removeAttribute('disabled');
        $('#asigtoFilter').html('<option value="" selected="true"> Seleccione una opción</option>');
            response.forEach(element => {
            $('#asigtoFilter').append('<option  value='+element.id+'> '+element.name+' </option>')
        });  

      });
  });
//




