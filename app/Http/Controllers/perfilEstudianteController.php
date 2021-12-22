<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\perfilEstudiante;
use App\SocioeconomicData;
use App\RecordsActionsUpdateDelete;
use App\User;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Controllers\Auth;


class perfilEstudianteController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function indexPerfilEstudiante(){
        
        $perfilEstudiantes = perfilEstudiante::all();
        //dd($perfilEstudiantes);
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
        
         return redirect('estudiante')->with('status', 'Perfil guardado exitosamente!');
         
      }

    public function verPerfilEstudiante($id){

        $verDatosPerfil = perfilEstudiante::findOrFail($id);
        //dd($verDatosPerfil);
        return view('perfilEstudiante.verDatos', compact('verDatosPerfil'));   
    }

    public function verDatosSocieconomicos($id) {
        //dd($id_student);
        //$datos = SocioeconomicData::all()->where('id_student', $id_student); 
        $datos = perfilEstudiante::findOrFail($id);
        //dd($datos);

        return view('perfilEstudiante.datosSocioeconomicos', compact('datos'));
    }

    public function verDatosAcademicos($id){
        $datos = perfilEstudiante::findOrFail($id);

        return view('perfilEstudiante.datosAcademicos', compact('datos'));
    }

    public function editarPerfilEstudiante($id){
        
        $editarEstudiante = perfilEstudiante::findOrFail($id);
        //dd($editarEstudiante->gender);
        
        return view('perfilEstudiante.editar', compact('editarEstudiante'));
    }

    public function updatePerfilEstudiante(perfilEstudianteRequest $request, $id) {
        
        $data = perfilEstudiante::findOrFail($id);
        
        $data->update($request->validated());
    
        return redirect('estudiante')->with('status', 'Perfil actualizado exitosamente!');
    }


    public function eliminarPerfilEstudiante(Request $request, $id){

       
       //dd('hola');
       $data = perfilEstudiante::findOrFail($id);

       $ip = User::getRealIP();
       $data -> delete();
       $id = auth()->user();
       //dd($id);
            $datos = RecordsActionsUpdateDelete::create([
            'identificacion'           => $id['cedula'],
            'nombres'                  => $id['name'],
            'apellidos'                => $id['apellidos_user'],
            'email'                    => $id['email'],
            'rol'                      => $id['rol_id'],   
            'ip'                       => $ip,
            'id_usuario_accion'        => $data['id'],
            'nombres_usuario_accion'   => $data['nombres'],
            'apellidos_usuario_accion' => $data['apellidos'],
            'email_usuario_accion'     => $data['email'],
            'actividad_realizada'      => 'SE ELIMINO UN REGISTRO',
            ]); 

        return redirect('estudiante')->with('status', 'Perfil eliminado exitosamente!');
    }

}
















