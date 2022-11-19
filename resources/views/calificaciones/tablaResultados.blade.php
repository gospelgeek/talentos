@extends('layouts.app')


@section('content')



<div class="container-fluid">
    <h1 style="text-align:center;">RESULTADOS DE ADMISIÓN (Simulación)</h1>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            @if($vistas == 1)
            <div class="row">
                <div class="col-sm">
                    <table id="estudiante" class=" table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RESULTADO</th>
                                <td><strong><p style="background-color: #F91E1B;">NO ADMITIDO</p> </strong></td>
                            </tr>
                            <tr>
                                <th>NOMBRES</th>
                                <td>{{$estudiante[0]->name}}</td>
                            </tr>
                            <tr>
                                <th>APELLIDOS</th>
                                <td>{{$estudiante[0]->lastname}}</td>
                            </tr>
                            <tr>
                                <th>Nº DOCUMENTO</th>
                                <td>{{$estudiante[0]->document_number}}</td>
                            </tr>
                            <tr>
                                <th>LINEA</th>
                                <td>{{$estudiante[0]->cohorte}}</td>
                            </tr>
                            <tr>
                                <th>GRUPO</th>
                                <td>{{$estudiante[0]->grupo}}</td>
                            </tr>
                            <tr>
                                <th>PROGRAMA</th>
                                <td><strong>NINGUNO</strong></td>
                            </tr>
                            <tr>
                                <th>OPCIONES</th>
                                <td>
                                    1: 
                                    2: 
                                    3: 
                                    4: 
                                    5: 
                                </td>
                            </tr>
                            <tr>
                                <th>SEMESTRE INGRESO</th>
                                <td><strong>NINGUNO</strong></td>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
            @else
            @if($bandera == 0)
            <div class="row" id="info">
                <div class="col-sm ">
                    <table id="resultados" class=" table table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RESULTADO</th>
                                <td><strong><p style="background-color: #21D817;">ADMITIDO</p></strong></td>
                            </tr>
                            <tr>
                                <th>NOMBRES</th>
                                <td>{{$dataCalificados[0]->name}}</td>
                            </tr>
                            <tr>
                                <th>APELLIDOS</th>
                                <td>{{$dataCalificados[0]->lastname}}</td>
                            </tr>
                            <tr>
                                <th>Nº.DOCUMENTO</th>
                                <td>{{$dataCalificados[0]->document_number}}</td>
                            </tr>
                            <tr>
                                <th>LINEA</th>
                                <td>{{$dataCalificados[0]->cohorte}}</td>
                            </tr>
                            <tr>
                                <th>GRUPO</th>
                                <td>{{$dataCalificados[0]->grupo}}</td>
                            </tr>
                            <tr>
                                <th>PROGRAMA</th>
                                <td><strong>{{$dataCalificados[0]->name_program}}</strong></td>
                            </tr>
                            <tr>
                                <th>PUESTO</th>
                                <td>{{$dataCalificados[0]->position}}</td>
                            </tr>
                            <tr>
                                <th>OPCION</th>
                                <td>{{$dataCalificados[0]->iteration}}</td>
                            </tr>
                            <tr>
                                <th>TOTAL PONDERADO</th>
                                <td>{{$dataCalificados[0]->weighted_total}}</td>
                            </tr>
                            <tr>
                                <th>PONDERADO POR AREAS</th>
                                <td>{{$dataCalificados[0]->weighted_areas}}</td>
                            </tr>
                            <tr>
                                <th>PROMEDIO NOTAS</th>
                                <td>{{$dataCalificados[0]->average_grades}}</td>
                            </tr>
                            <tr>
                                <th>OPCIONES</th>
                                <td>
                                    1: {{$dataCalificados[0]->opc1}}
                                    2: {{$dataCalificados[0]->opc2}}
                                    3: {{$dataCalificados[0]->opc3}}
                                    4: {{$dataCalificados[0]->opc4}}
                                    5: {{$dataCalificados[0]->opc5}}
                                </td>
                            </tr>
                            <tr>
                                <th>SEMESTRE INGRESO</th>
                                <td>{{$dataCalificados[0]->semestre_ingreso}}</td>
                            </tr>
                            
                        </thead>
                        
                        
                    </table>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-sm">
                    <table id="no_clasificados" class=" table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RESULTADO</th>
                                <td><strong><p style="background-color: #F91E1B;">NO ADMITIDO</p> </strong></td>
                            </tr>
                            <tr>
                                <th>NOMBRES</th>
                                <td>{{$dataNoCalificados[0]->name}}</td>
                            </tr>
                            <tr>
                                <th>APELLIDOS</th>
                                <td>{{$dataNoCalificados[0]->lastname}}</td>
                            </tr>
                            <tr>
                                <th>Nº DOCUMENTO</th>
                                <td>{{$dataNoCalificados[0]->document_number}}</td>
                            </tr>
                            <tr>
                                <th>LINEA</th>
                                <td>{{$dataNoCalificados[0]->cohorte}}</td>
                            </tr>
                            <tr>
                                <th>GRUPO</th>
                                <td>{{$dataNoCalificados[0]->grupo}}</td>
                            </tr>
                            <tr>
                                <th>PROGRAMA</th>
                                <td><strong>NINGUNO</strong></td>
                            </tr>
                            <tr>
                                <th>OPCIONES</th>
                                <td>
                                    1: {{$dataNoCalificados[0]->opc1}}
                                    2: {{$dataNoCalificados[0]->opc2}}
                                    3: {{$dataNoCalificados[0]->opc3}}
                                    4: {{$dataNoCalificados[0]->opc4}}
                                    5: {{$dataNoCalificados[0]->opc5}}
                                </td>
                            </tr>
                            <tr>
                                <th>SEMESTRE INGRESO</th>
                                <td>{{$dataNoCalificados[0]->semestre_ingreso}}</td>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>




@endsection
