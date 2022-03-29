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
                <div class="col-sm-4">
                    <canvas id="etniaLinea"></canvas>
                </div>
            </div>
            <div class="row">
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
        </div>
    </div>

</div>

@push('scripts')

{!!Html::script('/js/graficas.js')!!}">
@endpush
@endsection