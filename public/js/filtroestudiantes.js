$('.crear_estado').click(function(e) { 
      e.preventDefault();
        var valor = $('#estadoN').val();
          //console.log(valor)
          if(valor == ""){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
          }

          if(valor == 3 || valor == 2 || valor == 5){

            $('#CMotivo').show();
            $('#Cobservacion').show();
            $('#CUrl').show();
            $('#CBoton').show();
          }
          if(valor == 4){
            $('#Cobservacion').show();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();               
          }
          if(valor == 1){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
          } 

        

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
          }

          if(valor == 3 || valor == 2 || valor == 5){
            $('#CMotivo').show();
            $('#Cobservacion').show();
            $('#CUrl').show();
            $('#CBoton').show();
          }
          if(valor == 4){
            $('#Cobservacion').show();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();               
          }
          if(valor == 1){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
          }
 });

//actualizar esatdo y crear retiro 

  $('.boton_update_estado').click(function(e) { 
  e.preventDefault();   
  var idEstado = $('#idE').val();
  //alert($("#estadoN").val());
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
    },
    success:function(msj) {
      $('#modal_crear_estado').modal('hide');
      //window.location.reload(); 
      toastr.success('Actualizado Correctamente!!');
      setTimeout("location.replace('/estudiante')", 2000);
    },

    error:function(msj) {          
      var mensajeError = "";
      $.each(msj.responseJSON.errors,function(i,field){
        mensajeError += "<li>"+field+"</li>"
        //$("#msj").append("<ul><li>"+field.errors.calendario_nombre+"</li><li>"+field.errors.calendario_semestre+"</li></ul>");   
        console.log(mensajeError)
      });
      $("#msj-error-agendamiento").html("<ul>"+mensajeError+"</ul>").fadeIn();         
    },       
  });
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

var id_moodle= document.getElementById("moodle");
var url = document.getElementById('json').src;
var asistencias = document.getElementById('asisten').src;

$.getJSON(asistencias, function(asistencias){
    var totalasistencias=0;
    $.each(asistencias, function(index,value){
      //console.log(value.userid, id_moodle)
        if(value.userid == id_moodle.dataset.id){
        //console.log(value.courses);
        $.each(value.courses , function(i, courses){
          //console.log(courses.coursefullname);
          var tr = document.createElement('tr');
          tr.setAttribute('id',courses.courseid)
          tr.classList.add('prueba');
          var td_asignatura = document.createElement('td');      
          td_asignatura.innerHTML = courses.coursefullname;
          var td_sesiones = document.createElement('td');
          //console.log(document.getElementById(courses.courseid))
          td_sesiones.setAttribute('id', courses.courseid+"sesiones")
          var td_asistencias = document.createElement('td');
          td_asistencias.innerHTML = courses.attendance.takensessionssumary.numtakensessions;
          td_asistencias.setAttribute('id', courses.courseid+"asistencias")
          td_asistencias.setAttribute('data-id', courses.attendance.takensessionssumary.numtakensessions)
          var td_faltas = document.createElement('td');
          td_faltas.setAttribute('id', courses.courseid+"faltas");
          var td_acciones = document.createElement('td');
          td_acciones.innerHTML = '<a id="'+courses.courseid+'" type="button" onclick="abrirmodal(this);"><i class="fa fa-eye" aria-hidden="true"></i>Detalles</a>';
          tr.appendChild(td_asignatura);
          tr.appendChild(td_sesiones);
          tr.appendChild(td_asistencias);
          tr.appendChild(td_faltas);
          tr.appendChild(td_acciones);
          document.getElementById('insertar').appendChild(tr);
          totalasistencias = totalasistencias + parseInt(courses.attendance.takensessionssumary.numtakensessions);
        });
        }
        
    });
    document.getElementById('totalasistencias').innerHTML = totalasistencias;
});

