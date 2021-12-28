@extends('layouts.dashboard')
@section('title', 'Index')
@section('content')

<div class="container">
    <div class="card">  
        
        
        <div class="card-body">

            <div class="row">
                <div  class="col-xs-12 col-md-3 col-sm-3">
                    <a class="btn btn-success btn-sm mt-3 mb-3 float-left" href="{{route('crear_usuario')}}">Crear Usuario</a>            
                </div>
            </div>

	        <div class="table-responsive">
                <table id="example1" class=" table table-bordered table-striped">
                    <caption>USUARIOS</caption>
                        <thead>
                            <tr>
                                <td>Nombres y apellidos</td>
                                <td>Tipo documento</td>
                                <td>Documento</td>
                                <td>Correo electronico</td>
                                <td>Rol</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuario as $usuarios)
                            <tr>
                                <td>{{ $usuarios->name}} {{ $usuarios->apellidos_user}}</td>
                                <td>{{ $usuarios->tipo_documento_user}}</td>
                                <td>{{ $usuarios->cedula}}</td>
                                <td>{{ $usuarios->email}}</td>
                                <td>{{ $usuarios->roles->nombre_rol}}</td>                
                                <td>
                                   <div class="row">                                  
                                                <div class="col-xs-4 col-sm-4">
                                                    <a title="Ver Informacion" href="{{ route('ver_usuario', $usuarios->id) }}" class="btn btn-block btn-sm  fa fa-eye"></a>    
                                                </div>
                                                <div class="col-xs-4 col-sm-4">
                                                    <a title="Editar Informacion "href="{{ route('editar_usuario', $usuarios->id) }}" class="btn btn-sm btn-block fa fa-pen"></a>    
                                                </div>
                                                <div class="col-xs-4 col-sm-4">
                                                    {!!Form::open(['id'=>'myform','route'=>['eliminar_usuario', $usuarios->id], 'method'=>'delete'])!!}
                                                    {{csrf_field()}}
                                                    <a onclick="document.getElementById('myform').submit()"title="Eliminar Usuario" type="submit" style="color: red;border: none;" class="fa fa-trash"></a>
                                                    {!!Form::close()!!}    
                                                </div>
                                        </div> 
                                    @csrf                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron coincidencias",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar",
            "paginate":{
                "next" : "Siguiente",
                "previous": "Anterior"
            }
        },
            });
        });        
    </script>

 
@endpush
@endsection