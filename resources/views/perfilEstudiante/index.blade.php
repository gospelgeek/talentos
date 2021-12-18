@extends('layouts.app')

@section('title', 'Index')

@section('content')


<a class="btn btn-success btn-sm mt-3 mb-3 float-right" href="{{route('crear_estudiante')}}">Crear Perfil</a>
<div class="container">    
    <div class="card">
    <div class="card-body">
        

     <table id="table9" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <td>Nombres y apellidos</td>
                <td>Nº documento</td>
                <td>Fecha de nacimiento</td>
                <td>Sexo</td>
                <td>Ciudad Residencia</td>
                <td>Direccion</td>
                <td>Email</td>
                <td>Telefono</td>
                <td>Acciones</td>
            </tr>
        </thead> 

        <tbody>
            @foreach ($perfilEstudiantes as $estudiante)
                <tr>
                    <td>{{ $estudiante->name}} {{ $estudiante->lastname}}</td>
                                        <td>{{ $estudiante->document_number}}</td>
                                        <td>{{ $estudiante->birth_date}}</td>
                                        <td>{{ $estudiante->sex}}</td>
                                        <td>{{ $estudiante->id_birth_department}}</td>
                                        <td>{{ $estudiante->id_birth_city}}</td>
                                        <td>{{ $estudiante->email}}</td>
                                        <td>{{ $estudiante->cellphone }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6 form-group">
                                                    <a href="{{ route('ver_estudiante', $estudiante->id) }}" class="btn btn-primary">VER</a>    
                                                </div>
                                                <div class="col-xs-12 col-md-6 form-group">
                                                    <a href="{{ route('editar_estudiante', $estudiante->id) }}" class="btn btn-primary">EDT</a>    
                                                </div>
                                                <div class="col-xs-12 col-md-6 form-group">
                                                    <form method="POST" action="{{ route('delete_estudiante', $estudiante->id) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger" type="submit">ELI</button>    
                                                    </form>    
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
@endsection