@extends('layouts.app')
@section('title', 'index')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("usuario.update_datos_socioeconomicos", $editarSocioeconomicos->socioeconomicdata->id)}}" method="POST"> 
		@method('PUT')
		@include('usuario.perfilEstudiante.datosSocioeconomicos._formulario_socioeconomico')
	</form>

@endsection