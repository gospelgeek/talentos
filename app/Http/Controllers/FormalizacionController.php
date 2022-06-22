<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Auth;
use App\Formalization;
use App\perfilEstudiante;
use App\EconomicalSupport;
use App\Group;
use App\Cohort;
use App\StudentGroup;
use App\UpdateInformation;
use App\LogsCrudActions;
use App\User;
use Session;
use Redirect;
use Response;
use DB;

class FormalizacionController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function formalizacionDatos(){
        
        $datosFormalizacion = Formalization::formalizacion();

        return datatables()->of($datosFormalizacion)->toJson();
    }

    public function index(){
        $update_frmlzcon = Formalization::ultimo_update_formalizacion();
        if($update_frmlzcon != null){
            $update_formalizacion = $update_frmlzcon[0]->created_at;
        }else{
            $update_formalizacion = null;
        }

        return view('perfilEstudiante.indexFormalizacion', compact('update_formalizacion'));
    }
    
    public function formalizacionupdate($id, Request $request){
  
    $data = Formalization::findOrFail($id);
    $dataOld = Formalization::findOrFail($id);
        
        if ($request->ajax()) {

            if($request->checkAceptacion == 'true') {
                    
                if($request->acceptance_v2 != null){
                    $data->acceptance_v2 = $request['acceptance_v2'];
                }else{
                    $data->acceptance_v2 = 'SI';
                }      
            }

            if($request->checkTablet == 'true') {
                    
                if($request->tablets_v2 != null){
                    $data->tablets_v2 = $request['tablets_v2'];
                }else{
                    $data->tablets_v2 = 'SI';
                }      
            }
            $data->acceptance_v2 = $request['acceptance_v2'];
            $data->tablets_v2 = $request['tablets_v2'];
            $data->serial_tablet = $request['serial_tablet'];
            $data->kit_date = $request['date_kit'];
            $data->observations = $request['observaciones'];
                
            $pre_registro;
            if($request['pre_registro_icfes'] !== null){
                $pre_registro = true;
                $data->pre_registration_icfes = $pre_registro; 
            }else if($request['pre_registro_icfes'] == null) {
                $pre_registro = false;
                $data->pre_registration_icfes = $pre_registro;
            }

            $inscripcion_icfes;
            if($request['inscripcion_icfes'] !== null){
                $inscripcion_icfes = true;
                $data->inscription_icfes = $inscripcion_icfes;
            }else if($request['inscripcion_icfes'] == null){
                $inscripcion_icfes = false;
                $data->inscription_icfes = $inscripcion_icfes;
            }

            $presento_icfes;
            if($request['presento_icfes'] !== null){
                $presento_icfes = true;
                $data->presented_icfes = $presento_icfes;
            }else if($request['presento_icfes'] == null){
                $presento_icfes = false;
                $data->presented_icfes = $presento_icfes;
            }

           /*$apoyo_economico = EconomicalSupport::create([
                'id_student'    => $request['id'],
                'date'          => $request['fecha_apoyo'],
                'url_banco'     => $request['banco_url'],
                'monto'         => $request['monto'],
            ]);

            
            
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $apoyo_economico['id'],
                'actividad_realizada'      => 'NUEVO REGISTRO DE APOYO ECONOMICO',
            ]);*/
            
        };

        $data->save();

        $old = array();
        $new = array();

        if($dataOld->acceptance_v2 != $data->acceptance_v2){
            $old[] = array('aceptacion' => $dataOld->acceptance_v2);
            $new[] = array('aceptacion' => $data->acceptance_v2);
        }
        if($dataOld->tablets_v2 != $data->tablets_v2){
            $old[] = array('tablets' => $dataOld->tablets_v2);
            $new[] = array('tablets' => $data->tablets_v2);
        }
        if($dataOld->serial_tablet != $data->serial_tablet){
            $old[] = array('serial tablet' => $dataOld->serial_tablet);
            $new[] = array('serial tablet' => $data->serial_tablet);
        }
        if($dataOld->kit_date != $data->kit_date){
            $old[] = array('fecha kit' => $dataOld->kit_date);
            $new[] = array('fecha kit' => $data->kit_date);
        }
        if($dataOld->pre_registration_icfes != $data->pre_registration_icfes){
            $old[] = array('pre_registro' => $dataOld->pre_registration_icfes);
            $new[] = array('pre_registro' => $data->pre_registration_icfes);
        }
        if($dataOld->inscription_icfes != $data->inscription_icfes){
            $old[] = array('inscription' => $dataOld->inscription_icfes);
            $new[] = array('inscription' => $data->inscription_icfes);
        }
        if($dataOld->presented_icfes != $data->presented_icfes){
            $old[] = array('presentó icfes' => $dataOld->presented_icfes);
            $new[] = array('presentó icfes' => $data->presented_icfes);
        }
        if($dataOld->observations != $data->observations){
            $old[] = array('observaciones' => $dataOld->observations);
            $new[] = array('observaciones' => $data->observations);
        }
        $ip = User::getRealIP();
        $id = auth()->user();

        if($old != null && $new != null){

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data['id'],
                'actividad_realizada'      => 'FORMALIZACION ACTUALIZADA',
            ]);
            
            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);
        }        

        return 2;     
    }
    
    public function apoyo_economico_editar($id, Request $request){

        $apoyos = EconomicalSupport::findOrFail($id);

        if ($request->ajax()) {
            return Response::json($apoyos);
        };
    }

    public function apoyo_economico_update($id, Request $request){

        $data = EconomicalSupport::findOrFail($id);
        $dataOld = EconomicalSupport::findOrFail($id);

        if($request->ajax()){
            $data->date      = $request['date'];
            $data->url_banco = $request['url_banco'];
            $data->monto     = $request['monto'];

            $data->save();

            $old = array();
            $new = array();

            if($dataOld->date != $data->date){
                $old[] = array('fecha apoyo' => $dataOld->date);
                $new[] = array('fecha apoyo' => $data->date);
            }
            if($dataOld->url_banco != $data->url_banco){
                $old[] = array('banco' => $dataOld->url_banco);
                $new[] = array('banco' => $data->url_banco);
            }
            if($dataOld->monto != $data->monto){
                $old[] = array('monto' => $dataOld->monto);
                $new[] = array('monto' => $data->monto);
            }

            if($old != null && $new != null){

                $ip = User::getRealIP();
                $id = auth()->user();
            
                $datos = LogsCrudActions::create([
                    'id_user'                  => $id['id'],
                    'rol'                      => $id['rol_id'],
                    'ip'                       => $ip,
                    'id_usuario_accion'        => $data['id'],
                    'actividad_realizada'      => 'SE ACTUALIZO REGISTRO DE APOYO ECONOMICO',
                ]);

                $guardarOld = json_encode($old);
                $guardarNew = json_encode($new);

                $update = UpdateInformation::create([
                    'id_log'              => $datos['id'],
                    'changed_information' => $guardarOld,
                    'new_information'     => $guardarNew,
                ]);
            }

        }

        return 1;
    }

    public function apoyo_economico_delete($id, Request $request){
        
        $data = EconomicalSupport::findOrFail($id);
        $mensaje = 'Apoyo economico eliminado correctamente';
        if ($request->ajax()) {
            
            $ip = User::getRealIP();
            $id = auth()->user();

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data['id'],
                'actividad_realizada'      => 'APOYO ECONOMICO ELIMINADO',
            ]);

            $data->delete();    
        }
        
        return $mensaje;   
    }
}
