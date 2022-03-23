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
        $datosFormalizacion = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,student_profile.document_number,
        (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
        (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort) as cohorte,
        formalizations.id_student,formalizations.acceptance_v1, formalizations.acceptance_v2, formalizations.tablets_v1, formalizations.tablets_v2
        FROM student_profile, formalizations, groups, student_groups
        WHERE student_profile.id = student_groups.id_student
        AND student_groups.id_group = groups.id
        AND student_profile.id = formalizations.id_student");

        return datatables()->of($datosFormalizacion)->toJson();
    }

    public function index(){
        /*$datosFormalizacion = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,student_profile.document_number,
        (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
        (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort) as cohorte,
        formalizations.id_student,formalizations.acceptance_v1, formalizations.acceptance_v2, formalizations.tablets_v1, formalizations.tablets_v2
        FROM student_profile, formalizations, groups, student_groups
        WHERE student_profile.id = student_groups.id_student
        AND student_groups.id_group = groups.id
        AND student_profile.id = formalizations.id_student");       
        return datatables()->of($datosFormalizacion)->toJson();*/

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
                }

                
            }

            $data->save();

            return 2;
            

              
            
        };
        
         
    }
}
