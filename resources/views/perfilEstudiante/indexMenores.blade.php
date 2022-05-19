@extends('layouts.dashboard')
@section('title', 'Mayoria de edad')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">MAYORIA DE EDAD</h1>
    <div class="card">         
    <div class="card-body">
        @if(auth()->user()->rol_id == 1) 
        <div class="btn-group">
            <div class="col-xs-6 col-md-12 col-sm-6">
                <a class="btn btn-primary btn-sm mt-3 mb-3 float-left" href="{{route('reporte_socioeducativo')}}">EXCEL SOCIOEDUCATIVO</a>
            </div>
        </div>
        @endif

    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        
        <thead>
            <tr>
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Nº Documento</td>
                <td>Codigo</td>
                <td>Grupo</td>
                <td>Cohorte</td>
                <td>Fecha nacimiento</td>
                <td>Edad</td>
                <td width="15%">Acciones</td>
            </tr>
        </thead>
        
    </table>
      </div>
    </div>
    </div>
</div>

@push('scripts')

    <!-- Page specific script -->
    <script>

    let date = new Date().toDateString();
    //alert(date);

    var rol = document.getElementById('roles').value;
    var mstr;
    if(rol == 4 || rol == 1 || rol == 2){
        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<button class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver estudiante" onclick="verStudent()"></button>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn btn-block fa fa-pencil-square-o fa editar_seguimiento" title="Editar seguimiento"></button>'+
                          '</div>'+
                          
                "</div>"; 
    }else{
        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<button class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></button>'+
                          "</div>"+
                "</div>";
    }

   

 $("#example1").DataTable({
            "ajax": "{{route('datos.estudiantes.menores')}}",
            

            "columns": [
                {data: 'name'},
                {data: 'lastname'},
                {data: 'document_number'},
                {data: 'student_code'},
                {data: 'grupo'},
                {data: 'cohorte'},
                {data: 'birth_date'},
                {data: 'edad'},
                {data: null, render:function(data, type, row, meta){
                    var rol = document.getElementById('roles').value;
                    var mstr;
                    if(rol == 4 || rol == 1 || rol == 2){
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<tr id="1">'+'<td">'+'<a href="ver_estudiante/'+data.id+'" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                          '</div>'+                                 
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a href="editar_estudiante/'+data.id+'" class="btn btn-block fa fa-pencil-square-o fa" title="Editar seguimiento"></a>'+
                          '</div>'+
                          
                        "</div>"; 
                    }else{
                        mstr = '<div class="btn-group">'+
                          '<div class="col-xs-6 col-sm-6 btn-group">'+
                            '<a href="ver_estudiante/'+data.id+'" class="btn btn-block fa fa-eye fa ver_seguimiento" title="Ver seguimiento"></a>'+
                          "</div>"+
                        "</div>";
                    }

                    return mstr;
                }
            }
                
            ],

            
            
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "dom":'Bfrtip',
            "buttons": [
                "copy",
                "csv",
                "excel", 
                "pdf",
                "print",
                "colvis",
            ]
        });
 
 

    /*$('#accion button.ver_seguimiento').on('click', function() {
        //var id = $('this').parent('tr').attr('id');
        console.log();
    });*/
              
    </script>

 
@endpush
@endsection
