/*

	var url = document.getElementById('json').src;
        var asistencias = document.getElementById('asisten').src;
        //console.log(asistencias);
	//var flickerAPI = "https://skyler.profesionalhosting.com:2083/cpsess2822578250/frontend/paper_lantern/filemanager/showfile.html?file=attendancereport_ptuv_15_02_2022.json&fileop=&dir=%2Fhome%2Ftodosytodasaestu%2Ftodosytodasaestudiar.org%2Fpna%2Freportesmoodle&dirop=&charset=&file_charset=&baseurl=&basedir=";
	//console.log(asistencias);
	//alert(flickerAPI);

        var article = document.getElementById('code_curse');
        var id_moodle = document.getElementById('moodle');
        var student_moodle = JSON.parse(id_moodle.dataset.datos);
        var grupo = article.dataset.group.split(" ", 2);
        //console.log(student_moodle);        
        if(grupo[1] < 10 && grupo[1] > 0){
                grupo[1]= '0' + grupo[1];
        }
        //console.log(article.dataset.cohort);       
        if(article.dataset.cohort === '1'){
                var cohort = 'A0';
        }
        if(article.dataset.cohort === '2'){
                var cohort = 'TE';
        }
        if(article.dataset.cohort ==='3'){
                var cohort = 'TS';
        } 
        var form = $('#form-edit');
        const totalsesiones = [];
        $.getJSON(asistencias,function(asis){

                $.each(asis, function(index,value){
                        //console.log(value.userid,index);
                        //console.log(value);
                        for (const j of student_moodle){

                                if(j == value.userid){
                                        //
                                        $.each(value.courses, function(i,course){
                                                var dividir = course.courseshortname.split("-",5);
                                                //console.log(dividir);
                                                if(article.dataset.name == dividir[1] && cohort == dividir[4] && grupo[1] == dividir[2]){
                                                        $.each(course.attendance.fullsessionslog, function(k,attendance){
                                                                //console.log(attendance);
                                                                var fecha_json = new Date(attendance.timestamp * 1000);
                                                                //console.log(fecha_json);
                                                                var fecha_actual = new Date();
                                                                if(fecha_json <= fecha_actual){
                                                                        
                                                                        totalsesiones.push(attendance.sessionid);
                                                                }
                                                                                
                                                        });
                                                }                        
                                        });            
                                }         
                        }
                });

	 $.getJSON(url, function(result){
		
                $.each(result, function(index, value){              
        	        var divisiones = value.shortname.split("-", 5);
                           //console.log(totalsesiones);                     
                        if(article.dataset.name == divisiones[1] && cohort == divisiones[4] && grupo[1] == divisiones[2]){
                                var sesiones = 0;
                                //console.log(value.sessions)
                                for (const i in value.sessions) 
                                {       
                                        var fecha_json = new Date(value.sessions[i].sesstimestamp * 1000);
                                        var fecha_actual = new Date();
                                        //console.log(new Date('feb 26 2022'), fecha_actual);
                                             
                                        if(fecha_json <= fecha_actual){
                                                sesiones++;
                                                var contador=0;
                                                for(const indice of totalsesiones){
                                                        //console.count(indice);
                                                        if(indice == value.sessions[i].id){
                                                                contador++;
                                                                //console.log(value.sessions[i].id);                                                          
                                                        }                                  
                                                }
                                                let div = document.createElement('div');
                                                //div.className += "row ";
                                                let div_2 = document.createElement('div');
                                                div_2.className += "col-xs-12 col-sm-12";
                                                let a = document.createElement('a');
                                                a.className += "btn  btn-sm  fa fa-eye";
                                                a.innerHTML = ' lista';
                                                a.setAttribute('title', 'ver asistencias');
                                                var route = form.attr('action').replace(':SESSIONID', value.sessions[i].id);
                                                //console.log(value);
                                                a.setAttribute("href", route);
                                                let vinculo = document.createElement('a');
                                                vinculo.className +="btn btn-sm fa fa-external-link";
                                                vinculo.setAttribute('title', 'Enlace Campus virtual');
                                                //vinculo.setAttribute('style', 'display:none');
                                                vinculo.innerHTML = "Campus";
                                                vinculo.setAttribute("href", "https://campusvirtual.univalle.edu.co/moodle/mod/attendance/take.php?id=+"+value.instanceid+"&sessionid="+value.sessions[i].id+"&grouptype=0");
                                                vinculo.setAttribute("target", "_blank");
                                                let row_2 = document.createElement('tr');
                                                let row_2_data_1 = document.createElement('td');
                                                row_2_data_1.innerHTML = value.sessions[i].sessdate;
                                                let row_2_data_2 =document.createElement('td');
                                                row_2.setAttribute('id',"987");
                                                row_2_data_2.innerHTML = contador;
                                                let row_2_data_3 = document.createElement('td');
                                                let row_2_data_4 = document.createElement('td');
                                                row_2_data_4.innerHTML = (student_moodle.length - contador);
                                                row_2.appendChild(div);
                                                div_2.appendChild(div); 
                                                row_2.appendChild(row_2_data_1);
                                                row_2.appendChild(row_2_data_2);
                                                row_2.appendChild(row_2_data_4);
                                                row_2.appendChild(row_2_data_3);
                                                row_2_data_3.appendChild(div);
                                                div.appendChild(div_2);
                                                div_2.appendChild(a);
                                                div_2.appendChild(vinculo);
                                                document.getElementById("ddd").appendChild(row_2);                                                
                                        }                                          
                                }
                                //console.log(sesiones);
                                document.getElementById("num_sesiones").append(sesiones);
                                                  
                        }       
                });
                document.getElementById("carga").remove();
               

         });
        
        });
        
        //const filas=document.querySelector("#987");
        //const tr = document.querySelectorAll("#example1 thead tr th");
        //console.log(tr);	


*/  

                 
 $("#example1").DataTable({
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
                        "buttons": ["copy", "csv", "excel", "pdf", "print"]
});
