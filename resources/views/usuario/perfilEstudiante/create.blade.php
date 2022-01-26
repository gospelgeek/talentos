@extends('layouts.app')

@section('content')

	@include('vistasParciales.validacionErrores')

	<form action="{{ route("usuario.store_estudiante")}}" method="POST"> 
		<div class="container">
		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right;"><label for="name">Nombres *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input class="form-control" type="text" name="name" id="name" value="{{ old('name', $editarEstudiante->name) }}">

							@error('name')
				    			<small class="text-danger">{{ $message }}</small>
				    		@enderror

						</div>
					</div>
                	
            	</div>
			
            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="lastname">Apellidos *</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input class="form-control" type="text" name="lastname" id="lastname" value="{{ old('lastname', $editarEstudiante->lastname) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</diªv>

		<div class="form-group">  
    		<div class="row">
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="id_document_type">Seleccionar Tipo de documento</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12"> 
							{!!Form::select('id_document_type',$tipo_documento, null,['id'=>'id_document_type','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento' ,'style'=>' '])!!}
						</div>
					</div>
            	</div>
   
            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="document_number">Documento de identificacion *</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-4 col-md-12">
							<input class="form-control" type="text" name="document_number" id="document_number" value="{{ old('document_number', $editarEstudiante->document_number) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="birth_date">Fecha de nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="date" name="birth_date" id="birth_date" value="{{ old('fecha_nacimiento', $editarEstudiante->birth_date) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="departamento_nacimiento">Departamento nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('depNacimiento',$depNacimiento, null,['id'=>'depNacimiento','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento' ,'style'=>' '])!!}
						</div>
					</div>
                	
            	</div>
            </div>
		</div>


		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="id_birth_city">Ciudad nacimiento *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							{!!Form::select('id_birth_city',$muni_nacimiento, null,['id'=>'muni_nacimiento','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento' ,'style'=>' '])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="email">Correo Electronico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
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
            	<div class="col-xs-4 col-md-3">
            		<p style="text-align: right"><label for="sex">Sexo</label></p>
            	</div>
				<div class="col-xs-4 col-md-3">
					<div class="row">
						<div class="col-xs-3 col-md-12"> 
								{!!Form::select('sex',$sexo, null,['id'=>'sex','class'=>'form-control','required',
									'placeholder'=>'Seleccionar sexo' ,'style'=>' '])!!}
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-3 col-md-3">
            		<p style="text-align: right"><label for="gender">Genero</label></p>
            	</div>
				<div class="col-xs-3 col-md-3">
					<div class="row">
						<div class="col-xs-3 col-md-12"> 
								{!!Form::select('gender', $genero,null,['placeholder'=>'Genero','class'=>'form-control','required'])!!}
						</div>
					</div>
            	</div>		
            </div>
        </div>

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="id_neighborhood">Barrio Residencia *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="id_neighborhood" id="id_neighborhood" value="{{ old('id_neighborhood') }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="direction">Direccion *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="direction" id="direction" value="{{ old('direction', $editarEstudiante->direction) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>

		

		<div class="form-group">
    		<div class="row">
            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="cellphone">Numero telefonico *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="cellphone" id="cellphone" value="{{ old('cellphone', $editarEstudiante->cellphone) }}">
						</div>
					</div>
                	
            	</div>

            	<div class="col-xs-12 col-md-3">
            		<p style="text-align: right"><label for="phone">Numero telefonico alternativo *</label></p>
            	</div>
				<div class="col-xs-12 col-md-3">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $editarEstudiante->phone) }}">
						</div>
					</div>
                	
            	</div>
            </div>
		</div>
		<a class="btn btn-primary" type="button" href="{{ route('usuario.estudiante')}}" >Regresar</a>						
		
</div>

	</form>
@endsection