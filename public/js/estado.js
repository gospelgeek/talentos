//Editar estado desde la vista estudiantes estado 23
function abrirmodal(e) {
       var url_retiro = document.createElement('a');
       url_retiro.setAttribute('id', 'CBoton');
       url_retiro.setAttribute('href'," ");
       url_retiro.setAttribute('target', '_blank')         
       //var row = $(this).parents('tr');
       //console.log(row);
       var id = $(e).attr("id"); 
       //console.log(id);
       var form = $('#form-edit');
       var url = form.attr('action').replace(':ESTADO_ID', id);
       //console.log(url);
       var data = form.serialize();

       $.get(url, function(result){

        //alert(result);
        //console.log(result[0]);
          //document.getElementById('modal_crear_estado').reset();
          if(result[0].id_state == 1){
            $('#Cobservacion').hide();
            $('#CMotivo').hide();
            $('#CUrl').hide();
            $('#CBoton').hide();
            var valor = $('#estadoN').val();
            //console.log(valor)
            $('#idE').val(result[0].id);
            $("#estadoN").val(result[0].id_state); 
            $('#modal_crear_estado').modal('show');
          }else{
                $("#estadoN").val(result[0].id_state);     
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
                  $('#idE').val(result[0].id); 
                  $("#CMotivo").val(result[0].withdrawals.id_reasons);
                  $("#CUrl").val(result[0].withdrawals.url);

                  if(result[0].withdrawals.url != null){
                    document.getElementById('CBoton').setAttribute('href', result[0].withdrawals.url);
                  }else{
                      //console.log("entro");
                      $('#CBoton').hide();
                  }
                  $("#Cobservacion").val(result[0].withdrawals.observation);
                }
                if(valor == 4){
                  $('#idE').val(result[0].id);
                  $("#Cobservacion").val(result[0].withdrawals.observation);
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
          }
          

       });
};

$("#estadoN").on('change',function(event) {
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
      setTimeout("location.replace('/estudiantes/estado')", 2000);
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
            "order": [[5,'dsc']],
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
                                                    page: 'all',

                                                  }
                                        }
                      },
                      {
                        extend: 'pdf',
                        text: 'EXPORTAR PDF',
                        exportOptions: {
                                        modifier: {
                                                    page: 'all'
                                                  }
                                        }
                      },
                      {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                                        modifier: {
                                                    page: 'all'
                                                  }
                                        }
                      },
                    ]
      });

      

