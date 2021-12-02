@extends('layouts.app')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("storePerfilEstudiante")}}" method="POST"> 
		@include('perfilEstudiante._formulario')
	</form>
@endsection