@extends('layouts.secundario')
@section('title', 'Editar datos Academicos')

@section('content')

	@include('vistasParciales.validacionErrores')
	
	<form action="{{ route("update_datos_academicos", $editarAcademicos->id)}}" method="POST"> 
			@method('PUT')
			@include('perfilEstudiante.datosAcademicos._formulario_academico')
	</form>

@endsection