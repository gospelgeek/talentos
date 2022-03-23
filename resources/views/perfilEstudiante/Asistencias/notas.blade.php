@extends('layouts.dashboard')

@section('title', 'ASISTENCIAS'." ". $name->name . "-". $grupo->name . "-". $grupo->cohort->name)
@section('content')
<h1 style="text-align:center;">ASISTENCIAS<br>{{$name->name}}<br>{{$grupo->name}} - {{$grupo->cohort->name}}</h1>
<div class="containerd-fluid" id="container">    
    
    <script id="asisten" type="text" src="/json/asistencias.json"></script>
    
    <input type="hidden" id="notas" data-session="{{$id_session}}">
    <div class="card" id="container2">        
        <div class="card-body">
            @if(auth()->user()->rol_id == 4)
            <div class="row">
                <div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class="btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Agregar Calificacion</a>            
                </div>
            </div>
            @endif<div id="carga" class="d-flex justify-content-center">
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
                        @foreach ($notas as $nota)
                        <tr class="prueba" data-id="{{$nota->student->id_moodle}}">
                            <td>{{$nota->student->name}}</td>
                            <td>{{$nota->student->lastname}}</td>
                            <td id="{{$nota->student->id_moodle}}">No Asistio<i style="color: red; text-align: center;" class="fa fa-times" aria-hidden="true"></i></td>                                  
                        </tr>
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<a href="/Asistencias/{{$name->id}}/grupo/{{$grupo->id}}" class="fa fa-arrow-left">Regresar</a>

@push('scripts')
{!!Html::script('/js/notas.js')!!}
@endpush

@endsection