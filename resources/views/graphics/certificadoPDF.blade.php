<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body{
            padding: 0;
            margin: 0;
        }
        .titulo{
            margin-top: 12%;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }
        .cuerpo{
            margin-top: 7%;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
        }
        .cohorte{
            margin-top: 8%;
            font-family: Arial, Helvetica, sans-serif;
        }
        .generacion{
            margin-top: 6%;
            font-family: Arial, Helvetica, sans-serif;
        }
        img {
            height: 80px;
            width: 210px;
        }
        header{
            margin-top: 0;
            padding-top: 0;
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

    <div class="contenido">

        <div class="titulo">
            <h2>EL PROYECTO PLAN DE NIVELACION ACADEMICA</h2>
            <h2>CERTIFICA QUE</h2>
        </div>

        <div class="cuerpo">
        {{$data[0]->nombre}} {{$data[0]->apellidos}}, identificado(a) con número
         de {{$data[0]->tipo_documento}}: {{$data[0]->numero_identificacion}}, 
        se encuentra actualmente vinculado cómo beneficiario del Proyecto Todos y Todas a 
        estudiar de la Alcaldía de Santiago de Cali en conjunto con la Universidad del Valle.
        </div>

        <div class="cohorte">
        La persona mencionada pertenece a la Linea {{$data[0]->linea}}, en el grupo {{$data[0]->grupo}}
        </div>

        <div class="generacion">
        Generado el: {{$fecha}}
        Este certificado tiene vigencia por un mes a partir de la fecha de generación.
        </div>
    </div>

</body>

</html>