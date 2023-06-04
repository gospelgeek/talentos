@extends('layouts.dashboard')

@section('title', 'ASISTENCIAS'." ". $name->name . "-". $grupo->name . "-". $grupo->cohort->name)
@section('content')
<h1 style="text-align:center;">ASISTENCIAS<br>{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}<br>{{$docente}}</h1>
<div class="containerd-fluid" id="container">
    <div class="card" id="container2">        
        <div class="card-body">
            <div id="carga" class="d-flex justify-content-center">
                        <strong>Procesando&nbsp;</strong>
                        <div class="spinner-border spinner-border-sm" role="status">                    
                        </div>
            </div>  
            <div id="tabla" class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>Nombres</td>
                            <td>Apellidos</td>
                            <td width="15%">Asistencias</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($asistencias as $nota)
                        <tr >
                            <td>{{$nota->name}}</td>
                            <td>{{$nota->lastname}}</td>
                            @if($nota->grade == "Asistio")
                                <td >{{$nota->grade}}<i style="color: #2ECC71" class="fa fa-check" aria-hidden="true"></i></td>
                            @else
                                <td>{{$nota->grade}}<i style="color: red; text-align: center;" class="fa fa-times" aria-hidden="true"></i></td>
                            @endif                                  
                        </tr>
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
{!!Html::script('/js/notas.js')!!}
@endpush

@endsection
