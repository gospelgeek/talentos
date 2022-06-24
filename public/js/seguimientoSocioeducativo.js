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
            'url_document': $('#dcmnto_url').val(),

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
      'url_document': $("#dcmntOUrl").val(),
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
            var trabajador = $('#employee').is(":checked");
            var salud_fisica = $('#physical_health').is(":checked");
            var salud_mental = $('#slud_mntal').is(":checked");
            var riesgo_psicosocial = $('#psychosocial_risk').is(":checked");

            $.ajax({
  
                url:'/crear_condicion_salud/',
                type:'GET',
                data:{
                    '_token': $('input[name=_token]').val(),
                    'id': $("#estudiantE").val(),
                    'trabajador': trabajador,
                    'salud_fisica': salud_fisica, 
                    'salud_mental': salud_mental,
                    'riesgo_psicosocial': riesgo_psicosocial,
                },
                success:function(result) {
                    toastr.success('Guardado Exitoso');
                    if(result.employee == true){
                        document.getElementById('employee').checked = true;
                    }
                    if(result.employee == false){
                        document.getElementById('employee').checked = false;
                    }
                    if(result.physical_health == true){
                        document.getElementById('physical_health').checked = true;
                    }
                    if(result.physical_health == false){
                        document.getElementById('physical_health').checked = false;
                    }
                    if(result.mental_health == true){
                        document.getElementById('slud_mntal').checked = true;
                    }
                    if(result.mental_health == false){
                        document.getElementById('slud_mntal').checked = false;
                    }
                    if(result.psychosocial_risk == true){
                        document.getElementById('psychosocial_risk').checked = true;
                    }
                    if(result.psychosocial_risk == false){
                        document.getElementById('psychosocial_risk').checked = false;
                    }
                },

            });        
                
          });

});

