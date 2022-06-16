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


$(".accordion-titulo").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content");

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


        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
            
        }


});

$(".accordion-titulo-6").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-6");

$('#mostrar_registros').empty();
        $('#inputs').empty();
        $('#nuevo_registro').removeClass('disabled');  
    
        $(function () {
          $('#aceptacion_check').change(function(event)
          {
            
            var checkAcptacon = $('#aceptacion_check').is(":checked");
            if(checkAcptacon) {
              document.getElementById('acceptancev2').disabled = false;

            }else{
              document.getElementById('acceptancev2').disabled = true;

            }
                    
      
          });
        });

      $(function () {
          $('#tablet_check').change(function(event)
          {
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
      //

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
      let array = document.getElementById('apoyos').value;

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
      //
     
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
$(document).ready(function()
{
  //Defino los totales de mis 2 columnas en 0
  var total_col1 = 0;
  var total_col2 = 0;
  //Recorro todos los tr ubicados en el tbody
  $('#example1 tbody').find('tr').each(function (i, el) {
             
        //Voy incrementando las variables segun la fila ( .eq(0) representa la fila 1 )     
        total_col1 += parseFloat($(this).find('td').eq(1).text());
        total_col2 += parseFloat($(this).find('td').eq(2).text());
                
    });
    //Muestro el resultado en el th correspondiente a la columna
    $('#totalsesiones').text(total_col1);
    $('#totalasistencias').text(total_col2);

});
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
    }
}

$("#example1").DataTable({
            "orderCellsTop": true,
            "processing": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            buttons: [     
                      {
                        extend: 'excel',
                        text: 'EXPORTAR EXCEL',
                        footer: 'true',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current',

                                                  }
                                        }
                      },
                      {
                        extend: 'pdf',
                        text: 'EXPORTAR PDF',
                        footer: 'true',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                      {
                        extend: 'print',
                        text: 'Imprimir',
                        footer: 'true',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                    ]
}); 
