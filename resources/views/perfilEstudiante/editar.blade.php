@extends('layouts.app')
@section('title', 'index')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("update_estudiante", $verDatosPerfil->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante.verEditarDatos')
	</form>

@endsection