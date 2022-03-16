@extends('layouts.dashboard')

@section('title', 'Estudiantes Estados')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
<h1 style="text-align:center;">ESTADO ESTUDIANTES</h1>
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
                <td>Estado</td>
                <td>Acciones</td>
            </tr>
        </thead> 

        <tbody>
            @foreach ($verDatosPerfil  as $data)
                <tr data-id="{{$data->id}}">
                                        <td>{{ $data->name}}</td>
                                        <td>{{ $data->lastname }}</td>
                                        <td>{{ $data->document_number }}</td>
                                        <td>{{ $data->studentGroup->group->name}}</td>
                                        <td>{{ $data->studentGroup->group->cohort->name}}</td>
                                        <td>{{ $data->condition->name}}</td>
                                        <td >

                                        @if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)   
                                 
                                                <a id="{{$data->id}}" type="button" onclick="abrirmodal(this);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Cambiar Estado</a>
                                        </td>
                                        @csrf
                </tr>
                @endif
            @endforeach    
        </tbody>

      </table>
      </div>
    </div>
    </div>
</div>
{!!Form::open(['id'=>'form-edit','route'=>['estudiantes.estado_edit',':ESTADO_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}
@include('perfilEstudiante.estado.modal.edit_estado')
@push('scripts')
{!!Html::script('/js/estado.js')!!}
@endpush
@endsection
