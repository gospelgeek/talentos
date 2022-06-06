@extends('layouts.dashboard')

@section('title', 'Estudiantes Estados')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
<h1 style="text-align:center;">ESTADO ESTUDIANTES</h1>
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
                <td>Estado</td>
                <td>Motivo</td>
                <td>Fecha</td>
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
    var table = $('#example1').DataTable({
         processing: false,
         serverSide: false,
         ajax: "{{route('estudiantes.get_Estados')}}",
         columns: [
            { data: 'name' },
            { data: 'lastname' },
            { data: 'document_number' },
            { data: 'grupo' },
            { data: 'cohort' },
            { data: 'condicion' },
            { data: 'motivo'},
            { data: 'fecha'},
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

</script>
{!!Html::script('/js/estado.js')!!}
@endpush
@endsection
