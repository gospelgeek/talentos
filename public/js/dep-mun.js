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
