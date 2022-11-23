@extends('layouts.dashboard')
@section('title', 'Icfes')
@section('icfes')
<style>
    #tablaLinea1 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea1 td:nth-child(9) {
        border-right: black solid 1px;

    }

    #tablaLinea1 td:nth-child(10) {

        border-left: black solid 1px;
    }

    #tablaLinea1 td:nth-child(12) {
        border-right: black solid 2px;

    }

    #tablaLinea1 td {
        text-align: center;
    }


    #tablaLinea2 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea2 td:nth-child(9) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(10) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(12) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(13) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(15) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(16) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(18) {
        border-right: black solid 2px;

    }

    #tablaLinea2 td {
        text-align: center;
    }


    #tablaLinea3 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea3 td:nth-child(9) {
        border-right: black solid 1px;

    }

    #tablaLinea3 td:nth-child(10) {

        border-left: black solid 1px;
    }

    #tablaLinea3 td:nth-child(12) {
        border-right: black solid 1px;

    }

    #tablaLinea3 td:nth-child(13) {

        border-left: black solid 1px;
    }

    #tablaLinea3 td:nth-child(15) {
        border-right: black solid 2px;

    }

    #tablaLinea3 td {
        text-align: center;
    }
</style>
@endsection
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <h1 style="text-align:center;">COMPARATIVO ICFES</h1>
    <div class="card">
        <div class="card-header">

            <div class="row">
                
                &nbsp;
                <div class="col-md-2">
                    <label for="">ELIJA LA COHORTE: </label>
                    <select class="form-control" name="opcion" id="opcion">
                        <option default value="0">-----</option>
                        <option value="1">LINEA 1</option>
                        <option value="2">LINEA 2</option>
                        <option value="3">LINEA 3</option>
                    </select>
                </div>
                &nbsp;
                &nbsp;
                <div class="col-md-3">
                    <a class="btn btn-primary" href="{{ route('sabana_icfes') }}">
                        DESCARGAR SABANA
                    </a>
                </div>
            </div>


        </div>
        <div class="card-body">

            <div class="row" id="linea1" hidden>
                <div class="col-sm table-responsive">
                    <table id="tablaLinea1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td align="center">Nombres</td>
                                <td align="center">Apellidos</td>
                                <td align="center">Nº documento</td>
                                <td align="center">Linea</td>
                                <td align="center">Grupo</td>
                                <td align="center">Icfes Entrada</td>
                                <td align="center">Simulacro 3</td>
                                <td align="center" id="pV1">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV2">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Ver Detalle</td>


                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="row" id="linea2" hidden>
                <div class="col-sm table-responsive">
                    <table id="tablaLinea2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td align="center">Nombres</td>
                                <td align="center">Apellidos</td>
                                <td align="center">Nº documento</td>
                                <td align="center">Linea</td>
                                <td align="center">Grupo</td>
                                <td align="center">Icfes Entrada</td>
                                <td align="center">Simulacro 1</td>
                                <td align="center" id="pV3">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Simulacro 2</td>
                                <td align="center" id="pV4">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Simulacro 3</td>
                                <td align="center" id="pV5">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV6">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Ver Detalle</td>


                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="row" id="linea3" hidden>
                <div class="col-sm table-responsive">
                    <table id="tablaLinea3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td align="center">Nombres</td>
                                <td align="center">Apellidos</td>
                                <td align="center">Nº documento</td>
                                <td align="center">Linea</td>
                                <td align="center">Grupo</td>
                                <td align="center">Simulacro 1</td>
                                <td align="center">Simulacro 2</td>
                                <td align="center" id="pV7">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Simulacro 3</td>
                                <td align="center" id="pV8">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV9">Puntos Variacion</td>
                                <td align="center">Porcentaje</td>
                                <td align="center">Ver Detalle</td>


                            </tr>
                        </thead>
                    </table>
                </div>
            </div>





        </div>
    </div>
</div>

@include('icfes.modal_areas')
@include('icfes.modal_registro_icfes')

