const opcion = document.getElementById("opcion")
const linea1 = document.getElementById("linea1")
const linea2 = document.getElementById("linea2")
const linea3 = document.getElementById("linea3")
const cambio = document.getElementById("cambio")
/*
const variacion = document.querySelector("#variacion")
const valor = variacion.querySelectorAll(".valor")
const variacionPor = document.querySelector("#variacionPor")
const valorP = variacionPor.querySelectorAll(".valorP")*/


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

/*cambio.addEventListener('change', () => {

    console.log(cambio.checked)
   if(cambio.checked === true){
        console.log(variacion)
        variacion.forEach(e => {
            e.setAttribute('hidden','')
        })
        variacionPor.forEach(e => {
            e.removeAttribute('hidden')
        })
    }

    if(cambio.checked === false){
        console.log(variacion)
        variacionPor.forEach(e => {
            e.setAttribute('hidden','')
        })
        variacion.forEach(e => {
            e.removeAttribute('hidden')
        })
    }

})*/