$(function() {

    $('#mostrarFcA').empty();
    
        let array = document.getElementById('detalle').value;
        
        const ver = JSON.parse(array);
        //console.log(ver);
        
        $.each(ver, function(index, value) {
            
            console.log(value.tracking_detail);
            const mostar = JSON.parse(value.tracking_detail);
            console.log(mostar);   
            
            if(mostar.RiesgoIndividual !== null){
                if(mostar.RiesgoIndividual === 'alto'){
                    var valor_individual = "<div style='background-color: red;'>"+'ALTO'+"</div>";
                }
                if(mostar.RiesgoIndividual === 'medio'){
                    var valor_individual = "<div style='background-color: yellow;'>"+'MEDIO'+"</div>";
                }
                if(mostar.RiesgoIndividual === 'bajo'){
                    var valor_individual = "<div style='background-color: green;'>"+'BAJO'+"</div>";
                }
            }else{
                var valor_individual = '--';
            }

            if(mostar.RiesgoAcademico !== null){
                if(mostar.RiesgoAcademico === 'alto'){
                    var valor_academico = "<div style='background-color: red;'>"+'ALTO'+"</div>";
                }
                if(mostar.RiesgoAcademico === 'medio'){
                    var valor_academico = "<div style='background-color: yellow;'>"+'MEDIO'+"</div>";
                }
                if(mostar.RiesgoAcademico === 'bajo'){
                    var valor_academico = "<div style='background-color: green;'>"+'BAJO'+"</div>";
                }
            }else{
                var valor_academico = '--';
            }

            if(mostar.RiesgoFamiliar !== null){
                if(mostar.RiesgoFamiliar === 'alto'){
                    var valor_familiar = "<div style='background-color: red;'>"+'ALTO'+"</div>";
                }
                if(mostar.RiesgoFamiliar === 'medio'){
                    var valor_familiar = "<div style='background-color: yellow;'>"+'MEDIO'+"</div>";
                }
                if(mostar.RiesgoFamiliar === 'bajo'){
                    var valor_familiar = "<div style='background-color: green;'>"+'BAJO'+"</div>";
                }
            }else{
                var valor_familiar = '--';
            }

            if(mostar.RiesgoEconomico !== null){
                if(mostar.RiesgoEconomico === 'alto'){
                    var valor_economico = "<div style='background-color: red;'>"+'ALTO'+"</div>";
                }
                if(mostar.RiesgoEconomico === 'medio'){
                    var valor_economico = "<div style='background-color: yellow;'>"+'MEDIO'+"</div>";
                }
                if(mostar.RiesgoEconomico === 'bajo'){
                    var valor_economico = "<div style='background-color: green;'>"+'BAJO'+"</div>";
                }
            }else{
                var valor_economico = '--';
            }

            if(mostar.RiesgoUc !== null){
                if(mostar.RiesgoUc === 'alto'){
                    var valor_Uyc = "<div class='text-align-center' style='background-color: red;'>"+'ALTO'+"</div>";
                }
                if(mostar.RiesgoUc === 'medio'){
                    var valor_Uyc = "<div style='background-color: yellow;'>"+'MEDIO'+"</div>";
                }
                if(mostar.RiesgoUc === 'bajo'){
                    var valor_Uyc = "<div style='background-color: green;'>"+'BAJO'+"</div>";
                }
            }else{
                var valor_Uyc = '--';
            }

            $('#mostrarFcA').append(
                '<tr data-id='+value.id+'>'+
                    "<td>"+mostar.fecha+"</td>"+    
                    "<td>"+valor_individual+"</td>"+
                    "<td>"+valor_academico+"</td>"+
                    "<td>"+valor_familiar+"</td>"+
                    "<td>"+valor_economico+"</td>"+
                    "<td>"+valor_Uyc+"</td>"+
                    "<td>"+
                      '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></button>'+
                          "</div>"+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn btn-block fa fa-pencil-square-o fa editar_seguimiento" title="Editar seguimiento"></button>'+
                          '</div>'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn text-danger btn-block fa fa-trash fa boton_delete_seguimiento" title="Eliminar seguimiento"></button>'+
                          "</div>"+
                      "</div>"+
                    "</td>"+
                "</tr>");
 
    });

    $('.editar_seguimiento').click(function(e) {
            e.preventDefault();
            
            var row = $(this).parents('tr');
            var id = row.data('id');
            //alert(id);

            var form = $('#form-edit-seguimiento');
            //console.log(form);
            var url = form.attr('action').replace(':SEGUIMIENTO_ID', id);
            console.log(url);
            var data = form.serialize();

            $.get(url, function(result){
            const object = JSON.parse(result.tracking_detail);
            console.log(object);
            var fcha = object.fecha;
            var checkind = object.RiesgoIndividual;
            var checkaca = object.RiesgoAcademico;
            var checkfam = object.RiesgoFamiliar;
            var checkeco = object.RiesgoEconomico;
            var checkvuc = object.RiesgoUc;

            $("#idSeguI").val(result.id);
            //alert($("#idSeguI"));
            $('#datfecha').val(fcha);  
            $('#lugar1').val(object.Lugar);       
            $('#hInicio').val(object.HoraInicio); 
            $("#horafin").val(object.HoraFin);
            $("#dcmntOUrl").val(object.urlDocumento);
            $('textarea[id="textobjetivos"]').val(object.Objetivos);
            $('textarea[id="textindividualT"]').val(object.Individual);
            if(checkind == 'alto'){
                $("input[name=checkindi][value='alto']").prop("checked",true);
            }
    
            if(checkind == 'medio') {
              $("input[name=checkindi][value='medio']").prop("checked",true);  
            }
        
            if(checkind == 'bajo') {
              $("input[name=checkindi][value='bajo']").prop("checked",true);   
            }
               
            $('textarea[id="textacademico"]').val(object.Academico); 
              if(checkaca == 'alto'){
            $("input[name=checkacad][value='alto']").prop("checked",true);
            }

            if(checkaca == 'medio') {
              $("input[name=checkacad][value='medio']").prop("checked",true);  
            }
        
            if(checkaca == 'bajo') {
              $("input[name=checkacad][value='bajo']").prop("checked",true);   
            }
            //$('input[name="checkacad"]:checked').val(object.RiesgoAcademico);
            $('textarea[id="textfamiliar"]').val(object.Familiar);        
            if(checkfam == 'alto'){
              $("input[name=checkfami][value='alto']").prop("checked",true);
            }

            if(checkfam == 'medio') {
              $("input[name=checkfami][value='medio']").prop("checked",true);  
            }
        
            if(checkfam == 'bajo') {
              $("input[name=checkfami][value='bajo']").prop("checked",true);   
            }
            //$('input[name="checkfami"]:checked').val(object.RiesgoFamiliar);
            $('textarea[id="texteconomico"]').val(object.Economico);
            if(checkeco == 'alto'){
              $("input[name=checkecono][value='alto']").prop("checked",true);
            }

            if(checkeco == 'medio') {
              $("input[name=checkecono][value='medio']").prop("checked",true);  
            }   
        
            if(checkeco == 'bajo') {
              $("input[name=checkecono][value='bajo']").prop("checked",true);   
            }
              
            $('textarea[id="textvdaunvrstria"]').val(object.VidaUniversitariaYciudad);
            if(checkvuc == 'alto'){
              $("input[name=checkuni][value='alto']").prop("checked",true);
            }

            if(checkvuc == 'medio') {
              $("input[name=checkuni][value='medio']").prop("checked",true);  
            }
        
            if(checkvuc == 'bajo') {
              $("input[name=checkuni][value='bajo']").prop("checked",true);   
            }
            $('textarea[id="textobsrvacnes"]').val(object.Observaciones);
        

            $('#modal_editar').modal('show');

            });

        });

      $('.ver_seguimiento').click(function(e) {
            e.preventDefault();
            
            var row = $(this).parents('tr');
            var id = row.data('id');
            //alert(id);

            var form = $('#form-edit-seguimiento');
            //console.log(form);
            var url = form.attr('action').replace(':SEGUIMIENTO_ID', id);
            console.log(url);
            var data = form.serialize();

            $.get(url, function(result){
            const object = JSON.parse(result.tracking_detail);
        
            var fcha = object.fecha;
            var checkind = object.RiesgoIndividual;
            var checkaca = object.RiesgoAcademico;
            var checkfam = object.RiesgoFamiliar;
            var checkeco = object.RiesgoEconomico;
            var checkvuc = object.RiesgoUc;
            //alert(checkvuc);

            $("#idSeguI").val(object.id);
            $('#datfechaAver').val(fcha);  
            $('#lugar12').val(object.Lugar);       
            $('#hInicioOs').val(object.HoraInicio); 
            $("#horafinNh").val(object.HoraFin);
            $('textarea[id="textobjetivos"]').val(object.Objetivos);
            $('textarea[id="textindividualT"]').val(object.Individual);
            $('#riesIndi').val(checkind);  
            $('textarea[id="textacademico"]').val(object.Academico); 
            $('#rsgAcdmcO').val(checkaca);
            $('textarea[id="textfamiliar"]').val(object.Familiar);
            $('#rsgFmlAr').val(checkfam);
            $('textarea[id="texteconomico"]').val(object.Economico);
            $('#rsgEcnmcO').val(checkeco);
            $('textarea[id="textvdaunvrstria"]').val(object.VidaUniversitariaYciudad);
            $('#rsgvdUnyCdad').val(checkvuc);
            $('textarea[id="textobsrvacnes"]').val(object.Observaciones);
            $('#dcmnto_urL').val(object.urlDocumento);
            
            $('#modal_ver').modal('show');

            });

        });

      $('.boton_delete_seguimiento').click(function(e) {       
       e.preventDefault();

       var row = $(this).parents('tr');
       var id = row.data('id');
       var form = $('#form-delete');
       var url = form.attr('action').replace(':SEGUIMIENTO_ID', id);
       var data = form.serialize();
       
       //alert(id);
       
      $.post(url, data, function(result){
        row.fadeOut();
        toastr.success('Seguimiento eliminado correctamente!!'); 
        //setTimeout("location.reload()", 2000);
       });

      });

});


