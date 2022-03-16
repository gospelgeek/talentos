@extends('layouts.dashboard')

@section('title', 'Reporte Asistencias Estudiante')
@section('content')

@csrf
<div id="container-main">
	<div class="row">		
		<img  src="https://drive.google.com/uc?id={{$foto}}" class="avatar" alt="FOTO ESTUDIANTE">	
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
</div>
@endsection	