@csrf
<div class="container">

	<div class="form-group">
    		<div class="row">
            	<div class="col-xs-3 col-md-2">
            		<p style="text-align: right;"><label for="id_student">Id estudiante </label></p>
            	</div>
				<div class="col-xs-4 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="id_student" id="id_student" value="{{ old('id_student', $editarSocioeconomicos->socioeconomicdata->id_student) }}">

							@error('id_student')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-4 col-md-2">
            		<p style="text-align: right"><label for="id_ocupation">Ocupacion</label></p>
            	</div>
				<div class="col-xs-4 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								{!!Form::select('id_ocupation', $ocupacion,$editarSocioeconomicos->socioeconomicdata->id_ocupation,['placeholder'=>'Ocupacion','class'=>'form-control','required'])!!}
						</div>
					</div>
            	</div>


            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_civil_status">Estado civil</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_civil_status', $estado_civil,$editarSocioeconomicos->socioeconomicdata->id_civil_status,['placeholder'=>'Estado Civil','class'=>'form-control','required'])!!}	
						</div>
					</div>  	
            	</div>
            </div>
		</div>
	
		<div class="form-group">
		    
    		<div class="row">
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="children_number">Numero de hijos</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
								
							<input   class="form-control" type="text" name="children_number" id="children_number" value="{{ old('children_number',$editarSocioeconomicos->socioeconomicdata->children_number) }}">
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_residence_time">Tiempo en su residencia</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							{!!Form::select('id_residence_time', $tiempo_residencia,$editarSocioeconomicos->socioeconomicdata->id_residence_time,['placeholder'=>'Tiempo residencia','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_housing_type">Tipo de vivienda</label></p>
            </div>
			<div class="col-xs-2 col-md-2">
				<div class="row">
					<div class="col-xs-4 col-md-12">
						{!!Form::select('id_housing_type', $tipo_vivienda,$editarSocioeconomicos->socioeconomicdata->id_housing_type,['placeholder'=>'Tipo vivienda','class'=>'form-control','required'])!!}
					</div>
				</div>   	
            </div>
            </div>
            
		</div>
		<div class="form-group">
    		<div class="row">
    			<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_health_regime">Regimen de Salud</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_health_regime', $regimen_salud,$editarSocioeconomicos->socioeconomicdata->id_health_regime,['placeholder'=>'Regimen salud','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="sisben_category">Categoria Sisben</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('sisben_category', $categoria_sisben,$editarSocioeconomicos->socioeconomicdata->sisben_category,['placeholder'=>'Categoria sisben','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_benefits">Beneficios</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_benefits', $beneficios,$editarSocioeconomicos->socioeconomicdata->id_benefits,['placeholder'=>'Beneficios','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
		    
			
    		<div class="row">
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="household_people">Personas en la familia</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  class="form-control" type="text" name="household_people" id="household_people" value="{{ old('household_people', $editarSocioeconomicos->socioeconomicdata->household_people) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="economic_possition">Posicion economica</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('economic_possition', $posicion_economica, $editarSocioeconomicos->socioeconomicdata->economic_possition,['placeholder'=>'Posicion economica','class'=>'form-control','required'])!!}
						</div>
					</div>
						
					</div>
            	
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="dependent_people">Personas a cargo</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  class="form-control" type="text" name="dependent_people" id="dependent_people" value="{{ old('dependent_people', $editarSocioeconomicos->socioeconomicdata->dependent_people) }}">
						</div>
					</div>
                	
            	</div>	
            	</div>	
            </div>

			<div class="form-group">
    		<div class="row">
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="internet_zon">Internet en la zona</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('internet_zon', $internet_zona,$editarSocioeconomicos->socioeconomicdata->internet_zon,['placeholder'=>'Internet Zona','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="internet_home">Internet en el hogar</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('internet_home', $internet_hogar,$editarSocioeconomicos->socioeconomicdata->internet_home,['placeholder'=>'Internet hogar','class'=>'form-control','required'])!!}
						</div>
					</div>	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="sex_document_identidad">Sexo documento de identidad</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  class="form-control" type="text" name="sex_document_identidad" id="sex_document_identidad" value="{{ old('sex_document_identidad', $editarSocioeconomicos->socioeconomicdata->sex_document_identidad) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
    			<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_social_conditions">Condicion social</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_social_conditions', $condicion_social,$editarSocioeconomicos->socioeconomicdata->id_social_conditions,['placeholder'=>'Condicion social','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_disability">Discapacidad</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_disability', $discapacidad,$editarSocioeconomicos->socioeconomicdata->id_disability,['placeholder'=>'Discapacidad','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_ethnicity">Etnia</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_ethnicity', $etnia,$editarSocioeconomicos->socioeconomicdata->id_ethnicity,['placeholder'=>'Etnia','class'=>'form-control','required'])!!}
						</div>
					</div>
                	
            	</div>

            	
            </div>
		</div>	
			<input class="btn btn-primary" type="button" onclick="history.back()" name="volver atrás" value="Regresar">
			<input type="submit" value="Guardar Datos" class="btn btn-primary">
		
</div>
