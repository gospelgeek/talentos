@extends('layouts.dashboard')

@section('title', 'Perfil Estudiante')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<!--<div class="col-xs-12 col-md-8">
    <form method="POST" action="store/save/usuarios" accept-charset="UTF-8" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class=" col-xs-12 col-md-8">
                  {!!Form::label('archivo','Seleccione Archivo:')!!}                            
                  {!!Form::file('file',[ 'accept'=>'.xls,.xlsx','class'=>'form-control-file form-group','required'])!!}
                        
                        <button type="submit" class="btn btn-danger bg-lg form-group btn-block">Enviar</button>
                      </div>
    </form>
</div>-->

</div>

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">
    <h1 style="text-align:center;">ESTUDIANTES</h1>
    <div class="card">
        <div class="card-body">
            @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1)
            <div class="btn-group">
                <div class="col-xs-6 col-md-5 col-sm-3">
                    <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Crear Perfil</a>
                </div>
                <div class="col-xs-6 col-md-12 col-sm-6">


                    <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('sabana_export')}}">EXPORTAR S&Aacute;BANA</a>

                </div>


            </div>

            <div class="row justify-content-md-center">
                <col-sm>
                    <h5 class="mr-3 mt-2">DESCARGAR LISTADO DE GRUPOS DE:</h5>
                </col-sm>
                <div class="col-sm">
                    <div class="col-md-4">
                        <input class="form-control" id="texto_listado" placeholder="Ingrese el titulo del listado a descargar" type="text">
                    </div>
                </div>

            </div>
            <br>
            <div class="row justify-content-md-center">
                <div class="col-sm-3">

                </div>
                &nbsp;
			&nbsp;
                &nbsp;
                &nbsp;
			    &nbsp;
                &nbsp;
                <div class="col-sm">
                    <button id="L_1" class="btn btn-primary btn-sm-10 mr-3 mb-3 float-left" >Linea 1</button>
                    <button id="L_2" class="btn btn-primary btn-sm-10 mr-3 mb-3 float-left" >Linea 2</button>
                    <button id="L_3" class="btn btn-primary btn-sm-10 mr-3 mb-3 float-left" >Linea 3</button>
                </div>

            </div>
            @endif


            <div class="table-responsive">

                <table id="example1" class=" table table-bordered table-striped">

                    <thead>

                        <tr>
                            <td>Nombres</td>
                            <td>Apellidos</td>
                            <td>Tipo Documento</td>
                            <td>Fecha expedicion documento</td>
                            <td>Nº Documento</td>
                            <td>Codigo</td>
                            <td>Email</td>
                            <td>Telefono</td>
                            <td id="group">Grupo</td>
                            <td>Cohorte</td>
                            <td>Fecha nacimiento</td>
                            <td>Edad</td>
                            <td>Dpto. Nacimiento</td>
                            <td>Ciudad Nacimiento</td>
                            <td>Sexo</td>
                            <td>Genero</td>
                            <td>Direcion</td>
                            <td>Comuna</td>
                            <td>Barrio</td>
                            <td>Tel. Alternativo</td>
                            <td>Tutor</td>
                            <td>Estado</td>
                            <td>Estado Civil</td>
                            <td>Etnia</td>
                            <td>Institucion</td>
                            <td id="botons" width="15%">Acciones</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<!-- Page specific script -->
<script>

    const texto = document.getElementById('texto_listado')
    const l1 = document.getElementById('L_1')
    const l2 = document.getElementById('L_2')
    const l3 = document.getElementById('L_3')

    l1.addEventListener('click', (e) => {
        descargarListado(1)
    })
    l2.addEventListener('click', (e) => {
        descargarListado(2)
    })
    l3.addEventListener('click', (e) => {
        descargarListado(3)
    })

    function descargarListado(linea){
        if(texto.value){
            return location.href=`/listado_estudiantes_grupo/${linea}/${texto.value}`
        }
        toastr.warning(`Debe ingresar el Texto, no debe estar vacio para la descarga del listado de estudiantes de Linea ${linea}`)

    }
    /*$('input[type="checkbox"]').change(function (){
    var ver = $("input[name=filtro]:checked").val();
});*/


    /*
        var table = $("#example1").DataTable({

            "ajax": {
                "method": "GET",
                "url": "{{route('datos.estudiantes')}}",
            },

            "columns": [{
                    data: 'name'
                },
                {
                    data: 'lastname'
                },
                {
                    data: 'tipodocumento',
                    visible: false
                },
                {
                    data: 'document_expedition_date',
                    visible: false
                },
                {
                    data: 'document_number'
                },
                {
                    data: 'student_code'
                },
                {
                    data: 'email'
                },
                {
                    data: 'cellphone'
                },
                {
                    data: 'namegrupo'
                },
                {
                    data: 'cohorte'
                },
                {
                    data: 'birth_date',
                    visible: false
                },
                {
                    data: 'edad',
                    visible: false
                },
                {
                    data: 'departamentoN',
                    visible: false
                },
                {
                    data: 'ciudadN',
                    visible: false
                },
                {
                    data: 'sex',
                    visible: false
                },
                {
                    data: 'genero',
                    visible: false
                },
                {
                    data: 'direction',
                    visible: false
                },
                {
                    data: 'comuna',
                    visible: false
                },
                {
                    data: 'barrio',
                    visible: false
                },
                {
                    data: 'phone',
                    visible: false
                },
                {
                    data: 'tutor',
                    visible: false
                },
                {
                    data: 'estado',
                    visible: false
                },
                {
                    data: 'nombreEstadocivil',
                    visible: false
                },
                {
                    data: 'nombreEtnia',
                    visible: false
                },
                {
                    data: 'colegio',
                    visible: false
                },

                {
                    data: null,
                    render: function(data, type, row, meta) {
                        var rol = document.getElementById('roles').value;
                        var mstr;
                        if (rol == 4 || rol == 1 || rol == 2 || rol == 6) {
                            mstr = '<div class="btn-group">' +
                                '<div class="col-xs-6 col-sm-6 btn-group">' +
                                '<tr id="1">' + '<td">' + '<a href="ver_estudiante/' + data.id + '" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>' + '</td>' + '</tr>' +
                                '</div>' +
                                '<div class="col-xs-6 col-sm-6 btn-group">' +
                                '<a href="editar_estudiante/' + data.id + '" class="btn btn-block fa fa-pencil-square-o fa" title="Editar seguimiento"></a>' +
                                '</div>' +

                                "</div>";
                        } else {
                            mstr = '<div class="btn-group">' +
                                '<div class="col-xs-6 col-sm-6 btn-group">' +
                                '<a href="ver_estudiante/' + data.id + '" class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></a>' +
                                "</div>" +
                                "</div>";
                        }

                        return mstr;
                    }
                }

            ],

            "deferRender": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel",
                "pdf",
                "print",
                "colvis"

            ]
        });*/
</script>


@endpush
@endsection