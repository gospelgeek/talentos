@extends('layouts.dashboard')

@section('title', 'Asistencias Estudiantes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">    
    <h1 style="text-align:center;">ESTUDIANTES</h1>
    <div class="card">         
    <div class="card-body">


    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº documento</td>
                <td>Grupo</td>
                <td>Cohorte</td>
                <td>Total Inasistencias</td>
                <td>Acciones</td>
            </tr>
        </thead> 
      </table>
      </div>
    </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

   var table = $("#example1").DataTable({
            
            "ajax":{

                "method":"GET",
                "url": "{{route('inasistencias')}}",
                "dataSrc": 'data'            
            },
            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'document_number'},
                {data: 'student_group.group.name'},
                {data: 'student_group.group.cohort.name'},
                {data: 'inasistencia'},
                {data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '<div class="row">'+                                  
                                                '<div class="col-xs-4 col-sm-4">'+
                                                    '<a id="'+data.id+'" title="Ver Informacion" onclick="redireccionar(this)" class="btn btn-block btn-sm  fa fa-eye"></a>'+    
                                                '</div>'+                                                
                                            '</div>'; 

                    return mstr;
                }
            }       
            ],

            "deferRender": true,"responsive": true, "lengthChange": false, "autoWidth": false,"order": [[5,'dsc']],
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
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
