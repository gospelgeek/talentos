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
            /*background-image: url('http://localhost:8000/img/membrete.png');*/
        }
        
        .titulo{
            margin-top: 12px;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }
        .cuerpo{
            margin-top: 3%;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
            font-size: small;
            text-align: justify;
        }
        .cohorte{
            margin-top: 3%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
            text-align: justify;
        }
        .generacion{
            margin-top: 3%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
            text-align: justify;
        }
        .generacion p{
            margin-top: 3%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
            text-align: justify;
        }
        .en {
            padding: 0%;
            padding-top: 0%;
            margin-left: 0%;
            margin-right: 0%;
            margin: 0%;
            margin-bottom: 0%;
            height: 100px;
            width: 750px;
        }
        .pie {
            height: 90px;
            width: 650px;
        }
        header{
            margin: 0%;
            padding: 0%;
        }
    </style>
</head>

<body>
    
        
        <!--
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
        </table>-->
    

    <div class="contenido">
    
        <img class="en" src="https://todosytodasaestudiar.org/img/enca2.png" alt="">
        <br><br><br>
        @if($data[0]->linea == "LINEA 2")

        <div class="titulo">
            <h2>DE LA DIRECCIÓN DE EXTENSIÓN Y EDUCACIÓN CONTINUA DE LA UNIVERSIDAD DEL VALLE </h2>
            <h2>SE INFORMA </h2>
        </div>

        <div class="cuerpo">
        En el marco del Convenio Interadministrativo No. 4143.010.27.1.8 2021 suscrito 
        entre la Alcaldía de Santiago de Cali-Secretaría de Educación y la Universidad 
        del Valle, para la ejecución de tres de las líneas de intervención de la estrategia 
        Todas y Todos a Estudiar, el (la) joven {{$data[0]->nombre}} {{$data[0]->apellidos}} 
        identificado con tipo de documento {{$data[0]->tipo_documento}} de número {{$data[0]->numero_identificacion}}, 
        es beneficiario (a) de la línea Talentos Egresados.
        </div>

        <div class="cohorte">
        La línea Talentos Egresados tiene como objetivo desarrollar actividades de nivelación 
        académica para que 1000 jóvenes egresados de educación media de estratos 1, 2 y 3 puedan 
        presentar de nuevo las pruebas SABER 11 y mejorar sus resultados, obteniendo mayores 
        oportunidades de ingreso en la Educación Superior. 
        
        </div>

        <div class="generacion">
        Por lo tanto, el (la) beneficiario (o) cursa en la Universidad del Valle el Plan de 
        Nivelación Académica Univalle-Todas y Todos a Estudiar, en el cual participa de un 
        proceso de formación integral entre los meses de febrero y octubre del 2022, de lunes a
         viernes con una intensidad diaria de 4 horas virtuales, y el sábado con una intensidad 
         diaria de 8 horas presenciales. En el desarrollo de este proceso formativo, el joven 
         beneficiario participa de un programa de nivelación académica, orientación vocacional, 
         vida universitaria y cultura democrática, con elementos formativos tanto del orden académico 
         como social, ético, cultural y político; adicionalmente tiene acceso a una asistencia económica
          para apoyar los gastos en que se incurren durante el desarrollo del proceso formativo.
        </div>

        <div class="generacion">
        <p>Se firma en Santiago de Cali, a los {{$dia}} días del mes de {{$mes}} del {{$anio}}.</p>
        <p>Atentamente,</p>
        </div>

        <div class="generacion">
        Tulio Gerardo Motoa Garavito
        <br>
        Director Proyecto Convenio No. 4143.010.27.1.8.-2021
        </div>
        @endif

        @if($data[0]->linea == "LINEA 1")

        <div class="titulo">
            <h2>DE LA DIRECCIÓN DE EXTENSIÓN Y EDUCACIÓN CONTINUA DE LA UNIVERSIDAD DEL VALLE   </h2>
            <h2>SE INFORMA </h2>
        </div>

        <div class="cuerpo">

        En el marco del Convenio Interadministrativo No. 4143.010.27.1.8 2021 suscrito entre la 
        Alcaldía de Santiago de Cali - Secretaría de Educación y la Universidad del Valle, para 
        la ejecución de tres de las líneas de intervención de la estrategia Todas y Todos a Estudiar, 
        el (la) joven {{$data[0]->nombre}} {{$data[0]->apellidos}} identificado con tipo de documento 
        {{$data[0]->tipo_documento}} de número {{$data[0]->numero_identificacion}}, 
        es beneficiario (a) de la línea Año Cero

        </div>

        <div class="cohorte">
        La línea Año Cero tiene como objetivo posibilitar el ingreso, de acuerdo con las condiciones 
        que la Universidad del Valle ha previsto, de 1000 jóvenes egresados de educación media de estratos 
        1, 2 y 3, a programas académicos de esta institución.  
        
        </div>

        <div class="generacion">
        Por lo tanto, el (la) beneficiario (o) cursa en la Universidad del Valle el Plan de Nivelación
         Académica Univalle - Todas y Todos a Estudiar, en el cual participa de un proceso de 
         formación integral entre los meses de febrero y octubre del 2022, de lunes a viernes 
         con una intensidad diaria de 4 horas virtuales, y el sábado con una intensidad diaria 
         de 8 horas presenciales. En el desarrollo de este proceso formativo, el joven beneficiario 
         participa de un programa de nivelación académica, orientación vocacional, vida universitaria y 
         cultura democrática, con elementos formativos tanto del orden académico como social, ético, cultural
          y político; adicionalmente tiene acceso a una asistencia económica para apoyar los gastos en que 
          se incurren durante el desarrollo del proceso formativo.
        </div>

        <div class="generacion">
        <p>Se firma en Santiago de Cali, a los {{$dia}} días del mes de {{$mes}} del {{$anio}}.</p>
        <p>Atentamente,</p>
        </div>

        <div class="generacion">
        Tulio Gerardo Motoa Garavito
        <br>
        Director Proyecto Convenio No. 4143.010.27.1.8.-2021
        </div>
        @endif

    </div>
    <br><br><br><br><br><br>
    <footer>
        <div  style="text-align: center;">
            <img class="pie" src="https://todosytodasaestudiar.org/img/pie2.png" alt="">
        </div>
    </footer>

</body>

</html>
