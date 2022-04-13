// canvas normales por linea
const lsex = document.getElementById('sexolineas').getContext('2d');
const ledad = document.getElementById('edadlineas').getContext('2d');
const lanioGraduacion = document.getElementById('anioGraduacion').getContext('2d');
const licfesPuntaje =  document.getElementById('icfesPuntajeLinea').getContext('2d');
const lestadoCivil =  document.getElementById('estadoCivilLinea').getContext('2d');
const letnia =  document.getElementById('etniaLinea').getContext('2d');
const locupacion =  document.getElementById('ocupacionLinea').getContext('2d');
const lhijos = document.getElementById('hijosLinea').getContext('2d');
const lregimen = document.getElementById('regimenLinea').getContext('2d');
const lsisben =  document.getElementById('sisbenLinea').getContext('2d');
const lbeneficios = document.getElementById('beneficiosLinea').getContext('2d');
const linternetzona =  document.getElementById('internetZonaLinea').getContext('2d');
const linternethome = document.getElementById('internetHogarLinea').getContext('2d');
const lsocialcondicion = document.getElementById('condicionSocialLinea').getContext('2d');
const ldiscapacidad = document.getElementById('discapacidadLinea').getContext('2d');

// generales canvas
const gsexo = document.getElementById('sexoGeneral').getContext('2d');
const gedad = document.getElementById('edadGeneral').getContext('2d')
// botones

const line1 = document.getElementById('linea1')
const line2 = document.getElementById('linea2')
const line3 = document.getElementById('linea3')
const generales = document.getElementById('generales')

// vistas
const cohorte1 = document.getElementById('cohorte1')
const cohorte2 = document.getElementById('cohorte2')
const cohorte3 = document.getElementById('cohorte3')
const cohorte4 = document.getElementById('cohorte4')
const cohorte5 = document.getElementById('cohorte5')

function hiddenGraficas() {
    cohorte1.setAttribute('hidden', '')
    cohorte2.setAttribute('hidden', '')
    cohorte3.setAttribute('hidden', '')
    cohorte4.setAttribute('hidden', '')
    cohorte5.setAttribute('hidden', '')
}

function removeHiddenGraficas() {
    cohorte1.removeAttribute('hidden')
    cohorte2.removeAttribute('hidden')
    cohorte3.removeAttribute('hidden')
    cohorte4.removeAttribute('hidden')
    cohorte5.removeAttribute('hidden')
}

// general
const gen1 = document.getElementById('gen1')
const gen2 = document.getElementById('gen2')
const gen3 = document.getElementById('gen3')
const gen4 = document.getElementById('gen4')
const gen5 = document.getElementById('gen5')
const gen6 = document.getElementById('gen6')
const gen7 = document.getElementById('gen7')

function visualizarGenerales() {
    gen1.setAttribute('hidden',"")
    gen2.setAttribute('hidden',"")
    gen3.setAttribute('hidden',"")
    gen4.setAttribute('hidden',"")
    gen5.setAttribute('hidden',"")
    gen6.setAttribute('hidden',"")
    gen7.setAttribute('hidden',"")
}

function removeGeneral() {
    gen1.removeAttribute('hidden')
    gen2.removeAttribute('hidden')
    gen3.removeAttribute('hidden')
    gen4.removeAttribute('hidden')
    gen5.removeAttribute('hidden')
    gen6.removeAttribute('hidden')
    gen7.removeAttribute('hidden')
    
}

// sexo lineas
let sexolinea1 = []
let sexolinea2 = []
let sexolinea3 = []

// edad por lineas
let edadlinea1 = []
let edadlinea2 = []
let edadlinea3 = []

// año graduacion
let anioGlinea1 = []
let anioGlinea2 = []
let anioGlinea3 = []

// puntaje de icfes 
let icfesPuntajeLinea1 = []
let icfesPuntajeLinea2 = []
let icfesPuntajeLinea3 = []

// estado civil
let estadoCivilLinea1 = []
let estadoCivilLinea2 = []
let estadoCivilLinea3 = []

// etnia 
let etniaLinea1 = []
let etniaLinea2 = []
let etniaLinea3 = []

// ocupacion
let ocupacionLinea1 = []
let ocupacionLinea2 = []
let ocupacionLinea3 = []

//hijos
let hijosLinea1 = []
let hijosLinea2 = []
let hijosLinea3 = []

// regimen salud
let regimenLinea1 = []
let regimenLinea2 = []
let regimenLinea3 = []

//categoria de sisben
let categoriaSisbenLinea1 = []
let categoriaSisbenLinea2 = []
let categoriaSisbenLinea3 = []

