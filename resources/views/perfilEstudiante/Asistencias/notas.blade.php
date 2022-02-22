@extends('layouts.dashboard')

@section('title', 'Calificaciones')
@section('content')

<div class="container-fluid">    
    <h1 style="text-align:center;">CALIFICACIONES</h1>
    <div class="card">        
    	<div class="card-body">
        	@if(auth()->user()->rol_id == 4)
       		<div class="row">
            	<div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class="btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_estudiante')}}">Agregar Calificacion</a>            
            	</div>
        	</div>
        	@endif

    		<div class="table-responsive">
     			<table id="example1" class=" table table-bordered table-striped">
        			<thead>
            			<tr>
                			<td style="width: 22%;">Nombres y apellidos</td>
               				<td>ITEMS</td>
            			</tr>
        			</thead>

        			<tbody>
           	 			@foreach ($notas as $nota)
                		<tr data-id="{{$nota->id}}">
                    		<td>{{ $nota->student->name}} {{$nota->student->lastname}}</td>                                  
                    		<td>
                        		<div class="row">                                  
                            		<div class="col-xs-6 col-sm-6">
                                		<a title="Ver Informacion" href="" class="btn btn-block btn-sm">NOTAS</a>    
                            		</div>
                        		</div>       
                    		</td>
                		</tr>
            			@endforeach    
        			</tbody>
      			</table>
      		</div>
    	</div>
    </div>
</div>

<a href="{{url()->previous()}}">Regresar</a>

@push('scripts')
{!!Html::script('/js/notas.js')!!}
@endpush

@endsection