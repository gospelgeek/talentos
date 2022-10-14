@extends('layouts.dashboard')
@section('title', 'Caracterización Individual Socioeducativa')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">CARACTERIZACIÓN INDIVIDUAL SOCIOEDUCATIVA</h1>
    <div class="card">         
        <div class="card-body">
        	<h3 style="text-align:center;">{{$datos->name}} {{$datos->lastname}}<br>Profesional: {{$usuario->name}} {{$usuario->apellidos_user}}<br>{{$linea->name}} - {{$grupo->name}}</h3>
            <div class="table-responsive">  
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        	<th rowspan="2">Preguntas</th>
                            <th colspan="2">Respuesta</th>
                            <th rowspan="2">Fecha</th>
                        	<th rowspan="2">Riesgo</th>            
                        </tr>
                        <tr>
                            <th>Primer diligenciamiento</th>
                            <th>Segundo diligenciamiento</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts') 

    <script>

        var url = location.href;
        let parametro = url.substring(60);

    	var table_1 = $("#example1").DataTable({
            "ajax":{
                "method":"GET",
                "url":"{{route('datos.caracterizacion_individual')}}",
                "data": function(d){
                    d.parametro = parametro;
                },
            },
            "columns":[
                {data: 'name_question'},            
                {data: 'primer_diligenciamiento'},
                {data: 'segundo_diligenciamiento'},
                /*{data: null, render:function(data, type, row, meta){
                        if(data.try == 1){
                            return data.answers;
                        }else{
                            return '-';
                        }
                    }
                },*/         
                /*{data: null, render:function(data, type, row, meta){
                        if(data.try == 2){
                            return data.answers;
                        }else{
                            return '-';
                        }
                    }
                },*/
                {data: 'date_diligence'},
                {data: 'score', render:function(data, type, row, meta){
                        if(data != null && data != ''){
                            if(data == 1){
                                celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+'BAJO'+'</td>'+
                                            '</div>';
                                    return celda;
                            }
                            if(data == 2){
                                celda = '<div style="background-color: yellow;">'+
                                                '<td>'+'MEDIO'+'</td>'+
                                            '</div>';
                                    return celda;
                            }
                            if(data == 3){
                                celda = '<div style="background-color: red;">'+
                                                '<td>'+'ALTO'+'</td>'+
                                            '</div>';
                                    return celda;
                            }
                        }else{
                            if(data == 0){
                                celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+'BAJO'+'</td>'+
                                            '</div>';
                                    return celda;
                            }else{
                                return '-';
                            }
                        }
                    }
                },
            ],
    		
    		"deferRender": true,"responsive": false, "lengthChange": false, "autoWidth": false,
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print",
                "colvis"
            ]
    	});
    </script>
 
@endpush
@endsection
