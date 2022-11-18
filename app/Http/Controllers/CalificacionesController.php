<?php

namespace App\Http\Controllers;

use App\perfilEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalificacionesController extends Controller
{
    public function _constructor()
    {
    }

    public function index()
    {
        return view('calificaciones.consulta');
    }

    public function consulta(Request $request)
    {
        $documento = perfilEstudiante::where('document_number', $request['iden'])->first();
        return redirect()->action('CalificacionesController@informacionResultados',[$documento->id]);
    }

    public function informacionResultados($iden)
    {
        $bandera = false;
        $vistas = false;

        $dataCalificados = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, ratings.id_definitive_program, ratings.position, ratings.iteration, ratings.weighted_total, ratings.weighted_areas, ratings.average_grades, programs.name_program, program_options.semestre_ingreso, 
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa1) as opc1,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa2) as opc2,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa3) as opc3,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa4) as opc4,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa5) as opc5
        FROM student_profile
        INNER JOIN student_groups ON student_groups.id_student = student_profile.id
        INNER JOIN groups ON groups.id = student_groups.id_group
        INNER JOIN cohorts on cohorts.id = groups.id_cohort 
        INNER JOIN ratings on ratings.id_student = student_profile.id
        INNER JOIN programs ON programs.id = ratings.id_definitive_program
        INNER JOIN program_options on program_options.id_estudiante = student_profile.id
        WHERE student_groups.deleted_at IS null
        AND cohorts.id = 1
        AND student_profile.id_state = 1
        AND student_profile.id = ?", [$iden]);

        $dataNoCalificados = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, program_options.semestre_ingreso,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa1) as opc1,  
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa2) as opc2,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa3) as opc3,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa4) as opc4,
        (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa5) as opc5
        FROM student_profile
        INNER JOIN student_groups ON student_groups.id_student = student_profile.id
        INNER JOIN groups ON groups.id = student_groups.id_group
        INNER JOIN cohorts on cohorts.id = groups.id_cohort 
        INNER JOIN program_options on program_options.id_estudiante = student_profile.id
        WHERE student_groups.deleted_at IS null
        AND program_options.deleted_at is null
        AND cohorts.id = 1
        AND student_profile.id_state = 1
        AND student_profile.id = ?", [$iden]);

        if($dataCalificados == [] && $dataNoCalificados == []) $vistas = true;

        if($dataCalificados == []){
            $bandera = true;
        }else{
            if($dataNoCalificados == []){
                $bandera = false;
            }
        }

        //dd($dataCalificados);
        return view('calificaciones.tablaResultados', compact('dataCalificados', 'dataNoCalificados', 'bandera', 'vistas'));
    }

}