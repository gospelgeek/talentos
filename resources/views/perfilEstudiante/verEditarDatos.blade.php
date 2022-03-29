@extends('layouts.dashboard')
@section('title', 'Editar Datos')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
@csrf
<div id="container-main">
	<div class="row">		
		<img  src="https://drive.google.com/uc?id={{$foto}}" class="avatar" alt="FOTO ESTUDIANTE">	
	</div>
	<br>	
	<div class="sticky-top">	
		<div class="row">
			<div class="col-sm-12">		             
           		{!!Form::text('nombres',$verDatosPerfil->name.' '.$verDatosPerfil->lastname,['class'=>'form-control','readonly','style' =>'font-size : 30px;font-weight: bolder; text-align: center;','disabled'])!!}
			</div>
		</div>
	</div>				
	<br>
	<div class="form-row align-items-center" >
		{!!Form::label('td','TD:')!!}
		<div class="col-sm-1">
			{!!Form::select('documento',$documento,$verDatosPerfil->documenttype ? $verDatosPerfil->documenttype->id : null,['class'=>'form-control','required','readonly','disabled','style'=>'border: none ', 'text-align: left;'])!!}	
		</div>
		{!!Form::label('documento','Nº documento:')!!}						
		<div class="col-sm-2">
			{!!Form::text('n_documento',$verDatosPerfil->document_number,['class'=>'form-control','readonly','disabled','style' =>'border: none ', 'text-align: left;'])!!}
		</div>
			{!!Form::label('edad','Edad:')!!}
		<div class="col-sm-1">					
			{!!Form::text('edad',$edad,['class'=>'form-control','readonly','disabled','style' =>'border: none ', 'text-align: left;'])!!}
		</div>
		{!!Form::label('correo','Email:')!!}
		<div class="col-sm-4">
			{!!Form::text('e-mail',$verDatosPerfil->email,['class'=>'form-control','readonly','disabled','style' =>'border: none ', 'text-align: left;'])!!}
		</div>				
	</div>
	<br>
	<div class="form-row align-items-center">
		{!!Form::label('celular','Celular:')!!}
		<div class="col-sm-2">
			{!!Form::text('e-phone',$verDatosPerfil->cellphone,['class'=>'form-control','readonly','disabled','style' =>'border: none ', 'text-align: left;'])!!}
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
			{!!Form::model($verDatosPerfil,['route'=>['updatedatosgenerales',$verDatosPerfil->id], 'method'=>'PUT'])!!}
            {{csrf_field()}}
			<div class="form-group">
				<div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->id,['id'=>'idGeN','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                </div> 
    			<div class="row">
            		<div class="col-xs-3 col-md-2">
            			<p style="text-align: right;"><label for="nombres">Nombres *</label></p>
            		</div>
					<div class="col-xs-4 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input class="form-control" type="text" name="nombres" id="nombres123" value="{{ old('nombres', $verDatosPerfil->name) }}">
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
								<input  class="form-control" type="text" name="apellidos" id="apellidosG" value="{{ old('apellidos', $verDatosPerfil->lastname) }}">
							</div>
						</div>	
            		</div>

            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="fecha_nacimiento">Fecha de nacimiento *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input   class="form-control" type="date" name="fecha_nacimiento" id="fechanacimientoG" value="{{ old('fecha_nacimiento', $verDatosPerfil->birth_date) }}">
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
								{!!Form::select('tipo_documento',$tipo_documento,$verDatosPerfil->documenttype ? $verDatosPerfil->documenttype->id : null,['id'=>'tipodocumento','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento'])!!}					
							</div>
						</div>
            		</div>   
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="numero_documento">Documento de identificacion *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input  class="form-control" type="text" name="numero_documento" id="numerodocumento" value="{{ old('numero_documento', $verDatosPerfil->document_number) }}">
							</div>
						</div>               	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="fecha_nacimiento">Fecha de Expedicion del documento</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input   class="form-control" type="date" name="document_expedition_date" id="expedition" value="{{ old('fecha_nacimiento', $verDatosPerfil->document_expedition_date) }}">
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
								{!!Form::select('id_birth_city',$ciudad, $verDatosPerfil ? $verDatosPerfil->id_birth_city : null,['id'=>'ciudadnacimiento','class'=>'form-control','required','placeholder'=>'Ciudad nacimiento'])!!}
							</div>
						</div>                	
            		</div>

            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="emailq">Correo Electronico *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="email" id="elctrncO" value="{{ old('email', $verDatosPerfil->email) }}">
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
								{!!Form::select('sexo',$sexo, $verDatosPerfil ? $verDatosPerfil->sex : null,['id'=>'sexoGeN','class'=>'form-control','required','placeholder'=>'Seleccionar sexo'])!!}
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="genero">Genero</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('genero', $genero,$verDatosPerfil->gender ? $verDatosPerfil->gender->id : null ,['id'=>'gen','placeholder'=>'Genero','class'=>'form-control','required'])!!}
							</div>	
						</div>
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="telefono1">Numero telefonico *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="telefono1" id="telefono11" value="{{ old('telefono1', $verDatosPerfil->cellphone) }}">
							</div>
						</div>               	
            		</div>		
            	</div>
        	</div>

			<div class="form-group">
    			<div class="row">
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_neighborhood">Barrio Residencia *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('id_neighborhood', $barrio,$verDatosPerfil->neighborhood ? $verDatosPerfil->neighborhood->id : null ,['id'=>'barrioresidencia','placeholder'=>'Genero','class'=>'form-control','required'])!!}
							</div>
						</div>    	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="direccion">Direccion *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input   class="form-control" type="text" name="direccion" id="direccionnnnn" value="{{ old('direccion', $verDatosPerfil->direction) }}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="telefono2">Numero telefonico alternativo *</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="telefono2" id="telefono22" value="{{ old('telefono2', $verDatosPerfil->phone) }}">
							</div>
						</div>     	
          </div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="student_code">Codigo estudinate</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="student_code" id="codEstudiante" value="{{ old('student_code', $verDatosPerfil->student_code) }}">
							</div>
						</div>     	
            		</div>
            	</div>
			</div>			
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
			
		    {!!Form::submit('Guardar Datos',['class'=>'btn btn-primary boton_update_generales'])!!}                       
            {!!Form::close()!!} 	
			
			@endif
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		</div>			
	</div>

	<div class="accordion-container">
		<a href="#" id="titulo-2" class="accordion-titulo-2">Datos Academicos Previos<span class="toggle-icon"></span></a>
		<div id="contenido-2" class="accordion-content-2">
			{!!Form::model($verDatosPerfil,['route'=>['updatedatosacademicosprevios',$verDatosPerfil->previousacademicdata->id], 'method'=>'PUT'])!!}
            {{csrf_field()}}
			<div class="form-group">
				<div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->previousacademicdata->id,['id'=>'idPaD','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                </div> 
    			<div class="row">			
            		<div class="col-xs-4 col-md-2">
            			<p style="text-align: right"><label for="institution_name">Institucion</label></p>
            		</div>
					<div class="col-xs-4 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input class="form-control" type="text" name="institution_name" id="institutionname" value="{{  $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->institution_name : null }}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="year_graduation">A&ntilde;o Graduacion</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="year_graduation" id="yeargraduation" value="{{ old('year_graduation', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->year_graduation : null) }}">
							</div>
						</div>  	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="snp_register">Registro SNP</label></p>
           			 </div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input  class="form-control" type="text" name="snp_register" id="snpregister" value="{{ old('snp_register', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->snp_register : null) }}">
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
								<input  class="form-control" type="text" name="bachelor_title" id="bachelortitle" value="{{ old('bachelor_title',$verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->bachelor_title : null)}}">					
							</div>
						</div>
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="icfes_date">Fecha ICFES</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								<input class="form-control" type="date" name="icfes_date" id="icfesdate" value="{{ old('icfes_date', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_date : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="icfes_score">Puntaje ICFES</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input class="form-control" type="text" name="icfes_score" id="icfesscore" value="{{ old('icfes_score', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_score : null) }}">
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

			{!!Form::submit('Guardar Datos',['class'=>'btn btn-primary boton_update_academicos_previos'])!!}                       

			@endif
		</div>
	</div>

	<div class="accordion-container">
		<a href="#" id="titulo-3" class="accordion-titulo-3">Datos SocioEconomicos<span class="toggle-icon"></span></a>
		<div id="contenido-3" class="accordion-content-3">
			{!!Form::model($verDatosPerfil,['route'=>['updatedatossocioeconomicos',$verDatosPerfil->socioeconomicdata->id], 'method'=>'PUT'])!!}
            {{csrf_field()}}
			<div class="form-group">
				<div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->socioeconomicdata->id,['id'=>'idSd','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                </div> 
    			<div class="row">			
            		<div class="col-xs-4 col-md-2">
            			<p style="text-align: right"><label for="id_ocupation">Ocupacion</label></p>
            		</div>
					<div class="col-xs-4 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								{!!Form::select('id_ocupation', $ocupacion, $verDatosPerfil->socioeconomicdata->occupation ? $verDatosPerfil->socioeconomicdata->occupation->id : null ,['id'=>'idocupation','placeholder'=>'Ocupacion','class'=>'form-control','required'])!!}
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_civil_status">Estado civil</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('id_civil_status', $estado_civil, $verDatosPerfil->socioeconomicdata->civilstatus ? $verDatosPerfil->socioeconomicdata->civilstatus->id : null ,['id'=>'idcivilstatus','placeholder'=>'Estado civil','class'=>'form-control','required'])!!}
							</div>
						</div>  	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_ethnicity">Etnia</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('id_ethnicity', $etnia, $verDatosPerfil->socioeconomicdata->ethnicity ? $verDatosPerfil->socioeconomicdata->ethnicity->id : null ,['id'=>'idethnicity','placeholder'=>'Etnia','class'=>'form-control','required'])!!}
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
								<input  class="form-control" type="text" name="children_number" id="childrennumber" value="{{ old('children_number',$verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->children_number : null) }}">						
							</div>
						</div>
            		</div>   
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_residence_time">Tiempo en su residencia</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								{!!Form::select('id_residence_time', $residencia, $verDatosPerfil->socioeconomicdata->recidencetime ? $verDatosPerfil->socioeconomicdata->recidencetime->id : null ,['id'=>'idresidencetime','placeholder'=>'Tiempo en residencia','class'=>'form-control','required'])!!}
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_housing_type">Tipo de vivienda</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-4 col-md-12">
								{!!Form::select('id_housing_type', $vivienda, $verDatosPerfil->socioeconomicdata->housingtype ? $verDatosPerfil->socioeconomicdata->housingtype->id : null ,['id'=>'idhousingtype','placeholder'=>'Tipo vivienda','class'=>'form-control','required'])!!}
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
								{!!Form::select('id_health_regime', $regimen, $verDatosPerfil->socioeconomicdata->healthregime ? $verDatosPerfil->socioeconomicdata->healthregime->id : null ,['id'=>'idhealthregime','placeholder'=>'Regimen de salud','class'=>'form-control','required'])!!}
							</div>
						</div>             	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="sisben_category">Categoria Sisben</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input class="form-control" type="text" name="sisben_category" id="sisbencategory" value="{{ old('sisben_category', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->sisben_category : null) }}">
							</div>
						</div>               	
					</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_benefits">Beneficios</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('id_benefits', $beneficios, $verDatosPerfil->socioeconomicdata->benefits ? $verDatosPerfil->socioeconomicdata->benefits->id : null ,['id'=>'idbenefits','placeholder'=>'Beneficios','class'=>'form-control','required'])!!}
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
								<input class="form-control" type="text" name="household_people" id="householdpeople" value="{{ old('household_people', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->household_people : null) }}">
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="economic_possition">Posicion economica</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input class="form-control" type="text" name="economic_possition" id="economicpossition" value="{{ old('economic_possition', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->economic_possition : null) }}">
							</div>
						</div>		
					</div>            	
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="dependent_people">Personas a cargo</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input class="form-control" type="text" name="dependent_people" id="dependentpeople" value="{{ old('dependent_people', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->dependent_people : null) }}">
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
								<input class="form-control" type="text" name="internet_zon" id="internetzon" value="{{ old('internet_zon', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->internet_zon : null) }}">
							</div>
						</div>               	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="internet_home">Internet en el hogar</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input  class="form-control" type="text" name="internet_home" id="internethome" value="{{ old('internet_home', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->internet_home : null) }}">
							</div>
						</div>	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="sex_document_identidad">Sexo documento de identidad</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input class="form-control" type="text" name="sex_document_identidad" id="sexdocumentidentidad" value="{{ old('sex_document_identidad', $verDatosPerfil->socioeconomicdata ? $verDatosPerfil->socioeconomicdata->sex_document_identidad : null) }}">
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
								{!!Form::select('id_social_conditions', $condicion, $verDatosPerfil->socioeconomicdata->socialconditions ? $verDatosPerfil->socioeconomicdata->socialconditions->id : null ,['id'=>'idsocialconditions','placeholder'=>'Condicion social','class'=>'form-control','required'])!!}
							</div>
						</div>                	
            		</div>
            		<div class="col-xs-2 col-md-2">
            			<p style="text-align: right"><label for="id_disability">Discapacidad</label></p>
            		</div>
					<div class="col-xs-2 col-md-2">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								{!!Form::select('id_disability', $discapacidad, $verDatosPerfil->socioeconomicdata->disability ? $verDatosPerfil->socioeconomicdata->disability->id : null ,['id'=>'iddisability','placeholder'=>'Discapacidad','class'=>'form-control','required'])!!}
							</div>
						</div>                	
            		</div>
            			
            	</div>
			</div>
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)

			{!!Form::submit('Guardar Datos',['class'=>'btn btn-primary boton_update_socioeconomicos'])!!}                       

            {!!Form::close()!!}
			@endif
		</div>
	</div>
	@if(auth()->user()->rol_id == 2 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 6)
	<div class="accordion-container">
		<a href="#" id="titulo-4" class="accordion-titulo-4">Seguimiento socioeducativo<span class="toggle-icon"></span></a>
		<div id="contenido-4" class="accordion-content-4">
			{!!link_to('#',$title = 'Nuevo seguimiento', $attributes = ['class'=>'btn btn-primary abrir_modal_seguimiento_socioeducativo'],$secure = null)!!}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<center><strong>PROFESIONAL ACOMPAÑAMIENTO: {{ $asignacion->UserInfo ? $asignacion->UserInfo->name : null }} {{ $asignacion->UserInfo ? $asignacion->UserInfo->apellidos_user : null }}</strong></center>
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
<div class="accordion-container">

		<a href="#" id="titulo-5" class="accordion-titulo-5">Asistencias<span class="toggle-icon"></span></a>
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
			{!!Form::model($verDatosPerfil,['route'=>['updateformalizacion',$verDatosPerfil->formalization->id], 'method'=>'PUT'])!!}
            {{csrf_field()}}
			<div class="form-group">
				<div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->formalization->id,['id'=>'idfLz','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                </div>
    			<div class="row">
    				<div class="col-xs-12 col-md-12">
            				<input type="checkbox" name="aceptandoAcptacn" value="si" id="aceptandoAceptacion">&nbsp;&nbsp;<label>ACEPTACIÓN</label>	
            		</div>			
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="acceptance_v1">URL aceptacion V1</label></p>
            		</div>
					<div class="col-xs-6 col-md-3">
						<input class="form-control" type="text" name="acceptance_v1" id="acceptancev1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v1 : null }}">
					</div>
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="acceptance_v2">URL aceptacion V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input  class="form-control" type="text" name="acceptance_v2" id="acceptancev2" value="{{ old('acceptance_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->acceptance_v2 : null) }}">
					</div>
				</div><hr>
				<div class="row">
					<div class="col-xs-12 col-md-12">
            			<input type="checkbox" name="aceptando" value="si" id="aceptandoTablet">&nbsp;&nbsp;<label>TABLETS</label>	
            		</div>			
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v1">URL Tablet V1</label></p>
            		</div>
					<div class="col-xs-6 col-md-3">
						<input class="form-control" type="text" name="tablets_v1" id="tabletsv1" value="{{  $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v1 : null }}">
					</div>
            		<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="tablets_v2">URL Tablet V2</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input class="form-control" type="text" name="tabletsv2" id="tabletsv2" value="{{ old('tablets_v2', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->tablets_v2 : null) }}">
					</div>
					<div class="col-xs-3 col-md-3">
            			<p style="text-align: right"><label for="serial_tablet">Serial tablet</label></p>
            		</div>
					<div class="col-xs-3 col-md-3">
						<input class="form-control" type="text" name="serialtablet" id="serialtablet" value="{{ old('serial_tablet', $verDatosPerfil->formalization ? $verDatosPerfil->formalization->serial_tablet : null) }}">

					</div>
				</div>
			</div>
			@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)

			{!!Form::submit('Guardar Datos',['class'=>'btn btn-primary boton_update_formalizacion', 'id'=>'boton' ])!!}                       

            {!!Form::close()!!}
		@endif
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



@include('vistasParciales.validacionErrores')

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
