@csrf 
<div class="container">
		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="nombres">Nombres *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="nombres" id="nombres" value="{{ old('nombres', $editarEstudiante->nombres) }}">

							@error('nombre')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="apellidos">Apellidos *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $editarEstudiante->apellidos) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="tipo_documento">Seleccionar Tipo de documento</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12"> 
								{!!Form::select('tipo_documento', [
                                    'Cedula Ciudadania' => 'Cedula Ciudadania',
                                    'Tarjeta Identidad'   => 'Tarjeta Identidad',
                                    'Cedula extranjera' => 'Cedula extranjera'], null,['id'=>'tipo_documento','class'=>'form-control','required','placeholder'=>'Tipo identificacion' ,'style'=>' ']
                                )!!}
						</div>
					</div>
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="numero_documento">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $editarEstudiante->numero_documento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="fecha_nacimiento">Fecha de nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $editarEstudiante->fecha_nacimiento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="departamento_nacimiento">Departamento nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ old('departamento_nacimiento', $editarEstudiante->departamento_nacimiento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="ciudad_nacimiento">Ciudad nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ old('ciudad_nacimiento', $editarEstudiante->ciudad_nacimiento) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
		    
			
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="sexo">Sexo</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<br>
							<input type="radio" name="sexo" value="F"> Femenino<br>

    						<input type="radio" name="sexo" value="M"> Masculino<br>
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="genero">Genero</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12"> 
								{!!Form::select('genero', [
                                    'Hombre' => 'Hombre',
                                    'Mujer'  => 'Mujer',
                                    'LGTBI' => 'LGTBI',
                                    'Otros' => 'Otros'], null,['id'=>'genero','class'=>'form-control','required','placeholder'=>'Genero' ,'style'=>' ']
                                )!!}
						</div>
					</div>
            	</div>		
            </div>

            	

        </div>
		

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="departamento_residencia">Departamento Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="departamento_residencia" id="departamento_residencia" value="{{ old('departamento_residencia', $editarEstudiante->departamento_residencia) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="ciudad_residencia">Ciudad Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="ciudad_residencia" id="ciudad_residencia" value="{{ old('ciudad_residencia', $editarEstudiante->ciudad_residencia) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="barrio_residencia">Barrio Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ old('barrio_residencia', $editarEstudiante->barrio_residencia) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="direccion">Direccion *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="direccion" id="direccion" value="{{ old('direccion', $editarEstudiante->direccion) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="email">Correo Electronico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="email" id="email" value="{{ old('email', $editarEstudiante->email) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="telefono1">Numero telefonico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="telefono1" id="telefono1" value="{{ old('telefono1', $editarEstudiante->telefono1) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: center"><label for="telefono2">Numero telefonico alternativo *</label></p>
            	</div>
				<div class="col-xs-12 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="telefono2" id="telefono2" value="{{ old('telefono2', $editarEstudiante->telefono2) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

	

	
		<input type="submit" value="ENVIAR" class="btn btn-primary">
</div>

