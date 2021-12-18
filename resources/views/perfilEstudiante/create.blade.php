@extends('layouts.app')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("store_estudiante")}}" method="POST"> 
		@include('perfilEstudiante._formulario')
	</form>
@endsection