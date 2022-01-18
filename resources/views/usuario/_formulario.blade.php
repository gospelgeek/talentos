@csrf 
<br><br>
<div class="container">
		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right;"><label for="nombres">Nombres *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input class="form-control" type="text" name="name" id="name" value="{{ old('name', $editarUsuario->name) }}">

							@error('name')
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
							<input class="form-control" type="text" name="apellidos_user" id="apellidos_user" value="{{ old('apellidos_user', $editarUsuario->apellidos_user) }}">
						</div>
					</div>	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
    			<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="tipo_documento_user">Seleccionar Tipo de documento</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								{!!Form::select('tipo_documento_user',['Cedula Ciudadania' => 'Cedula Ciudadania',
        														  'Tarjeta Identidad'   => 'Tarjeta Identidad',
       															  'Cedula extranjera' => 'Cedula extranjera'],
								$editarUsuario->tipo_documento_user,['class'=>'form-control select2',
								'placeholder'=>'Seleccione el tipo de documento','style'=>'width: 100%;','required']
                                )!!}
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input class="form-control" type="text" name="cedula" id="cedula" value="{{ old('cedula', $editarUsuario->cedula)}}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
       			<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="email">Correo Electronico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="email" id="email" value="{{ old('email', $editarUsuario->email) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="password">Password *</label></p>
            	</div>

            	<div class="col-xs-12 col-md-3">
                    <input id="password" type="password" class="form-control @error('password', $editarUsuario->password) is-invalid @enderror" name="password" value="{{ old('password', $editarUsuario->password) }}">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>	
            </div>	
        </div>

		<div class="form-group">
    		<div class="row">
    			<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="rol_id">Seleccionar Rol:</label></p>
            	</div>
            	<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
               			{!!Form::select('rol_id',$roles, $editarUsuario->roles->id,(['editarUsuario'=>'roles','class' => 'form-control ','style'=>'width: 100%;','placeholder'=>'Seleccionar Rol:','required']))!!}
						</div>
					</div>
            	</div>
            </div>
        </div>

		<input type="button" onclick="history.back()" name="volver atrás" value="Regresar" class="btn btn-primary">							
		<input type="submit" value="Guardar Datos" class="btn btn-primary">
</div>

