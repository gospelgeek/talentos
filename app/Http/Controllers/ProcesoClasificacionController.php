<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Programs;
use App\ProgramOptions;
use App\ResultByArea;
use App\StudentGroup;
use App\CourseMoodle;
use App\CourseItems;
use App\perfilEstudiante;
use App\Rating;
use DB;
use App\Http\Controllers\Auth;
use Session;

class ProcesoClasificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index_vista(){
        $datos = Rating::clasificados();
        $datos_no = Rating::no_clasificados();
        //dd($datos, $datos_no);
        $si = count($datos);
        $no = count($datos_no);
        //dd($si, $no);
        return view('administrativo.procesoClasificacion.index', compact('si', 'no'));
    }

    public function datos_clasificados(){
        $datos = Rating::clasificados();

        return datatables()->of($datos)->toJson();
    }
    public function datos_no_clasificados(){        
        $datos = Rating::no_clasificados();
        //$datos = Rating::activoslinea1();
        
        return datatables()->of($datos)->toJson();
    }
    
    public function datos_resumen(){
        $datos = Programs::all();
        //dd($datos);
        return datatables()->of($datos)->toJson();    
    }

    public function detalles_programas(Request $request){
        //dd($request['semestre']);
        $data = Rating::detalle_programa($request['id_programa'], $request['semestre']);
        
        return datatables()->of($data)->toJson();
    }

    public function index(Request $request){

        $Programas_EstudiantesAdmitidos_semestre = array();

        $programs = Programs::select('id','quotas_I_2023','remaining_quotas_I_2023','quotas_II_2023','remaining_quotas_II_2023','iteration_group')->get();
        
        $semestre = 2;
        for ($i=1; $i <= 5; $i++) {

            foreach($programs as $program){
                switch ($semestre) {
                    case 1:
                        if($program->quotas_I_2023 > 0 && $program->remaining_quotas_I_2023 > 0){

                            $cupos = $program->remaining_quotas_I_2023;

                            $elegidos = $this->iteracion_carreras($program->id,$i,$cupos,"I-2023");
                            //dd($elegidos);
                            if(count($elegidos) > 0){

                                foreach($elegidos as $student){

                                    ProgramOptions::where('id_estudiante',$student['id_student'])->delete();   
                                }

                                $cupos_restantes = $program->remaining_quotas_I_2023 - count($elegidos);
                                //dd($cupos_restantes);
                                $program->remaining_quotas_I_2023 = $cupos_restantes;

                                Programs::Where('id',$program->id)->update(['remaining_quotas_I_2023' => $cupos_restantes]);

                                array_push($Programas_EstudiantesAdmitidos_semestre, array("iteracion" => $i,"id_program" => $program->id,"seleccionados"=>$elegidos));
                            }
                        }

                        break;
                    case 2:
                        if($program->quotas_II_2023 > 0 && $program->remaining_quotas_II_2023 > 0){

                            $cupos = $program->remaining_quotas_II_2023;

                            $elegidos = $this->iteracion_carreras($program->id,$i,$cupos,"II-2023");
                            //dump($elegidos);
                            if(count($elegidos) > 0){

                                foreach($elegidos as $student){

                                    ProgramOptions::where('id_estudiante',$student['id_student'])->delete();   
                                }

                                $cupos_restantes = $program->remaining_quotas_II_2023 - count($elegidos);
                                //dd($cupos_restantes);
                                $program->remaining_quotas_II_2023 = $cupos_restantes;

                                Programs::Where('id',$program->id)->update(['remaining_quotas_II_2023' => $cupos_restantes]);

                                array_push($Programas_EstudiantesAdmitidos_semestre, array("iteracion" => $i,"id_program" => $program->id,"seleccionados"=>$elegidos));
                            }
                        }
                        break;
                    default:
                        // code...
                        break;
                }
                
            }        
        }

        $programs_options = ProgramOptions::all();
        foreach($programs_options as $data){
            if($data->semestre_ingreso == 'I-2023'){
                ProgramOptions::where('id', $data->id)->update(['semestre_ingreso' => 'II-2023']);
            }
        }
        if(count($Programas_EstudiantesAdmitidos_semestre) > 0){

            foreach($Programas_EstudiantesAdmitidos_semestre as $value) {

                foreach($value['seleccionados'] as $key => $selec){

                    $data = Rating::create([
                        'id_student'            => $selec['id_student'],
                        'id_definitive_program' => $value['id_program'],
                        'weighted_total'        => $selec['total_ponderado'],
                        'weighted_areas'        => $selec['ponderado_areas'],
                        'average_grades'        => $selec['promedio_nota'],
                        'position'              => $key + 1,
                        'iteration'             => $value['iteracion'],  
                    ]);    
                }              
            } 
        }

        return back()->with('status', 'Script ejecutado correctamente!');  
    }

    public function iteracion_carreras($carrera,$iteracion,$cupos,$semestre){
        $estudiantes_seleccionados = array();
        switch ($iteracion) {
            case 1:
                $programs_options = ProgramOptions::select('id_estudiante','nota_ponderada1')->where('id_programa1', $carrera)->where('semestre_ingreso',$semestre)->orderBy('nota_ponderada1','DESC')->get();
                
                if(count($programs_options) > 0 && $cupos < count($programs_options)){
                    //dd("entr");
                    for ($i=0; $i < $cupos;){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada1;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada1'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada1'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate);

                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada1, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    }                   
                }
                else{

                    for ($i=0; $i < count($programs_options);){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada1;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada1'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada1'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada1, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    } 
                }
                break;
            case 2:
                $programs_options = ProgramOptions::select('id_estudiante','nota_ponderada2')->where('id_programa2', $carrera)->where('semestre_ingreso',$semestre)->orderBy('nota_ponderada2','DESC')->get();
                
                if(count($programs_options) > 0 && $cupos < count($programs_options)){
                    //dd("entr");
                    for ($i=0; $i < $cupos;){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada2;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada2'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada2'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada2, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    }                   
                }
                else{

                    for ($i=0; $i < count($programs_options);){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada2;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada2'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada2'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada2, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    } 
                }
                break;
            case 3:
                $programs_options = ProgramOptions::select('id_estudiante','nota_ponderada3')->where('id_programa3', $carrera)->where('semestre_ingreso',$semestre)->orderBy('nota_ponderada3','DESC')->get();
                
                if(count($programs_options) > 0 && $cupos < count($programs_options)){
                    //dd("entr");
                    for ($i=0; $i < $cupos;){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada3;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada3'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada3'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada3, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    }                   
                }
                else{

                    for ($i=0; $i < count($programs_options);){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada3;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada3'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada3'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada3, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    } 
                }
                break;
            case 4:
                $programs_options = ProgramOptions::select('id_estudiante','nota_ponderada4')->where('id_programa4', $carrera)->where('semestre_ingreso',$semestre)->orderBy('nota_ponderada4','DESC')->get();
                
                if(count($programs_options) > 0 && $cupos < count($programs_options)){
                    //dd("entr");
                    for ($i=0; $i < $cupos;){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada4;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada4'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada4'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada4, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    }                   
                }
                else{

                    for ($i=0; $i < count($programs_options);){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada4;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada4'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada4'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada4, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    } 
                }
                break;
            case 5:
                $programs_options = ProgramOptions::select('id_estudiante','nota_ponderada5')->where('id_programa5', $carrera)->where('semestre_ingreso',$semestre)->orderBy('nota_ponderada5','DESC')->get();
                
                if(count($programs_options) > 0 && $cupos < count($programs_options)){
                    //dd("entr");
                    for ($i=0; $i < $cupos;){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada5;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada5'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada5'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada5, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    }                   
                }
                else{

                    for ($i=0; $i < count($programs_options);){ 

                        $this->estudiante = $programs_options[$i]->nota_ponderada5;

                        $estudiantes_empate = array_filter($programs_options->toArray(),function($v, $k) {
                                            //if($k >=  $this->ultima_pos_estudiantes_seleccionados){
                                                return $v['nota_ponderada5'] == $this->estudiante;
                                            //}                                            
                                        }, ARRAY_FILTER_USE_BOTH);

                        if(count($estudiantes_empate) > 1){

                            $desempate = array();

                            foreach ($estudiantes_empate as $key => $estudiante) {
                                    //dd($estudiante);

                                $program         = Programs::Where('id',$carrera)->first();

                                $lectura_critica    = ResultByArea::where('id_icfes_area', 1)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $matematicas        = ResultByArea::where('id_icfes_area', 2)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $sociales           = ResultByArea::where('id_icfes_area', 3)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $naturales          = ResultByArea::where('id_icfes_area', 4)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $ingles             = ResultByArea::where('id_icfes_area', 5)->where('id_student',$estudiante['id_estudiante'])->first('qualification');

                                $prueba_especifica  = 100 * (($program ? $program->weighting_test_specific : 0)/100);

                                    

                                $total_ponderado_areas = (($lectura_critica ? $lectura_critica->qualification : 0) * (($program ? $program->critical_reading_weight : 0)/100))
                                                      +(($matematicas ? $matematicas->qualification : 0) * (($program ? $program->weighting_mathematics : 0)/100))
                                                      +(($sociales ? $sociales->qualification : 0) * (($program ? $program->weighting_social : 0)/100))
                                                      +(($naturales ? $naturales->qualification : 0) * (($program ? $program->weighting_natural : 0)/100))
                                                      +(($ingles ? $ingles->qualification : 0) * (($program ? $program->weighting_english : 0)/100))
                                                      +$prueba_especifica;

                                $desempate[$key] = array("id_student" => $estudiante['id_estudiante'],"total_ponderado" => $estudiante['nota_ponderada5'], "ponderado_areas" => $total_ponderado_areas, 'promedio_nota' => null);                  
                            }

                            $colum_ponderado_areas  = array_column($desempate, 'ponderado_areas');

                            array_multisort($colum_ponderado_areas, SORT_DESC, $desempate);
                                
                            $this->desempate = $desempate[0]['ponderado_areas'];

                            $empate_ponderacion = array_filter($desempate,function($v, $k) {
                                                    return $v['ponderado_areas'] == $this->desempate;
                                                }, ARRAY_FILTER_USE_BOTH);
                            //dd($empate_ponderacion);
                            if(count($empate_ponderacion) > 1){

                                $promedios_empate = array();

                                foreach($empate_ponderacion as $key => $ponde){

                                    $grupo_id = StudentGroup::select('id_group')->where('id_student', $ponde['id_student'])->first();

                                    $student = perfilEstudiante::select('id_moodle')->where('id',$ponde['id_student'])->first();
                                        
                                    $promedio_nota = DB::select("
                                                                select SUM(students_grades.grade) / COUNT(students_grades.grade) as promedio 
                                                                FROM course_moodles
                                                                INNER JOIN course_items ON course_items.course_id = course_moodles.course_id
                                                                INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                                                                WHERE course_moodles.group_id = '".$grupo_id->id_group."'
                                                                AND course_items.category_name = 'TOTAL CURSO'
                                                                AND students_grades.id_moodle = '".$student->id_moodle."'");
                                         
                                    $promedios_empate[$key] = array('id_student' => $ponde['id_student'],'total_ponderado' => $ponde['total_ponderado'],'ponderado_areas' => $ponde['ponderado_areas'],'promedio_nota' => $promedio_nota[0]->promedio);
                                }

                                $colum_prom_notas = array_column($promedios_empate, 'promedio_nota');

                                array_multisort($colum_prom_notas, SORT_DESC, $promedios_empate);

                                foreach($promedios_empate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$promedios_empate[$key]);
                                }

                                $i += count($promedios_empate);
                            }
                            else{

                                foreach($desempate as $key => $insertar){
                                    array_push($estudiantes_seleccionados,$desempate[$key]);
                                }
                                $i += count($desempate); 
                            }
                        }else{
                            
                            array_push($estudiantes_seleccionados,array("id_student" => $programs_options[$i]->id_estudiante, "total_ponderado" => $programs_options[$i]->nota_ponderada5, 'ponderado_areas' => null, "promedio_nota" => null));
                            $i++;
                        }
                    } 
                }
                break;
            default:
                // code...
                break;
        }
        
        if(count($estudiantes_seleccionados) > $cupos){
            array_splice($estudiantes_seleccionados,$cupos);
        }

        return $estudiantes_seleccionados;     
    }
}
