$("#example1").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
            });

$(document).ready(function(){
  //window.location.reload(false);
    const id_student = [];
    $('.prueba').each(function(){
          id_student.push($(this).attr("data-id"));
    }); 
     
    //console.log(id_student);
    var fecha=new Date().toISOString();
    var partirfecha= fecha.split("-",3)
    var dia = partirfecha[2].split("T",2);
    const namejson = "attendancereport_ptuv_"+dia[0]+"_"+partirfecha[1]+"_"+partirfecha[0]+".json";

    var asistencias = document.getElementById('asisten').src;
    var sesiones = document.getElementById('notas'); 
    var asistio=[];
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
                          console.count(attendance.sessionid);
                          if(sesiones.dataset.session == attendance.sessionid){
                            //console.count(attendance.sessionid);
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
      
      $('.prueba').each(function(){

          for(const id in asistio)
          {
            //console.log($(this).attr("id"),"compara",id,"  ",asistio[id]);
            if($(this).attr("data-id") == asistio[id]){
              console.log($(this).attr("data-id"), " : ", asistio[id])
              document.getElementById(asistio[id]).innerHTML = '<i style="color: #2ECC71" class="fa fa-check" aria-hidden="true"></i>';
            }
          }
      }); 
    });   
});

