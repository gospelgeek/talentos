const opcion = document.getElementById("opcion")
const linea1 = document.getElementById("linea1")
const linea2 = document.getElementById("linea2")
const linea3 = document.getElementById("linea3")

opcion.addEventListener('change', () => {
    if(opcion.value === "1"){
        
        linea1.removeAttribute('hidden')
        linea2.setAttribute('hidden', '')
        linea3.setAttribute('hidden', '')
    }

    if(opcion.value === "2"){
        
        linea2.removeAttribute('hidden')
        linea1.setAttribute('hidden', '')
        linea3.setAttribute('hidden', '')
    }

    if(opcion.value === "3"){
        
        linea3.removeAttribute('hidden')
        linea1.setAttribute('hidden', '')
        linea2.setAttribute('hidden', '')
    }

})

