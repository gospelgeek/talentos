@extends('layouts.app')
@section('title', 'index')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("update_estudiante", $editarEstudiante->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante._formulario')
	</form>

@endsection