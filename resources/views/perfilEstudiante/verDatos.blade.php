@extends('layouts.secundario')

@section('content')

@csrf
<div class="container">
<div class="form-group">
	<label for="nombres">Nombres</label>
	<input readonly class="form-control" type="text" name="nombres" id="nombres" value="{{ $verDatosPerfil->nombres }}">

	@error('nombres')
	<small class="text-danger">{{ message }}</small>
	@enderror
</div>
<div class="form-group">
	<label for="apellidos">Apellidos</label>
	<input readonly class="form-control" type="text" name="apellidos" id="apellidos" value="{{ $verDatosPerfil->apellidos }}">
</div>
<div class="form-group">
	<label for="tipo_documento">Tipo de documento</label>
	<input readonly class="form-control" type="text" name="tipo_documento" id="tipo_documento" value="{{ $verDatosPerfil->tipo_documento }}">
</div>
<div class="form-group">
	<label for="numero_documento">Numero de identificacion</label>
	<input readonly class="form-control" type="text" name="numero_documento" id="numero_documento" value="{{ $verDatosPerfil->numero_documento }}">
</div>
<div class="form-group">
	<label for="fecha_nacimiento">Fecha de nacimiento</label>
	<input readonly class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $verDatosPerfil->fecha_nacimiento }}">
</div>
<div class="form-group">
	<label for="departamento_nacimiento">Departamento de nacimiento</label>
	<input readonly class="form-control" type="text" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ $verDatosPerfil->departamento_nacimiento }}">
</div>
<div class="form-group">
	<label for="ciudad_nacimiento">Ciudad de nacimiento</label>
	<input readonly class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ $verDatosPerfil->ciudad_nacimiento }}">
</div>
<div class="form-group">	
	<label for="sexo">Sexo</label>
	<input readonly class="form-control" type="text" name="sexo" id="sexo" value="{{ $verDatosPerfil->sexo }}">
</div>
<div class="form-group">
	<label for="genero">Genero</label>
	<input readonly class="form-control" type="text" name="genero" id="genero" value="{{ $verDatosPerfil->genero }}">
</div>
<div class="form-group">
	<label for="departamento_residencia">Departamento de residencia</label>
	<input readonly class="form-control" type="text" name="departamento_residencia" id="departamento_residencia" value="{{ $verDatosPerfil->departamento_residencia }}">
</div>
<div class="form-group">
	<label for="ciudad_residencia">Ciudad de residencia</label>
	<input readonly class="form-control" type="text" name="ciudad_residencia" id="ciudad_residencia" value="{{ $verDatosPerfil->ciudad_residencia }}">
</div>
<div class="form-group">
	<label for="barrio_residencia">Barrio</label>
	<input readonly class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ $verDatosPerfil->barrio_residencia }}">
</div>
<div class="form-group">
	<label for="direccion">Direccion</label>
	<input readonly class="form-control" type="text" name="direccion" id="direccion" value="{{ $verDatosPerfil->direccion }}">
</div>
<div class="form-group">
	<label for="email">Email</label>
	<input readonly class="form-control" type="text" name="email" id="email" value="{{ $verDatosPerfil->email }}">
</div>
<div class="form-group">
	<label for="telefono1">Numero telefonico</label>
	<input readonly class="form-control" type="text" name="telefono1" id="telefono1" value="{{ $verDatosPerfil->telefono1 }}">
</div>
<div class="form-group">
	<label for="telefono2">Numero telefonico alternativo</label>
	<input readonly class="form-control" type="text" name="telefono2" id="telefono2" value="{{ $verDatosPerfil->telefono2 }}">
</div>
</div>
@endsection
