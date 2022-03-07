/*let desplegar
let sele
let edit
let selector

function habilitar(id) {
    selector = id.toString().trim()
    edit = document.getElementById(`edit${selector}`)
    sele = document.getElementById(`${selector}`)
    desplegar = document.getElementById(`desplegar${selector}`)
    sele.disabled = false;
    edit.hidden = false;
    desplegar.hidden = true;
}*/

function actualizarDato(id) {
    let cel = document.getElementById(`user${id}`)
    let valor = document.getElementById(`userId${id}`)
    //cel.style.backgroundColor="#FFD54F";
    $.ajax({
        url: '/updateDato/' + id,
        type: 'PUT',
        data: {
            '_token': $('input[name=_token]').val(),
            'id_user': valor.value,
        },
        success: function (result) {
            /*desplegar.hidden = false
            edit.hidden = true
            sele.disabled = true*/
            cel.style.backgroundColor="#FFD54F";
            cel.innerHTML = `${result.name} ${result.apellidos_user}`
            toastr.info(`Asignacion guardada exitosamente al usuario ${result.name} ${result.apellidos_user}`);
            console.log(result)
        },
        error:function(result) {          
            console.log(result)       
          },
    });

}