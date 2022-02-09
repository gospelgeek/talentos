@extends('layouts.dashboard')
@section('title', 'Editar Datos')

@section('content')
@include('../alerts.success')
@include('../alerts.request')
	@include('vistasParciales.validacionErrores')

	<form action="{{ route("updatedatosgenerales", $verDatosPerfil->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante.verEditarDatos')
	</form>

@endsection