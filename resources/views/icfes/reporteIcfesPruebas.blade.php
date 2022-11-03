@extends('layouts.dashboard')
@section('title', 'Reporte Pruebas Icfes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="content-fluid">
    <h1 style="text-align:center;">RESULTADOS ICFES</h1>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-2">
                    <button class="btn btn-primary" id="Ricfes">REGISTRO DE RESULTADO ICFES</button>
                </div>
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
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>URL SOPORTE</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>

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
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>URL SOPORTE</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>

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
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>URL SOPORTE</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>

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
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>URL SOPORTE</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>

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
                                <td>LECTURA CRITICA</td>
                                <td>MATEMATICAS</td>
                                <td>CIENCIAS SOCIALES</td>
                                <td>CIENCIAS NATURALES</td>
                                <td>INGLES</td>
                                <td>TOTAL</td>
                                <td>URL SOPORTE</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('icfes.form_update')
@include('icfes.registro_pruebas')

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

            url.value = url.value || ""
            puntaje.value = puntaje.value
            lecturaC.value = lecturaC.value
            mate.value = mate.value
            cienS.value = cienS.value
            cienN.value = cienN.value
            ingles.value = ingles.value

            

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
                    switch (_prueba) {
                        case 1:
                            renderTable("S1", _prueba).ajax.reload(null, false)
                            break;

                        case 2:
                            renderTable("S2", _prueba).ajax.reload(null, false)
                            break;

                        case 3:
                            renderTable("S3", _prueba).ajax.reload(null, false)
                            break;

                        case 4:
                            renderTable("En", _prueba).ajax.reload(null, false)
                            break;

                        case 5:
                            renderTable("Sal", _prueba).ajax.reload(null, false)
                            break;

                        default:
                            break;
                    }

                },
                error: function(result) {
                    toastr.info('Ocurrio un error inesperado :(')
                },
            });
        })

    }

    const registroIcfes = document.getElementById('Ricfes')

    registroIcfes.addEventListener('click', () => {
        $('#modal-registro').modal('show')
    })

    const r_areas = document.getElementById('r_areas')
    const fm_areas = document.getElementById('form_areas2')
    const _guardar = document.getElementById('_guardar')
    const _formRegistro = document.getElementById('_registro')

    _guardar.addEventListener('click', (e) => {
        e.preventDefault()
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
                    if (result.mensaje !== "no") {
                        _formRegistro.reset()
                        toastr.info(`${result.mensaje}`);
                        renderTable("Sal", _formRegistro['prueba'].value).row.add({
                            documento: result.estudiante.document_number,
                            nombre: result.estudiante.name,
                            apellidos: result.estudiante.lastname,
                            grupo: result.grupo,
                            codigo: result.estudiante.student_code,
                            linea: result.linea,
                            LC: result.lecturaCritica,
                            MT: result.matematicas,
                            CS: result.cienciasSociales,
                            CN: result.cienciasNaturales,
                            ING: result.ingles,
                            Total: result.total,
                            url: result.url
                        }).draw()
                    } else {
                        toastr.info(`El estudiante ya cuenta con registro de icfes de salida`);
                    }

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

    function renderTable(tabla, prueba) {
        let table = $(`#prueba${tabla}`).DataTable({
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
                    data: 'LC',
                    
                },
                {
                    data: 'MT',
                    
                },
                {
                    data: 'CS',
                    
                },
                {
                    data: 'CN',
                    
                },
                {
                    data: 'ING',
                    
                },
                {
                    data: 'Total',
                    
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<a id="url${data.documento}" href="${data.url}">${data.url}</a>`
                    }
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
                                    <a id="editar" onClick="editarModal(${data.documento},'${data.url}',${data.Total},${data.LC},${data.MT},${data.CS},${data.CN},${data.ING}, ${prueba})" class="btn btn-block fa fa-pencil-square-o fa">
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
            "scrollX": true,
            "autoWidth": true,
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
        return table
    }

    renderTable("S1", 1)
    renderTable("S2", 2)
    renderTable("S3", 3)
    renderTable("En", 4)
    renderTable("Sal", 5)
</script>

@endpush
@endsection
