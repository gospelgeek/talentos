@extends('layouts.app')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("updatePerfilEstudiante", $editarEstudiante->id)}}" method="POST"> 
		@method('PUT')
		@include('perfilEstudiante._formulario')
	</form>
@endsection