<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiante</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .imagen {
            margin-right: 10%;
            margin-left: 10%;
            text-align: center;
        }

        .contenedor {
            margin-left: 5%;
            margin-right: 5%;
        }
        .contenedor2 {
            margin-left: 5%;
            
        }

        .titulos {
            background: #1C2458;
            margin-right: 5%;
            margin-left: 5%;
            height: 4%;
            border-radius: 12px 12px 12px 12px;
            text-align: center;
        }

        .nombre_generales {
            padding-top: 2%;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        .contenido_nombre {
            margin-right: 5%;
            margin-left: 5%;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }

        img {
            height: 80px;
            width: 210px;
        }

        header {
            margin-top: 0;
            padding-top: 0;
        }

        #datos_generales td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }

        #datos_academicos td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }

        #datos_socioeconomicos td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }

        #datos_formalizacion td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }

        #datos_socioeducativos td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }
    </style>
</head>

<body>

    <header>
        <table style="padding-top: 0; margin-top: 0;">
            <thead>
                <tr>
                    <td>
                        <img src="https://todosytodasaestudiar.org/img/todosytodas.png" alt="">
                    </td>
                    <td style="text-align: center;">ESTRATEGIA TODAS Y TODOS A ESTUDIAR - UNIVALLE CONVENIO INTERADMINISTRATIVO No. 4143.010.27.1.8.-2021</td>
                    <td><img src="https://todosytodasaestudiar.org/img/logo.jpeg" alt=""></td>
                </tr>
            </thead>
        </table>
    </header>

    <br>

    @foreach ( $student as $data )

    <div class="imagen">
        @if ($foto != null)
        <img src="https://drive.google.com/uc?export=view&id={{$foto}}" alt="">
        @else
        <h1 style="color: red">SIN FOTO</h1>
        @endif
    </div>

    <div class="contenido_nombre">
        <h1>{{$data->name}} {{$data->lastname}}</h1>
    </div>
    <div class="titulos">
        <h3 class="nombre_generales">DATOS GENERALES</h3>
    </div>

    <div class="contenedor">
        <table id="datos_generales">
            <thead>
                <tr>
                    <td><strong>FECHA DE NACIMIENTO: </strong> {{$data->birth_date}}</td>
                    <td><strong>TIPO DE DOCUMENTO: </strong> {{$data->tipoD}}</td>
                    <td><strong>NUMERO DE DOCUMENTO: </strong> {{$data->document_number}}</td>
                </tr>
                <tr>
                    <td><strong>FECHA DE EXPEDICION DEL DOCUMENTO: </strong> {{$data->document_expedition_date}}</td>
                    <td><strong>DEPARTAMENTO DE NACIMIENTO: </strong>{{$data->departamento}}</td>
                    <td><strong>CIUDAD DE NACIMIENTO: </strong>{{$data->ciudad}}</td>
                </tr>
                <tr>
                    <td><strong>EMAIL: </strong>{{$data->email}}</td>
                    <td><strong>SEXO: </strong>{{$data->sex}}</td>
                    <td><strong>DIRECCION: </strong> {{$data->direction}}</td>
                </tr>
                <tr>
                    <td><strong>GENERO: </strong>{{$data->genero}}</td>
                    <td><strong>NUMERO TELEFONICO: </strong>{{$data->cellphone}}</td>
                    <td><strong>NUMERO TELEFONICO ALTERNATIVO: </strong>{{$data->phone}}</td>
                </tr>
                <tr>
                    <td><strong>BARRIO: </strong>{{$data->barrio}}</td>
                    <td><strong>CODIGO: </strong>{{$data->student_code}}</td>
                </tr>

            </thead>

        </table>



    </div>



    @endforeach

    <div class="titulos">
        <h3 class="nombre_generales">DATOS ACADEMICOS</h3>
    </div>

    <div class="contenedor">
        <table id="datos_academicos">
            <thead>
                <tr>
                    <td><strong>INSTITUCION: </strong>{{$academico['institution_name']}}</td>
                    <td><strong>AÑO DE GRADUACION: </strong>{{$academico['year_graduation']}}</td>
                    <td><strong>REGISTRO SNP: </strong>{{$academico['snp_register']}}</td>
                </tr>
                <tr>
                    <td><strong>TITULO DE BACHILLER: </strong>{{$academico['bachelor_title']}}</td>
                    <td><strong>FECHA ICFES: </strong>{{$academico['icfes_date']}}</td>
                    <td><strong>PUNTAJE ICFES: </strong>{{$academico['icfes_score']}}</td>
                </tr>
            </thead>
        </table>
    </div>

    <div class="titulos">
        <h3 class="nombre_generales">DATOS SOCIOECONOMICOS</h3>
    </div>

    <div class="contenedor">
        <table id="datos_socioeconomicos">
            <thead>
                <tr>
                    <td><strong>OCUPACION: </strong>{{$socioeconomico[0]->ocupacion}}</td>
                    <td><strong>ESTADO CIVIL: </strong>{{$socioeconomico[0]->estadoCivil}}</td>
                    <td><strong>ETNIA: </strong>{{$socioeconomico[0]->etnia}}</td>
                </tr>
                <tr>
                    <td><strong>NUMERO DE HIJOS: </strong>{{$socioeconomico[0]->hijos}}</td>
                    <td><strong>TIEMPO DE RESIDENCIA: </strong>{{$socioeconomico[0]->tiempoResidencia}}</td>
                    <td><strong>TIPO DE VIVIENDA: </strong>{{$socioeconomico[0]->tipoVivienda}}</td>
                </tr>
                <tr>
                    <td><strong>REGIMEN DE SALUD: </strong>{{$socioeconomico[0]->regimen}}</td>
                    <td><strong>CATEGORIA SISBEN: </strong>{{$socioeconomico[0]->sisben}}</td>
                    <td><strong>BENEFICIOS: </strong>{{$socioeconomico[0]->beneficio}}</td>
                </tr>
                <tr>
                    <td><strong>PERSONAS EN LA FAMILIA: </strong>{{$socioeconomico[0]->cantPersonas}}</td>
                    <td><strong>POSICION ECONOMICA: </strong>{{$socioeconomico[0]->posEconomica}}</td>
                    <td><strong>PERSONAS A CARGO: </strong>{{$socioeconomico[0]->perCargo}}</td>
                </tr>
                <tr>
                    <td><strong>INTERNET EN LA ZONA: </strong>{{$socioeconomico[0]->internetZon}}</td>
                    <td><strong>INTERNET EN LA CASA: </strong>{{$socioeconomico[0]->internetHom}}</td>
                    <td><strong>SEXO DOCUMENTO DE IDENTIDAD: </strong>{{$socioeconomico[0]->sexo}}</td>
                </tr>
                <tr>
                    <td><strong>CONDICION SOCIAL: </strong>{{$socioeconomico[0]->condicionS}}</td>
                    <td><strong>DISCAPACIDAD: </strong>{{$socioeconomico[0]->discapacidad}}</td>
                </tr>
            </thead>
        </table>
    </div>

    <div class="titulos">
        <h3 class="nombre_generales">SEGUIMIENTO SOCIOEDUCATIVO</h3>
    </div>

    <div class="contenedor2">
        <table id="datos_socioeducativos">
            <thead>
                <tr>
                    <td><strong>PROFESIONAL DE ACOMPAÑAMIENTO: </strong> NOMBRE Y APELLIDOS</td>
                </tr>
            </thead>
        </table>
        <br>
        <table id="datos_socioeducativos">
            <thead>
                <tr>
                    <td><strong>SEGUIMIENTO (YYYY-mm-dd): -</strong>2022-05-17</td>
                    <td><strong>R.I: </strong>----</td>
                    <td><strong>R.A: </strong>MEDIO</td>
                    <td><strong>R.F: </strong>----</td>
                </tr>
                <tr>
                    
                    <td><strong>R.E: </strong>ALTO</td>
                    <td><strong>R.V: </strong>----</td>
                </tr>
            </thead>
            
        </table>

    </div>
    
    <div class="titulos">
        <h3 class="nombre_generales">ASISTENCIAS</h3>
    </div>

    <br>
    <div class="titulos">
        <h3 class="nombre_generales">FORMALIZACION</h3>
    </div>
    <div class="contenedor">
        <h4>ACEPTACION</h4>
        <table id="datos_formalizacion">
            <thead>
                <tr>

                    <td><strong>URL aceptacion: </strong>{{$formalization["acepptance_v2"]}}</td>
                </tr>
            </thead>
        </table>
        <h4>TABLETS</h4>
        <table>
            <thead>
                <tr>

                    <td><strong>URL Tablet: </strong>{{$formalization["tablets_v2"]}}</td>
                    <td><strong>Serial tablet: </strong>{{$formalization["serial_tablet"]}}</td>
                </tr>

            </thead>
        </table>
    </div>
</body>

</html>