@push('scripts')

<script>
 
    const registroIcfes = document.getElementById('Ricfes')
    registroIcfes.addEventListener('click', () => {
        $('#modal-registro').modal('show')
    })
    const r_areas = document.getElementById('r_areas')
    const fm_areas = document.getElementById('form_areas')
    const _guardar = document.getElementById('_guardar')
    const _formRegistro = document.getElementById('_registro')
    _guardar.addEventListener('click', (e) => {
        e.preventDefault()
        console.log(_formRegistro['lecturaC'].validity.valid)
        let iden = _formRegistro['identificacion'].validity.valid
        let url = _formRegistro['url'].validity.valid
        //let areas_formRegistro['r_areas'].validity.valid
        let prueba = _formRegistro['prueba'].validity.valid
        let puntaje = _formRegistro['puntaje'].validity.valid
        let lecturaC = _formRegistro['lecturaC'].validity.valid
        let mate = _formRegistro['mate'].validity.valid
        let cienS = _formRegistro['cienS'].validity.valid
        let cienN = _formRegistro['cienN'].validity.valid
        let ingles = _formRegistro['ingles'].validity.valid
        if (iden !== true) {
            toastr.info('la identificacion no puede ser vacia')
        }
        if (url !== true) {
            toastr.info('la url no puede ser vacia')
        }
        if (puntaje !== true) {
            toastr.info('la informacion del puntaje no es valido, debe ser un numero de 0 a 500 y no puede ser vacio')
        }
        if (lecturaC !== true) {
            toastr.info('el campo de lectura critica no puede ser vacio')
        }
        if (mate !== true) {
            toastr.info('el campo de matematicas no puede ser vacio')
        }
        if (cienS !== true) {
            toastr.info('el campo de ciencias sociales no puede ser vacio')
        }
        if (cienN !== true) {
            toastr.info('el campo de ciencias naturales no puede ser vacio')
        }
        if (ingles !== true) {
            toastr.info('el campo de ingles no puede ser vacio')
        }
        if (
            iden === true &&
            url === true &&
            puntaje === true &&
            lecturaC === true &&
            mate === true &&
            cienS === true &&
            cienN === true &&
            ingles === true
        ) {
            $.ajax({
                url: '/registro_icfes',
                type: 'POST',
                data: {
                    '_token': _formRegistro['_token'].value,
                    'identificacion': _formRegistro['identificacion'].value,
                    'url': _formRegistro['url'].value,
                    'r_areas': _formRegistro['r_areas'].value,
                    'prueba': _formRegistro['prueba'].value,
                    'puntaje': _formRegistro['puntaje'].value,
                    'lecturaC': _formRegistro['lecturaC'].value,
                    'mate': _formRegistro['mate'].value,
                    'cienS': _formRegistro['cienS'].value,
                    'cienN': _formRegistro['cienN'].value,
                    'ingles': _formRegistro['ingles'].value
                },
                success: function(result) {
                    console.log(result.mensaje)
                    toastr.info(`${result.mensaje}`);
                    _formRegistro.reset()
                },
                error: function(result) {
                    toastr.info('Ocurrio un error inesperado :(')
                },
            })
        }
    })
    if (r_areas.checked == true) {
        fm_areas.removeAttribute('hidden')
        _formRegistro['lecturaC'].setAttribute('required', '')
        _formRegistro['mate'].setAttribute('required', '')
        _formRegistro['cienS'].setAttribute('required', '')
        _formRegistro['cienN'].setAttribute('required', '')
        _formRegistro['ingles'].setAttribute('required', '')
    }
    r_areas.addEventListener('change', () => {
        if (r_areas.checked === true) {
            fm_areas.removeAttribute('hidden')
            _formRegistro['lecturaC'].setAttribute('required', '')
            _formRegistro['mate'].setAttribute('required', '')
            _formRegistro['cienS'].setAttribute('required', '')
            _formRegistro['cienN'].setAttribute('required', '')
            _formRegistro['ingles'].setAttribute('required', '')
        }
        if (r_areas.checked === false) {
            fm_areas.setAttribute('hidden', '')
            _formRegistro['lecturaC'].removeAttribute('required')
            _formRegistro['mate'].removeAttribute('required')
            _formRegistro['cienS'].removeAttribute('required')
            _formRegistro['cienN'].removeAttribute('required')
            _formRegistro['ingles'].removeAttribute('required')
        }
    })
 
    $("#tablaLinea1").DataTable({
        "ajax": {
            "method": "GET",
            "url": "{{route('datos_icfes_lineas', 1)}}"
        },
        "columns": [{
                data: 'nombre'
            },
            {
                data: 'apellidos'
            },
            {
                data: 'documento'
            },
            {
                data: 'linea'
            },
            {
                data: 'grupo'
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `<td><strong>${data.ie}</strong></td>`
                }

            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 3 - LINEA 1');"><u>${data.s3}</u></button>
                       
                    `
                }

            },
            {
                data: null,
                render: function(data, type, row, meta) {

                    let variacion = Math.round(data.s3 - data.ie);
                    let resultado

                    if (variacion < 0) {
                        resultado = `
                                <div style="background-color: #FE3F3F;" >
                                    <td>${variacion}</td>

                                </div>
                                `
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                    <td>${variacion}</td>
                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                    <td>${variacion}</td>
                                </div>`
                    }

                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {

                    let variacion = data.s3 - data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }

                    let resultado

                    if (variacion < 0) {
                        resultado = `
                                <div style="background-color: #FE3F3F;" >
                                    <td >${variacionPor}%</td>

                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                    <td>${variacionPor} %</td>
                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                    <td>${variacionPor} %</td>
                                </div>`
                    }

                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5, '${data.nombre}', '${data.apellidos}', '- ICFES DE SALIDA - LINEA 1');"><u>${data.if}</u></button>
                       
                    `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {

                    let variacion = Math.round(data.if-data.ie);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                    <td>${variacion}</td>
                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                    <td>${variacion}</td>
                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                    <td>${variacion}</td>
                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {

                    let variacion = data.if-data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }

                    let resultado

                    if (variacion < 0) {
                        resultado = `
                                <div style="background-color: #FE3F3F;" >
                                    <td >${variacionPor}%</td>

                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                    <td>${variacionPor} %</td>
                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                    <td>${variacionPor} %</td>
                                </div>`
                    }

                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                    <div class="row">                                  
                        <div class="col-xs-4 col-sm-4">
                            <a href="/ver_estudiante/${data.id_student}?css=titulo-7#ti7" class="btn btn-block btn-sm  fa fa-eye" ></a>  
                        </div>                                       
                    </div>
                     
                     `
                }
            },

        ],

        "deferRender": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "destroy": true,
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    });

    $("#tablaLinea2").DataTable({
        "ajax": {
            "method": "GET",
            "url": "{{route('datos_icfes_lineas', 2)}}"
        },
        "columns": [{
                data: 'nombre'
            },
            {
                data: 'apellidos'
            },
            {
                data: 'documento'
            },
            {
                data: 'linea'
            },
            {
                data: 'grupo'
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `<td><strong>${data.ie}</strong></td>`
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 1 - LINEA 2');"><u>${data.s1}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.s1 - data.ie);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.s1 - data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 2 - LINEA 2');"><u>${data.s2}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.s2 - data.ie);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.s2 - data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 3 - LINEA 2');"><u>${data.s3}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.s3 - data.ie);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.s3 - data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5, '${data.nombre}', '${data.apellidos}', '- ICFES DE SALIDA - LINEA 2');"><u>${data.if}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.if-data.ie);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacion}</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.if-data.ie;
                    let variacionPor = 0

                    if (data.ie === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.ie) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                <td>${variacionPor} %</td>
                                            </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <div class="row">                                  
                                    <div class="col-xs-4 col-sm-4">
                                        <a href="/ver_estudiante/${data.id_student}?css=titulo-7#ti7" class="btn btn-block btn-sm  fa fa-eye" ></a>  
                                    </div>                                       
                                </div>
                                 
                                 `
                }
            },

        ],

        "deferRender": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "destroy": true,
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    });

    $("#tablaLinea3").DataTable({
        "ajax": {
            "method": "GET",
            "url": "{{route('datos_icfes_lineas', 3)}}"
        },
        "columns": [{
                data: 'nombre'
            },
            {
                data: 'apellidos'
            },
            {
                data: 'documento'
            },
            {
                data: 'linea'
            },
            {
                data: 'grupo'
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 1 - LINEA 3');"><u><strong>${data.s1}</strong></u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 2 - LINEA 3');"><u>${data.s2}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.s2 - data.s1);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.s2 - data.s1;
                    let variacionPor = 0

                    if (data.s1 === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.s1) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3, '${data.nombre}', '${data.apellidos}', '- SIMULACRO 3 - LINEA 3');"><u>${data.s3}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.s3 - data.s1);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.s3 - data.s1;
                    let variacionPor = 0

                    if (data.s1 === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.s1) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5, '${data.nombre}', '${data.apellidos}', '- ICFES DE SALIDA - LINEA 3');"><u>${data.if}</u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = Math.round(data.if-data.s1);
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacion}</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    let variacion = data.if-data.s1;
                    let variacionPor = 0

                    if (data.s1 === 0) {
                        variacionPor = 0
                    } else {
                        variacionPor = Math.round((Math.round(variacion) / data.s1) * 100)
                    }
                    let resultado;
                    if (variacion < 0) {
                        resultado = `<div style="background-color: #FE3F3F;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion > 0) {
                        resultado = `<div style="background-color: #34E82E;">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    if (variacion == 0) {
                        resultado = `<div ">
                                                    <td>${variacionPor} %</td>
                                                </div>`
                    }
                    return resultado
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                    <div class="row">                                  
                                        <div class="col-xs-4 col-sm-4">
                                            <a href="/ver_estudiante/${data.id_student}?css=titulo-7#ti7" class="btn btn-block btn-sm  fa fa-eye" ></a>  
                                        </div>                                       
                                    </div>
                                     
                                     `
                }
            },

        ],

        "deferRender": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "destroy": true,
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    });


    function abrirModal(id, idP, nom, apel, prueba) {
        const nombreModal = document.getElementById('nombreModal')
        const mensaje = document.getElementById('mensaje')
        
        if(nom !== undefined && apel !== undefined){
            nombreModal.innerHTML=`${nom} ${apel}` 
            mensaje.innerHTML = `${prueba} - RESULTADO POR AREA -` 
        }else {
            nombreModal.innerHTML=``
            mensaje.innerHTML = ``
        }
        fetch(`/pruebaAreas/${id}/${idP}`)
            .then(res => res.json())
            .then(data => {
                if (data.data === []) {
                    
                    $("#pruebaAreas").DataTable({
                        "processing": false,
                        "LoadingRecords": true,
                        "paging": true,
                        "deferRender": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "order": [0, 'desc'],
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "destroy": true,
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        "buttons": [
                            "copy",
                            "csv",
                            "excel",
                            "pdf",
                            "print",
                            "colvis"
                        ]
                    });
                } else {
                    
                    $("#pruebaAreas").DataTable({
                        "data": data.data,
                        "columns": [{
                                data: 'nombre'
                            },
                            {
                                data: 'calificacion'
                            }

                        ],

                        "processing": true,
                        "LoadingRecords": true,
                        "paging": true,
                        "deferRender": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "order": [0, 'desc'],
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "destroy": true,
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        "buttons": [
                            "copy",
                            "csv",
                            "excel",
                            "pdf",
                            "print",
                            "colvis"
                        ]
                    });
                }


            })


        $('#modal-areas').modal('show')
    }
</script>
{!!Html::script('/js/icfes.js')!!}">
@endpush
@endsection
