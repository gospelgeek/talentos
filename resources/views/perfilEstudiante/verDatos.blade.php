@extends('layouts.dashboard')
@section('title', 'Ver Datos')

@section('content')

@csrf
<div id="container-main">
	<div class="row">
		@if($verDatosPerfil->photo != null)		
		<img  src="https://drive.google.com/uc?id={{$foto}}" class="avatar" alt="FOTO ESTUDIANTE">
		@else
		<img style="color: red;" alt="SIN SOPORTE" class="avatar">
		@endif
	</div>
	<br>	
	<div class="sticky-top">	
		<div class="row">
			<div class="col-sm-12">		             
           		{!!Form::text('nombres',$verDatosPerfil->name.' '.$verDatosPerfil->lastname,['class'=>'form-control','readonly','style' => 'font-size : 30px;font-weight: bolder; text-align: center;','disabled'])!!}
			</div>
		</div>
	</div>				
	<br>
	<div class="row" >
		{!!Form::label('td','TD:')!!}
		<div class="col-sm-1">
			{!!Form::select('documento',$documento,$verDatosPerfil->documenttype ? $verDatosPerfil->documenttype->id : null,['class'=>'form-control','required','readonly','disabled','style' =>'text-align: left;'])!!}	
		</div>
		{!!Form::label('documento','Nº documento:')!!}						
		<div class="col-sm-2">
			{!!Form::text('n_documento',$verDatosPerfil->document_number,['class'=>'form-control','readonly','disabled'])!!}
		</div>
			{!!Form::label('edad','Edad:')!!}
		<div class="col-sm-1">					
			{!!Form::text('edad',$edad,['class'=>'form-control','readonly','disabled'])!!}
		</div>
		{!!Form::label('correo','Email:')!!}
		<div class="col-sm-4">
			{!!Form::text('e-mail',$verDatosPerfil->email,['class'=>'form-control','readonly','disabled'])!!}
		</div>				
	</div>
	<br>
	<div class="row">
		{!!Form::label('celular','Celular:')!!}
		<div class="col-sm-2">
			{!!Form::text('e-phone',$verDatosPerfil->cellphone,['class'=>'form-control','readonly','disabled'])!!}
		</div>				
		{!!Form::label('grupo','Grupo:')!!}		
		<div class="col-sm-2">
			{!!Form::text('id_group', $verDatosPerfil->studentGroup->group->name,['class'=>'form-control','readonly','disabled'])!!}
		</div>
		{!!Form::label('cohorte','Cohorte:')!!}	
		<div class="col-sm-2">
			{!!Form::text('id_cohort', $verDatosPerfil->studentGroup->group->cohort->name,['class'=>'form-control','readonly','disabled'])!!}
		</div>
		@if(auth()->user()->rol_id == 1)
			{!!link_to('#',$title = '', $attributes = ['class'=>'btn bg-primary fa fa-pencil-square-o boton_cambiar_cohorte_grupo',$secure = null])!!}
		@endif
		&nbsp;{!!Form::label('cohorte','Estado:')!!}
		<div class="col-sm-2">
			{!!Form::select('id_state', $estado, $verDatosPerfil->id_state,['class'=>'form-control','readonly','disabled'])!!}
		</div>

		@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			{!!link_to('#',$title = '', $attributes = ['class'=>'btn bg-primary fa fa-pencil-square-o crear_estado',$secure = null])!!}

		@endif
	</div>	

	<br>

	<div class="accordion-container">
		<a href="#" id="titulo-1" class="accordion-titulo">Datos Generales<span class="toggle-icon"></span></a>
		<div id="contenido-1" class="accordion-content">
			<div class="form-group">
    			<div class="row">
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
								{!!Form::select('tipo_documento',$tipo_documento,$verDatosPerfil->documenttype ? $verDatosPerfil->documenttype->id : null,['id'=>'tipo_documento','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento' ,'disabled'])!!}					
							</div>
						</div>
            		</div>   
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								{!!Form::text('n_documento',$verDatosPerfil->document_number,['class'=>'form-control fa fa-external-link','readonly','disabled'])!!}
								@if($verDatosPerfil->url_document_type != null)
								<a href="{{$verDatosPerfil->url_document_type}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin Soporte</span>
								@endif
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
								<input readonly class="form-control" type="text" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ old('departamento_nacimiento', $verDatosPerfil->id_birth_department ?  $verDatosPerfil->birthcity->birthdepartament->name : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="ciudad_nacimiento">Ciudad nacimiento *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ old('ciudad_nacimiento', $verDatosPerfil->birthcity ? $verDatosPerfil->birthcity->name : null) }}">
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
								{!!Form::select('sexo',$sexo, $verDatosPerfil->sex,['id'=>'sexo','class'=>'form-control','required','placeholder'=>'Seleccionar sexo' ,'disabled'])!!}
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="genero">Genero</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('genero', $genero,$verDatosPerfil->gender ? $verDatosPerfil->gender->id : null ,['placeholder'=>'Genero','class'=>'form-control','required','disabled'])!!}
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
            			<p style="text-align: right"><label for="barrio_residencia">Barrio de residencia *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="barrio_residencia" id="barrio_residencia" value="{{ old('barrio_residencia', $verDatosPerfil->neighborhood ? $verDatosPerfil->neighborhood->name : null) }}">
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
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="telefono2">Codigo estudiante</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="student_code" id="student_code" value="{{ old('student_code', $verDatosPerfil ? $verDatosPerfil->student_code : null) }}">
							</div>
						</div>     	
            		</div>
            	</div>
			</div>		
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			{!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn btn-primary abrir_modal_actualizar'],$secure = null)!!}
			@endif
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		</div>			
	</div>

	<div class="accordion-container">
		<a href="#" id="titulo-2" class="accordion-titulo-2">Datos Academicos Previos<span class="toggle-icon"></span></a>
		<div id="contenido-2" class="accordion-content-2">
			<div class="form-group">
    			<div class="row">			
            		<div class="col-xs-4 col-md-2">
            			<p style="text-align: right"><label for="institution_name">Institucion</label></p>
            		</div>
					<div class="col-xs-4 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input readonly class="form-control" type="text" name="institution_name" id="institution_name" value="{{  $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->institution_name : null }}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="year_graduation">A&ntilde;o Graduacion</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  readonly class="form-control" type="text" name="year_graduation" id="year_graduation" value="{{ old('year_graduation', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->year_graduation : null) }}">
							</div>
						</div>  	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="snp_register">Registro SNP</label></p>
           			 </div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input  readonly class="form-control" type="text" name="snp_register" id="snp_register" value="{{ old('snp_register', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->snp_register : null) }}">
							</div>
						</div>   	
            		</div>
            	</div>
			</div>
	
			<div class="form-group">
    			<div class="row">
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="bachelor_title">Titulo Bachiller</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12"> 								
								<input  readonly class="form-control" type="text" name="bachelor_title" id="bachelor_title" value="{{ old('bachelor_title',$verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->bachelor_title : null)}}">
								@if($verDatosPerfil->previousacademicdata->url_academic_support != null)
								<a href="{{$verDatosPerfil->previousacademicdata->url_academic_support}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin soporte</span>
								@endif					
							</div>
						</div>
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="icfes_date">Fecha ICFES</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input readonly class="form-control" type="date" name="icfes_date" id="icfes_date" value="{{ old('icfes_date', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_date : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="icfes_score">Puntaje ICFES</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="icfes_score" id="icfes_score" value="{{ old('icfes_score', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_score : null) }}">
							</div>
						</div>               	
            		</div>
            		
           		</div>            
			</div>

			<div class="form-group">
    			<div class="row">
    				
            		
           		</div>
			</div>
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			{!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn btn-primary abrir_modal_actualizar_previos'],$secure = null)!!}
			@endif
		</div>
	</div>

	<div class="accordion-container">
		<a href="#" id="titulo-3" class="accordion-titulo-3">Datos SocioEconomicos<span class="toggle-icon"></span></a>
		<div id="contenido-3" class="accordion-content-3">
			<div class="form-group">
    			<div class="row">			
            		<div class="col-xs-4 col-md-2">
            			<p style="text-align: right"><label for="id_ocupation">Ocupacion</label></p>
            		</div>
					<div class="col-xs-4 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input readonly class="form-control" type="text" name="id_ocupation" id="id_ocupation" value="{{ old('id_ocupation', $verDatosPerfil->socioeconomicdata->id_ocupation ? $verDatosPerfil->socioeconomicdata->occupation->name : null) }}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_civil_status">Estado civil</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  readonly class="form-control" type="text" name="id_civil_status" id="id_civil_status" value="{{ old('id_civil_status', $verDatosPerfil->socioeconomicdata->civilstatus ? $verDatosPerfil->socioeconomicdata->civilstatus->name : null) }}">
							</div>
						</div>  	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_ethnicity">Etnia</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="id_ethnicity" id="id_ethnicity" value="{{$verDatosPerfil->socioeconomicdata->ethnicity ? $verDatosPerfil->socioeconomicdata->ethnicity->name : null }}">
								@if($verDatosPerfil->socioeconomicdata->url_ethnicity != null)
								<a href="{{$verDatosPerfil->socioeconomicdata->url_ethnicity}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin soporte</span>
								@endif	
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
								<input  readonly class="form-control" type="text" name="children_number" id="children_number" value="{{ old('children_number',$verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->children_number : null) }}">						
							</div>
						</div>
            		</div>   
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_residence_time">Tiempo en su residencia</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input readonly class="form-control" type="text" name="id_residence_time" id="id_residence_time" value="{{ old('id_residence_time', $verDatosPerfil->socioeconomicdata->recidencetime ? $verDatosPerfil->socioeconomicdata->recidencetime->name : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_housing_type">Tipo de vivienda</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input  readonly class="form-control" type="text" name="id_housing_type" id="id_housing_type" value="{{ old('id_housing_type', $verDatosPerfil->socioeconomicdata->recidencetime ? $verDatosPerfil->socioeconomicdata->recidencetime->name : null ) }}">
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
								<input readonly class="form-control" type="text" name="id_health_regime" id="id_health_regime" value="{{ old('id_health_regime', $verDatosPerfil->socioeconomicdata->healthregime ? $verDatosPerfil->socioeconomicdata->healthregime->name : null) }}">
								@if($verDatosPerfil->socioeconomicdata->url_health_regime != null)
								<a href="{{$verDatosPerfil->socioeconomicdata->url_health_regime}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin soporte</span>
								@endif			
							</div>
						</div>             	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="sisben_category">Categoria Sisben</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="sisben_category" id="sisben_category" value="{{ old('sisben_category', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->sisben_category : null) }}">
								@if($verDatosPerfil->socioeconomicdata->url_sisben_category != null)
								<a href="{{$verDatosPerfil->socioeconomicdata->url_sisben_category}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin soporte</span>
								@endif
							</div>
						</div>               	
					</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_benefits">Beneficios</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="id_benefits" id="id_benefits" value="{{ old('id_benefits', $verDatosPerfil->socioeconomicdata->benefits ? $verDatosPerfil->socioeconomicdata->benefits->name : null) }}">
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
								<input readonly class="form-control" type="text" name="household_people" id="household_people" value="{{ old('household_people', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->household_people : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="economic_possition">Posicion economica</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="economic_possition" id="economic_possition" value="{{ old('economic_possition', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->economic_possition : null) }}">
							</div>
						</div>		
					</div>            	
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="dependent_people">Personas a cargo</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="dependent_people" id="dependent_people" value="{{ old('dependent_people', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->dependent_people : null) }}">
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
								<input readonly class="form-control" type="text" name="internet_zon" id="internet_zon" value="{{ old('internet_zon', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->internet_zon : null) }}">
							</div>
						</div>               	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="internet_home">Internet en el hogar</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly  class="form-control" type="text" name="internet_home" id="internet_home" value="{{ old('internet_home', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->internet_home : null)}}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="sex_document_identidad">Sexo documento de identidad</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="sex_document_identidad" id="sex_document_identidad" value="{{ old('sex_document_identidad', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->sex_document_identidad : null) }}">
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
								<input readonly class="form-control" type="text" name="id_social_conditions" id="id_social_conditions" value="{{ $verDatosPerfil->socioeconomicdata->socialconditions ? $verDatosPerfil->socioeconomicdata->socialconditions->name : null }}">
								@if($verDatosPerfil->socioeconomicdata->url_social_conditions != null)
								<a href="{{$verDatosPerfil->socioeconomicdata->url_social_conditions}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
								@else
								<span style="color: red;">Sin soporte</span>
								@endif
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_disability">Discapacidad</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="id_disability" id="id_disability" value="{{ old('id_disability', $verDatosPerfil->socioeconomicdata->disability ? $verDatosPerfil->socioeconomicdata->disability->name : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_disability">Nombre EPS</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input readonly class="form-control" type="text" name="eps_name" id="eps_name" value="{{ old('eps_name', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->eps_name : null) }}">
							</div>
						</div>                	
            		</div>	
            	</div>
			</div>
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			{!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn btn-primary abrir_modal_socioeconomico'],$secure = null)!!}	
			@endif
		</div>
	</div>
	@if(auth()->user()->rol_id == 2 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 6 || auth()->user()->rol_id == 5)
	<div class="accordion-container">
		<a href="#" id="titulo-4" class="accordion-titulo-4">Seguimiento socioeducativo<span class="toggle-icon"></span></a>
		<div id="contenido-4" class="accordion-content-4">
            @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			    {!!link_to('#',$title = 'Nuevo seguimiento', $attributes = ['class'=>'btn btn-primary abrir_modal_seguimiento_socioeducativo'],$secure = null)!!}
			@endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<center><strong>PROFESIONAL ACOMPAÑAMIENTO: 

			@if($verDatosPerfil->assignmentstudent()->exists())
				@if($verDatosPerfil->assignmentstudent->id_user != 0)
					{{$verDatosPerfil->assignmentstudent->UserInfo->name}}
					{{$verDatosPerfil->assignmentstudent->UserInfo->apellidos_user}}
				@endif
			@endif
			<div id="mostrarsegui" class="table-responsive">
     			<br><table class=" table table-bordered table-striped">
        			<thead >
            			<tr>
                			<td>SEGUIMIENTO (YYYY-mm-dd)</td>
                			<td width="35%">ACCIONES</td>
            			</tr>
        			</thead>
        			<input type="hidden" id="detalle" value="{{$seguimientos}}"> 
        				
					<tbody id="mostrarFcA">
						
					
                	</tbody>
                	 
      			</table>
      			
      			
		
        	</div>
        	
        	
		</div>
	@endif
	</div>
    <div class="accordion-container" id="ti5">
		<a  href="#" id="titulo-5" class="accordion-titulo-5">Asistencias<span class="toggle-icon"></span></a>
		<div id="contenido-5" class="accordion-content-5">
			<script id="json" type="text" src="/json/students.json"></script>
			<script id="asisten" type="text" src="/json/asistencias.json"></script>
			<input type="hidden" name="id_moodle" id="moodle" data-id="{{$verDatosPerfil->id_moodle}}">
			<div class="table-responsive">
				<div id="carga" class="d-flex justify-content-center">
                        <strong>Procesando&nbsp;</strong>
                        <div class="spinner-border spinner-border-sm" role="status">                    
                        </div>
            	</div> 
				<table id="example1" class="table table-bordered table-striped">
					<caption style="caption-side: top;text-align:center;">Asistencias {{$verDatosPerfil->name}}</caption>
					<thead>
						<td>Asignatura</td>
						<td>Sesiones</td>
						<td>Asistencias</td>
						<td>Faltas</td>
						<td>Acciones</td>
					</thead>
					<tbody id="insertar">
						
					</tbody>
					<tfoot id="insertar2">
						<td>TOTAL</td>
						<td id="totalsesiones"></td>
						<td id="totalasistencias"></td>
						<td id="totalfaltas"></td>
						<td></td>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="accordion-container">
		<a href="#" id="titulo-6" class="accordion-titulo-6">Formalización<span class="toggle-icon"></span></a>
		<div id="contenido-6" class="accordion-content-6">
			<div class="form-group">
    			<div class="row">	
    				<div class="col-xs-12 col-md-12">
            				<input type="hidden" type="checkbox" name="aceptandoAcptacn" value="si" id="aceptandoAceptacion">	
            		</div>
            		<div class="col-xs-12 col-md-12">
            		<label>ACEPTACIÓN</label>	
            		</div>		
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="acceptance_v1">URL aceptacion V1</label></p>
            		</div>
            		@if($verDatosPerfil->formalization->acceptance_v1 != 'SI' && $verDatosPerfil->formalization->acceptance_v1 != null)
					<div class="col-xs-6 col-md-3">
						<input readonly class="form-control" type="text" name="acceptance_v1" id="acceptancev1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v1 : null }}">
						<a href="{{$verDatosPerfil->formalization->acceptance_v1}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
					</div>
					@else
					<div class="col-xs-6 col-md-3">
						<input readonly class="form-control" type="text" name="acceptance_v1" id="acceptancev1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v1 : null }}">
						
					</div>
					@endif
					@if($verDatosPerfil->formalization->acceptance_v2 != 'SI' && $verDatosPerfil->formalization->acceptance_v2 != null)
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="acceptance_v2">URL aceptacion V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input  readonly class="form-control" type="text" name="acceptance_v2" id="acceptancev2" value="{{ old('acceptance_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v2 : null) }}">
						<a href="{{$verDatosPerfil->formalization->acceptance_v2}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
					</div>
					@else
					<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="acceptance_v2">URL aceptacion V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input  readonly class="form-control" type="text" name="acceptance_v2" id="acceptancev2" value="{{ old('acceptance_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v2 : null) }}">
					</div>
					@endif
				</div><hr>
				<div class="row">		
					<div class="col-xs-12 col-md-12">
            			<input type="hidden" type="checkbox" name="aceptando" value="si" id="aceptandoTablet">
            		</div>
            		<div class="col-xs-12 col-md-12">
            		<label>TABLETS</label>	
            		</div>
            		@if($verDatosPerfil->formalization->tablets_v1 != 'SI' && $verDatosPerfil->formalization->tablets_v1 != null)	
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v1">URL Tablet V1</label></p>
            		</div>
					<div class="col-xs-6 col-md-3">
						<input readonly class="form-control" type="text" name="tablets_v1" id="tabletsv1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v1 : null }}">
						<a href="{{$verDatosPerfil->formalization->tablets_v1}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
					</div>
					@else
					<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v1">URL Tablet V1</label></p>
            		</div>
					<div class="col-xs-6 col-md-3">
						<input readonly class="form-control" type="text" name="tablets_v1" id="tabletsv1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v1 : null }}">
					</div>
					@endif
					@if($verDatosPerfil->formalization->tablets_v2 != 'SI' && $verDatosPerfil->formalization->tablets_v1 != null)
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v2">URL Tablet V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input  readonly class="form-control" type="text" name="tablets_v2" id="tabletsv2" value="{{ old('tablets_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v2 : null) }}">
						<a href="{{$verDatosPerfil->formalization->tablets_v2}}" target="blank" class="fa fa-external-link">Enlace Documento</a>
					</div>
					@else
					<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v2">URL Tablet V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input  readonly class="form-control" type="text" name="tablets_v2" id="tabletsv2" value="{{ old('tablets_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v2 : null) }}">
					</div>
					@endif
					<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="serial_tablet">Serial tablet</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input readonly class="form-control" type="text" name="serialtablet" id="serialtablet" value="{{ old('serial_tablet', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->serial_tablet : null) }}">

					</div>
				</div>
			</div>
		</div>
	</div>
	<br><a class="btn btn-primary" type="button" href="{{ route('estudiante')}}" >Regresar</a>
</div>

@include('perfilEstudiante.modal.editestado')
@include('perfilEstudiante.modal.detalles_asistencias')
@include('perfilEstudiante.modal.actualizarDatos.generales')
@include('perfilEstudiante.modal.actualizarDatos.socioeconomicos')
@include('perfilEstudiante.modal.actualizarDatos.academicosPrevios')
@include('perfilEstudiante.seguimientos.modal.create')
@include('perfilEstudiante.seguimientos.modal.editar')
@include('perfilEstudiante.seguimientos.modal.ver')
@include('perfilEstudiante.modal.editcohortegrupo')
@include('perfilEstudiante.modal.alerta')


{!!Form::open(['id'=>'form-edit-seguimiento','route'=>['editarseguimiento',':SEGUIMIENTO_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}

{!!Form::open(['id'=>'form-delete','route'=>['deleteseguimiento',':SEGUIMIENTO_ID'], 'method'=>'DELETE'])!!}
{!!Form::close()!!}


@push('scripts')
{!!Html::script('/js/filtroestudiantes.js')!!}
{!!Html::script('/js/actualizarDatos.js')!!}
{!!Html::script('/js/seguimientoSocioeducativo.js')!!}
@endpush


@endsection
