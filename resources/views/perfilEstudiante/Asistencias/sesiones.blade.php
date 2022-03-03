@extends('layouts.dashboard')

@section('title', $name->name ." ". $grupo->name)
@section('content')
<script id="json" type="text" src="/students.json"></script>
<script id="asisten" type="text" src="/asistencias.json"></script>
<h1 id="num_sesiones" style="text-align: center;">{{$name->name}}<br>{{$grupo->name}}<br> Total Sesiones </h1>
<input type="hidden" id="code_curse" data-id="{{$grupo->id}}" data-name="{{ $name->name}}" data-cohort="{{ $grupo->cohort->id}}" data-group="{{$grupo->name}}" data-courseid="{{$name->id}}">
<input type="hidden" id="moodle" name="quotation" data-datos="{{json_encode($id_moole,TRUE)}}">
<div class="table-responsive" id="datos">

</div>
<a href="{{route('asistencias.grupos',$name->id)}}" class="fa fa-arrow-left">Regresar</a>
{!!Form::open(['id'=>'form-edit','route'=>['asistencias.asignatura',$name->id,$grupo->id,':SESSIONID'], 'method'=>'GET'])!!}
{!!Form::close()!!}
@push('scripts')
{!!Html::script('/js/asignaturas.js')!!}
@endpush
@endsection