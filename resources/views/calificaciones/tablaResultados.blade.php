@extends('layouts.app')


@section('content')



<div class="container-fluid">
    <h1 style="text-align:center;">CONSULTA DE CALIFICACIONES</h1>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            @if($vistas == 1)
            @else
            @if($bandera == 0)
            <div class="row" id="info">
                <div class="col-sm ">
                    <table id="resultados" class=" table table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>Nº.DOCUMENTO</th>
                                <th>LINEA</th>
                                <th>GRUPO</th>
                                <th>PROGRAMA</th>
                                <th>PUESTO</th>
                                <th>OPCIÓN</th>
                                <th>TOTAL PONDERADO</th>
                                <th>PONDERADO POR AREAS</th>
                                <th>PROMEDIO NOTAS</th>
                                <th>OPCIONES</th>
                                <th>SEMESTRE INGRESO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $dataCalificados as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->lastname}}</td>
                                <td>{{$data->document_number}}</td>
                                <td>{{$data->cohorte}}</td>
                                <td>{{$data->grupo}}</td>
                                <td>{{$data->name_program}}</td>
                                <td>{{$data->position}}</td>
                                <td>{{$data->iteration}}</td>
                                <td>{{$data->weighted_total}}</td>
                                <td>{{$data->weighted_areas}}</td>
                                <td>{{$data->average_grades}}</td>
                                <td>
                                    1: {{$data->opc1}}
                                    2: {{$data->opc2}}
                                    3: {{$data->opc3}}
                                    4: {{$data->opc4}}
                                    5: {{$data->opc5}}
                                </td>
                                <td>{{$data->semestre_ingreso}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-sm">
                    <table id="no_clasificados" class=" table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>Nº.DOCUMENTO</th>
                                <th>LINEA</th>
                                <th>GRUPO</th>
                                
                                <th>OPCIONES</th>
                                <th>SEMESTRE INGRESO</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $dataNoCalificados as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->lastname}}</td>
                                <td>{{$data->document_number}}</td>
                                <td>{{$data->cohorte}}</td>
                                <td>{{$data->grupo}}</td>
                                
                                <td>
                                    1: {{$data->opc1}}
                                    2: {{$data->opc2}}
                                    3: {{$data->opc3}}
                                    4: {{$data->opc4}}
                                    5: {{$data->opc5}}
                                </td>
                                <td>{{$data->semestre_ingreso}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>




@endsection