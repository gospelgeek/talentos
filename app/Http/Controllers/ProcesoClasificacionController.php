<?php

namespace App\Http\Controllers;

use DB;

use Session;
use App\Rating;
use App\Rating2;
use App\Programs;
use App\CourseItems;
use App\CourseMoodle;
use App\IcfesStudent;
use App\ResultByArea;
use App\StudentGroup;
use App\ProgramOptions;
use App\ProgramOptions2;
use App\perfilEstudiante;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ProcesoClasificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index_vista(){
        $si = count(Rating::clasificados());
        $no_icfes_si = count(Rating::no_clasificados_icfes_si());
        $pendientes = count(Rating::pendientes_2023_2());
        $no_icfes_no = count(Rating::no_clasificados_icfes_no());
        
        //dd($si, $no);
        return view('administrativo.procesoClasificacion.index', compact('si','no_icfes_si', 'no_icfes_no', 'pendientes'));
    }

    public function index_vista2(){
        $si = count(Rating2::clasificados());
        $no = count(Rating2::no_clasificados());
        /*$pendientes = count(Rating2::pendientes_2023_2());
        $no_icfes_no = count(Rating2::no_clasificados_icfes_no());*/
        
        //dd($si, $no);
        return view('administrativo.procesoClasificacion2.index', compact('si','no'));
    }

    public function datos_clasificados(){
        $datos = collect(Rating::clasificados());
        //dd($datos);
        $datos->map(function ($data) {
            //dd($data);
            $validate = IcfesStudent::select('id_student')->where('id_student', $data->id)->exists();
            if($validate){
                $icfes = IcfesStudent::select('total_score')->where('id_student', $data->id)->where('id_icfes_test', 5)->first();
                //dd($icfes);
                $data->icfes = $icfes->total_score;
            }else{
                $data->icfes = '--';
            }
        });
        //dd($datos);
        return datatables()->of($datos)->toJson();
    }

    public function datos_clasificados2(){
        $datos = collect(Rating2::clasificados());
        //dd($datos);
        $datos->map(function ($data) {
            //dd($data);
            $validate = IcfesStudent::select('id_student')->where('id_student', $data->id)->exists();
            if($validate){
                $icfes = IcfesStudent::select('total_score')->where('id_student', $data->id)->where('id_icfes_test', 5)->first();
                //dd($icfes);
                $data->icfes = $icfes->total_score;
            }else{
                $data->icfes = '--';
            }
        });
        //dd($datos);
        return datatables()->of($datos)->toJson();
    }

    public function datos_no_clasificados2(){        
        $datos = collect(Rating2::no_clasificados());

        $datos->map(function ($data) {
            //dd($data);
            $icfes = IcfesStudent::select('total_score')->where('id_student', $data->id)->where('id_icfes_test', 5)->first();
            $data->icfes = $icfes->total_score;
            //dd($data);
        });

        return datatables()->of($datos)->toJson();
    }

    public function datos_no_clasificados_icfes_si(){        
        $datos = collect(Rating::no_clasificados_icfes_si());

        $datos->map(function ($data) {
            //dd($data);
            $icfes = IcfesStudent::select('total_score')->where('id_student', $data->id)->where('id_icfes_test', 5)->first();
            $data->icfes = $icfes->total_score;
            //dd($data);
        });

        return datatables()->of($datos)->toJson();
    }

    public function datos_no_clasificados_icfes_no(){
        $datos = Rating::no_clasificados_icfes_no();
        
        return datatables()->of($datos)->toJson();
    }
    
    public function datos_resumen(){
        $datos = Programs::all();
        //dd($datos);
        return datatables()->of($datos)->toJson();    
    }
    
    public function pendientes(){
        $pendientes_data = Rating::pendientes_2023_2();
        return datatables()->of($pendientes_data)->toJson();
    }

    public function detalles_programas(Request $request){
        //dd($request['semestre']);
        $data = Rating::detalle_programa($request['id_programa'], $request['semestre']);
        
        return datatables()->of($data)->toJson();
    }

    public function detalles_programas2(Request $request){
        //dd($request['semestre']);
        $data = Rating2::detalle_programa($request['id_programa'], $request['semestre']);
        
        return datatables()->of($data)->toJson();
    }


    public function index(Request $request){

        $repechaje = Rating::count();
        //dd($repechaje);
        if($repechaje > 0){
           $ronda = 5;
           $estado = 2; 
        }else{
            $ronda = 0;
            $estado = 1;
        }
        //dd($estado);
        $Programas_EstudiantesAdmitidos_semestre = array();

        $programs = Programs::select('id','quotas_I_2023','remaining_quotas_I_2023','quotas_II_2023','remaining_quotas_II_2023','iteration_group')->get();
        
        $semestre = 1;
        
        for ($i=1; $i <= 5; $i++) {

            foreach($programs as $program){
                switch ($semestre) {
                    case 1:
                        if($program->quotas_I_2023 > 0 && $program->remaining_quotas_I_2023 > 0){

                            $cupos = $program->remaining_quotas_I_2023;

                            $elegidos = $this->iteracion_carreras($program->id,$i,$cupos,"I-2023",$estado);
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

        /*$programs_options = ProgramOptions::all();
        foreach($programs_options as $data){
            if($data->estado == '1'){
                ProgramOptions::where('id', $data->id)->update(['estado' => '2']);
            }
        }*/
        
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
                        'iteration'             => $value['iteracion']+$ronda,  
                    ]);    
                }              
            } 
        }

        return back()->with('status', 'Script ejecutado correctamente!');  
    }

    public function iteracion_carreras($carrera,$iteracion,$cupos,$semestre,$estado,$prioridad){

        $estudiantes_seleccionados = array();
        switch ($iteracion) {
            case 1:
                $programs_options = ProgramOptions2::select('id_estudiante','nota_ponderada1','nota_prueba_1','id_programa1')->where('id_programa1', $carrera)->where('semestre_ingreso',$semestre)->where('estado',$estado)->where('prioridad', $prioridad)->orderBy('nota_ponderada1','DESC')->get();

                //validar que el si un programa tiene el 100% en prueba especifica y el estudiante no presento prueba lo saque del arreglo
                foreach($programs_options as $key => $student){

                    $prueba_programa = Programs::where('id', $student->id_programa1)->where('weighting_test_specific', 100)->exists();
                    
                    if(($prueba_programa && $student->nota_prueba_1 > 0) || !$prueba_programa){
                        continue;
                    }else{
                        $programs_options->pull($key);
                    }
                }

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

                                $prueba_especifica  = $estudiante['nota_prueba_1'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

                                $prueba_especifica  = $estudiante['nota_prueba_1'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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
                $programs_options = ProgramOptions2::select('id_estudiante','nota_ponderada2','nota_prueba_2','id_programa2')->where('id_programa2', $carrera)->where('semestre_ingreso',$semestre)->where('estado',$estado)->where('prioridad', $prioridad)->orderBy('nota_ponderada2','DESC')->get();
                
                foreach($programs_options as $key => $student){

                    $prueba_programa = Programs::where('id', $student->id_programa2)->where('weighting_test_specific', 100)->exists();
                    
                    if(($prueba_programa && $student->nota_prueba_2 > 0) || !$prueba_programa){
                        continue;
                    }else{
                        $programs_options->pull($key);
                    }
                }

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

                                $prueba_especifica  = $estudiante['nota_prueba_2'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

                                $prueba_especifica  = $estudiante['nota_prueba_2'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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
                $programs_options = ProgramOptions2::select('id_estudiante','nota_ponderada3','nota_prueba_3','id_programa3')->where('id_programa3', $carrera)->where('semestre_ingreso',$semestre)->where('estado',$estado)->where('prioridad', $prioridad)->orderBy('nota_ponderada3','DESC')->get();
                
                foreach($programs_options as $key => $student){

                    $prueba_programa = Programs::where('id', $student->id_programa3)->where('weighting_test_specific', 100)->exists();
                    
                    if(($prueba_programa && $student->nota_prueba_3 > 0) || !$prueba_programa){
                        continue;
                    }else{
                        $programs_options->pull($key);
                    }
                }

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

                                $prueba_especifica  = $estudiante['nota_prueba_3'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

                                $prueba_especifica  = $estudiante['nota_prueba_3'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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
                $programs_options = ProgramOptions2::select('id_estudiante','nota_ponderada4','nota_prueba_4','id_programa4')->where('id_programa4', $carrera)->where('semestre_ingreso',$semestre)->where('estado',$estado)->where('prioridad', $prioridad)->orderBy('nota_ponderada4','DESC')->get();
                
                foreach($programs_options as $key => $student){

                    $prueba_programa = Programs::where('id', $student->id_programa4)->where('weighting_test_specific', 100)->exists();
                    
                    if(($prueba_programa && $student->nota_prueba_4 > 0) || !$prueba_programa){
                        continue;
                    }else{
                        $programs_options->pull($key);
                    }
                }

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

                                $prueba_especifica  = $estudiante['nota_prueba_4'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

                                $prueba_especifica  = $estudiante['nota_prueba_4'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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
                $programs_options = ProgramOptions2::select('id_estudiante','nota_ponderada5','nota_prueba_5','id_programa5')->where('id_programa5', $carrera)->where('semestre_ingreso',$semestre)->where('estado',$estado)->where('prioridad', $prioridad)->orderBy('nota_ponderada5','DESC')->get();
                
                foreach($programs_options as $key => $student){

                    $prueba_programa = Programs::where('id', $student->id_programa5)->where('weighting_test_specific', 100)->exists();
                    
                    if(($prueba_programa && $student->nota_prueba_5 > 0) || !$prueba_programa){
                        continue;
                    }else{
                        $programs_options->pull($key);
                    }
                }

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

                                $prueba_especifica  = $estudiante['nota_prueba_5'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

                                $prueba_especifica  = $estudiante['nota_prueba_5'] * (($program ? $program->weighting_test_specific : 0)/100);

                                    

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

    public function index2(Request $request){

        $repechaje = Rating2::count();
        //dd($repechaje);
        if($repechaje > 0){
           $ronda = 5;
           $estado = 2; 
        }else{
            $ronda = 0;
            $estado = 1;
        }
        //dd($estado);
        $Programas_EstudiantesAdmitidos_semestre = array();

        $programs = Programs::select('id','quotas_I_2023','remaining_quotas_I_2023','quotas_II_2023','remaining_quotas_II_2023','iteration_group')->get();
        
        $semestre = 2;

        for ($i=1; $i <= 5; $i++) {

            foreach($programs as $program){
                switch ($semestre) {
                    case 1:
                        if($program->quotas_I_2023 > 0 && $program->remaining_quotas_I_2023 > 0){

                            $cupos = $program->remaining_quotas_I_2023;

                            $elegidos = $this->iteracion_carreras($program->id,$i,$cupos,"I-2023",$estado);
                            //dd($elegidos);
                            if(count($elegidos) > 0){

                                foreach($elegidos as $student){

                                    ProgramOptions2::where('id_estudiante',$student['id_student'])->delete();   
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

                            for($prioridad=1; $prioridad <= 2; $prioridad++){
                                
                                $cupos = $program->remaining_quotas_II_2023;

                                $elegidos = $this->iteracion_carreras($program->id,$i,$cupos,"II-2023",$estado,$prioridad);
                                //dump($elegidos);
                                if(count($elegidos) > 0){

                                    foreach($elegidos as $student){

                                        ProgramOptions2::where('id_estudiante',$student['id_student'])->delete();   
                                    }

                                    $cupos_restantes = $program->remaining_quotas_II_2023 - count($elegidos);
                                    //dd($cupos_restantes);
                                    $program->remaining_quotas_II_2023 = $cupos_restantes;

                                    Programs::Where('id',$program->id)->update(['remaining_quotas_II_2023' => $cupos_restantes]);

                                    array_push($Programas_EstudiantesAdmitidos_semestre, array("iteracion" => $i,"id_program" => $program->id,"seleccionados"=>$elegidos));
                                }
                            }   
                        }
                        break;
                    default:
                        // code...
                        break;
                }
                
            }
        }

        /*$programs_options = ProgramOptions::all();
        foreach($programs_options as $data){
            if($data->estado == '1'){
                ProgramOptions::where('id', $data->id)->update(['estado' => '2']);
            }
        }*/
        
        if(count($Programas_EstudiantesAdmitidos_semestre) > 0){

            foreach($Programas_EstudiantesAdmitidos_semestre as $value) {

                foreach($value['seleccionados'] as $key => $selec){

                    $data = Rating2::create([
                        'id_student'            => $selec['id_student'],
                        'id_definitive_program' => $value['id_program'],
                        'weighted_total'        => $selec['total_ponderado'],
                        'weighted_areas'        => $selec['ponderado_areas'],
                        'average_grades'        => $selec['promedio_nota'],
                        'position'              => $key + 1,
                        'iteration'             => $value['iteracion']+$ronda,  
                    ]);    
                }              
            } 
        }

        return back()->with('status', 'Script ejecutado correctamente!');  
    }
}
