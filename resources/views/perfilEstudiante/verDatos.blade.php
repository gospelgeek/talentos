@extends('layouts.secundario')
@section('title', 'Ver Datos')

@section('content')

@csrf
<div class="container">

	<div class="form-group">
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right;"><label for="nombres">Nombres *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input  readonly class="form-control" type="text" name="nombres" id="nombres" value="{{ old('nombres', $verDatosPerfil->nombres) }}">

							@error('nombre')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>
			
            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="apellidos">Apellidos *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $verDatosPerfil->apellidos) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>
	


		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="tipo_documento">Tipo de documento</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								
							<input readonly class="form-control" type="text" name="tipo_documento" id="tipo_documento" value="{{ old('tipo_documento', $verDatosPerfil->tipo_documento) }}">
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $verDatosPerfil->numero_documento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="fecha_nacimiento">Fecha de nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  readonly class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $verDatosPerfil->fecha_nacimiento) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="departamento_nacimiento">Departamento nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ old('departamento_nacimiento', $verDatosPerfil->departamento_nacimiento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="ciudad_nacimiento">Ciudad nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ old('ciudad_nacimiento', $verDatosPerfil->ciudad_nacimiento) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="email">Correo Electronico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="email" id="email" value="{{ old('email', $verDatosPerfil->email) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
		    
			
    		<div class="row">
            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="sexo">Sexo</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<br>
							<input readonly class="form-control" type="text" name="sexo" id="sexo" value="{{ old('sexo', $verDatosPerfil->sexo) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="genero">Genero</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						
								<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="genero" id="genero" value="{{ old('genero', $verDatosPerfil->genero) }}">
						</div>
						
					</div>
            	</div>		
            </div>
        </div>
		

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="departamento_residencia">Departamento Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="departamento_residencia" id="departamento_residencia" value="{{ old('departamento_residencia', $verDatosPerfil->departamento_residencia) }}">
						</div>
					</div>
                	
            	</div>

  
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="ciudad_residencia">Ciudad Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="ciudad_residencia" id="ciudad_residencia" value="{{ old('ciudad_residencia', $verDatosPerfil->ciudad_residencia) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="barrio_residencia">Barrio Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ old('barrio_residencia', $verDatosPerfil->barrio_residencia) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="direccion">Direccion *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly  class="form-control" type="text" name="direccion" id="direccion" value="{{ old('direccion', $verDatosPerfil->direccion) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="telefono1">Numero telefonico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="telefono1" id="telefono1" value="{{ old('telefono1', $verDatosPerfil->telefono1) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="telefono2">Numero telefonico alternativo *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="telefono2" id="telefono2" value="{{ old('telefono2', $verDatosPerfil->telefono2) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>	
			<input type="button" onclick="history.back()" name="volver atrás" value="volver atrás">
</div>
@endsection
