<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('sistemas');
        
    }

    public function prueba(){

        dd('usuario Controller');
    }
    
    public function index(){

        $usuario = User::orderBy('created_at', 'desc')->paginate(5);
        //dd($usuario);
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
            'password'             => bcrypt($request['password']),
        ]);

        return redirect('usuario')->with('status', 'Usuario guardado exitosamente!');
    }

    public function show($id) {
        $verUsuario = User::findOrFail($id);
        return view('usuario.verDatos', compact('verUsuario'));
    }

    public function editar($id){
        $roles =  Role::pluck('nombre_rol','id');
        $editarUsuario = User::findOrFail($id);
        
        return view('usuario.editar', compact('editarUsuario', 'roles'));
    }

    public function update(UsuarioRequest $request, $id) {
        
        $data = User::findOrFail($id);
        //dd($data);
        $data->update($request->validated());
        
        return redirect('usuario')->with('status', 'usuario actualizado exitosamente!');
    }

    public function delete (Request $request, $id){

        $data = User::findOrFail($id);
        $data -> delete();

        return redirect('usuario')->with('status', 'Estudiante eliminado exitosamente!');
    }


}