// beneficios
let beneficiosLinea1 = []
let beneficiosLinea2 = []
let beneficiosLinea3 = []

// internet en la zona
let internetZLinea1 = []
let internetZLinea2 = []
let internetZLinea3 = []

//internet home
let internetHomeLinea1 = []
let internetHomeLinea2 = []
let internetHomeLinea3 = []

// condicion social
let socialCondicionLinea1 = []
let socialCondicionLinea2 = []
let socialCondicionLinea3 = []

// discapacidad
let discapacidadLinea1 = []
let discapacidadLinea2 = []
let discapacidadLinea3 = []

// variables 
let renderSex
let renderEdad
let renderAnioG
let renderIcfesPuntajes
let renderEstadoC
let renderEtniasLinea
let renderOcupacionL
let renderHijosN
let renderRegimenS
let renderCategoriaS
let renderBeneficiosL
let renderInternetZ
let renderInternetH
let renderCondicionS
let renderDiscapacidadL

// generales 
let generalRenderSexo
let generalRenderEdad

async function datosSexoPorLineas() {
    //linea 1
    const resHlinea1 = await fetch('/sex/H/linea/1')
    const jsonHLinea1 = await resHlinea1.json()

    sexolinea1.push(jsonHLinea1[0].sexo)

    const resMLinea1 = await fetch('/sex/M/linea/1')
    const jsonMLinea1 = await resMLinea1.json()

    sexolinea1.push(jsonMLinea1[0].sexo)

    // fin de linea 1

    // linea 2
    const resHLinea2 = await fetch('/sex/H/linea/2')
    const jsonHLinea2 = await resHLinea2.json()

    sexolinea2.push(jsonHLinea2[0].sexo)

    const resMLinea2 = await fetch('/sex/M/linea/2')
    const jsonMLinea2 = await resMLinea2.json()

    sexolinea2.push(jsonMLinea2[0].sexo)
    // fin liena 2

    // linea 3

    const resHLinea3 = await fetch('/sex/H/linea/3')
    const jsonHLinea3 = await resHLinea3.json()

    sexolinea3.push(jsonHLinea3[0].sexo)

    const resMLinea3 = await fetch('/sex/M/linea/3')
    const jsonMLinea3 = await resMLinea3.json()

    sexolinea3.push(jsonMLinea3[0].sexo)

}

async function datosEdadLineas(arreglo, linea) {

    const res14 = await fetch(`/edad/14/linea/${linea}`)
    const json14 = await res14.json()
    arreglo.push(json14[0].cantidad)

    const res15 = await fetch(`/edad/15/linea/${linea}`)
    const json15 = await res15.json()
    arreglo.push(json15[0].cantidad)

    const res16 = await fetch(`/edad/16/linea/${linea}`)
    const json16 = await res16.json()
    arreglo.push(json16[0].cantidad)

    const res17 = await fetch(`/edad/17/linea/${linea}`)
    const json17 = await res17.json()
    arreglo.push(json17[0].cantidad)

    const res18 = await fetch(`/edad/18/linea/${linea}`)
    const json18 = await res18.json()
    arreglo.push(json18[0].cantidad)

    const res19 = await fetch(`/edad/19/linea/${linea}`)
    const json19 = await res19.json()
    arreglo.push(json19[0].cantidad)

    const res20 = await fetch(`/edad/20/linea/${linea}`)
    const json20 = await res20.json()
    arreglo.push(json20[0].cantidad)

    const res21 = await fetch(`/edad/21/linea/${linea}`)
    const json21 = await res21.json()
    arreglo.push(json21[0].cantidad)

    const res22 = await fetch(`/edad/22/linea/${linea}`)
    const json22 = await res22.json()
    arreglo.push(json22[0].cantidad)

    const res23 = await fetch(`/edad/23/linea/${linea}`)
    const json23 = await res23.json()
    arreglo.push(json23[0].cantidad)

    const res24 = await fetch(`/edad/24/linea/${linea}`)
    const json24 = await res24.json()
    arreglo.push(json24[0].cantidad)

    const res25 = await fetch(`/edad/25/linea/${linea}`)
    const json25 = await res25.json()
    arreglo.push(json25[0].cantidad)

    const res26 = await fetch(`/edad/26/linea/${linea}`)
    const json26 = await res26.json()
    arreglo.push(json26[0].cantidad)

    const res27 = await fetch(`/edad/27/linea/${linea}`)
    const json27 = await res27.json()
    arreglo.push(json27[0].cantidad)

    const res28 = await fetch(`/edad/28/linea/${linea}`)
    const json28 = await res28.json()
    arreglo.push(json28[0].cantidad)

    const res29 = await fetch(`/edad/29/linea/${linea}`)
    const json29 = await res29.json()
    arreglo.push(json29[0].cantidad)

    const res30 = await fetch(`/edad/30/linea/${linea}`)
    const json30 = await res30.json()
    arreglo.push(json30[0].cantidad)
}

