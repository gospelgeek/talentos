@extends('layouts.dashboard')
@section('title', 'Reporte Pruebas Icfes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="content-fluid">
    <h1 style="text-align:center;">PRUEBAS ICFES</h1>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-2">
                    <label for="">ELIJA LA PRUEBA DE ICFES: </label>
                    <select class="form-control" name="opcion" id="opcion">
                        <option default value="0">-----</option>
                        <option value="1">ICFES DE ENTRADA</option>
                        <option value="2">SIMULACRO 1</option>
                        <option value="3">SIMULACRO 2</option>
                        <option value="4">SIMULACRO 3</option>
                        <option value="5">ICFES DE SALIDA</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div id="s1" class="row" hidden>
                <div class="col-sm">
                    <table id="pruebaS1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>DOCUMENTO</td>
                                <td>NOMBRE</td>
                                <td>APELLIDOS</td>
                                <td>CODIGO</td>
                                <td>GRUPO</td>
                                <td>LINEA</td>
                                <td>URL SOPORTE</td>
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="s2" class="row" hidden>
                <div class="col-sm">
                    <table id="pruebaS2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>DOCUMENTO</td>
                                <td>NOMBRE</td>
                                <td>APELLIDOS</td>
                                <td>CODIGO</td>
                                <td>GRUPO</td>
                                <td>LINEA</td>
                                <td>URL SOPORTE</td>
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="s3" class="row" hidden>
                <div class="col-sm">
                    <table id="pruebaS3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>DOCUMENTO</td>
                                <td>NOMBRE</td>
                                <td>APELLIDOS</td>
                                <td>CODIGO</td>
                                <td>GRUPO</td>
                                <td>LINEA</td>
                                <td>URL SOPORTE</td>
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="en" class="row" hidden>
                <div class="col-sm">
                    <table id="pruebaEn" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>DOCUMENTO</td>
                                <td>NOMBRE</td>
                                <td>APELLIDOS</td>
                                <td>CODIGO</td>
                                <td>GRUPO</td>
                                <td>LINEA</td>
                                <td>URL SOPORTE</td>
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="sal" class="row" hidden>
                <div class="col-sm">
                    <table id="pruebaSal" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>DOCUMENTO</td>
                                <td>NOMBRE</td>
                                <td>APELLIDOS</td>
                                <td>CODIGO</td>
                                <td>GRUPO</td>
                                <td>LINEA</td>
                                <td>URL SOPORTE</td>
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('icfes.form_update')


@push('scripts')

<script>
    const opcion = document.getElementById('opcion')
    const s_1 = document.getElementById('s1')
    const s_2 = document.getElementById('s2')
    const s_3 = document.getElementById('s3')
    const en = document.getElementById('en')
    const sal = document.getElementById('sal')
    const _formUpdate = document.getElementById('_update')
    const _actualizar = document.getElementById('_actualizar')

    opcion.addEventListener('change', () => {
        if (opcion.value === "1") {
            s_1.setAttribute('hidden', '')
            s_2.setAttribute('hidden', '')
            s_3.setAttribute('hidden', '')
            en.removeAttribute('hidden')
            sal.setAttribute('hidden', '')
        }

        if (opcion.value === "2") {
            s_1.removeAttribute('hidden')
            s_2.setAttribute('hidden', '')
            s_3.setAttribute('hidden', '')
            en.setAttribute('hidden', '')
            sal.setAttribute('hidden', '')
        }

        if (opcion.value === "3") {
            s_1.setAttribute('hidden', '')
            s_2.removeAttribute('hidden')
            s_3.setAttribute('hidden', '')
            en.setAttribute('hidden', '')
            sal.setAttribute('hidden', '')
        }

        if (opcion.value === "4") {
            s_1.setAttribute('hidden', '')
            s_2.setAttribute('hidden', '')
            s_3.removeAttribute('hidden')
            en.setAttribute('hidden', '')
            sal.setAttribute('hidden', '')
        }

        if (opcion.value === "5") {
            s_1.setAttribute('hidden', '')
            s_2.setAttribute('hidden', '')
            s_3.setAttribute('hidden', '')
            en.setAttribute('hidden', '')
            sal.removeAttribute('hidden')
        }

    })

    function actualizar(doc, pb, datos) {

        console.log(datos)



    }

    function editarModal(documento, _url, Total, LC, MT, CS, CN, IN, _prueba) {
        $('#modal-update').modal('show')
        let iden = _formUpdate['identificacion']
        let url = _formUpdate['url']
        let pruebaV = _formUpdate['pruebaVista']
        let prueba = _formUpdate['prueba']
        let puntaje = _formUpdate['puntaje']
        let lecturaC = _formUpdate['lecturaC']
        let mate = _formUpdate['mate']
        let cienS = _formUpdate['cienS']
        let cienN = _formUpdate['cienN']
        let ingles = _formUpdate['ingles']

        switch (_prueba) {
            case 1:
                pruebaV.value = "Simulacro 1"
                pruebaV.setAttribute('disabled', '')
                prueba.value = 1
                break;

            case 2:
                pruebaV.value = "Simulacro 2"
                pruebaV.setAttribute('disabled', '')
                prueba.value = 2
                break;

            case 3:
                pruebaV.value = "Simulacro 3"
                pruebaV.setAttribute('disabled', '')
                prueba.value = 3
                break;

            case 4:
                pruebaV.value = "Icfes de entrada"
                pruebaV.setAttribute('disabled', '')
                prueba.value = 4
                break;

            case 5:
                pruebaV.value = "Icfes de salida"
                pruebaV.setAttribute('disabled', '')
                prueba.value = 5
                break;

            default:
                break;
        }

        iden.value = documento
        url.value = _url
        puntaje.value = parseInt(Total)
        lecturaC.value = parseInt(LC)
        mate.value = parseInt(MT)
        cienS.value = parseInt(CS)
        cienN.value = parseInt(CN)
        ingles.value = parseInt(IN)

        let datos

        _actualizar.addEventListener('click', (e) => {
            e.preventDefault()
            const edt = document.getElementById(`edit${documento}`)
            url.value = url.value || ""
            puntaje.value = puntaje.value
            lecturaC.value = lecturaC.value
            mate.value = mate.value
            cienS.value = cienS.value
            cienN.value = cienN.value
            ingles.value = ingles.value

            //console.log(datos)

            $.ajax({
                url: '/actualizacion_icfes/' + iden.value + "/" + prueba.value,
                type: 'POST',
                data: {
                    '_token': $('input[name=_token]').val(),
                    "documento": iden.value,
                    "url": url.value,
                    "puntajeT": puntaje.value,
                    "lc": lecturaC.value,
                    "mt": mate.value,
                    "cs": cienS.value,
                    "cn": cienN.value,
                    "in": ingles.value,
                },
                success: function(result) {
                    toastr.info(`Actualizacion ${result.mensaje}`);
                    //datos = {}
                    edt.style.backgroundColor = "#FFD54F"
                },
                error: function(result) {
                    toastr.info('Ocurrio un error inesperado :(')
                },
            });
        })

    }

    function renderTable(tabla, prueba) {
        $(`#prueba${tabla}`).DataTable({
            //"data": data.data,
            "ajax": {
                "method": "GET",
                "url": `/datos_prueba/${prueba}`
            },
            "columns": [{
                    data: 'documento'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'apellidos'
                },
                {
                    data: 'codigo'
                },
                {
                    data: 'grupo'
                },
                {
                    data: 'linea'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<a id="url${data.documento}" href="${data.url}">${data.url}</a>`
                    }
                },
                {
                    data: 'LC',
                },
                {
                    data: 'MT'
                },
                {
                    data: 'CS'
                },
                {
                    data: 'CN'
                },
                {
                    data: 'IN'
                },
                {
                    data: 'Total'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                            <div class="btn-group">                                  
                                <div class="col-xs-6 col-sm-6 btn-group">
                                    <a href="/ver_estudiante/${data.id_student}?css=titulo-7#ti7" class="btn btn-block btn-sm  fa fa-eye" ></a>  
                                </div> 
                                <div id="edit${data.documento}" class="col-xs-6 col-sm-6 btn-group">
                                    <a id="editar" onClick="editarModal(${data.documento},'${data.url}',${data.Total},${data.LC},${data.MT},${data.CS},${data.CN},${data.IN}, ${prueba})" class="btn btn-block fa fa-pencil-square-o fa">
                                    </a>
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
    }

    renderTable("S1", 1)
    renderTable("S2", 2)
    renderTable("S3", 3)
    renderTable("En", 4)
    renderTable("Sal", 5)
</script>

@endpush
@endsection