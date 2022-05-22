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

        .titulos {
            background: #1C2458;
            margin-right: 5%;
            margin-left: 5%;
            height: 6%;
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
        }
        img {
            height: 100px;
            width: 200px;
        }
    </style>
</head>

<body>

    <header>
    <table>
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
        <img src="https://drive.google.com/uc?id={{$foto}}" alt="">
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
        <table>
            <thead>
                <tr>
                    <td><strong>FECHA DE NACIMIENTO: </strong> {{$data->birth_date}}</td>
                    <td><strong>TIPO DE DOCUMENTO: </strong> {{$data->tipoD}}</td>
                </tr>
                <tr>
                    <td><strong>NUMERO DE DOCUMENTO: </strong> {{$data->document_number}}</td>
                    <td><strong>FECHA DE EXPEDICION DEL DOCUMENTO: </strong> {{$data->document_expedition_date}}</td>

                </tr>
                <tr>
                    <td><strong>DEPARTAMENTO DE NACIMIENTO: </strong>{{$data->departamento}}</td>
                    <td><strong>CIUDAD DE NACIMIENTO: </strong>{{$data->ciudad}}</td>
                </tr>
                <tr>
                    <td><strong>EMAIL: </strong>{{$data->email}}</td>
                    <td><strong>SEXO: </strong>{{$data->sex}}</td>
                </tr>
                <tr>
                    <td><strong>DIRECCION: </strong> {{$data->direction}}</td>
                    <td><strong>GENERO: </strong>{{$data->genero}}</td>
                </tr>
                <tr>
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
    <br>
    <div class="titulos">
        <h3 class="nombre_generales">FORMALIZACION</h3>
    </div>
    <div class="contenedor">
    <h4>ACEPTACION</h4>
        <table>
            <thead>
                <tr>
                    
                    <td><strong>URL aceptacion V1: </strong>{{$formalization["acepptance_v1"]}}</td>
                    <td><strong>URL aceptacion V2: </strong>{{$formalization["acepptance_v2"]}}</td>
                </tr>
            </thead>
        </table>
        <h4>TABLETS</h4>
        <table>
            <thead>
                <tr>
                   
                    <td><strong>URL Tablet V1: </strong>{{$formalization["tablets_v1"]}}</td>
                    <td><strong>URL Tablet V2: </strong>{{$formalization["tablets_v2"]}}</td>
                </tr>
                <tr>
                    <td><strong>Serial tablet: </strong>{{$formalization["serial_tablet"]}}</td>
                </tr>
            </thead>
        </table>
    </div>
</body>

</html>
