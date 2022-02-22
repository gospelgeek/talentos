@extends('layouts.dashboard')

@section('title', 'Sesiones')
@section('content')
<script id="json" type="text" src="/students.json"></script>
<h1 style="text-align: center;">{{$name->name}}<br> {{$grupo->name}}</h1>
<input type="hidden" id="code_curse" data-id="{{$grupo->id}}" data-name="{{ $name->name}}" data-cohort="{{ $grupo->cohort->id}}" data-group="{{$grupo->name}}">
<div class="table-responsive" id="datos">

</div>
{!!Form::open(['id'=>'form-edit','route'=>['asistencias.asignatura',':EDIFICIO_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}
@push('scripts')
{!!Html::script('/js/asignaturas.js')!!}
@endpush
@endsection