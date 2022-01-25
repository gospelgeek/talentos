@extends('layouts.app')
@section('title', 'index')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("usuario.update_estudiante", $editarEstudiante->id)}}" method="POST"> 
		@method('PUT')
		@include('usuario.perfilEstudiante._formulario')
	</form>

@endsection