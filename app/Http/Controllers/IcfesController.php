<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IcfesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index(){
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

        $resultSimulacro1 = DB::select("SELECT id, (SELECT icfes_areas.name FROM icfes_areas WHERE 
        icfes_areas.id = result_by_areas.id_icfes_area) as nombre, result_by_areas.qualification 
        as calificacion FROM result_by_areas WHERE id_student = ? ", [$id_student]);

        for ($i = 0; $i < 5; $i++) {
            $datosNombre[$i] = $resultSimulacro1[$i]->nombre;
        }
        for ($i=0; $i < 5; $i++) { 
            $datosCalificacionS1[$i] = $resultSimulacro1[$i]->calificacion;
        }
        $cont = 0;
        for ($i=5; $i < 10; $i++) { 
            $datosCalificacionS2[$cont] = $resultSimulacro1[$i]->calificacion;
            $cont++;
        }
        
        for ($i=0; $i < 5; $i++) { 
            $datos[$i] = array("nombre" => $datosNombre[$i],"simulacro1" => $datosCalificacionS1[$i],"simulacro2" => $datosCalificacionS2[$i]);
        }

        $result = $datos;

        return datatables()->of($result)->toJson();
    }
}
