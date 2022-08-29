$('.crear_estado').click(function(e) { 
      e.preventDefault();
        var valor = $('#estadoN').val();
          //console.log(valor)
          if(valor == ""){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').hide();
          }
          if(valor == 3 || valor == 2 || valor == 5){
            $('#CMotivo').show();
            $('#Cobservacion').show();
            $('#CUrl').show();
            $('#CBoton').show();
            $('#Cfecha').show();
          }
          if(valor == 4){
            $('#Cobservacion').show();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').show();               
          }
          if(valor == 1){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').hide();
          } 

        
        //console.log("ss");
        $('#modal_crear_estado').modal('show'); 
});

 $('#estadoN').on('change',function(event) {
          var valor = $('#estadoN').val();
          //console.log(valor)
          if(valor == ""){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').hide();
          }
          if(valor == 3 || valor == 2 || valor == 5){
            $('#CMotivo').show();
            $('#Cobservacion').show();
            $('#CUrl').show();
            $('#CBoton').show();
            $('#Cfecha').show();
          }
          if(valor == 4){
            $('#Cobservacion').show();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').show();               
          }
          if(valor == 1){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            $('#Cfecha').hide();
          }
 });

//actualizar estado y crear retiro 

$('.boton_update_estado').click(function(e) { 
  e.preventDefault();   
  var idEstado = $('#idE').val();
  var estado = $("#estadoN").val();
  var fecha = $('#Cfecha').val();
  var observation = $('#Cobservacion').val();
  //alert(observation)
  if(fecha != "" && estado != 1 && observation != ""){
    $.ajax({
      //ruta manual
      url:'/update_estado/'+ idEstado,
      type:'PUT',
      data:{
        '_token': $('input[name=_token]').val(),
        'id_state': $("#estadoN").val(),
        'id_reasons': $("#CMotivo").val(),
        'observation': $("#Cobservacion").val(),
        'url':         $("#CUrl").val(),
        'fecha':       $("#Cfecha").val(),
      },
      success:function(msj) {
        $('#modal_crear_estado').modal('hide');
        //window.location.reload(); 
        toastr.success('Actualizado Correctamente!!');
        //setTimeout("location.replace('/estudiantes/estado')", 2000);
      },
      error:function(msj) {          
        var mensajeError = "";
        $.each(msj.responseJSON.errors,function(i,field){
          mensajeError += "<li>"+field+"</li>"
          //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
          console.log(mensajeError)
        });
        $("#msj-error-en-estado").html("<ul>"+mensajeError+"</ul>").fadeIn();         
      },       
    });
  }else{
    if(estado != 1){
      if(fecha == ""){
        var campo1 = document.getElementById("Cfecha");
        campo1.style.borderColor = "red";
        toastr.error('!!El campo FECHA es obligatorio!!');
      }
      if(observation == ""){
        var campo = document.getElementById("Cobservacion");
        campo.style.borderColor = "red";
        toastr.error('!!El campo OBSERVACION es obligatorio!!');
      }
      
    }    
    else{
      $.ajax({
      //ruta manual
      url:'/update_estado/'+ idEstado,
      type:'PUT',
      data:{
        '_token': $('input[name=_token]').val(),
        'id_state': $("#estadoN").val(),
        'id_reasons': $("#CMotivo").val(),
        'observation': $("#Cobservacion").val(),
        'url':         $("#CUrl").val(),
        'fecha':       $("#Cfecha").val(),
      },
      success:function(msj) {
        $('#modal_crear_estado').modal('hide');
        //window.location.reload(); 
        toastr.success('Actualizado Correctamente!!');
        //setTimeout("location.replace('/estudiantes/estado')", 2000);
      },
      error:function(msj) {          
        var mensajeError = "";
        $.each(msj.responseJSON.errors,function(i,field){
          mensajeError += "<li>"+field+"</li>"
          //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
          console.log(mensajeError)
        });
        $("#msj-error-en-estado").html("<ul>"+mensajeError+"</ul>").fadeIn();         
      },       
    });
    }
  }
});

$("#Cfecha").on('change',function(event) {
    var fecha = $('#Cfecha').val();
    if(fecha != ""){
      var campo = document.getElementById("Cfecha");
      campo.style.borderColor = "#CED4DA";
    }
});