async function datosAnioGraduacion(arreglo, linea) {

    const res2012 = await fetch(`/anio/2012/linea/${linea}`)
    const json2012 = await res2012.json()
    arreglo.push(json2012[0].cantidad)

    const res2013 = await fetch(`/anio/2013/linea/${linea}`)
    const json2013 = await res2013.json()
    arreglo.push(json2013[0].cantidad)

    const res2014 = await fetch(`/anio/2014/linea/${linea}`)
    const json2014 = await res2014.json()
    arreglo.push(json2014[0].cantidad)

    const res2015 = await fetch(`/anio/2015/linea/${linea}`)
    const json2015 = await res2015.json()
    arreglo.push(json2015[0].cantidad)

    const res2016 = await fetch(`/anio/2016/linea/${linea}`)
    const json2016 = await res2016.json()
    arreglo.push(json2016[0].cantidad)

    const res2017 = await fetch(`/anio/2017/linea/${linea}`)
    const json2017 = await res2017.json()
    arreglo.push(json2017[0].cantidad)

    const res2018 = await fetch(`/anio/2018/linea/${linea}`)
    const json2018 = await res2018.json()
    arreglo.push(json2018[0].cantidad)

    const res2019 = await fetch(`/anio/2019/linea/${linea}`)
    const json2019 = await res2019.json()
    arreglo.push(json2019[0].cantidad)

    const res2020 = await fetch(`/anio/2020/linea/${linea}`)
    const json2020 = await res2020.json()
    arreglo.push(json2020[0].cantidad)

    const res2021 = await fetch(`/anio/2021/linea/${linea}`)
    const json2021 = await res2021.json()
    arreglo.push(json2021[0].cantidad)

    const res2022 = await fetch(`/anio/2022/linea/${linea}`)
    const json2022 = await res2022.json()
    arreglo.push(json2022[0].cantidad)
}

async function datosIcfesPuntaje(arreglo, linea) {

    const res150_200 = await fetch(`/puntaje/150/200/linea/${linea}`)
    const json150_200 = await res150_200.json()
    arreglo.push(json150_200[0].cantidad)

    const res201_250 = await fetch(`/puntaje/201/250/linea/${linea}`)
    const json201_250 = await res201_250.json()
    arreglo.push(json201_250[0].cantidad)

    const res251_300 = await fetch(`/puntaje/251/300/linea/${linea}`)
    const json251_300 = await res251_300.json()
    arreglo.push(json251_300[0].cantidad)

    const res301_350 = await fetch(`/puntaje/301/350/linea/${linea}`)
    const json301_350 = await res301_350.json()
    arreglo.push(json301_350[0].cantidad)

    const res351_400 = await fetch(`/puntaje/351/400/linea/${linea}`)
    const json351_400 = await res351_400.json()
    arreglo.push(json351_400[0].cantidad)

    const res401_450 = await fetch(`/puntaje/401/450/linea/${linea}`)
    const json401_450 = await res401_450.json()
    arreglo.push(json401_450[0].cantidad)

    const res451_500 = await fetch(`/puntaje/451/500/linea/${linea}`)
    const json451_500 = await res451_500.json()
    arreglo.push(json451_500[0].cantidad)

}

