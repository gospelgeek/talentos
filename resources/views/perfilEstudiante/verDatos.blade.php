@extends('layouts.app')
@section('title', 'Ver Datos')

@section('content')

@csrf
<div class="container">

	<div class="form-group">
    		<div class="row">

    			<div class="col-xs-3 col-md-2">
            		<p style="text-align: right;"><label for="nombres">Id *</label></p>
            	</div>
				<div class="col-xs-4 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input  readonly class="form-control" type="text" name="id" id="id" value="{{ old('id', $verDatosPerfil->id) }}">

							@error('nombre')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-3 col-md-2">
            		<p style="text-align: right;"><label for="nombres">Nombres *</label></p>
            	</div>
				<div class="col-xs-4 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input  readonly class="form-control" type="text" name="nombres" id="nombres" value="{{ old('nombres', $verDatosPerfil->name) }}">

							@error('nombre')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>
			
            	<div class="col-xs-4 col-md-2">
            		<p style="text-align: right"><label for="apellidos">Apellidos *</label></p>
            	</div>
				<div class="col-xs-4 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $verDatosPerfil->lastname) }}">
						</div>
					</div>	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="fecha_nacimiento">Fecha de nacimiento *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  readonly class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $verDatosPerfil->birth_date) }}">
						</div>
					</div>  	
            	</div>
            </div>
		</div>
	
		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="tipo_documento">Tipo de documento</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								
							{!!Form::select('tipo_documento',$tipo_documento, $verDatosPerfil->documenttype->id,['id'=>'tipo_documento','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento' ,'disabled'])!!}
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $verDatosPerfil->document_number) }}">
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="fecha_nacimiento">Fecha de Expedicion del documento</label></p>
            </div>
			<div class="col-xs-2 col-md-2">
				<div class="row">
					<div class="col-xs-4 col-md-12">
						<input  readonly class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $verDatosPerfil->document_expedition_date) }}">
					</div>
				</div>   	
            </div>
            </div>
            
		</div>
	<div class="form-group">
    		<div class="row">
    			<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="departamento_nacimiento">Departamento nacimiento *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ old('departamento_nacimiento', $verDatosPerfil->birthcity->birthdepartament->name) }}">
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="ciudad_nacimiento">Ciudad nacimiento *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ old('ciudad_nacimiento', $verDatosPerfil->birthcity->name) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="email">Correo Electronico *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
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
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="sexo">Sexo</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-3 col-md-12"> 
								{!!Form::select('sexo',$sexo, $verDatosPerfil->sex,['id'=>'sexo','class'=>'form-control','required',
									'placeholder'=>'Seleccionar sexo' ,'disabled'])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="genero">Genero</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						
								<div class="col-xs-12 col-md-12">
									{!!Form::select('genero', $genero,$verDatosPerfil->gender->id,['placeholder'=>'Genero','class'=>'form-control','required','disabled'])!!}
						</div>
						
					</div>
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="telefono1">Numero telefonico *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="telefono1" id="telefono1" value="{{ old('telefono1', $verDatosPerfil->cellphone) }}">
						</div>
					</div>
                	
            	</div>		
            </div>
        </div>
		



		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="barrio_residencia">Barrio Residencia *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ old('barrio_residencia', $verDatosPerfil->neighborhood->name) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="direccion">Direccion *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly  class="form-control" type="text" name="direccion" id="direccion" value="{{ old('direccion', $verDatosPerfil->direction) }}">
						</div>
					</div>	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="telefono2">Numero telefonico alternativo *</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="telefono2" id="telefono2" value="{{ old('telefono2', $verDatosPerfil->phone) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		

		<div class="form-group">
    		<div class="row">
            	

            	
            </div>
		</div>	
			<a class="btn btn-primary" type="button" href="{{ route('estudiante')}}" >Regresar</a>
			<a type="button" href="{{ route('editar_estudiante', $verDatosPerfil->id) }}" class="btn btn-primary">Actualizar Datos</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a type="button" href="{{ route('ver_datos_socioeconomicos', $verDatosPerfil->id) }}" class="btn btn-primary">Datos Socioeconomicos </a>
			<a type="button" href="{{ route('ver_datos_academicos', $verDatosPerfil->id) }}" class="btn btn-primary">Datos Academicos </a>
			
			
			
</div>
@endsection
