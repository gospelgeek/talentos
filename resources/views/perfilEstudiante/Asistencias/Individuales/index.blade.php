@extends('layouts.dashboard')

@section('title', 'Asitencias Estudiantes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">    
    <h1 style="text-align:center;">ESTUDIANTES</h1>
    <div class="card">         
    <div class="card-body">


    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº documento</td>
                <td>Grupo</td>
                <td>Cohorte</td>
                <td>Total Inasistencias</td>
                <td>Acciones</td>
            </tr>
        </thead> 

        <tbody>
            @foreach ($perfilEstudiantes as $estudiante)
                <tr data-id="{{$estudiante->id_moodle}}">
                                        <td>{{ $estudiante->name}}</td>
                                        <td>{{ $estudiante->lastname }}</td>
                                        <td>{{ $estudiante->document_number }}</td>
                                        <td>{{ $estudiante->studentGroup->group->name}}</td>
                                        <td>{{ $estudiante->studentGroup->group->cohort->name}}</td>
                                        <td></td>
                                        <td >

                                        @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)   

                                            <div class="row">                                  
                                                <div class="col-xs-4 col-sm-4">
                                                    <a id="{{$estudiante->id}}" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>    
                                                </div>                                                
                                            </div>
                                           

                                            @csrf
                    </td>
                </tr>
                @endif
            @endforeach    
        </tbody>

      </table>
      </div>
    </div>
    </div>
</div>

@push('scripts')
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
