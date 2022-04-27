<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Formalization;
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

            if($request->checkAceptacion == 'false' && $request->checkTablet == 'false'){

                return 1;

            }else{
                if($request->checkAceptacion == 'true') {
                    if($request->acceptance_v1 != null){
                        $data->acceptance_v1 = $request['acceptance_v1'];
                        if($request->acceptance_v2 != null){
                            $data->acceptance_v2 = $request['acceptance_v2'];
                        }else{
                            $data->acceptance_v2 = 'SI';
                        }      
                    }else{
                        $data->acceptance_v1 = 'SI';
                        if($request->acceptance_v2 != null){
                            $data->acceptance_v2 = $request['acceptance_v2'];
                        }else{
                            $data->acceptance_v2 = 'SI';
                        }
                    }
                }

                if($request->checkTablet == 'true') {
                    if($request->tablets_v1 != null){
                        $data->tablets_v1 = $request['tablets_v1'];
                        if($request->tablets_v2 != null){
                            $data->tablets_v2 = $request['tablets_v2'];
                        }else{
                            $data->tablets_v2 = 'SI';
                        }      
                    }else{
                        $data->tablets_v1 = 'SI';
                        if($request->tablets_v2 != null){
                            $data->tablets_v2 = $request['tablets_v2'];
                            
                        }else{
                            $data->tablets_v2 = 'SI';
                        }
                    }

                    $data->serial_tablet = $request['serial_tablet'];
                }


                
            }

            $data->save();

            return 2;
            

              
            
        };
        
         
    }
}
