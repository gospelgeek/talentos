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
							<input  readonly class="form-control" type="text" name="nombres" id="nombres" value="{{ old('nombres', $verDatosPerfil->name) }}">

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
							<input readonly class="form-control" type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $verDatosPerfil->lastname) }}">
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
								
							<input readonly class="form-control" type="text" name="tipo_documento" id="tipo_documento" value="{{ old('tipo_documento', $verDatosPerfil->id_document_type) }}">
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $verDatosPerfil->document_number) }}">
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
							<input  readonly class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $verDatosPerfil->birth_date) }}">
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
							<input readonly class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ old('ciudad_nacimiento', $verDatosPerfil->id_birth_city) }}">
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
							<input readonly class="form-control" type="text" name="sexo" id="sexo" value="{{ old('sexo', $verDatosPerfil->sex) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="genero">Genero</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						
								<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="genero" id="genero" value="{{ old('genero', $verDatosPerfil->id_gender) }}">
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
							<input readonly class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ old('barrio_residencia', $verDatosPerfil->id_neighborhood) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="direccion">Direccion *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly  class="form-control" type="text" name="direccion" id="direccion" value="{{ old('direccion', $verDatosPerfil->direction) }}">
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
							<input readonly class="form-control" type="text" name="telefono1" id="telefono1" value="{{ old('telefono1', $verDatosPerfil->cellphone) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="telefono2">Numero telefonico alternativo *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="telefono2" id="telefono2" value="{{ old('telefono2', $verDatosPerfil->phone) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>	
			<input class="btn btn-primary" type="button" onclick="history.back()" name="volver atrás" value="Regresar">
			
			
</div>
@endsection
