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

    public function etniaPorLinea($etnia, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE socioeconomic_data.id_ethnicity = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups 
        WHERE student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$etnia, $cohorte]);

        return $datos;
    }

    public function ocupacionLinea($ocup, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE socioeconomic_data.id_ocupation = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))",[$ocup, $cohorte]);

        return $datos;

    }

    public function numeroDeHijos($hijos, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE socioeconomic_data.children_number = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$hijos, $cohorte]);

        return $datos;
    }

    public function regimenSalud($regimen, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE socioeconomic_data.id_health_regime = ?
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$regimen, $cohorte]);

        return $datos;
    }

    public function categoriaDeSisben($sisben, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE sisben_category = ?
         AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
         student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$sisben, $cohorte]);

         return $datos;
    }

    public function beneficios($beneficio, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE id_benefits = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))",[$beneficio, $cohorte]);

        return $datos;
    }

    public function internetZona($zona, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE internet_zon = ?
         AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
         student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$zona, $cohorte]);

        return $datos;
    }

    public function internetHome($home, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE internet_home = ?
         AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups 
         WHERE student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$home, $cohorte]);

        return $datos;
    }

    public function socialCondicion($condicion, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE id_social_conditions = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$condicion, $cohorte]);

        return $datos;
    }

    public function discapacidad($discapacidad, $cohorte){
        $datos = DB::select("SELECT COUNT(id) as cantidad FROM socioeconomic_data WHERE id_disability = ? 
        AND socioeconomic_data.id_student IN (SELECT student_groups.id_student FROM student_groups WHERE 
        student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$discapacidad, $cohorte]);

        return $datos;
    }

}
