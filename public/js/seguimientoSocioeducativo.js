//ACCIONES SEGUIMIENTO SOCIOEDUCATIVO
//Abrir modal
$('.abrir_modal_seguimiento_socioeducativo').click(function(e) { 
      e.preventDefault();
        $('#modal_crear_datos_seguimiento_socioeducativo').modal('show');
        //alert(cod)
});

$('.boton_almacenar_seguimiento').click(function(e) { 
  e.preventDefault();
  var form = $('#form-almacenar');
    var ruta = $('#form-almacenar').attr('action');
    var method = $('#form-almacenar').attr('method');
    var datos = form.serialize();
    var token = $('input[name=_token]').val();
    //alert($('#datfechA').val());
    var fecha = $('#datfechA').val();
    var abrir = $('#modal_crear_datos_seguimiento_socioeducativo').modal('show');

    $.ajax({
        url:ruta,
        //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        headers: {'X-CSRF-TOKEN':token},
        type:method,
        data:{
            '_token': $('input[name=_token]').val(),
            'id_student': $('#idsSd').val(),
            'date': $('#datfechA').val(),
            'lugarsegui': $('#lugar').val(),
            'iniciohora': $('#hInicioo').val(),
            'finhora': $('#horafinn').val(),
            'textareaobjetivos': $('textarea[id="objetivos"]').val(),
            'texareaindividual': $('textarea[id="individualT"]').val(),
            'checkindiV': $('input[name="checkindiV"]:checked').val(),
            'textareaacademico': $('textarea[id="academico"]').val(),
            'checkacadE': $('input[name="checkacadE"]:checked').val(),
            'textareafamil': $('textarea[id="familiar"]').val(),
            'checkfamiL': $('input[name="checkfamiL"]:checked').val(),
            'textareaecono': $('textarea[id="economico"]').val(),
            'checkeconoM': $('input[name="checkeconoM"]:checked').val(),
            'textareavidauni': $('textarea[id="vdaunvrstria"]').val(),
            'checkuniC': $('input[name="checkuniC"]:checked').val(),
            'textareobservaciones': $('textarea[id="obsrvacnes"]').val(),


        },




        success:function(msj) {

            if(msj == 'Las categorias deben ser diligenciadas completamente' || msj == 'No es posible crear un seguimiento con esa estructura' || msj == 'No es posible crear un seguimiento vacio' || msj == 'La hora final debe ser mayor a la hora inicial'){
              toastr.warning(msj);
            }else if(msj == 'Seguimiento creado correctamente'){
              $('#modal_crear_datos_seguimiento_socioeducativo').modal('hide');
              document.getElementById("form-almacenar").reset(); 
              toastr.success(msj);
              setTimeout("location.reload()", 2000);       
              $('.accordion-content-4').slideDown();
              window.location.reload();
            }

            console.log(msj);

            
        },

        /*error:function(msj) {
        var mensajeError = "";
        $.each(msj.responseJSON.errors,function(i,field){
          mensajeError += "<li>"+field+"</li>"
         //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
            console.log(mensajeError)
        });
        $("#msj-error").html("<ul>"+mensajeError+"</ul>").fadeIn();
      },  */     
  });
});

$('.boton_limpiarI').click(function(e) { 
    e.preventDefault();

        var indiC = document.getElementsByName("checkindiV");
        for(var i=0;i<indiC.length;i++){
          indiC[i].checked = false;
        }
});

$('.boton_limpiarIU').click(function(e) { 
    e.preventDefault();
        var indiU = document.getElementsByName("checkindi");
        for(var i=0;i<indiU.length;i++){
          indiU[i].checked = false;
        }
});

$('.boton_limpiarA').click(function(e) { 
    e.preventDefault();
        var acadC = document.getElementsByName("checkacadE");
        for(var i=0;i<acadC.length;i++){
          acadC[i].checked = false;
        }
});

$('.boton_limpiarAU').click(function(e) { 
    e.preventDefault();
        var acadU = document.getElementsByName("checkacad");
        for(var i=0;i<acadU.length;i++){
          acadU[i].checked = false;
        }
});

$('.boton_limpiarF').click(function(e) { 
    e.preventDefault();
        var famiC = document.getElementsByName("checkfamiL");
        for(var i=0;i<famiC.length;i++){
          famiC[i].checked = false;
        }
});

