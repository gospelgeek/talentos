<?php

namespace App\Http\Controllers;

use App\Exports\SabanaIcfesExport;
use App\IcfesStudent;
use App\IcfesTest;
use App\perfilEstudiante;
use App\ResultByArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class IcfesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index()
    {
       $pruebas = IcfesTest::all();
        $estudiantes = perfilEstudiante::where('id_state', 1)->select('document_number', 'name', 'lastname')->get();
        return view('icfes.index', compact('pruebas', 'estudiantes'));
    }
    
    public function registroIcfes(Request $request)
    {
        if ($request->ajax()) {
            $iden = explode("-",$request['identificacion']);
            $id_student = $iden[1];
            $url = $request['url'];
            $r_areas = $request['r_areas'];
            $lecturaC = $request['lecturaC'];
            $mate = $request['mate'];
            $cienS = $request['cienS'];
            $cienN = $request['cienN'];
            $ingles = $request['ingles'];
            $form_areas = 0;
           
            $id_S = perfilEstudiante::where('document_number', $id_student)->first();

            $lineaGrupo = DB::select("SELECT (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE 
            cohorts.id = groups.id_cohort LIMIT 1) FROM groups WHERE groups.id = 
            student_groups.id_group LIMIT 1) FROM student_groups WHERE student_groups.id_student = 
            student_profile.id LIMIT 1) as linea, (SELECT (SELECT groups.name FROM groups WHERE 
            groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE 
            student_groups.id_student = student_profile.id LIMIT 1) as grupo FROM student_profile 
            WHERE student_profile.id = ?", [$id_S->id]);

            $comprobacion = IcfesStudent::where('id_student', $id_S->id)->where('id_icfes_test', 5)->first();

            if ($comprobacion != null) {
                return array("mensaje" => "no");
            } else {

                if ($url == null) {
                    $url = "";
                }

                if ($r_areas == "on") {
                    $form_areas = 1;
                } else {
                    $form_areas = 0;
                }


                $datos = IcfesStudent::create([
                    'id_student' => $id_S->id,
                    'id_icfes_test' =>  $request['prueba'],
                    'total_score' => floatval($request['puntaje']),
                    'url_support' => $url
                ]);

                switch ($form_areas) {
                    case 1:
                        $lec = ResultByArea::create([
                            'id_student' => $id_S->id,
                            'id_icfes_student' => $datos->id,
                            'id_icfes_area' => 1,
                            'qualification' => floatval($lecturaC)
                        ]);
                        $mat = ResultByArea::create([
                            'id_student' => $id_S->id,
                            'id_icfes_student' => $datos->id,
                            'id_icfes_area' => 2,
                            'qualification' => floatval($mate)
                        ]);

                        $cis = ResultByArea::create([
                            'id_student' => $id_S->id,
                            'id_icfes_student' => $datos->id,
                            'id_icfes_area' => 3,
                            'qualification' => floatval($cienS)
                        ]);

                        $cin = ResultByArea::create([
                            'id_student' => $id_S->id,
                            'id_icfes_student' => $datos->id,
                            'id_icfes_area' => 4,
                            'qualification' => floatval($cienN)
                        ]);

                        $ing = ResultByArea::create([
                            'id_student' => $id_S->id,
                            'id_icfes_student' => $datos->id,
                            'id_icfes_area' => 5,
                            'qualification' => floatval($ingles)
                        ]);

                        return array(
                            "mensaje" => "guardado exitoso", 
                            "estudiante" => $id_S,
                            "linea" => $lineaGrupo[0]->linea,
                            "grupo" => $lineaGrupo[0]->grupo,
                            "lecturaCritica" => $lec->qualification,
                            "matematicas" => $mat->qualification,
                            "cienciasSociales" => $cis->qualification,
                            "cienciasNaturales" => $cin->qualification,
                            "ingles" => $ing->qualification,
                            "total" => $datos->total_score,
                            "url" => $datos->url_support
                        );
                        break;

                    case 0:
                        return array(
                            "mensaje" => "guardado exitoso", 
                            "estudiante" => $id_S,
                            "linea" => $lineaGrupo[0]->linea,
                            "grupo" => $lineaGrupo[0]->grupo,
                            "lecturaCritica" => '',
                            "matematicas" => '',
                            "cienciasSociales" => '',
                            "cienciasNaturales" => '',
                            "ingles" => '',
                            "total" => '',
                            "url" => ''
                        );
                        break;

                    default:
                        return array("mensaje" => "guardado exitoso");
                        break;
                }
            }
        }

    }

    public function DatosIcfes()
    {
        $datosIcfes = DB::select("SELECT id, icfes_students.id_student as id_student, (SELECT student_profile.name FROM student_profile 
        WHERE student_profile.id = icfes_students.id_student LIMIT 1 ) as nombre, 
        (SELECT student_profile.lastname FROM student_profile 
        WHERE student_profile.id = icfes_students.id_student LIMIT 1 ) as apellidos, 
        (SELECT student_profile.document_number FROM student_profile WHERE 
        student_profile.id = icfes_students.id_student LIMIT 1) as documento, 
        (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort LIMIT 1) 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE 
        student_groups.id_student = icfes_students.id_student LIMIT 1) as linea,
        (SELECT (SELECT groups.name FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) 
        FROM student_groups WHERE student_groups.id_student = icfes_students.id_student LIMIT 1) as grupo , 
        icfes_students.total_score FROM icfes_students");

        return datatables()->of($datosIcfes)->toJson();
    }

    public function resultadoArea($id_student)
    {
        $datosNombre = [];
        $datosCalificacionS1 = [];
        $datosCalificacionS2 = [];
        $datosCalificacionS3 = [];
        $datos = [];

        $nombres = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas WHERE 
        icfes_areas.id = result_by_areas.id_icfes_area) as nombre FROM result_by_areas WHERE 
        result_by_areas.id_student = ? limit 5", [$id_student]);

        $resultSimulacro1 = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas 
        WHERE icfes_areas.id = result_by_areas.id_icfes_area) as nombre, result_by_areas.qualification 
        as calificacion FROM result_by_areas WHERE id_student = ? AND result_by_areas.id_icfes_student
         = (SELECT icfes_students.id FROM icfes_students WHERE icfes_students.id_student = ? AND 
         icfes_students.id_icfes_test = 1) ", [$id_student, $id_student]);

        $resultSimulacro2 = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas 
        WHERE icfes_areas.id = result_by_areas.id_icfes_area) as nombre, result_by_areas.qualification 
        as calificacion FROM result_by_areas WHERE id_student = ? AND result_by_areas.id_icfes_student
         = (SELECT icfes_students.id FROM icfes_students WHERE icfes_students.id_student = ? AND 
         icfes_students.id_icfes_test = 2) ", [$id_student, $id_student]);
        
        $resultSimulacro3 = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas 
        WHERE icfes_areas.id = result_by_areas.id_icfes_area) as nombre, result_by_areas.qualification 
        as calificacion FROM result_by_areas WHERE id_student = ? AND result_by_areas.id_icfes_student
        = (SELECT icfes_students.id FROM icfes_students WHERE icfes_students.id_student = ? AND 
        icfes_students.id_icfes_test = 3) ", [$id_student, $id_student]);

        if ($nombres == []) {
            for ($i = 0; $i < 5; $i++) {
                $datos[$i] = array("nombre" => "--", "simulacro1" => 0, "simulacro2" => 0, "simulacro3" => 0);
            }
        } else {
            for ($i = 0; $i < 5; $i++) {
                $datosNombre[$i] = $nombres[$i]->nombre;
            }

            if ($resultSimulacro1 == []) {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS1[$i] = 0;
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS1[$i] = $resultSimulacro1[$i]->calificacion;
                }
            }

            if ($resultSimulacro2 == []) {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS2[$i] = 0;
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS2[$i] = $resultSimulacro2[$i]->calificacion;
                }
            }
            
            if ($resultSimulacro3 == []) {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS3[$i] = 0;
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $datosCalificacionS3[$i] = $resultSimulacro3[$i]->calificacion;
                }
            }

            for ($i = 0; $i < 5; $i++) {
                $datos[$i] = array("nombre" => $datosNombre[$i], "simulacro1" => $datosCalificacionS1[$i], "simulacro2" => $datosCalificacionS2[$i], "simulacro3" => $datosCalificacionS3[$i]);
            }
        }





        $result = $datos;

        return datatables()->of($result)->toJson();
    }

    public function datosIcfesLinea1($id_cohorte)
    {
        $contador = 0;
        $total_s1 = 0;
        $total_s2 = 0;
        $total_s3 = 0;
        $total_ie = 0;
        $total_if = 0;
        $data = [];

        $estudiantes = DB::select("SELECT student_profile.id as id, student_profile.name as nombre, 
        student_profile.lastname as apellidos, student_profile.document_number as documento, 
        (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort LIMIT 1) 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE 
        student_groups.id_student = student_profile.id LIMIT 1) as linea, (SELECT (SELECT groups.name 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) 
        FROM student_groups WHERE student_groups.id_student = student_profile.id LIMIT 1) as grupo 
        FROM student_profile WHERE (SELECT (SELECT (SELECT cohorts.id FROM cohorts 
        WHERE cohorts.id = groups.id_cohort LIMIT 1) 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE 
        student_groups.id_student = student_profile.id LIMIT 1) = ?", [$id_cohorte]);

        /*$s1 = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 1 AND icfes_students.id_student = ?", [1230]);
        dd($s1[0]->total_score);*/

        $tamanioDatos = sizeof($estudiantes);

        while ($contador < $tamanioDatos) {

            $s1 = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 1 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s1 == []) {
                $total_s1 = 0;
            } else {
                $total_s1 = $s1[0]->total_score;
            }

            $s2 = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 2 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s2 == []) {
                $total_s2 = 0;
            } else {
                $total_s2 = $s2[0]->total_score;
            }

            $s3 = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 3 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s3 == []) {
                $total_s3 = 0;
            } else {
                $total_s3 = $s3[0]->total_score;
            }

            $ie = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 4 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($ie == []) {
                $total_ie = 0;
            } else {
                $total_ie = $ie[0]->total_score;
            }

            $if = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 5 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($if == []) {
                $total_if = 0;
            } else {
                $total_if = $if[0]->total_score;
            }

            $data[$contador] = array(
                "id_student" => $estudiantes[$contador]->id,
                "nombre" => $estudiantes[$contador]->nombre,
                "apellidos" => $estudiantes[$contador]->apellidos,
                "documento" => $estudiantes[$contador]->documento,
                "linea" => $estudiantes[$contador]->linea,
                "grupo" => $estudiantes[$contador]->grupo,
                "s1" => $total_s1,
                "s2" => $total_s2,
                "s3" => $total_s3,
                "ie" => $total_ie,
                "if" => $total_if,
            );

            ++$contador;
        }

        $result = $data;

        return datatables()->of($result)->toJson();
    }
    
    public function archivoSabanaIcfes()
    {
        ini_set('max_execution_time', '600');
        $nombreArchivo = "sabana_icfes_datos.json";
        $contador = 0;
        $total_s1 = 0;
        $AreasS1 = [0, 0, 0, 0, 0];
        $variacionS1 = [0,0];
        $total_s2 = 0;
        $AreasS2 = [0, 0, 0, 0, 0];
        $variacionS2 = [0,0];
        $total_s3 = 0;
        $AreasS3 = [0, 0, 0, 0, 0];
        $variacionS3 = [];
        $total_ie = 0;
        $total_if = 0;
        $data = [];

        $estudiantes = DB::select("SELECT student_profile.id as id, student_profile.name as nombre, 
        student_profile.lastname as apellidos, student_profile.document_number as documento, 
        (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort LIMIT 1) 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups 
        WHERE student_groups.id_student = student_profile.id LIMIT 1) as linea, (SELECT 
        (SELECT groups.name FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) 
        FROM student_groups WHERE student_groups.id_student = student_profile.id LIMIT 1) as grupo 
        FROM student_profile WHERE id_state = 1 AND id IN (SELECT icfes_students.id_student FROM icfes_students)");

        $tamanioDatos = sizeof($estudiantes);

        while ($contador < $tamanioDatos) {

            $ie = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 4 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($ie == []) {
                $total_ie = 0;
            } else {
                $total_ie = $ie[0]->total_score;
            }

            $s1 = DB::select("SELECT icfes_students.total_score, icfes_students.id FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 1 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s1 == []) {
                $total_s1 = 0;
                $AreasS1 = [0, 0, 0, 0, 0];
            } else {
                $total_s1 = $s1[0]->total_score;
                $idPrueba = $s1[0]->id;
                $lc = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 1", [$idPrueba]);
                $mt = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 2", [$idPrueba]);
                $cs = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 3", [$idPrueba]);
                $cn = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 4", [$idPrueba]);
                $in = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 5", [$idPrueba]);
                $AreasS1[0] = $lc[0]->calificacion;
                $AreasS1[1] = $mt[0]->calificacion;
                $AreasS1[2] = $cs[0]->calificacion;
                $AreasS1[3] = $cn[0]->calificacion;
                $AreasS1[4] = $in[0]->calificacion;
            }

            if($estudiantes[$contador]->linea == "LINEA 1" || $estudiantes[$contador]->linea == "LINEA 2"){
                $variacionS1[0] = round($total_s1 - $total_ie);
                if($total_ie != 0){
                    $variacionS1[1] = round(($variacionS1[0] / $total_ie) * 100);
                }else{
                    $variacionS1[1] = 0;
                }
            }else{
                $variacionS1 = [0,0];
            }

            $s2 = DB::select("SELECT icfes_students.total_score, icfes_students.id FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 2 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s2 == []) {
                $total_s2 = 0;
                $AreasS2 = [0, 0, 0, 0, 0];
            } else {
                $total_s2 = $s2[0]->total_score;
                $idPrueba = $s2[0]->id;
                $lc = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 1", [$idPrueba]);
                $mt = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 2", [$idPrueba]);
                $cs = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 3", [$idPrueba]);
                $cn = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 4", [$idPrueba]);
                $in = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 5", [$idPrueba]);
                $AreasS2[0] = $lc[0]->calificacion;
                $AreasS2[1] = $mt[0]->calificacion;
                $AreasS2[2] = $cs[0]->calificacion;
                $AreasS2[3] = $cn[0]->calificacion;
                $AreasS2[4] = $in[0]->calificacion;
            }

            if($estudiantes[$contador]->linea == "LINEA 3"){
                $variacionS2[0] = round($total_s2 - $total_s1);
                if($total_s1 != 0){
                    $variacionS2[1] = round(($variacionS2[0] / $total_s1) * 100);
                }else{
                    $variacionS2[1] = 0;
                }
                
            }else{
                $variacionS2[0] = round($total_s2 - $total_ie);
                if($total_ie != 0){
                    $variacionS2[1] = round(($variacionS2[0] / $total_ie) * 100);
                }else{
                    $variacionS2[1] = 0;
                }
                
            }

            $s3 = DB::select("SELECT icfes_students.total_score, icfes_students.id FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 3 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($s3 == []) {
                $total_s3 = 0;
                $AreasS3 = [0, 0, 0, 0, 0];
            } else {
                $total_s3 = $s3[0]->total_score;
                $idPrueba = $s3[0]->id;
                $lc = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 1", [$idPrueba]);
                $mt = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 2", [$idPrueba]);
                $cs = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 3", [$idPrueba]);
                $cn = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 4", [$idPrueba]);
                $in = DB::select("SELECT qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ? AND id_icfes_area = 5", [$idPrueba]);
                $AreasS3[0] = $lc[0]->calificacion;
                $AreasS3[1] = $mt[0]->calificacion;
                $AreasS3[2] = $cs[0]->calificacion;
                $AreasS3[3] = $cn[0]->calificacion;
                $AreasS3[4] = $in[0]->calificacion;
            }

            if($estudiantes[$contador]->linea == "LINEA 3"){
                $variacionS3[0] = round($total_s3 - $total_s1);
                if($total_s1 != 0){
                    $variacionS3[1] = round(($variacionS3[0] / $total_s1) * 100);
                }else{
                    $variacionS3[1] = 0;
                }
                
            }else{
                $variacionS3[0] = round($total_s3 - $total_ie);
                if($total_ie != 0){
                    $variacionS3[1] = round(($variacionS3[0] / $total_ie) * 100);
                }else{
                    $variacionS3[1] = 0;
                }
                
            }

            $if = DB::select("SELECT icfes_students.total_score FROM icfes_students 
            WHERE icfes_students.id_icfes_test = 5 AND icfes_students.id_student = ?", [$estudiantes[$contador]->id]);

            if ($if == []) {
                $total_if = 0;
            } else {
                $total_if = $if[0]->total_score;
            }

            $data[$contador] = array(
                "id_student" => $estudiantes[$contador]->id,
                "nombre" => $estudiantes[$contador]->nombre,
                "apellidos" => $estudiantes[$contador]->apellidos,
                "documento" => $estudiantes[$contador]->documento,
                "linea" => $estudiantes[$contador]->linea,
                "grupo" => $estudiantes[$contador]->grupo,
                "LCie" => "-",
                "MTie" => "-",
                "CSie" => "-",
                "CNie" => "-",
                "INie" => "-",
                "Tie" => $total_ie,
                "LCs1" => $AreasS1[0],
                "MTs1" => $AreasS1[1],
                "CSs1" => $AreasS1[2],
                "CNs1" => $AreasS1[3],
                "INs1" => $AreasS1[4],
                "Ts1" => $total_s1,
                "PuntosVar1" => $variacionS1[0],
                "PorVar1" => "$variacionS1[1] %",
                "LCs2" => $AreasS2[0],
                "MTs2" => $AreasS2[1],
                "CSs2" => $AreasS2[2],
                "CNs2" => $AreasS2[3],
                "INs2" => $AreasS2[4],
                "Ts2" => $total_s2,
                "PuntosVar2" => $variacionS2[0],
                "PorVar2" => "$variacionS2[1] %",
                "LCs3" => $AreasS3[0],
                "MTs3" => $AreasS3[1],
                "CSs3" => $AreasS3[2],
                "CNs3" => $AreasS3[3],
                "INs3" => $AreasS3[4],
                "Ts3" => $total_s3,
                "PuntosVar3" => $variacionS3[0],
                "PorVar3" => "$variacionS3[1] %",
                "LCif" => "-",
                "MTif" => "-",
                "CSif" => "-",
                "CNif" => "-",
                "INif" => "-",
                "if" => $total_if,
                "PuntosVarIf" => "-",
                "PorVarIf" => "-",
            );

            ++$contador;
        }
        $result = $data;
        Storage::disk('local')->put($nombreArchivo, json_encode($result));
        return redirect('icfes');
        
    }

    public function exportarSabanaIcfes()
    {
        $datos = json_decode(Storage::get('sabana_icfes_datos.json'));
        $exportar = new SabanaIcfesExport($datos);

        return Excel::download($exportar, "Sabana_icfes_comparativo.xlsx");
    }

    public function icfesResultadoArea($id_student, $id_icfes_test)
    {
         $con = DB::select("SELECT id FROM icfes_students WHERE id_icfes_test = ? AND id_student = ?", [$id_icfes_test, $id_student]);
        if($con == []){
            
            return datatables()->of($con)->toJson();
        }
        $idPrueba = $con[0]->id;

        $data = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas WHERE icfes_areas.id = result_by_areas.id_icfes_area)
         as nombre, qualification as calificacion FROM result_by_areas WHERE id_icfes_student = ?", [$idPrueba]);

        return datatables()->of($data)->toJson();
    }
    
    public function reportePruebas()
    {
       
        return view('icfes.reporteIcfesPruebas');
    }

    public function datosPruebasIcfes($test)
    {
        ini_set('max_execution_time', '600');
        
        $data = DB::select("SELECT icfes_students.id, icfes_students.id_student, (SELECT name FROM student_profile WHERE student_profile.id = 
        icfes_students.id_student) as nombre, (SELECT lastname FROM student_profile WHERE student_profile.id = 
        icfes_students.id_student) as apellidos, (SELECT document_number FROM student_profile WHERE student_profile.id
         = icfes_students.id_student) as documento, (SELECT student_code FROM student_profile WHERE student_profile.id
          = icfes_students.id_student) as codigo, (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id
           = groups.id_cohort  LIMIT 1) FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM 
           student_groups WHERE student_groups.id_student = icfes_students.id_student LIMIT 1) as linea,
            (SELECT (SELECT groups.name FROM groups WHERE groups.id = student_groups.id_group LIMIT 1)FROM 
            student_groups WHERE student_groups.id_student = icfes_students.id_student LIMIT 1) as grupo, 
            url_support as url, total_score as Total, (SELECT qualification FROM result_by_areas WHERE
             result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 1) as 
             LC, (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = 
             icfes_students.id AND result_by_areas.id_icfes_area = 2) as MT, (SELECT qualification FROM 
             result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 3)
              as CS, (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = 
              icfes_students.id AND result_by_areas.id_icfes_area = 4) as CN, 
              (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND 
              result_by_areas.id_icfes_area = 5) as ING FROM icfes_students WHERE icfes_students.id_icfes_test = ?", [$test]);

        return datatables()->of($data)->toJson();
    }

    public function actualizarIcfes($iden, $test, Request $request)
    {
        if ($request->ajax()) {
            $id_S = perfilEstudiante::where('document_number', $iden)->first();
            $icfes_student = IcfesStudent::where('id_student', $id_S->id)->where('id_icfes_test', $test)->first();
            $url = $request['url'];
            if ($url == null) {
                $url = "";
            }
            $icfes_student->url_support = $url;
            $icfes_student->total_score = $request['puntajeT'];
            $icfes_student->save();

            $lecturaC = ResultByArea::where('id_student', $id_S->id)->where('id_icfes_student', $icfes_student->id)->where('id_icfes_area', 1)->first();
            $matemticas = ResultByArea::where('id_student', $id_S->id)->where('id_icfes_student', $icfes_student->id)->where('id_icfes_area', 2)->first();
            $cienciasS = ResultByArea::where('id_student', $id_S->id)->where('id_icfes_student', $icfes_student->id)->where('id_icfes_area', 3)->first();
            $cienciasN = ResultByArea::where('id_student', $id_S->id)->where('id_icfes_student', $icfes_student->id)->where('id_icfes_area', 4)->first();
            $ingles = ResultByArea::where('id_student', $id_S->id)->where('id_icfes_student', $icfes_student->id)->where('id_icfes_area', 5)->first();

            if ($lecturaC == null) {
                ResultByArea::create([
                    'id_student' => $id_S->id,
                    'id_icfes_student' => $icfes_student->id,
                    'id_icfes_area' => 1,
                    'qualification' => floatval($request['lc'])
                ]);
            } else {
                $lecturaC->qualification = $request['lc'];
                $lecturaC->save();
            }

            if ($matemticas == null) {
                ResultByArea::create([
                    'id_student' => $id_S->id,
                    'id_icfes_student' => $icfes_student->id,
                    'id_icfes_area' => 2,
                    'qualification' => floatval($request['mt'])
                ]);
            } else {
                $matemticas->qualification = $request['mt'];
                $matemticas->save();
            }

            if ($cienciasS == null) {
                ResultByArea::create([
                    'id_student' => $id_S->id,
                    'id_icfes_student' => $icfes_student->id,
                    'id_icfes_area' => 3,
                    'qualification' => floatval($request['cs'])
                ]);
            } else {
                $cienciasS->qualification  = $request['cs'];
                $cienciasS->save();
            }

            if ($cienciasN == null) {
                ResultByArea::create([
                    'id_student' => $id_S->id,
                    'id_icfes_student' => $icfes_student->id,
                    'id_icfes_area' => 4,
                    'qualification' => floatval($request['cn'])
                ]);
            } else {
                $cienciasN->qualification  = $request['cn'];
                $cienciasN->save();
            }

            if ($ingles == null) {
                ResultByArea::create([
                    'id_student' => $id_S->id,
                    'id_icfes_student' => $icfes_student->id,
                    'id_icfes_area' => 5,
                    'qualification' => floatval($request['in'])
                ]);
            } else {
                $ingles->qualification  = $request['in'];
                $ingles->save();
            }

            return array("mensaje" => "exitoso");
        }
    }

    
    
}
