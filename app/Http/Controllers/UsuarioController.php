<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    public function index(){

        $usuario = User::orderBy('created_at', 'desc')->paginate(5);
        //$rol = User::roles_name();
        //dd($roles_nombres);
        return view('usuario.index', compact('usuario'));
    }  

    public function crear(){
        $roles =  Role::pluck('nombre_rol','id');
        return view('usuario.crear', compact('roles'), ['editarUsuario' => new User()]);
    } 

    public function store (UsuarioRequest $request) {
        //dd('hola');
        $idUsuario = User::create([
            'name'                 => $request['name'],
            'apellidos_user'       => $request['apellidos_user'], 
            'tipo_documento_user'  => $request['tipo_documento_user'], 
            'cedula'               => $request['cedula'],
            'email'                => $request['email'],
            'rol_id'               => $request['rol_id'], 
            'password'             => $request['password'],
        ]);

        return redirect('usuario')->with('status', 'Usuario guardado exitosamente!');
    }

    public function show($id) {
        $verUsuario = User::findOrFail($id);
        return view('usuario.verDatos', compact('verUsuario'));
    }

    public function editar($id){
        
        $editarUsuario = User::findOrFail($id);
        
        return view('usuario.editar', compact('editarUsuario'));
    }

    public function update(UsuarioRequest $request, $id) {
        
        $data = User::findOrFail($id);
        //dd($data);
        $data->update($request->validated());
        
        //$dataNew = perfilEstudiante::findOrFail($id);
        //dd($dataNew);



        return redirect('usuario')->with('status', 'usuario actualizado exitosamente!');
    }


}
