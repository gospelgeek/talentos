<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index(){
        return view('graphics.index');
    }

    public function sexoPorCohorte($tipo, $cohorte){
        $datos = DB::select("SELECT COUNT(sex) as sexo FROM student_profile WHERE sex = ? AND 
        student_profile.id IN (SELECT student_groups.id_student FROM student_groups WHERE
         student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$tipo, $cohorte]);

        return $datos;
    }

    public function edadPorCohorte($edad, $cohorte){

        $datos = DB::select("SELECT COUNT(student_profile.id) as cantidad FROM student_profile 
        WHERE (SELECT TIMESTAMPDIFF(YEAR, student_profile.birth_date, CURRENT_DATE())) = ? AND 
        student_profile.id IN (SELECT student_groups.id_student FROM student_groups WHERE student_groups.id_group 
        IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$edad, $cohorte]);

        return $datos;

    }

    public function anioGraduacion($anio, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM previous_academic_data 
        WHERE previous_academic_data.year_graduation = ? AND previous_academic_data.id_student 
        IN (SELECT student_groups.id_student FROM student_groups WHERE student_groups.id_group IN 
        (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$anio, $cohorte]);

        return $datos;
    }

    public function puntajeIcfes($icfesI, $icfesF, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM previous_academic_data 
        WHERE previous_academic_data.icfes_score BETWEEN ? AND ? AND previous_academic_data.id_student 
        IN (SELECT student_groups.id_student FROM student_groups WHERE student_groups.id_group 
        IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$icfesI, $icfesF, $cohorte]);

        return $datos;
    }

    public function civilEstado($estado, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE id_civil_status = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE student_groups.id_group 
        IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$estado, $cohorte]);

        return $datos;
    }

}
