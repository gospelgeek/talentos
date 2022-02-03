@extends('layouts.dashboard')
@section('title', 'Editar Datos')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("update_estudiante", $verDatosPerfil->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante.verEditarDatos')
	</form>

@endsection