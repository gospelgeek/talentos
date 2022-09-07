@extends('layouts.dashboard')
@section('title', 'Icfes')
@section('icfes')
<style>
    #tablaLinea1 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea1 td:nth-child(8) {
        border-right: black solid 1px;

    }

    #tablaLinea1 td:nth-child(9) {

        border-left: black solid 1px;
    }

    #tablaLinea1 td:nth-child(10) {
        border-right: black solid 2px;

    }

    #tablaLinea1 td {
        text-align: center;
    }

    #tablaLinea2 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea2 td:nth-child(8) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(9) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(10) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(11) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(12) {
        border-right: black solid 1px;

    }

    #tablaLinea2 td:nth-child(13) {

        border-left: black solid 1px;
    }

    #tablaLinea2 td:nth-child(14) {
        border-right: black solid 2px;

    }

    #tablaLinea2 td {
        text-align: center;
    }


    #tablaLinea3 td:nth-child(7) {

        border-left: black solid 2px;
    }

    #tablaLinea3 td:nth-child(8) {
        border-right: black solid 1px;

    }

    #tablaLinea3 td:nth-child(9) {

        border-left: black solid 1px;
    }

    #tablaLinea3 td:nth-child(10) {
        border-right: black solid 1px;

    }

    #tablaLinea3 td:nth-child(11) {

        border-left: black solid 1px;
    }

    #tablaLinea3 td:nth-child(12) {
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
                <div class="col-md-2">
                    <label for="">ELIJA LA COHORTE: </label>
                    <select class="form-control" name="opcion" id="opcion">
                        <option default value="0">-----</option>
                        <option value="1">LINEA 1</option>
                        <option value="2">LINEA 2</option>
                        <option value="3">LINEA 3</option>
                    </select>
                </div>
                <div class="row">
                    &nbsp;
                    <div class="col-ms-2">
                        <label for="">CAMBIAR A PORCENTAJE</label>
                    </div>
                    &nbsp;
                    &nbsp;
                    <div class="col-ms-4">
                        <input class="form-control mt-0" style="width: 20px; height: 19px;" type="checkbox" id="cambio">
                    </div>
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
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV2">Puntos Variacion</td>
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
                                <td align="center">Simulacro 2</td>
                                <td align="center" id="pV4">Puntos Variacion</td>
                                <td align="center">Simulacro 3</td>
                                <td align="center" id="pV5">Puntos Variacion</td>
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV6">Puntos Variacion</td>
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
                                <td align="center">Simulacro 3</td>
                                <td align="center" id="pV8">Puntos Variacion</td>
                                <td align="center">Icfes De Salida</td>
                                <td align="center" id="pV9">Puntos Variacion</td>
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

@push('scripts')

<script>
    
    const cambio = document.getElementById("cambio")
    const pv1 = document.getElementById('pV1')
    const pv2 = document.getElementById('pV2')
    const pv3 = document.getElementById('pV3')
    const pv4 = document.getElementById('pV4')
    const pv5 = document.getElementById('pV5')
    const pv6 = document.getElementById('pV6')
    const pv7 = document.getElementById('pV7')
    const pv8 = document.getElementById('pV8')
    const pv9 = document.getElementById('pV9')
    
    cambio.addEventListener('change', () => {

        console.log(cambio.checked)
        if (cambio.checked === true) {
            puntosDeVariacionConPorcentaje()
            pv1.innerHTML = `Porcentaje`
            pv2.innerHTML = `Porcentaje`
            pv3.innerHTML = `Porcentaje`
            pv4.innerHTML = `Porcentaje`
            pv5.innerHTML = `Porcentaje`
            pv6.innerHTML = `Porcentaje`
            pv7.innerHTML = `Porcentaje`
            pv8.innerHTML = `Porcentaje`
            pv9.innerHTML = `Porcentaje`
        }

        if (cambio.checked === false) {
            puntosDeVariacionSinPorcentaje()
            pv1.innerHTML=`Puntos Variacion`
            pv2.innerHTML=`Puntos Variacion`
            pv3.innerHTML=`Puntos Variacion`
            pv4.innerHTML=`Puntos Variacion`
            pv5.innerHTML=`Puntos Variacion`
            pv6.innerHTML=`Puntos Variacion`
            pv7.innerHTML=`Puntos Variacion`
            pv8.innerHTML=`Puntos Variacion`
            pv9.innerHTML=`Puntos Variacion`
        }

    })

    function puntosDeVariacionSinPorcentaje() {

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
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                       
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
                        return `
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                       
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
            "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u>${data.s1}</u></button>
                                   
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
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
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
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
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
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
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
            "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u><strong>${data.s1}</strong></u></button>
                                   
                                `
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
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
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
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
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
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
            "responsive": true,
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

    }

    function puntosDeVariacionConPorcentaje() {

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
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                       
                    `
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
                    <button class="btn" type="button" onclick="abrirModal(${data.nombre},${data.id_student}, 5);"><u>${data.if}</u></button>
                       
                    `
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
            "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u>${data.s1}</u></button>
                                   
                                `
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
                                `
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
                                `
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
                                `
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
            "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u><strong>${data.s1}</strong></u></button>
                                   
                                `
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
                                `
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
                                `
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
                                `
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
            "responsive": true,
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
    }


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
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                       
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
                    return `
                    <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                       
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
        "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u>${data.s1}</u></button>
                                   
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
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
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
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
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
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
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
        "responsive": true,
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
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 1);"><u><strong>${data.s1}</strong></u></button>
                                   
                                `
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 2);"><u>${data.s2}</u></button>
                                   
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
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 3);"><u>${data.s3}</u></button>
                                   
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
                    return `
                                <button class="btn" type="button" onclick="abrirModal(${data.id_student}, 5);"><u>${data.if}</u></button>
                                   
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
        "responsive": true,
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


    function abrirModal(id, idP) {
        
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
                        /*"ajax": {
                            "method": "GET",
                            "url": `/pruebaAreas/${id}/${idP}`
                        },*/
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
