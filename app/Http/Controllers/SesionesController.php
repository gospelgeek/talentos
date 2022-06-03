<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\SesionesRequest;
use App\LogsCrudActions;
use App\Exports\ReporteSesionesLineasExport;
use App\Cohort;
use App\Session;
use App\Group;
use App\Course;
use App\UpdateInformation;
use App\User;
use Redirect;
use DB;
use Excel;
use Response;

class SesionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function datos(Request $request){
              
       
            
        $sesiones = Session::where('id_group', $request->id_grupo)->where('id_course', $request->id_curso)->with('sesionGroup.cohort', 'sesionCourse')->get();


             return datatables()->of($sesiones)->toJson();
    }
    

    public function index(){
        
        $cohorte = Cohort::pluck('name', 'id');
        $grupos = Group::pluck('name', 'id');
        $asignaturas = Course::pluck('name', 'id');

        return view('sesiones.index', compact('cohorte', 'grupos', 'asignaturas'));
    }

    public function traerGrupos(Request $request, $id) {

        $grupos = Group::where('id_cohort', $id)->get();
        
        if($request->ajax()) {

            return response()->json($grupos);
        }
    
    }

    public function grupos_filter(Request $request, $id) {
        $grupos = Group::where('id_cohort', $id)->get();
        
        if($request->ajax()) {

            return response()->json($grupos);
        }

    }

    public function traerAsignaturas(Request $request, $id){
        $asignaturas = Course::where('id_cohort', $id)->get();
        
        if ($request->ajax()) {

            return response()->json($asignaturas);
        }
    }

    public function asignaturas_filter(Request $request, $id) {

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
    
    public function exportar_excel_linea(){
        $linea1 = DB::select("select sessions.id_group, sessions.id_course, sessions.date_session, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group BETWEEN 1 AND 40
            AND MONTH(sessions.date_session) = 05
        ");

        $linea1_colection = collect($linea1);
        $excel = array();

        foreach($linea1_colection as $colection_linea1){

            $excel[] = array('grupo' => $colection_linea1->grupo, 'fecha' => $colection_linea1->date_session, 'asignatura' => $colection_linea1->asignatura);
        }

        $exportar = new ReporteSesionesLineasExport([$excel]);


        return Excel::download($exportar, 'sesiones_linea_1.xlsx');

    }
}