$("#Cobservacion").on('change',function(event) {
    var observacion = $('#Cobservacion').val();
    if(observacion != ""){
      var campo = document.getElementById("Cobservacion");
      campo.style.borderColor = "#CED4DA";
    }
});


$(".accordion-titulo-1").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-1");

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open");
          $("#contenido-4").hide();
          $("#titulo-4").removeClass("open");
          $("#contenido-5").hide();
          $("#titulo-5").removeClass("open");
          $("#contenido-6").hide();
          $("#titulo-6").removeClass("open");  
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");
        }
        else{ //close       
          contenido.slideUp(250);
          $(this).removeClass("open");  
        }
});

$(".accordion-titulo-2").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-2");

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open"); 
          $("#contenido-4").hide();
          $("#titulo-4").removeClass("open");
          $("#contenido-5").hide();
          $("#titulo-5").removeClass("open");
          $("#contenido-6").hide();
          $("#titulo-6").removeClass("open"); 
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");
        }
        else{ //close       
          contenido.slideUp(250);
          $(this).removeClass("open");  
        }
});

$(".accordion-titulo-3").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-3");
 

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open");
          $("#contenido-4").hide();
          $("#titulo-4").removeClass("open");
          $("#contenido-5").hide();

          $("#titulo-5").removeClass("open"); 

          $("#contenido-6").hide();
          $("#titulo-6").removeClass("open");
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");
        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
          
            
        }
});

$(".accordion-titulo-4").click(function(e){
           
        e.preventDefault();
        var contenido=$(this).next(".accordion-content-4");
        //$('#mostrarFcA').empty();
         
        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open");
          $("#contenido-5").hide();
          $("#titulo-5").removeClass("open");
          $("#contenido-6").hide();
          $("#titulo-6").removeClass("open");  
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");

        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
            
        }


});

$(".accordion-titulo-6").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-6");
    
         if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open"); 
          $("#contenido-4").hide();
          $("#titulo-4").removeClass("open");

          $("#contenido-5").hide();
          $("#titulo-5").removeClass("open");  
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");

        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
          
            
        }
});

$(".accordion-titulo-5").click(function(e){
        
        e.preventDefault();
  
        var contenido=$(this).next(".accordion-content-5");
 

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open");
          $("#contenido-4").hide();
          $("#titulo-4").removeClass("open");
          $("#contenido-6").hide();
          $("#titulo-6").removeClass("open");
          $("#contenido-7").hide();
          $("#titulo-7").removeClass("open");
        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
                    
        }
});

$(".accordion-titulo-7").click(function(e){
        
  e.preventDefault();

  var contenido=$(this).next(".accordion-content-7");


  if(contenido.css("display")=="none"){ //open        
    contenido.slideDown(250);         
    $(this).addClass("open");
    $("#contenido-1").hide();
    $("#titulo-1").removeClass("open");
    $("#contenido-2").hide();
    $("#titulo-2").removeClass("open");
    $("#contenido-3").hide();
    $("#titulo-3").removeClass("open");
    $("#contenido-4").hide();
    $("#titulo-4").removeClass("open");
    $("#contenido-5").hide();
    $("#titulo-5").removeClass("open");
    $("#contenido-6").hide();
    $("#titulo-6").removeClass("open"); 
      
  }
  else{ //close

    contenido.slideUp(250);
    $(this).removeClass("open");
              
  }
});

