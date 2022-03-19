const ctx = document.getElementById('myChart').getContext('2d');
const modo = document.getElementById('valores');
const cohorte = document.getElementById('linea');
const view = document.getElementById('tipoGrafica')

let sexolinea1 = []
let sexolinea2 = []
let sexolinea3 = []

let linea = 0
let render


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

datosSexoPorLineas()

modo.addEventListener('change', (e) => {
    console.log(e.target.value)

})

cohorte.addEventListener('change', (e) => {
    linea = e.target.value
})

view.addEventListener('change', async (e) => {

    if(render){
        render.destroy()
    }

    let data = []
    let labels = ['Hombres', 'Mujeres']
    
    switch (linea) {
        case '1':
            data.push(sexolinea1)
            break;

        case '2':
            data.push(sexolinea2)
            break;

        case '3':
            data.push(sexolinea3)
            console.log(sexolinea3)
            break;

        default:
            break;
    }

    switch (e.target.value) {
        case 'bar':
            renderGraficas(linea, 'bar', data[0], labels)
            break;
        case 'line':
            renderGraficas(linea, 'line', data[0], labels)
            break;
        case 'polarArea':
            renderGraficas(linea, 'polarArea', data[0], labels)
            break;
        case 'radar':
            renderGraficas(linea, 'radar', data[0], labels)
            break;
        case 'doughnut':
            renderGraficas(linea, 'doughnut', data[0], labels)
            break;
        default:
            break;
    }
   
})

function renderGraficas(titulo, tipo, data, labels) {
    
    render = new Chart(ctx, {
        type: tipo || 'bar',
        data: {
            labels: labels || [],
            datasets: [{
                label: `LINEA ${titulo}` || '',
                data: data,
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
    //render.canvas.parentNode.style.height = '400px';
    //render.canvas.parentNode.style.width = '800px';
}
