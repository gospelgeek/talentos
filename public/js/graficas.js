// canvas
const lsex = document.getElementById('sexolineas').getContext('2d');
const ledad = document.getElementById('edadlineas').getContext('2d');
const lanioGraduacion = document.getElementById('anioGraduacion').getContext('2d');
const licfesPuntaje =  document.getElementById('icfesPuntajeLinea').getContext('2d');
const lestadoCivil =  document.getElementById('estadoCivilLinea').getContext('2d');
// botones

const line1 = document.getElementById('linea1')
const line2 = document.getElementById('linea2')
const line3 = document.getElementById('linea3')

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

// variables 
let renderSex
let renderEdad
let renderAnioG
let renderIcfesPuntajes
let renderEstadoC

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

toastr.info('cargando informacion....')
datosSexoPorLineas().then(() => toastr.info('se cargo toda la informacion de Sexos '))
datosEdadLineas(edadlinea1, 1).then(() => toastr.info('se cargo toda la informacion de edades en la linea 1 '))
datosEdadLineas(edadlinea2, 2).then(() => toastr.info('se cargo toda la informacion de edades en la linea 2 '))
datosEdadLineas(edadlinea3, 3).then(() => toastr.info('se cargo toda la informacion de edades en la linea 3 '))
datosAnioGraduacion(anioGlinea1, 1).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 1 '))
datosAnioGraduacion(anioGlinea2, 2).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 2 '))
datosAnioGraduacion(anioGlinea3, 3).then(() => toastr.info('se cargo toda la informacion de Año de graduacion en la linea 3 '))
datosIcfesPuntaje(icfesPuntajeLinea1, 1).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 1 '))
datosIcfesPuntaje(icfesPuntajeLinea2, 2).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 2 '))
datosIcfesPuntaje(icfesPuntajeLinea3, 3).then(() => toastr.info('se cargo toda la informacion de puntaje de icfes en la linea 3 '))
datosEstadoCivil(estadoCivilLinea1, 1).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 1 '))
datosEstadoCivil(estadoCivilLinea2, 2).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 2 '))
datosEstadoCivil(estadoCivilLinea3, 3).then(() => toastr.info('se cargo toda la informacion de estado civil en la linea 3 '))

line1.addEventListener('click', () => {
    renderSexLineas(1, lsex, sexolinea1)
    renderEdadPorLineas(1, ledad, edadlinea1)
    renderAnioGraduacion(1, lanioGraduacion, anioGlinea1)
    renderIcfesPuntaje(1, licfesPuntaje, icfesPuntajeLinea1)
    renderEstadoCivil(1, lestadoCivil, estadoCivilLinea1)
})

line2.addEventListener('click', () => {
    renderSexLineas(2, lsex, sexolinea2)
    renderEdadPorLineas(2, ledad, edadlinea2)
    renderAnioGraduacion(2, lanioGraduacion, anioGlinea2)
    renderIcfesPuntaje(2, licfesPuntaje, icfesPuntajeLinea2)
    renderEstadoCivil(2, lestadoCivil, estadoCivilLinea2)
})

line3.addEventListener('click', () => {
    renderSexLineas(3, lsex, sexolinea3)
    renderEdadPorLineas(3, ledad, edadlinea3)
    renderAnioGraduacion(3, lanioGraduacion, anioGlinea3)
    renderIcfesPuntaje(3, licfesPuntaje, icfesPuntajeLinea3)
    renderEstadoCivil(3, lestadoCivil, estadoCivilLinea3)
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
            }
        }
    });
}

function renderEdadPorLineas(titulo, line, dataEdad) {
    if(renderEdad) renderEdad.destroy()
    renderEdad = new Chart(line, {
        type: 'bar',
        data: {
            labels: ['14', '15', '16', '17', '18', '19', '20', '21', '22','23', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: `LINEA ${titulo} EDADES` || '',
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
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            }
        }
    });
    //renderEdad.canvas.parentNode.style.height = '700px';
    //renderEdad.canvas.parentNode.style.width = '500px';
}

function renderAnioGraduacion(titulo, line, dataAnioG) {
    if(renderAnioG) renderAnioG.destroy()
    renderAnioG = new Chart(line, {
        type: 'line',
        data: {
            labels: ['2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020','2021', '2022'],
            datasets: [{
                label: `LINEA ${titulo} AÑO DE GRADUACION` || '',
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
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}

function renderIcfesPuntaje(titulo, line, dataIcfes) {
    if(renderIcfesPuntajes) renderIcfesPuntajes.destroy()
    renderIcfesPuntajes = new Chart(line, {
        type: 'polarArea',
        data: {
            labels: ['150-200', '201-250', '251-300', '301-350', '351-400', '401-450', '451-500'],
            datasets: [{
                label: `LINEA ${titulo} PUNTAJE ICFES` || '',
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
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}

function renderEstadoCivil(titulo, line, dataEstadoCivil) {
    if(renderEstadoC) renderEstadoC.destroy()
    renderEstadoC = new Chart(line, {
        type: 'doughnut',
        data: {
            labels: ['Casado', 'Separado', 'Soltero', 'Union Libre'],
            datasets: [{
                label: `LINEA ${titulo} ESTADO CIVIL` || '',
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
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}
