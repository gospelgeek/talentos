function actualizarDato(id) {
    let cel = document.getElementById(`user${id}`)
    let valor = document.getElementById(`userId${id}`)
    
    let name = document.getElementById(`nameapel${id}`)
    $.ajax({
        url: '/updateDato/' + id,
        type: 'PUT',
        data: {
            '_token': $('input[name=_token]').val(),
            'id_user': valor.value,
        },
        success: function (result) {
            //cel.style.backgroundColor="#FFD54F";
            name.style.backgroundColor="#FFD54F"
            name.innerHTML=`<td>${result.name} ${result.apellidos_user}</td>`
            toastr.info(`Asignacion guardada exitosamente al usuario ${result.name} ${result.apellidos_user}`);
        },
        error:function(result) {          
           toastr.info('Ocurrio un error inesperado :(')       
          },
    });

}