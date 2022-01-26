@extends('layouts.secundario')
@section('title', 'Ver Datos Usuario')

@section('content')

@csrf
<div class="container">

	<div class="form-group">
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right;"><label for="name">Nombres *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input  readonly class="form-control" type="text" name="name" id="name" value="{{ old('name', $verUsuario->name) }}">

							@error('nombre')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>
			
            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="apellidos_user">Apellidos *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="apellidos_user" id="apellidos_user" value="{{ old('apellidos_user', $verUsuario->apellidos_user) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>
	


		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="tipo_documento_user">Tipo de documento</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								
							<input readonly class="form-control" type="text" name="tipo_documento_user" id="tipo_documento_user" value="{{ old('tipo_documento_user', $verUsuario->tipo_documento_user) }}">
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="cedula">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="cedula" id="cedula" value="{{ old('cedula', $verUsuario->cedula) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="email">Correo electronico</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  readonly class="form-control" type="email" name="email" id="email" value="{{ old('email', $verUsuario->email) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="password">Password *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="password" id="password" value="{{ old('password', $verUsuario->password) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="rol_id">Rol</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="rol_id" id="rol_id" value="{{ old('rol_id', $verUsuario->rol_id) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>
			<input class="btn btn-primary" type="button" onclick="history.back()" name="volver atrás" value="Regresar">
			<a type="button"href="{{ route('editar_usuario', $verUsuario->id) }}" class="btn btn-primary">Actualizar Datos</a>
</div>
@endsection