async function datosEstadoCivil(arreglo, linea) {

    const res1 = await fetch(`/estado/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/estado/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/estado/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/estado/4/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)

}

async function datosEtnia(arreglo, linea){

    const res1 = await fetch(`/etnia/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    
    const res2 = await fetch(`/etnia/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    
    const res3 = await fetch(`/etnia/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    
    const res4 = await fetch(`/etnia/4/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)

    
    const res5 = await fetch(`/etnia/5/linea/${linea}`)
    const json5 = await res5.json()
    arreglo.push(json5[0].cantidad)
}

async function datosOcupacion(arreglo, linea) {
    
    const res1 = await fetch(`/ocupacion/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/ocupacion/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/ocupacion/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/ocupacion/4/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)

    const res5 = await fetch(`/ocupacion/5/linea/${linea}`)
    const json5 = await res5.json()
    arreglo.push(json5[0].cantidad)

    const res6 = await fetch(`/ocupacion/6/linea/${linea}`)
    const json6 = await res6.json()
    arreglo.push(json6[0].cantidad)

    const res7 = await fetch(`/ocupacion/7/linea/${linea}`)
    const json7 = await res7.json()
    arreglo.push(json7[0].cantidad)

}

async function datosHijos(arreglo, linea) {
    
    const res1 = await fetch(`/hijos/0/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/hijos/1/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/hijos/2/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/hijos/3/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)

    const res5 = await fetch(`/hijos/5/linea/${linea}`)
    const json5 = await res5.json()
    arreglo.push(json5[0].cantidad)

}

async function datosRegimen(arreglo, linea) {
    
    const res1 = await fetch(`/regimen/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/regimen/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/regimen/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/regimen/4/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)
}

async function datosSisben(arreglo, linea) {
    
    const resA = await fetch(`/sisben/A/linea/${linea}`)
    const jsonA = await resA.json()
    arreglo.push(jsonA[0].cantidad)

    const resB = await fetch(`/sisben/B/linea/${linea}`)
    const jsonB = await resB.json()
    arreglo.push(jsonB[0].cantidad)

    const resC = await fetch(`/sisben/C/linea/${linea}`)
    const jsonC = await resC.json()
    arreglo.push(jsonC[0].cantidad)

    const resD = await fetch(`/sisben/D/linea/${linea}`)
    const jsonD = await resD.json()
    arreglo.push(jsonD[0].cantidad)

    const resNo = await fetch(`/sisben/No encontrado/linea/${linea}`)
    const jsonNo = await resNo.json()
    arreglo.push(jsonNo[0].cantidad)

}

async function datosBeneficios(arreglo, linea) {
    
    const res1 = await fetch(`/beneficios/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/beneficios/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/beneficios/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/beneficios/4/linea/${linea}`)
    const json4 = await res4.json()
    arreglo.push(json4[0].cantidad)

    const res5 = await fetch(`/beneficios/5/linea/${linea}`)
    const json5 = await res5.json()
    arreglo.push(json5[0].cantidad)

    const res6 = await fetch(`/beneficios/6/linea/${linea}`)
    const json6 = await res6.json()
    arreglo.push(json6[0].cantidad)

}

async function datosIntenerZona(arreglo, linea){

    const resS = await fetch(`/internetZona/s/linea/${linea}`)
    const jsonS = await resS.json()
    arreglo.push(jsonS[0].cantidad)

    const resN = await fetch(`/internetZona/n/linea/${linea}`)
    const jsonN = await resN.json()
    arreglo.push(jsonN[0].cantidad)

}

async function datosInternetHogar(arreglo, linea) {
    
    const resS = await fetch(`/internetHome/s/linea/${linea}`)
    const jsonS = await resS.json()
    arreglo.push(jsonS[0].cantidad)

    const resN = await fetch(`/internetHome/n/linea/${linea}`)
    const jsonN = await resN.json()
    arreglo.push(jsonN[0].cantidad)

}

async function datosSocialCondicion(arreglo, linea) {
    
    const res1 = await fetch(`/condicion/1/linea/${linea}`)
    const json1 = await res1.json()
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/condicion/2/linea/${linea}`)
    const json2 = await res2.json()
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/condicion/3/linea/${linea}`)
    const json3 = await res3.json()
    arreglo.push(json3[0].cantidad)

}

async function datosDiscapacidad(arreglo, linea) {

    const res0 = await fetch(`/discapacidad/0/linea/${linea}`)
    const json0 = await res0.json() 
    arreglo.push(json0[0].cantidad)

    const res1 = await fetch(`/discapacidad/1/linea/${linea}`)
    const json1 = await res1.json() 
    arreglo.push(json1[0].cantidad)

    const res2 = await fetch(`/discapacidad/2/linea/${linea}`)
    const json2 = await res2.json() 
    arreglo.push(json2[0].cantidad)

    const res3 = await fetch(`/discapacidad/3/linea/${linea}`)
    const json3 = await res3.json() 
    arreglo.push(json3[0].cantidad)

    const res4 = await fetch(`/discapacidad/4/linea/${linea}`)
    const json4 = await res4.json() 
    arreglo.push(json4[0].cantidad)

}

toastr.info('cargando informacion....')
datosSexoPorLineas().then(() => toastr.info('se cargo toda la informacion de Sexos '))
datosEdadLineas(edadlinea1, 1).then(() => toastr.info('se cargo toda la informacion de edad en la linea 1 '))
datosEdadLineas(edadlinea2, 2).then(() => toastr.info('se cargo toda la informacion de edad en la linea 2 '))
datosEdadLineas(edadlinea3, 3).then(() => toastr.info('se cargo toda la informacion de edad en la linea 3 '))
datosAnioGraduacion(anioGlinea1, 1).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 1 '))
datosAnioGraduacion(anioGlinea2, 2).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 2 '))
datosAnioGraduacion(anioGlinea3, 3).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 3 '))
datosIcfesPuntaje(icfesPuntajeLinea1, 1).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 1 '))
datosIcfesPuntaje(icfesPuntajeLinea2, 2).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 2 '))
datosIcfesPuntaje(icfesPuntajeLinea3, 3).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 3 '))
datosEstadoCivil(estadoCivilLinea1, 1).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 1 '))
datosEstadoCivil(estadoCivilLinea2, 2).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 2 '))
datosEstadoCivil(estadoCivilLinea3, 3).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 3 '))
datosEtnia(etniaLinea1, 1).then(() => toastr.info('se cargo toda la informacion de etnias en la linea 1 '))
datosEtnia(etniaLinea2, 2).then(() => toastr.info('se cargo toda la informacion de etnias en la linea 2 '))
datosEtnia(etniaLinea3, 3).then(() => toastr.info('se cargo toda la informacion de etnias en la linea 3 '))
datosOcupacion(ocupacionLinea1, 1).then(() => toastr.info('se cargo toda la informacion de ocupaciones en la linea 1 '))
datosOcupacion(ocupacionLinea2, 2).then(() => toastr.info('se cargo toda la informacion de ocupaciones en la linea 2 '))
datosOcupacion(ocupacionLinea3, 3).then(() => toastr.info('se cargo toda la informacion de ocupaciones en la linea 3 '))
datosHijos(hijosLinea1, 1).then(() => toastr.info('se cargo toda la informacion de numero de hijos en la linea 1'))
datosHijos(hijosLinea2, 2).then(() => toastr.info('se cargo toda la informacion de numero de hijos en la linea 2 '))
datosHijos(hijosLinea3, 3).then(() => toastr.info('se cargo toda la informacion de numero de hijos en la linea 3 '))
datosRegimen(regimenLinea1, 1).then(() => toastr.info('se cargo toda la informacion de regimen en salud en la linea 1'))
datosRegimen(regimenLinea2, 2).then(() => toastr.info('se cargo toda la informacion de regimen en salud en la linea 2'))
datosRegimen(regimenLinea3, 3).then(() => toastr.info('se cargo toda la informacion de regimen en salud en la linea 3'))
datosSisben(categoriaSisbenLinea1, 1).then(() => toastr.info('se cargo toda la informacion de categoria de sisben en la linea 1'))
datosSisben(categoriaSisbenLinea2, 2).then(() => toastr.info('se cargo toda la informacion de categoria de sisben en la linea 2'))
datosSisben(categoriaSisbenLinea3, 3).then(() => toastr.info('se cargo toda la informacion de categoria de sisben en la linea 3'))
datosBeneficios(beneficiosLinea1, 1).then(() => toastr.info('se cargo toda la informacion de beneficios en la linea 1'))
datosBeneficios(beneficiosLinea2, 2).then(() => toastr.info('se cargo toda la informacion de beneficios en la linea 2'))
datosBeneficios(beneficiosLinea3, 3).then(() => toastr.info('se cargo toda la informacion de beneficios en la linea 3'))
datosIntenerZona(internetZLinea1, 1).then(() => toastr.info('se cargo toda la informacion de internet en zona en la linea 1'))
datosIntenerZona(internetZLinea2, 2).then(() => toastr.info('se cargo toda la informacion de internet en zona en la linea 2'))
datosIntenerZona(internetZLinea3, 3).then(() => toastr.info('se cargo toda la informacion de internet en zona en la linea 3'))
datosInternetHogar(internetHomeLinea1, 1).then(() => toastr.info('se cargo toda la informacion de internet en el hogar en la linea 1'))
datosInternetHogar(internetHomeLinea2, 2).then(() => toastr.info('se cargo toda la informacion de internet en el hogar en la linea 2'))
datosInternetHogar(internetHomeLinea3, 3).then(() => toastr.info('se cargo toda la informacion de internet en el hogar en la linea 3'))
datosSocialCondicion(socialCondicionLinea1, 1).then(() => toastr.info('se cargo toda la informacion de condicion social en la linea 1'))
datosSocialCondicion(socialCondicionLinea2, 2).then(() => toastr.info('se cargo toda la informacion de condicion social en la linea 2'))
datosSocialCondicion(socialCondicionLinea3, 3).then(() => toastr.info('se cargo toda la informacion de condicion social en la linea 3'))
datosDiscapacidad(discapacidadLinea1, 1).then(() => toastr.info('se cargo toda la informacion de discapacidad en la linea 1'))
datosDiscapacidad(discapacidadLinea2, 2).then(() => toastr.info('se cargo toda la informacion de discapacidad en la linea 2'))
datosDiscapacidad(discapacidadLinea3, 3).then(() => toastr.info('se cargo toda la informacion de discapacidad en la linea 3'))

generales.addEventListener('click', () => {
    hiddenGraficas()
    removeGeneral()
    renderGeneralSexos(gsexo)
    renderGeneralEdad(gedad)
})

line1.addEventListener('click', () => {
    visualizarGenerales()
    removeHiddenGraficas()
    renderSexLineas(1, lsex, sexolinea1)
    renderEdadPorLineas(1, ledad, edadlinea1)
    renderAnioGraduacion(1, lanioGraduacion, anioGlinea1)
    renderIcfesPuntaje(1, licfesPuntaje, icfesPuntajeLinea1)
    renderEstadoCivil(1, lestadoCivil, estadoCivilLinea1)
    renderEtnias(1, letnia, etniaLinea1)
    renderOcupacion(1, locupacion, ocupacionLinea1)
    renderNumeroDeHijos(1, lhijos, hijosLinea1)
    renderRegimenSalud(1, lregimen, regimenLinea1)
    renderCategoriaSisben(1, lsisben, categoriaSisbenLinea1)
    renderBeneficios(1, lbeneficios, beneficiosLinea1)
    renderInternetZona(1, linternetzona, internetZLinea1)
    renderInternetHome(1, linternethome, internetHomeLinea1)
    renderSocialCondicion(1, lsocialcondicion, socialCondicionLinea1)
    renderDiscapacidad(1, ldiscapacidad, discapacidadLinea1)
    
})

line2.addEventListener('click', () => {
    visualizarGenerales()
    removeHiddenGraficas()
    renderSexLineas(2, lsex, sexolinea2)
    renderEdadPorLineas(2, ledad, edadlinea2)
    renderAnioGraduacion(2, lanioGraduacion, anioGlinea2)
    renderIcfesPuntaje(2, licfesPuntaje, icfesPuntajeLinea2)
    renderEstadoCivil(2, lestadoCivil, estadoCivilLinea2)
    renderEtnias(2, letnia, etniaLinea2)
    renderOcupacion(2, locupacion, ocupacionLinea2)
    renderNumeroDeHijos(2, lhijos, hijosLinea2)
    renderRegimenSalud(2, lregimen, regimenLinea2)
    renderCategoriaSisben(2, lsisben, categoriaSisbenLinea2)
    renderBeneficios(2, lbeneficios, beneficiosLinea2)
    renderInternetZona(2, linternetzona, internetZLinea2)
    renderInternetHome(2, linternethome, internetHomeLinea2)
    renderSocialCondicion(2, lsocialcondicion, socialCondicionLinea2)
    renderDiscapacidad(2, ldiscapacidad, discapacidadLinea2)
})

line3.addEventListener('click', () => {
    visualizarGenerales()
    removeHiddenGraficas()
    renderSexLineas(3, lsex, sexolinea3)
    renderEdadPorLineas(3, ledad, edadlinea3)
    renderAnioGraduacion(3, lanioGraduacion, anioGlinea3)
    renderIcfesPuntaje(3, licfesPuntaje, icfesPuntajeLinea3)
    renderEstadoCivil(3, lestadoCivil, estadoCivilLinea3)
    renderEtnias(3, letnia, etniaLinea3)
    renderOcupacion(3, locupacion, ocupacionLinea3)
    renderNumeroDeHijos(3, lhijos, hijosLinea3)
    renderRegimenSalud(3, lregimen, regimenLinea3)
    renderCategoriaSisben(3, lsisben, categoriaSisbenLinea3)
    renderBeneficios(3, lbeneficios, beneficiosLinea3)
    renderInternetZona(3, linternetzona, internetZLinea3)
    renderInternetHome(3, linternethome, internetHomeLinea3)
    renderSocialCondicion(3, lsocialcondicion, socialCondicionLinea3)
    renderDiscapacidad(3, ldiscapacidad, discapacidadLinea3)
})

function renderSexLineas(titulo,line, dataSex) {
    if(renderSex) renderSex.destroy()
    renderSex = new Chart(line, {
        type: 'doughnut',
        data: {
            labels: ['Hombres', 'Mujeres'],
            datasets: [{
                label: `LINEA ${titulo}` || '',
                data: dataSex,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE SEXOS'
                }
            }
        }
    });
}

function renderEdadPorLineas(titulo, line, dataEdad) {
    if(renderEdad) renderEdad.destroy()
    line.height = 500
    renderEdad = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['14', '15', '16', '17', '18', '19', '20', '21', '22','23', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: '',
                data: dataEdad,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            //showTooltips: false,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE EDAD'
                },
                legend: {
                    display: false
                },
                datalabels:{
                    display: true,
                
                }
            },
            
        }
    });
    //renderEdad.canvas.parentNode.style.height = '700px';
    //renderEdad.canvas.parentNode.style.width = '500px';
}

