@extends('layouts.secundario')
@section('title', 'Ver datos socioeconomicos')

@section('content')

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
							<input  readonly class="form-control" type="text" name="id_student" id="id_student" value="{{ old('id_student', $datos->socioeconomicdata->id_student) }}">

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
							<input readonly class="form-control" type="text" name="id_ocupation" id="id_ocupation" value="{{ old('id_ocupation', $datos->socioeconomicdata->occupation->name) }}">
						</div>
					</div>	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_civil_status">Estado civil</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input  readonly class="form-control" type="text" name="id_civil_status" id="id_civil_status" value="{{ old('id_civil_status', $datos->socioeconomicdata->civilstatus->name) }}">
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
								
							<input  readonly class="form-control" type="text" name="children_number" id="children_number" value="{{ old('children_number',$datos->socioeconomicdata->children_number) }}">
						
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_residence_time">Tiempo en su residencia</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input readonly class="form-control" type="text" name="id_residence_time" id="id_residence_time" value="{{ old('id_residence_time', $datos->socioeconomicdata->recidencetime->name) }}">
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_housing_type">Tipo de vivienda</label></p>
            </div>
			<div class="col-xs-2 col-md-2">
				<div class="row">
					<div class="col-xs-4 col-md-12">
						<input  readonly class="form-control" type="text" name="id_housing_type" id="id_housing_type" value="{{ old('id_housing_type', $datos->socioeconomicdata->recidencetime->name) }}">
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
							<input readonly class="form-control" type="text" name="id_health_regime" id="id_health_regime" value="{{ old('id_health_regime', $datos->socioeconomicdata->healthregime->name) }}">
						</div>
					</div>
                	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="sisben_category">Categoria Sisben</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="sisben_category" id="sisben_category" value="{{ old('sisben_category', $datos->socioeconomicdata->sisben_category) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_benefits">Beneficios</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="id_benefits" id="id_benefits" value="{{ old('id_benefits', $datos->socioeconomicdata->benefits->name) }}">
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
							<input readonly class="form-control" type="text" name="household_people" id="household_people" value="{{ old('household_people', $datos->socioeconomicdata->household_people) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="economic_possition">Posicion economica</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="economic_possition" id="economic_possition" value="{{ old('economic_possition', $datos->socioeconomicdata->economic_possition) }}">
						</div>
					</div>
						
					</div>
            	
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="dependent_people">Personas a cargo</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="dependent_people" id="dependent_people" value="{{ old('dependent_people', $datos->socioeconomicdata->dependent_people) }}">
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
							<input readonly class="form-control" type="text" name="internet_zon" id="internet_zon" value="{{ old('internet_zon', $datos->socioeconomicdata->internet_zon) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="internet_home">Internet en el hogar</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly  class="form-control" type="text" name="internet_home" id="internet_home" value="{{ old('internet_home', $datos->socioeconomicdata->internet_home) }}">
						</div>
					</div>	
            	</div>
            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="sex_document_identidad">Sexo documento de identidad</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="sex_document_identidad" id="sex_document_identidad" value="{{ old('sex_document_identidad', $datos->socioeconomicdata->sex_document_identidad) }}">
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
							<input readonly class="form-control" type="text" name="id_social_conditions" id="id_social_conditions" value="{{ old('id_social_conditions', $datos->socioeconomicdata->socialconditions->name) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_disability">Discapacidad</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="id_disability" id="id_disability" value="{{ old('id_disability', $datos->socioeconomicdata->disability->name) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-2 col-md-2">
            		<p style="text-align: right"><label for="id_ethnicity">Etnia</label></p>
            	</div>
				<div class="col-xs-2 col-md-2">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input readonly class="form-control" type="text" name="id_ethnicity" id="id_ethnicity" value="{{ old('id_ethnicity', $datos->socioeconomicdata->ethnicity->name) }}">
						</div>
					</div>
                	
            	</div>

            	
            </div>
		</div>	
			<input class="btn btn-primary" type="button" onclick="history.back()" name="volver atrás" value="Regresar">
			<a type="button" href="{{ route('usuario.editar_datos_socioeconomicos', $datos->id) }}" class="btn btn-primary">Actualizar Datos</a>
			
</div>
@endsection