<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\SesionesRequest;
use App\LogsCrudActions;
use App\Cohort;
use App\Session;
use App\Group;
use App\Course;
use App\UpdateInformation;
use App\User;
use Redirect;
use DB;
use Response;

class SesionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function datos(){

        $session = Session::all();

        $session->map(function ($datos) {
            $datos->cohorte = $this->name_cohorte($datos->id_group);
            $datos->grupo = $this->name_grupo($datos->id_group);
            $datos->course = $this->name_course($datos->id_course);
            $datos->idcohorte = $this->id_cohorte($datos->id_group);
        });

        return datatables()->of($session)->toJson();
    }

    public function name_cohorte($id_group){
        
        $name_grupo = Group::where('id', $id_group)->select('id_cohort')->first();
        $id_cohort = $name_grupo->id_cohort; 
        
        $name_cohorte = Cohort::where('id', $id_cohort)->select('name')->first();

        return $name_cohorte->name;
    }

    public function name_grupo($id_group) {
        $name_grupo = Group::where('id', $id_group)->select('name')->first();
        
        return $name_grupo->name;
    }


    public function index(){
        
        $cohorte = Cohort::pluck('name', 'id');
        $grupos = Group::pluck('name', 'id');
        $asignaturas = Course::pluck('name', 'id');

        return view('sesiones.index', compact('cohorte', 'grupos', 'asignaturas'));
    }

    public function name_course($id_course) {
        $name_course = Course::where('id', $id_course)->select('name')->first();

        return $name_course->name;
    }

    public function id_cohorte($id_group){
        $name_grupo = Group::where('id', $id_group)->select('id_cohort')->first();
        $id_cohort = $name_grupo->id_cohort; 
        
        $name_cohorte = Cohort::where('id', $id_cohort)->select('id')->first();

        return $name_cohorte->id;
    }

    public function traerGrupos(Request $request, $id) {

        $grupos = Group::where('id_cohort', $id)->get();
        //return $grupos;
        if ($request->ajax()) {

            return response()->json($grupos);
        }
    
    }

    public function traerAsignaturas(Request $request, $id){
        $asignaturas = Course::where('id_cohort', $id)->get();
        
        if ($request->ajax()) {

            return response()->json($asignaturas);
        }
    }

    public function store(SesionesRequest $request){

        //dd($request['cohorte']);

        $mensaje = 'Sesion creada corectamente!!';

        if($request->ajax())
        {
            $sesion = Session::create([
                'id_group'     => $request['id_group'],
                'id_course'    => $request['id_course'],            
                'date_session' => $request['date_session'],
            ]);


            $ip = User::getRealIP();
            $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $sesion['id'],
                'actividad_realizada'      => 'SE PROGRAMÓ UNA SESIÓN',
            ]);
        }
        return $mensaje;
    }

    public function edit($id,Request $request){

        $sesiones = Session::findOrFail($id); 
        //dd($sesiones->date_session);


        $datos = array('id'=> $sesiones->id, 'name_linea' => $sesiones->sesionGroup->cohort->id, 'name_grupo' => $sesiones->sesionGroup->id, 'name_curso' => $sesiones->sesionCourse->id, 'fecha' => $sesiones->date_session);

        $mostrar = collect($datos);

        if($request->ajax()){
            return Response::json($mostrar); 
        };
    }

    public function update($id, Request $request){

        $sesion = Session::findOrFail($id);
        $sesionOld = Session::findOrFail($id);

        $mensaje = "Registro de sesion actualizado correctamente!!";

        if ($request->ajax()) {

            $sesion->id_group      = $request['id_group'];
            $sesion->id_course     = $request['id_course'];
            $sesion->date_session  = $request['date_session'];

            $sesion->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $sesion['id'],
                'actividad_realizada'      => 'SE ACTUALIZO REGISTRO DE UNA SESIÓN',
            ]);

            $old = array();
            $new = array();

            if($sesionOld->id_group != $sesion->id_group){
                $old[] = array('id_group' => $sesionOld->id_group);
                $new[] = array('id_group' => $sesion->id_group);
            }
            if($sesionOld->id_course != $sesion->id_course){
                $old[] = array('id_course' => $sesionOld->id_course);
                $new[] = array('id_course' => $sesion->id_course);
            }
            if($sesionOld->date_session != $sesion->date_session){
                $old[] = array('fecha_sesion' => $sesionOld->date_session);
                $new[] = array('fecha_sesion' => $sesion->date_session);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);
        }

        return $mensaje;
    }

    public function delete($id, Request $request){

        $data = Session::findOrFail($id);
        $mensaje = 'Registro de sesion eliminado correctamente';
        if ($request->ajax()) {
            
            $data->delete();
            
        }

        $ip = User::getRealIP();
        $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'                 => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data['id'],
                'actividad_realizada'      => 'SE ELIMINÓ UNA SESIÓN',
            ]);
        return $mensaje;
    }
}
