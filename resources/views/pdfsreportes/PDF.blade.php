<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Listado linea {{$cohorte}}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <header>
        <h1>PLAN DE NIVELACION ACADEMICA</h1>
        &nbsp;
        <h3>LISTA DE GRUPOS POR COHORTES</h3>
    </header>

    <main>
        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 1 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo1 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 2 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo2 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 3 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo3 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 4 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo4 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 5 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo5 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 6 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo6 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 7 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo7 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 8 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo8 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 9 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo9 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 10 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo10 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 11 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo11 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 12 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo12 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 13 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table class=" table table-bordered table-striped">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo13 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 14 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo14 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 15 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo15 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 16 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo16 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 17 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo17 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 18 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo18 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 19 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo19 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 20 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo20 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 21 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo21 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 22 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo22 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 23 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo23 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 24 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo24 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 25 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo25 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 26 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo26 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 27 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo27 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 28 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo28 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 29 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo29 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 30 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo30 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 31 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo31 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 32 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo32 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 33 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo33 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 34 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo34 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 35 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo35 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 36 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo36 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 37 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo37 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 38 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo38 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 39 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo39 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="page-break"></div>

        <div style="text-align: center;">
            <h2><strong>LISTADO DE ESTUDIANTES GRUPO 40 DE LINEA {{$cohorte}}</strong> </h2>
        </div>
        <br>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>CODIGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo40 as $data)
                <tr data-id="{{$data->document_number}}">
                    <td>{{$data->document_number}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->lastname}}</td>
                    <td>{{$data->student_code}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>
    <br>
    <footer>
        <p>Sitio Web: <a href="http://todosytodasaestudiar.org">http://todosytodasaestudiar.org</a></p>
    </footer>

</body>

</html>