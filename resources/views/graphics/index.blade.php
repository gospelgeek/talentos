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
</form>-->
<div class="container-fluid">
    <h1 style="text-align:center;">GRAFICAS</h1>
    <div class="card">
        <div class="card-body">
        <div class="card-title">
            <select name="" id="valores">
                <option value="sexo" selected>SEXO</option>
                <option value="estrato" >ESTRATO</option>
            </select>
            <select name="" id="linea">
                <option value="" selected>COHORTE</option>
                <option value="1">LINEA 1</option>
                <option value="2">LINEA 2</option>
                <option value="3">LINEA 3</option>
            </select>
            <select name="" id="tipoGrafica">
                <option value="line" selected>LINEAR</option>
                <option value="bar">BARRAS</option>
                <option value="doughnut">CIRCULAR</option>
                <option value="polarArea">AREA POLAR</option>
                <option value="radar">RADAR</option>
            </select>
        </div>
        
        
            <canvas id="myChart"></canvas>
        
       
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


{!!Html::script('/js/graficas.js')!!}">
@endpush
@endsection