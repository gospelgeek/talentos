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
                    <button class="btn btn-primary mr-10" id="linea3">
                        Linea 3
                    </button>
                    <button class="btn btn-primary" id="generales">
                        ESTADISTICAS GENERALES
                    </button>
                </div>

            </div>
            <div class="row" id="gen1">
                <div class="col-4">
                    <canvas id="sexoGeneral"></canvas>
                </div>
                <div class="col-8">
                    <canvas id="edadGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="cohorte1">
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
            <div class="row" id="gen2">
                <div class="col-sm-8">
                    <canvas id="anioGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="estadoCivilGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="cohorte2">
                <div class="col-sm-4">
                    <canvas id="estadoCivilLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="icfesPuntajeLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="etniaLinea"></canvas>
                </div>
            </div>
            <div class="row" id="gen3">
                <div class="col-sm-4">
                    <canvas id="icfesGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="etniaGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="cohorte3">
                <div class="col-sm-4">
                    <canvas id="ocupacionLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="hijosLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="regimenLinea"></canvas>
                </div>
            </div>
            <div class="row" id="gen4">
                <div class="col-sm-4">
                    <canvas id="ocupacionGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="hijosGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="cohorte4">
                <div class="col-sm-4">
                    <canvas id="sisbenLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="beneficiosLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="internetZonaLinea"></canvas>
                </div>
            </div>
            <div class="row" id="gen5">
                <div class="col-sm-4">
                    <canvas id="regimenGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="sisbenGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="cohorte5">
                <div class="col-sm-4">
                    <canvas id="internetHogarLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="condicionSocialLinea"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="discapacidadLinea"></canvas>
                </div>
            </div>
            <div class="row" id="gen6">
                <div class="col-sm-4">
                    <canvas id="benefiosGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="internetZonaGeneral"></canvas>
                </div>
            </div>
            <div class="row" id="gen7">
                <div class="col-sm-4">
                    <canvas id="internetHogarGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="condicionSocialGeneral"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="discapacidadGeneral"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')

{!!Html::script('/js/graficas.js')!!}">
@endpush
@endsection
