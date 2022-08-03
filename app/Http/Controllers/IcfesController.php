<?php

namespace App\Http\Controllers;

use App\Exports\SabanaIcfesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IcfesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index()
    {
        return view('icfes.index');
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

        if ($nombres == []) {
            for ($i = 0; $i < 5; $i++) {
                $datos[$i] = array("nombre" => "--", "simulacro1" => 0, "simulacro2" => 0);
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

            for ($i = 0; $i < 5; $i++) {
                $datos[$i] = array("nombre" => $datosNombre[$i], "simulacro1" => $datosCalificacionS1[$i], "simulacro2" => $datosCalificacionS2[$i]);
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

    public function exportarSabanaIcfes()
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
        FROM student_profile");

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
                "ie" => $total_ie,
                "s1" => $total_s1,
                "s2" => $total_s2,
                "s3" => $total_s3,
                "if" => $total_if,
            );

            ++$contador;
        }
        $result = $data;

        $exportar = new SabanaIcfesExport($result);

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
}
