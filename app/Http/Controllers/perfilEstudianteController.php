<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\perfilEstudiante;
use App\LogosDeleteUsers;
use App\User;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Controllers\Auth;


class perfilEstudianteController extends Controller

{

    /*public function __construct()
    {
        $this->middleware('auth');
        
    }*/

    public function indexPerfilEstudiante(){
        
        $perfilEstudiantes = perfilEstudiante::orderBy('created_at', 'desc')->paginate(5);
        //dd($perfilEstudiante);
        return view('perfilEstudiante.index',compact('perfilEstudiantes'));
    }


    public function crearPerfilEstudiante(){
        
        return view("perfilEstudiante.create", ['editarEstudiante' => new perfilEstudiante()]);
    }

    public function storePerfilEstudiante(perfilEstudianteRequest $request){

        $idPerfilEstudiantes = perfilEstudiante::create([
            'nombres'                  =>  $request['nombres'],
            'apellidos'                =>  $request['apellidos'],
            'tipo_documento'           =>  $request['tipo_documento'],
            'numero_documento'         =>  $request['numero_documento'],
            'fecha_nacimiento'         =>  $request['fecha_nacimiento'],
            'departamento_nacimiento'  =>  $request['departamento_nacimiento'],
            'ciudad_nacimiento'        =>  $request['ciudad_nacimiento'],
            'sexo'                     =>  $request['sexo'],
            'genero'                   =>  $request['genero'],
            'departamento_residencia'  =>  $request['departamento_residencia'],
            'ciudad_residencia'        =>  $request['ciudad_residencia'],
            'barrio_residencia'        =>  $request['barrio_residencia'],
            'direccion'                =>  $request['direccion'],
            'email'                    =>  $request['email'],
            'telefono1'                =>  $request['telefono1'],
            'telefono2'                =>  $request['telefono2'],
        ]);
        
         return redirect('indexPerfilEstudiante')->with('status', 'Perfil guardado exitosamente!');
         
      }

    public function verPerfilEstudiante($id){

        $verDatosPerfil = perfilEstudiante::findOrFail($id);
        //dd($verDatosPerfil);
        return view('perfilEstudiante.verDatos', compact('verDatosPerfil'));   
    }

    public function editarPerfilEstudiante($id){
        
        $editarEstudiante = perfilEstudiante::findOrFail($id);
        
        //dd($editarEstudiante->sexo);
        return view('perfilEstudiante.editar', compact('editarEstudiante'));
    }

    public function updatePerfilEstudiante(perfilEstudianteRequest $request, $id) {
        
        $data = perfilEstudiante::findOrFail($id);
        
        $data->update($request->validated());



        return redirect('indexPerfilEstudiante')->with('status', 'Perfil actualizado exitosamente!');
    }


    public function eliminarPerfilEstudiante(Request $request, $id){

       $data = perfilEstudiante::findOrFail($id);
       
       dd($data);
       //$data ->delete();
       $id = auth()->user();
       //$est = perfilEstudiante::all();
       //dd($est);
       foreach ($est as $dat) {
            $datos = LogosDeleteUsers::create([
            'id'                    => $id['id'],
            'name'                  => $id['name'],
            'email'                 => $id['emmail'],
            'rol'                   => $dat->apellidos,
            'ip'                    => $dat->numero_documento,
            'id_user_delete'        => $dat->id,
            'name_user_delete'      => $dat->nombres,
            'email_user_delete'     => $dat->email,
            'actividad'             => 'DELETE'
            ]); 
       }
      

        return redirect('indexPerfilEstudiante')->with('status', 'Perfil eliminado exitosamente!');
    }

}
















