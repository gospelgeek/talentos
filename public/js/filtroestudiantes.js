
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
          if(valor == 3 || valor == 2){
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

        
        console.log("ss");
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
          if(valor == 3 || valor == 2){
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
          $("#titulo-4").removeClass("open"); 
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

        $('#mostrarFcA').empty();
    
        var contenido=$(this).next(".accordion-content-4");
        
        
        let array = document.getElementById('detalle').value;
        
        const ver = JSON.parse(array);
        //console.log(ver);
        
        
        $.each(ver, function(index, value) {

            //const datos = JSON.parse(ver[key]);
            console.log(value.tracking_detail);
            const mostar = JSON.parse(value.tracking_detail);
            console.log(mostar);   
            //texto +=datos.fecha;

            $('#mostrarFcA').append('<tr data-id='+value.id+'>'+"<td>"+mostar.fecha+"</td>"+
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
                    "</td>"+"</tr>");
 
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
            console.log(result.id);
            var fcha = object.fecha;
            var checkind = object.RiesgoIndividual;
            var checkaca = object.RiesgoAcademico;
            var checkfam = object.RiesgoFamiliar;
            var checkeco = object.RiesgoEconomico;
            var checkvuc = object.RiesgoUc;
            //alert(checkvuc);

            $("#idSeguI").val(result.id);
            //alert($("#idSeguI"));
            $('#datfecha').val(fcha);  
            $('#lugar1').val(object.Lugar);       
            $('#hInicio').val(object.HoraInicio); 
            $("#horafin").val(object.HoraFin);
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
        //console.log(value);
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
                    /*document.getElementById("carga2").remove();*/
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
/*$(function() {
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
            document.getElementById('carga').remove();
            //console.log("s");
            break;
    }
}*/

