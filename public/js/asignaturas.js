(function () {

	var url = document.getElementById('json').src;
	//var flickerAPI = "https://skyler.profesionalhosting.com:2083/cpsess2822578250/frontend/paper_lantern/filemanager/showfile.html?file=attendancereport_ptuv_15_02_2022.json&fileop=&dir=%2Fhome%2Ftodosytodasaestu%2Ftodosytodasaestudiar.org%2Fpna%2Freportesmoodle&dirop=&charset=&file_charset=&baseurl=&basedir=";
	
	//alert(flickerAPI);

        var article = document.getElementById('code_curse');
        var grupo = article.dataset.group.split(" ", 2);
                
        if(grupo[1] < 10 && grupo[1] > 0){
                grupo[1]= '0' + grupo[1];
        }
        //console.log(grupo);       
        if(article.dataset.cohort == 1){
                        var cohort = 'A0';
                }
                if(article.dataset.cohort == 2){
                        var cohort = 'TE';
                }
                if(article.dataset.cohort == 3){
                        var cohort = 'TS';
        } 
        var form = $('#form-edit');
        var route = form.attr('action').replace(':EDIFICIO_ID', article.dataset.id);
        var data = form.serialize();

        let table = document.createElement('table');
        let thead = document.createElement('thead');
        let tbody = document.createElement('tbody');

        table.setAttribute('id','example1')
        table.className += "table table-bordered table-striped";
        table.appendChild(thead);
        table.appendChild(tbody);

        let row_1 = document.createElement('tr');
        let heading_1 = document.createElement('th');
        heading_1.innerHTML = "Fecha";
        let heading_2 = document.createElement('th');
        heading_2.innerHTML = "Accion";

        row_1.appendChild(heading_1);
        row_1.appendChild(heading_2);
        thead.appendChild(row_1);      

        document.getElementById('datos').appendChild(table);

        

	$.getJSON(url, function(result){
		console.log(article.dataset.id); 
                $.each(result, function(index, value){              
        	       var divisiones = value.shortname.split("-", 5);
                
                        if(article.dataset.name == divisiones[1] && cohort == divisiones[4] && grupo[1] == divisiones[2]){

                                for (var i = 0; i < value.sessions.length; i++) 
                                {
                                        //console.log(value.sessions[i].id);
                                        
                                        let div = document.createElement('div');
                                        div.className += "row";
                                        let div_2 = document.createElement('div');
                                        div_2.className += "col-xs-6 col-sm-6";
                                        let a = document.createElement('a');
                                        a.className += "btn btn-block btn-sm  fa fa-eye";
                                        a.innerHTML = ' lista';
                                        a.setAttribute('title', 'ver asistencias');
                                        a.setAttribute("href", route);   
                                        let row_2 = document.createElement('tr');
                                        let row_2_data_1 = document.createElement('td');
                                        row_2_data_1.innerHTML = value.sessions[i].sessdate;
                                        let row_2_data_2 = document.createElement('td');
                                        row_2.appendChild(div);
                                        div_2.appendChild(div); 
                                        row_2.appendChild(row_2_data_1);
                                        row_2.appendChild(row_2_data_2);
                                        row_2_data_2.appendChild(div);
                                        div.appendChild(div_2);
                                        div_2.appendChild(a);
                                        tbody.appendChild(row_2);
                                }       
                        }          
                });

                $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "language": 
                        {
                                "lengthMenu": "Mostrar _MENU_ registros por página",
                                "zeroRecords": "No se encontraron coincidencias",
                                "info": "Página _PAGE_ de _PAGES_",
                                "infoEmpty": "No hay registros disponibles",
                                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                                "search": "Buscar",
                                "paginate":
                                {
                                        "next" : "Siguiente",
                                        "previous": "Anterior"
                                }
                        },
                });    
        });	
})();
  


