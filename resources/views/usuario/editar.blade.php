@extends('layouts.dashboard')
@section('title', 'Editar Usuario')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route('update_usuario', $editarUsuario->id)}}" method="POST"> 
		@method('PUT')
		@include('usuario._formulario')
	</form>
@endsection