function abrir_modal(attendance_id,id_moodle){
        //alert(attendance_id,id_moodle)
        
        $.get("/detalle_sesiones_ficha/"+attendance_id+"/"+id_moodle+"",function(response,municipios){
            //console.log(response)
            //$("#sesiones").load(" #sesiones > *");
            if(response.length == 0){
                alert("ESTE CURSO NO TIENE SESIONES REGISTRADAS EN EL SISTEMA")
            }else{
                $('#mensaje').append(response[0].curso);
                $.each(response,function(index,sesiones){
                    //console.log(sesiones)
                    let i = document.createElement('i');
                    let h6 = document.createElement('h6');
                    
                    if(sesiones.asistio && sesiones.lasttaken != null){
                        h6.innerHTML = "SI";
                        i.className += "btn  btn-sm  fa fa-check";
                        i.setAttribute('style', "color: #2ECC71");
                    }else if(!sesiones.asistio && sesiones.lasttaken !=null){
                        h6.innerHTML = "NO";
                        i.className += "btn  btn-sm  fa fa-times";
                        i.setAttribute('style', "color: red");
                    }else{
                        i.className += "btn  btn-sm  fa fa-minus";
                        i.setAttribute('style', "color: gray");
                    }
                    h6.appendChild(i);
                    let row_2 = document.createElement('tr');
                    let row_2_data_1 = document.createElement('td');
                    let row_2_data_2 = document.createElement('td');
                    row_2_data_1.innerHTML = sesiones.sessdate;
                    row_2_data_2.appendChild(h6);
                    row_2.appendChild(row_2_data_1);
                    row_2.appendChild(row_2_data_2);
                    document.getElementById("sesiones").appendChild(row_2);
                });
                $("#sesiones_tabla").DataTable({
                            "processing": true,
                            "LoadingRecords":true,
                            "paging": true,
                            "deferRender": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "order": [ 0, 'desc'],
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                            },
                            "dom": 'Bfrtip',
                            "buttons": ["copy","excel", "pdf", "print"]
                });
                $('#modal_asistencias').modal('show');
            }
        });
           
    }

function cerrar_modal(){
  $("#recargar").load(" #recargar > *");
  $('#modal_asistencias').modal('hide');
}

$(function() {
    // Crear un objeto URL con la ubicación de la página
    let url = new URL(window.location.href);
    // Busca si existe el parámetro
    let cancha = url.searchParams.get('css');
    //console.log(url);
    if(cancha) {
        // Si se encontró, entonces ejecuta la función
        tipoCancha(cancha);
    }
});

function tipoCancha(deporteSel){
    switch(deporteSel){
        case 'titulo-5':
            //var contenido=$(this).next(".accordion-content-5");
            $('.accordion-content-5').slideDown(250);         
            $('.accordion-titulo-5').addClass("open");
            //document.getElementById('carga').remove();
            //console.log("s");
            break;
        case 'titulo-4':
            //var contenido=$(this).next(".accordion-content-7");
            $('.accordion-content-4').slideDown(250);         
            $('.accordion-titulo-4').addClass("open");
            
            //console.log("s");
            break;
        case 'titulo-7':
            
            $('.accordion-content-7').slideDown(250);         
            $('.accordion-titulo-7').addClass("open");
            
            break;
        case 'titulo-6':
            //var contenido=$(this).next(".accordion-content-7");
            $('.accordion-content-6').slideDown(250);         
            $('.accordion-titulo-6').addClass("open");
            
            //console.log("s");
            break;
    }
}

$("#asistencias").DataTable({
            "ajax":{

                "method":"GET",
                "url": "../asistencias_ficha",
                "data": function(d){
                    var url = window.location.pathname;
                    var id = url.split("/",3);
                    d.id_student = id[2];             
                },            
            },
            "columns": [
                {data: 'fullname'},
                {data: 'cant_sesiones'},
                {data: 'asistencia'},
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr ='<a type="button" onclick="abrir_modal('+data.attendance_id+','+data.id_moodle+');"><i class="fa fa-eye" aria-hidden="true"></i>Detalles</a>'; 
                    return mstr;
                  }
                }    
            ],
            "footerCallback": function( tfoot, data, start, end, display ) {
              var api = this.api();
              $( api.column( 1 ).footer() ).html(
                api.column( 1 ).data().reduce( function ( a, b ) {
                  return a + b;
                }, 0 )
              );
              $( api.column( 2 ).footer() ).html(
                api.column( 2 ).data().reduce( function ( a, b ) {
                  return a + b;
                }, 0 )
              );
            },
            "deferRender": true,"responsive": true,"processing": true,'serverSider':true, 'stateSave': true,
            "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                {
                extend: 'excelHtml5',
                autoFilter: true
                }, 
                "pdf",
                "print",
                "colvis"
                
            ],
            "fixedHeader": {
            header: true,
            footer: true
            }
}); 


