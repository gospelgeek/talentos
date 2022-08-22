@extends('layouts.dashboard')

@section('title', 'Estudiantes Estados')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
<h1 style="text-align:center;">ESTADO ESTUDIANTES</h1>
    <div class="card">         
    <div class="card-body">
    <div class="btn-group">
       <div class="filtros_mes">
            <label>Filtrar por:</label>&nbsp;&nbsp;&nbsp;
            <label>FEBRERO</label>&nbsp;<input type="radio" name="filtro" id="fbrero">&nbsp;&nbsp;
            <label>MARZO</label>&nbsp;<input type="radio" name="filtro" id="mrzo">&nbsp;&nbsp;
            <label>ABRIL</label>&nbsp;<input type="radio" name="filtro" id="abrl">&nbsp;&nbsp;
            <label>MAYO</label>&nbsp;<input type="radio" name="filtro" id="myo">&nbsp;&nbsp;
            <label>JUNIO</label>&nbsp;<input type="radio" name="filtro" id="jnio">&nbsp;&nbsp;
            <label>JULIO</label>&nbsp;<input type="radio" name="filtro" id="jlio">&nbsp;&nbsp;
            <label>AGOSTO</label>&nbsp;<input type="radio" name="filtro" id="agsto">&nbsp;&nbsp;
            <label>TODOS</label>&nbsp;<input type="radio" name="filtro" id="tdos" checked>&nbsp;&nbsp;
       </div>
    </div>
    <div class="table-responsive">
     <table id="example1" class=" table table-bordered table-striped">
        <caption>Ultima modificación del estado de los estudiante: {{ $valor_ultimo }}</caption>
        <thead >
            <tr >
                <td>Nombres</td>
                <td>Tipo Doc.</td>
                <td>Nº documento</td>
                <td>Cohorte</td>
                <td>Grupo</td>
                <td>Prof. Acomp.</td>
                <td>Estado</td>
                <td>Motivo</td>
                <td>Fecha</td>
                <td>Observacion</td>
                <td>URL</td>
                <td>Acciones</td>
            </tr>
        </thead>
        @csrf 
      </table>
      </div>
    </div>
    </div>
</div>
{!!Form::open(['id'=>'form-edit','route'=>['estudiantes.estado_edit',':ESTADO_ID'], 'method'=>'GET'])!!}
{!!Form::close()!!}
@include('perfilEstudiante.estado.modal.edit_estado')
@include('perfilEstudiante.estado.modal.ver_estado')
@push('scripts')
<script type="text/javascript">
$('.filtros_mes').on('change', function() {
    $("#example1").DataTable().ajax.reload();
});
$(document).ready(function(){
    var table = $('#example1').DataTable({
         processing: false,
         serverSide: false,
         "ajax":{
            "method":"GET",
            "url": "{{route('estudiantes.get_Estados')}}",
            "data": function(d){
                d.febrero = $('#fbrero').is(":checked");
                d.marzo = $('#mrzo').is(":checked");
                d.abril = $('#abrl').is(":checked");
                d.mayo = $('#myo').is(":checked");
                d.junio = $('#jnio').is(":checked");
                d.julio = $('#jlio').is(":checked");
                d.agosto = $('#agsto').is(":checked");
                d.todos = $('#tdos').is(":checked");
            },
         },
         columns: [
            {data: null, render:function(data, type, row, meta) {
                        if(data.name !== null){
                            var celda;
                            celda = '<div>'+
                                    '<td>'+data.name+' '+data.lastname+'</td>'+
                                '</div>';
                            return celda;
                        }else{
                            return null;
                        }
                    }
            },
            { data: 'tipodocumento' },
            { data: 'document_number' },
            { data: 'cohorte' },
            { data: 'grupo' },
            {data: null, render:function(data, type, row, meta) {
                        if(data.profesional_name !== null){
                            var celda;
                            celda = '<div>'+
                                    '<td>'+data.profesional_name+' '+data.profesional_lastname+'</td>'+
                                '</div>';
                            return celda;
                        }else{
                            return null;
                        }
                    }
            },
            { data: 'condicion' },
            { data: 'motivo'},
            { data: 'fecha'},
            { data: 'observacion'},
            { data: 'url'},
            { data: null, render:function(data, type, row, meta){
                    
                    var mstr;
                   
                        mstr = '@if(auth()->user()->rol_id == 4 || auth()->user()->rol_id == 1)<a id="'+data.id+'" type="button" onclick="abrirmodal_ver(this);" ><i class="fa fa-eye" aria-hidden="true"></i>Detalles</a>&nbsp;<a id="'+data.id+'" type="button" onclick="abrirmodal(this);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Cambiar Estado</a> @else <a id="'+data.id+'" type="button" onclick="abrirmodal_ver(this);" ><i class="fa fa-eye" aria-hidden="true"></i>Detalles</a>@endif'; 

                    return mstr;
                }
            }
            
         ],
         "orderCellsTop": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "order": [[5,'desc']],
            "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            buttons: [     
                      {
                        extend: 'excel',
                        text: 'EXPORTAR EXCEL',
                        exportOptions: {
                                        modifier: {
                                                    page: 'all',

                                                  }
                                        }
                      },
                      {
                        extend: 'pdf',
                        text: 'EXPORTAR PDF',
                        exportOptions: {
                                        modifier: {
                                                    page: 'all'
                                                  }
                                        }
                      },
                      {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                                        modifier: {
                                                    page: 'all'
                                                  }
                                        }
                      },
                    ]
      });
      
      $('#example1 thead tr').clone(true).appendTo('#example1 thead');

        $('#example1 thead tr:eq(1) td').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Buscar"/>');

            $('input', this).on('keyup change', function () {
                if(table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
});
</script>
{!!Html::script('/js/estado.js')!!}
@endpush
@endsection
