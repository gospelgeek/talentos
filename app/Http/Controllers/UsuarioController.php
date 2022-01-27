<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UsuarioRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\perfilEstudiante;
use App\SocioeconomicData;
use App\PreviousAcademicData;
use App\LogsCrudActions;
use App\Gender;
use App\DocumentType;
use App\BirthDepartament;
use App\BirthCity;
use App\Occupation;
use App\CivilStatus;
use App\RecidenceTime;
use App\HousingType;
use App\HealthRegime;
use App\Benefits;
use App\SocialConditions;
use App\Disability;
use App\Ethnicity;
use App\InstitutionType;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Requests\DatosSocioeconomicosRequest;
use App\Http\Requests\DatosAcademicosRequest;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
Use Session;
Use Redirect;
use DB;

class UsuarioController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('sistemas');
        
    }
 
    public function index(){

        $usuario = User::all();

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
