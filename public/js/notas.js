    const id_student = [];
    $('.prueba').each(function(){
          id_student.push($(this).attr("data-id"));
    }); 
    //console.log(id_student);
    var fecha=new Date(1644930000 * 1000);
    //document.getElementById('fecha').innerHTML = fecha.toJSON().split('-')[2].split('T')[0] +"-"+fecha.toJSON().split('-')[1]+"-"+fecha.toJSON().split('-')[0]+" "+fecha.toTimeString().split('G')[0];
    document.getElementById('fecha_sesion').innerHTML = '<h3>'+"Fecha de la sesion: "+'<br>'+fecha.toJSON().split('-')[2].split('T')[0] +"-"+fecha.toJSON().split('-')[1]+"-"+fecha.toJSON().split('-')[0]+" "+fecha.toTimeString().split('G')[0]+'</h3>';
    console.log(fecha.toJSON());
    var asistencias = document.getElementById('asisten').src;
    var sesiones = document.getElementById('notas'); 
    const asistio=[];
    var json2= "students.json";
    //console.log(asistencias);
    $.getJSON(asistencias, function(result){
      //console.log(id_student);
      //console.log(result);
      $.each(result, function(index,values){ 
        
        for (const j of id_student){
          //console.log(j);
          //console.log(result[i].userid);
          if(j == result[index].userid){
                //console.log(result[index].userid);
                $.each(values.courses,function(contador, courses){
                    $.each(courses.attendance.fullsessionslog, function(course, attendance){
                          //console.log(attendance);
                          if(sesiones.dataset.session == attendance.sessionid){
                            //console.log(attendance);
                            //console.log(sesiones.dataset.session);
                            asistio.push(result[index].userid);
                          }
                    });
                });
          }
        
        }
          //console.log(values.courses);
          
      });

      //console.log(asistio);
      //var fecha_json = new Date(1644930000 * 1000).toString();
      //console.log(fecha_json);

      $('.prueba').each(function(){

          for(const id in asistio)
          {
            //console.log($(this).attr("id"),"compara",id,"  ",asistio[id]);
            if($(this).attr("data-id") == asistio[id]){
              //console.log($(this).attr("data-id"), " : ", asistio[id])
              document.getElementById(asistio[id]).innerHTML = 'Asistio<i style="color: #2ECC71" class="fa fa-check" aria-hidden="true"></i>';
            }
          }
      }); 
      document.getElementById("carga").remove();
      $("#example1").DataTable({
            "orderCellsTop": true,
            "processing": true,
            "paging": false,
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
                        exportOptions: {
                                        modifier: {
                                                    page: 'current',

                                                  }
                                        }
                      },
                      {
                        extend: 'pdf',
                        text: 'EXPORTAR PDF',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                      {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                                        modifier: {
                                                    page: 'current'
                                                  }
                                        }
                      },
                    ]
      });
    });

    

