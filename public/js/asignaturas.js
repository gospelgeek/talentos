(function () {

	var url = document.getElementById('json').src;
        var asistencias = document.getElementById('asisten').src;
        //console.log(asistencias);
	//var flickerAPI = "https://skyler.profesionalhosting.com:2083/cpsess2822578250/frontend/paper_lantern/filemanager/showfile.html?file=attendancereport_ptuv_15_02_2022.json&fileop=&dir=%2Fhome%2Ftodosytodasaestu%2Ftodosytodasaestudiar.org%2Fpna%2Freportesmoodle&dirop=&charset=&file_charset=&baseurl=&basedir=";
	//console.log(asistencias);
	//alert(flickerAPI);

        var article = document.getElementById('code_curse');
        var grupo = article.dataset.group.split(" ", 2);
        //console.log(grupo);        
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
        
        //alert(route);

        let table = document.createElement('table');
        let thead = document.createElement('thead');
        let tbody = document.createElement('tbody');

        table.setAttribute('id','example1');
        table.className += "table table-bordered table-striped";
        table.appendChild(thead);
        table.appendChild(tbody);

        let row_1 = document.createElement('tr');
        let heading_1 = document.createElement('th');
        heading_1.innerHTML = "Fecha";
        let heading_2 = document.createElement('th');
        heading_2.innerHTML = "Asistentes";
        let heading_3 = document.createElement('th');
        heading_3.innerHTML = "Accion";
        heading_3.setAttribute('style', "width:15%");

        row_1.appendChild(heading_1);
        row_1.appendChild(heading_2);
        row_1.appendChild(heading_3);
        thead.appendChild(row_1);      

        document.getElementById('datos').appendChild(table);
        let totalasistencias = [];
        $.getJSON(asistencias,function(asis){
                //console.log(asis);
                $.each(asis, function(index,value){
                        //console.log(value.courses);
                        $.each(value.courses, function(i,course){
                                //console.log(course.attendance.fullsessionslog);
                                $.each(course.attendance.fullsessionslog, function(k,attendance){
                                        //console.log(attendance.sessionid);
                                                 totalasistencias.push(attendance.sessionid);
                                        
                                });     
                               
                        });
                });
                //console.log(totalasistencias);
	 $.getJSON(url, function(result){
		
                $.each(result, function(index, value){              
        	        var divisiones = value.shortname.split("-", 5);
                           //console.log(totalasistencias);                     
                        if(article.dataset.name == divisiones[1] && cohort == divisiones[4] && grupo[1] == divisiones[2]){
                                var sesiones = 0;
                                for (const i in value.sessions) 
                                {       
                                        var fecha_json = new Date(value.sessions[i].sesstimestamp * 1000);
                                        var fecha_actual = new Date();
                                             
                                        if(fecha_json <= fecha_actual){
                                                sesiones++;
                                                var contador=0;
                                                for(const indice of totalasistencias){
                                                        console.log(indice);
                                                        if(indice == value.sessions[i].id){
                                                                contador++;
                                                                console.log(value.sessions[i].id);                                                          
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
                                                a.setAttribute("href", route);
                                                let vinculo = document.createElement('a');
                                                vinculo.className +="btn btn-sm fa fa-external-link";
                                                vinculo.setAttribute('title', 'Enlace Campus virtual');
                                                vinculo.innerHTML = "Campus";
                                                vinculo.setAttribute("href", "https://campusvirtual.univalle.edu.co/moodle/mod/attendance/take.php?id=1465667&sessionid="+value.sessions[i].id+"&grouptype=0");
                                                vinculo.setAttribute("target", "_blank");
                                                let row_2 = document.createElement('tr');
                                                let row_2_data_1 = document.createElement('td');
                                                row_2_data_1.innerHTML = value.sessions[i].sessdate;
                                                let row_2_data_2 =document.createElement('td');
                                                row_2.setAttribute('id',value.sessions[i].id);
                                                row_2_data_2.innerHTML = contador;
                                                let row_2_data_3 = document.createElement('td');
                                                row_2.appendChild(div);
                                                div_2.appendChild(div); 
                                                row_2.appendChild(row_2_data_1);
                                                row_2.appendChild(row_2_data_2);
                                                row_2.appendChild(row_2_data_3);
                                                row_2_data_3.appendChild(div);
                                                div.appendChild(div_2);
                                                div_2.appendChild(a);
                                                div_2.appendChild(vinculo);
                                                tbody.appendChild(row_2);                                                
                                        }                                          
                                }
                                //console.log(sesiones);
                                document.getElementById("num_sesiones").append(sesiones);     
                        }       
                });

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
         });
        });	
})();
  


