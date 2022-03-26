@extends('layouts.dashboard')
@section('title', 'Graficas')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<!---<form action="{{route('ejm')}}" method="post" enctype="multipart/form-data">
    
    @csrf
    <input type="file" name="file" id="file">
    <br>
    <button type="submit">Enviar</button>
</form>

-->

<div class="container-fluid">

    <div class="card">


        <div class="card-body">
            <div class="row justify-content-md-center">
                <col-sm>
                    <h3 class="mr-3">VER GRAFICAS DE:</h3>
                </col-sm>
                <div class="col-sm">
                    <button class="btn btn-primary" id="linea1">
                        Linea 1
                    </button>
                    <button class="btn btn-primary" id="linea2">
                        Linea 2
                    </button>
                    <button class="btn btn-primary" id="linea3">
                        Linea 3
                    </button>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-4">
                    <canvas id="sexolineas"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="edadlineas"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="anioGraduacion"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <canvas id="estadoCivilLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="icfesPuntajeLinea"></canvas>
                </div>
               
            </div>
        </div>
    </div>
    <!--
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        LINEA 1
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm">
                            <canvas id="l1Sexo"></canvas>
                        </div>
                        <div class="col">
                            <canvas id="l1Edad"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        LINEA 2
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm">
                            <canvas id="l2Sexo"></canvas>
                        </div>
                        <div class="col">
                            <canvas id="l2Edad"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        LINEA 3
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm">
                            <canvas id="l3Sexo"></canvas>
                        </div>
                        <div class="col">
                            <canvas id="l3Edad"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--->
</div>





@push('scripts')



{!!Html::script('/js/graficas.js')!!}">
@endpush
@endsection