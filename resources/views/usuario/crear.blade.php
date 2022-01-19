@extends('layouts.app')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("store_usuario")}}" method="POST"> 
		@include('usuario._formulario')
	</form>
@endsection