function renderAnioGraduacion(titulo, line, dataAnioG) {
    if(renderAnioG) renderAnioG.destroy()
    line.height = 500
    renderAnioG = new Chart(line, {
        type: 'line',
        data: {
            labels: ['2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020','2021', '2022'],
            datasets: [{
                //label: `LINEA ${titulo} AÑO DE GRADUACION` || '',
                data: dataAnioG,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE AÑO DE GRADUACION'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderIcfesPuntaje(titulo, line, dataIcfes) {
    if(renderIcfesPuntajes) renderIcfesPuntajes.destroy()
    line.height = 500
    renderIcfesPuntajes = new Chart(line, {
        type: 'line',
        data: {
            labels: ['150-200', '201-250', '251-300', '301-350', '351-400', '401-450', '451-500'],
            datasets: [{
                //label: `LINEA ${titulo} PUNTAJE ICFES` || '',
                data: dataIcfes,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE PUNTAJE DE ICFES'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderEstadoCivil(titulo, line, dataEstadoCivil) {
    
    if(renderEstadoC) renderEstadoC.destroy()
    line.height = 500
    renderEstadoC = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['Casado', 'Separado', 'Soltero', 'Union Libre'],
            datasets: [{
                //label: '',
                data: dataEstadoCivil,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE ESTADO CIVIL'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderEtnias(titulo, line, dataEtnias) {
    if(renderEtniasLinea) renderEtniasLinea.destroy()
    renderEtniasLinea = new Chart(line, {
        type: 'pie',
        data: {
            labels: ['Afro', 'Indigena', 'Ninguno', 'No', 'No encontrado'],
            datasets: [{
                label: `LINEA ${titulo} ETNIAS` || '',
                data: dataEtnias,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)'
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE ETNIAS'
                }
            }
        }
    });
}

function renderOcupacion(titulo, line, dataOcup) {
    if(renderOcupacionL) renderOcupacionL.destroy()
    //line.height = 500
    renderOcupacionL = new Chart(line, {
        type: 'doughnut',
        data: {
            labels: ['Estudiar', 'Estudiar y Trabajar', 'Hogar', 'Trabajo Completo', 'Trabajo Ocasional', 'Trabajo Medio', 'Ninguna'],
            datasets: [{
                label: `LINEA ${titulo} OCUPACION` || '',
                data: dataOcup,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)',
                    'rgba(128, 0, 0,1)',
                    'rgb(210, 105, 30,1)'
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)',
                    'rgba(128, 0, 0,1)',
                    'rgb(210, 105, 30,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            //maintainAspectRatio: false,
            responsive: true,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE OCUPACION'
                }
            }
        }
    });
}

function renderNumeroDeHijos(titulo, line, dataHijos) {
    if(renderHijosN) renderHijosN.destroy()
    line.height = 500
    renderHijosN = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['0', '1', '2', '3', '5 o mas'],
            datasets: [{
                //label: `LINEA ${titulo} NUMERO DE HIJOS` || '',
                data: dataHijos,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE NUMERO DE HIJOS'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderRegimenSalud(titulo, line, dataRegimen) {
    if(renderRegimenS) renderRegimenS.destroy()
    line.height = 500
    renderRegimenS = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['Contributivo', 'Especial', 'Subsidiado', 'En Proceso'],
            datasets: [{
                //label: `LINEA ${titulo} REGIMEN DE SALUD` || '',
                data: dataRegimen,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE REGIMEN EN SALUD'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderCategoriaSisben(titulo, line, dataSisben) {
    if(renderCategoriaS) renderCategoriaS.destroy()
    renderCategoriaS =  new Chart(line, {
        type: 'pie',
        data: {
            labels: ['A', 'B', 'C', 'D', 'No encontrado'],
            datasets: [{
                label: `LINEA ${titulo} ETNIAS` || '',
                data: dataSisben,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)'
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(255, 222, 173, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA CATEGORIA SISBEN'
                }
            }
        }
    });
}

function renderBeneficios(titulo, line, dataBeneficio) {
    if(renderBeneficiosL) renderBeneficiosL.destroy()
    line.height = 500
    renderBeneficiosL =  new Chart(line, {
        type: 'line',
        data: {
            labels: ['Familias en accion', 'Ingreso solidario', 'Jovenes en accion', 'No Recibo', 'Otro', 'Subsidio de vivienda'],
            datasets: [{
                //label: `LINEA ${titulo} PUNTAJE ICFES` || '',
                data: dataBeneficio,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE BENEFICIOS'
                },
                legend: {
                    display: false
                },
            }
        }
    });   
}

function renderInternetZona(titulo, line, dataInternetZona) {
    if(renderInternetZ) renderInternetZ.destroy()
    renderInternetZ = new Chart(line, {
        type: 'doughnut',
        data: {
            labels: ['SI', 'NO'],
            datasets: [{
                label: `LINEA ${titulo} INTERNET EN ZONA` || '',
                data: dataInternetZona,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            //maintainAspectRatio: false,
            responsive: true,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE INTERNET EN ZONA'
                }
            }
        }
    });

}

function renderInternetHome(titulo, line, dataInternetH) {
    if(renderInternetH) renderInternetH.destroy()
    renderInternetH = new Chart(line, {
        type: 'doughnut',
        data: {
            labels: ['SI', 'NO'],
            datasets: [{
                label: `LINEA ${titulo} INTERNET EN EL HOGAR` || '',
                data: dataInternetH,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            //maintainAspectRatio: false,
            responsive: true,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE INTERNET EN EL HOGAR'
                }
            }
        }
    });
}

function renderSocialCondicion(titulo, line, dataCondicio) {
    if(renderCondicionS)renderCondicionS.destroy()
    renderCondicionS = new Chart(line, {
        type: 'pie',
        data: {
            labels: ['Persona victima del conflicto armado', 'Persona con habilidades diferenciales Discapacidad', 'Ninguna'],
            datasets: [{
                label: `LINEA ${titulo} CONDICION SOCIAL` || '',
                data: dataCondicio,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                    
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    'rgba(255, 140, 0, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            //maintainAspectRatio: false,
            responsive: true,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE CONDICION SOCIAL'
                }
            }
        }
    });    
}

function renderDiscapacidad(titulo, line, dataDiscapacidad) {
    if(renderDiscapacidadL) renderDiscapacidadL.destroy()
    line.height = 500
    renderDiscapacidadL =  new Chart(line, {
        type: 'line',
        data: {
            labels: ['Ninguna', 'Auditiva', 'Cognitiva', 'Fisica', 'Visual'],
            datasets: [{
                //label: `LINEA ${titulo} REGIMEN DE SALUD` || '',
                data: dataDiscapacidad,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            //indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA DE DISCAPACIDAD'
                },
                legend: {
                    display: false
                },
            }
        }
    });
}

function renderGeneralSexos(line) {
    if(generalRenderSexo) generalRenderSexo.destroy()
    line.height = 800
    generalRenderSexo = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['Hombres', 'Mujesres'],
            datasets: [{
                label: 'LINEA 1',
                data: sexolinea1,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                ],
                borderWidth: 1
            },
            {
                label: 'LINEA 2',
                data: sexolinea2,
                backgroundColor: [
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            },
            {
                label: 'LINEA 3',
                data: sexolinea3,
                backgroundColor: [
                    'rgba(255, 140, 0, 1)',
                ],
                borderColor: [
                    'rgba(255, 140, 0, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            //showTooltips: false,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA GENERAL DE SEXOS'
                },
            },
            
        }
    });
}

function renderGeneralEdad(line) {
    if(generalRenderEdad) generalRenderEdad.destroy() 
    line.height = 800
    generalRenderEdad = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['14', '15', '16', '17', '18', '19', '20', '21', '22','23', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: 'LINEA 1',
                data: edadlinea1,
                backgroundColor: [
                    'rgba(226, 13, 13, 1)',
                ],
                borderColor: [
                    'rgba(226, 13, 13, 1)',
                ],
                borderWidth: 1
            },
            {
                label: 'LINEA 2',
                data: edadlinea2,
                backgroundColor: [
                    'rgba(5, 5, 147, 1)',
                ],
                borderColor: [
                    'rgba(5, 5, 147, 1)',
                    
                ],
                borderWidth: 1
            },
            {
                label: 'LINEA 3',
                data: edadlinea3,
                backgroundColor: [
                    'rgba(255, 140, 0, 1)',
                ],
                borderColor: [
                    'rgba(255, 140, 0, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            //showTooltips: false,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'GRAFICA GENERAL DE SEXOS'
                },
            },
            
        }
    });
}