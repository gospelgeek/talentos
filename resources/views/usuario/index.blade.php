@extends('layouts.app')
@section('title', 'Index')
@section('content')

<div class="container">
	
	<a class="btn btn-success btn-sm mt-3 mb-3 float-right" href="{{route('crear_usuario')}}">Crear Usuario</a>

	<table class="table table-hover">
        <caption>USUARIOS</caption>
        <thead>
            <tr>
                <td>Nombres y apellidos<td>
                <td>Tipo documento</td>
                <td>Documento</td>
                <td>Correo electronico</td>
                <td>Rol</td>
                <td>Password</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuario as $usuarios)
            <tr>
                <td>{{ $usuarios->name}} {{ $usuarios->apellidos_user}}</td><td></td>
                <td>{{ $usuarios->tipo_documento_user}}</td>
                <td>{{ $usuarios->cedula}}</td>
                <td>{{ $usuarios->email}}</td>
                <td>{{ $usuarios->rol_id}}</td>
                <td>{{ $usuarios->password}}</td>                
                <td>
                	<div class="row">
                        <div class="col-xs-12 col-md-6 form-group">
                            <a href="{{ route('ver_usuario', $usuarios->id) }}" class="btn btn-primary">VER</a>    
                        </div>
                        <div class="col-xs-12 col-md-6 form-group">
                            <a href="{{ route('editar_usuario', $usuarios->id) }}" class="btn btn-primary">EDT</a>    
                        </div>
                        <div class="col-xs-12 col-md-6 form-group">
                            <form method="POST" action="{{ route('eliminar_usuario', $usuarios->id) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit">ELI</button>    
                            </form>    
                        </div>
                    </div>
                        @csrf
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $usuario->links() }}
</div>

@endsection