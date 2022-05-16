$(function () {
     $('#depNacimiento').change(function(event)
      {
    //alert(event.target.value);
    
    $.get("/departamento/"+event.target.value+"",function(response,municipios)
    {
    //console.log(municipios)
      $('#muni_nacimiento').html('<option value="" selected="true"> Seleccione una opción </option>');
      response.forEach(element => {
          $('#muni_nacimiento').append('<option  value='+element.id+'> '+element.name+' </option>')
        });         
             
    });
    
  });
 });

$(function () {
     $('#comunaResidencia').change(function(event)
      {
      
    
    $.get("/comuna_barrios/"+event.target.value+"",function(response,municipios)
    {
    //console.log(municipios)
      $('#barrioResidencia').html('<option value="" selected="true"> Seleccione una opción </option>');
      response.forEach(element => {
          $('#barrioResidencia').append('<option  value='+element.id+'> '+element.name+' </option>')
        });         
             
    });
    
  });
 });

$(function () {
     $('#lineaC').change(function(event)
      {
      
    
    $.get("/cohorte_grupo/"+event.target.value+"",function(response,municipios)
    {
    //console.log(municipios)
      $('#groupC').html('<option value="" selected="true"> Seleccione una opción </option>');
      response.forEach(element => {
          $('#groupC').append('<option  value='+element.id+'> '+element.name+' </option>')
        });         
             
    });
    
  });
 });


//ACCIONES DE LOS ALMUERZOS
//Abrir modal
$('.abrir_modal_estudiante').click(function(e) { 
      e.preventDefault();
        $('#modal_crear_estudiante').modal('show');
        //alert(cod)
});

//Almacenar registro
$('.boton_almacenar_estudiante').click(function(e) { 
  e.preventDefault();
    

       var form = $('#form-almacenar-estudiante');
       var ruta = form.attr('action');
       var datos = form.serialize();
       
       

      $.ajax({
        url:ruta,
        type:'POST',
        data:datos,
        success:function(msj) {
          $('#modal_crear_estudiante').modal('hide');
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
