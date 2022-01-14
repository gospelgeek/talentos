@extends('layouts.app')
@section('title', 'index')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("update_datos_socioeconomicos", $editarSocioeconomicos->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante.datosSocioeconomicos._formulario_socioeconomico')
	</form>

@endsection