$('.boton_limpiarFU').click(function(e) { 
    e.preventDefault();
        var famiU = document.getElementsByName("checkfami");
        for(var i=0;i<famiU.length;i++){
          famiU[i].checked = false;
        }
});

$('.boton_limpiarE').click(function(e) { 
    e.preventDefault();
        var econoC = document.getElementsByName("checkeconoM");
        for(var i=0;i<econoC.length;i++){
          econoC[i].checked = false;
        }
});

$('.boton_limpiarEU').click(function(e) { 
    e.preventDefault();
        var econoU = document.getElementsByName("checkecono");
        for(var i=0;i<econoU.length;i++){
          econoU[i].checked = false;
        }
});

$('.boton_limpiarV').click(function(e) { 
    e.preventDefault();
        var uniycC = document.getElementsByName("checkuniC");
        for(var i=0;i<uniycC.length;i++){
          uniycC[i].checked = false;
        }
});

$('.boton_limpiarVU').click(function(e) { 
    e.preventDefault();
        var uniycU = document.getElementsByName("checkuni");
        for(var i=0;i<uniycU.length;i++){
          uniycU[i].checked = false;
        }          
});

//Actualizando seguimiento
$('.boton_update_seguimiento').click(function(e) { 
  e.preventDefault(); 
  //var row = $(this).parents('tr');
  //var id = row.data('id');  
  var idsegui = $('#idSeguI').val();
  //alert(idsegui);
  $.ajax({
  //ruta manual
    url:'/updateseguimientosocioeducativo/'+ idsegui,
    type:'PUT',
    data:{
      '_token': $('input[name=_token]').val(),
      'date': $("#datfecha").val(),
      'lugarsegui': $("#lugar1").val(),
      'iniciohora': $("#hInicio").val(),
      'finhora': $("#horafin").val(),
      'textareaobjetivos': $('textarea[id="textobjetivos"]').val(),
      'texareaindividual': $('textarea[id="textindividualT"]').val(),
      'checkindi': $('input[name="checkindi"]:checked').val(),
      'textareaacademico': $('textarea[id="textacademico"]').val(),
      'checkacad': $('input[name="checkacad"]:checked').val(),
      'textareafamil': $('textarea[id="textfamiliar"]').val(),
      'checkfami': $('input[name="checkfami"]:checked').val(),
      'textareaecono': $('textarea[id="texteconomico"]').val(),
      'checkecono': $('input[name="checkecono"]:checked').val(),
      'textareavidauni': $('textarea[id="textvdaunvrstria"]').val(),
      'checkuni': $('input[name="checkuni"]:checked').val(),
      'textareobservaciones': $('textarea[id="textobsrvacnes"]').val(),
    },
    success:function(result) {
      //alert(result);
      if(result == 'Las categorias deben ser diligenciadas completamente' || result == 'No es posible crear un seguimiento con esa estructura' || result == 'No es posible crear un seguimiento vacio' || result == 'La hora final debe ser mayor a la hora inicial')
      {
        toastr.warning(result);
      }else if(result == 'Seguimiento socioeducativo actualizado correctamente!!'){
        $('#modal_editar').modal('hide');
        //window.location.reload(); 
        toastr.success(result);
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

//guardar condiciones de salud
$(function () {
          $('.condiciones').change(function(event)
          {
            
            var requerimientos_especiales = $('#espcales_rqrmntos').is(":checked");
            var salud_mental = $('#slud_mntal').is(":checked");
            
            $.ajax({
  
                url:'/crear_condicion_salud/',
                type:'GET',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'id': $("#estudiantE").val(),
                    'requerimientos_especiales': requerimientos_especiales,
                    'salud_mental': salud_mental,
                },
                success:function(result) {
                    
                    if(result.special_requirements == true){
                        document.getElementById('espcales_rqrmntos').checked = true;
                    }
                    if(result.special_requirements == false){
                        document.getElementById('espcales_rqrmntos').checked = false;
                    }
                    if(result.mental_health == true){
                        document.getElementById('slud_mntal').checked = true;
                    }
                    if(result.mental_health == false){
                        document.getElementById('slud_mntal').checked = false;
                    }
                },

            });        
                
          });

});


