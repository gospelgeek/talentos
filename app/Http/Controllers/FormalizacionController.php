<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Formalization;
use App\perfilEstudiante;
use App\EconomicalSupport;
use App\Group;
use App\Cohort;
use App\StudentGroup;
use Session;
use Redirect;
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

        return view('perfilEstudiante.indexFormalizacion');
    }
    
    public function formalizacionupdate($id, Request $request){

       
    $data = Formalization::findOrFail($id);
        
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

            $ver = EconomicalSupport::where('id_student', $request['id'])->exists();

            if($ver == true){
                $economico_id = EconomicalSupport::select('id')->where('id_student', $request['id'])->first();
                $data_apoyo = EconomicalSupport::findOrfail($economico_id->id);
                $data_apoyo->date = $request['fecha_apoyo'];
                $data_apoyo->url_banco = $request['banco_url'];
                $data_apoyo->monto = $request['monto'];
                    
                $data_apoyo->save();
            }else if($ver == false){
                    
                $apoyo_economico = EconomicalSupport::create([
                    'id_student'    => $request['id'],
                    'date'          => $request['fecha_apoyo'],
                    'url_banco'     => $request['banco_url'],
                    'monto'         => $request['monto'],
                ]);
            }
        };

        $data->save();
            
        return 2;     
    }
}