$(".accordion-titulo-5").click(function(e){
        const course_id = [];
        $('.prueba').each(function(){
          //console.log($(this).attr("data-id"));
          course_id.push($(this).attr("id"));

        }); 
        let result = course_id.filter((item,index)=>{
             return course_id.indexOf(item) === index;
        })
        //console.log(result);

        
        $.getJSON(url, function(sesiones){
            //console.log(sesiones);
            var totalfaltas =0;
            var totalsesiones=0;
            $.each(sesiones, function(index, value){
              //console.log(value.fullname)
              for (const j of result){
                if(value.courseid == j){
                  contador=0;
                  $.each(value.sessions, function(i, sesion){
                    var fecha_actual = new Date();
                    var fecha_json = new Date(sesion.sesstimestamp * 1000);
                    //console.log(fecha_actual, fecha_json);
                    
                    if(fecha_json <= fecha_actual){
                      contador++;
                    } 
                    
                  });
                  //console.log(contador);
                  //document.getElementById(value.courseid+"sesiones").remove();
                  document.getElementById(value.courseid+"sesiones").innerHTML = contador;
                  var faltas= document.getElementById(value.courseid+"asistencias");
                  totalfaltas = totalfaltas + (contador -  faltas.dataset.id);
                  totalsesiones = totalsesiones+contador;
                  //console.log(totalsesiones,value);
                  document.getElementById(value.courseid+"faltas").innerHTML = contador -  faltas.dataset.id; 
                }

              }   
            });
            document.getElementById('totalsesiones').innerHTML = totalsesiones;
            document.getElementById('totalfaltas').innerHTML = totalfaltas;
            document.getElementById("carga").remove();
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
            
        });   
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
function abrirmodal(id){

  $('#sesiones').empty();
  $.getJSON(asistencias, function(asistencias){
    $.each(asistencias, function(index,value){
      if(value.userid == id_moodle.dataset.id){
        $.each(value.courses , function(i, courses){
          if(courses.courseid == $(id).attr("id")){
            //console.log(courses.attendance.fullsessionslog);
            const session_id = [];
            $.each(courses.attendance.fullsessionslog, function(key,idsession){
              session_id.push(idsession.sessionid);
            });
            //console.log(session_id);
            $.getJSON(url, function(result){
                $.each(result, function(j,cursos){
                  if(cursos.courseid == $(id).attr("id")){
                    $.each(cursos.sessions, function(k,session){
                      //console.log(session);
                      var fecha_actual = new Date();
                      var fecha_json = new Date(session.sesstimestamp * 1000);
                      if(fecha_json <= fecha_actual){
                        var tr = document.createElement('tr');
                        tr.setAttribute('class', 'asistencias');
                        tr.setAttribute('id',session.id);
                        var td_sesiones = document.createElement('td');
                        td_sesiones.innerHTML = session.sessdate;
                        var td_asistio = document.createElement('td');
                        td_asistio.innerHTML = 'No Asistio<i style="color: red; text-align: center;" class="fa fa-times" aria-hidden="true"></i>';
                        for(const i in session_id){
                          if(session.id == session_id[i]){
                            td_asistio.innerHTML = 'Asistio<i style="color: #2ECC71" text-align: center;" class="fa fa-check" aria-hidden="true"></i>';
                          }
                        }              
                        tr.appendChild(td_sesiones);
                        tr.appendChild(td_asistio);
                        document.getElementById("sesiones").appendChild(tr);
                      }
                      
                    });

                  //document.getElementById("carga2").remove();

                  }
                })
            });
            document.getElementById("mensaje").innerHTML = 'ASISTENCIAS POR SESION'+' '+'<br>'+courses.coursefullname;

          }
          
        });
      }
    });

  });
  $('#modal_asistencias').modal('show');
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
        case 'titulo-7':
            //var contenido=$(this).next(".accordion-content-7");
            $('.accordion-content-7').slideDown(250);         
            $('.accordion-titulo-7').addClass("open");
            
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
