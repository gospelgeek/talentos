<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Rating extends Model
{
    protected $table = 'ratings';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_definitive_program',
        'weighted_total',
        'weighted_areas',
        'average_grades',
        'position',
        'iteration',
    ];

    //Consulta para los clasificados
    public static function clasificados(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, ratings.id_definitive_program, ratings.position, ratings.iteration, ratings.weighted_total, ratings.weighted_areas, ratings.average_grades, programs.code_program, programs.name_program, program_options.semestre_ingreso, 
            programs.working_day,
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
            INNER JOIN program_options on (program_options.id_estudiante = student_profile.id and program_options.deleted_at is not null)
            WHERE program_options.id IN (SELECT MAX(id) FROM program_options group by id_estudiante) 
            AND student_groups.deleted_at IS null
            AND cohorts.id = 1
            AND student_profile.id_state = 1
            and student_profile.deleted_at is null
            and program_options.semestre_ingreso = 'I-2023'
            ");

        if($data != null){
            //dd($data);
            return $data;
        }else{
            return [];
        }
    }
    //
    public static function no_clasificados_icfes_si(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, 
            student_profile.document_number, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, program_options.semestre_ingreso,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa1) as opc1,  
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa2) as opc2,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa3) as opc3,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa4) as opc4,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa5) as opc5
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort 
            INNER JOIN program_options on (program_options.id_estudiante = student_profile.id AND       
            program_options.semestre_ingreso = 'I-2023')
            WHERE student_profile.id IN(
            SELECT icfes_students.id_student FROM icfes_students)
            and program_options.id IN (SELECT MAX(id) FROM program_options group by id_estudiante)
            AND student_groups.deleted_at IS null
            AND program_options.deleted_at IS null
            AND cohorts.id = 1
            AND student_profile.id_state = 1
            and student_profile.deleted_at is null
            UNION
            select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_groups.id_group as grupoid, groups.name AS                  grupo, cohorts.name AS cohorte, '--' as semestre_ingreso,'--' as opc1,'--' as opc2,'--' as opc3,'--' as opc4,'--' as opc5
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN icfes_students on ( icfes_students.id_student = student_profile.id and icfes_students.id_icfes_test = 5)
            WHERE student_profile.id NOT IN 
            (SELECT program_options.id_estudiante FROM program_options)
            AND student_profile.id IN(
            SELECT icfes_students.id_student FROM icfes_students)
            AND student_profile.id_state = 1
            AND student_profile.deleted_at is null
            AND student_groups.deleted_at is null
            AND cohorts.id = 1");

        if($data != null){
            return $data;
        }else{
            return [];
        }
    }

    public static function no_clasificados_icfes_no(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_groups.id_group as grupoid, groups.name AS               grupo, cohorts.name AS cohorte, '--' as semestre_ingreso,'--' as opc1,'--' as opc2,'--' as opc3,'--' as opc4,'--' as opc5
            FROM `student_profile`
            INNER JOIN student_groups on (student_groups.id_student = student_profile.id and student_groups.deleted_at is null)
            INNER JOIN groups on (groups.id = student_groups.id_group and groups.id_cohort = 1 )
            INNER JOIN cohorts on cohorts.id = groups.id_cohort 
            LEFT join icfes_students on (icfes_students.id_student = student_profile.id and icfes_students.id_icfes_test = 5)
            WHERE student_profile.`id_state` = 1
            and student_profile.deleted_at is null
            and icfes_students.id_student is null
            ");
        if($data != null){
            return $data;
        }else{
            return [];
        }
    }

    public static function pendientes_2023_2(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, 
            student_profile.document_number, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, program_options.semestre_ingreso,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa1) as opc1,  
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa2) as opc2,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa3) as opc3,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa4) as opc4,
            (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa5) as opc5
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort 
            INNER JOIN program_options on (program_options.id_estudiante = student_profile.id AND       
            program_options.semestre_ingreso = 'II-2023')
            WHERE student_groups.deleted_at IS null
            AND program_options.deleted_at IS null
            AND cohorts.id = 1
            AND student_profile.id_state = 1
            and student_profile.deleted_at is null");
        
        if($data != null){
            return $data;
        }else{
            return [];
        }
    }

    public static function detalle_programa($id_programa, $semestre){
        //dd($semestre,$id_programa);
        $data = DB::select("
                    select student_profile.id, student_profile.name, student_profile.lastname, 
                    ratings.weighted_total, ratings.weighted_areas, ratings.average_grades, 
                    ratings.position, ratings.iteration
                    FROM student_profile
                    INNER JOIN ratings on ratings.id_student = student_profile.id
                    WHERE ratings.id_definitive_program = ".$id_programa."");
        if($data != null){
            return $data;
        }else{
            return [];
        }
    }
    
    public static function consultaResultados($id_student){
        $data = DB::select("select student_profile.id, programs.name_program, ratings.position, 
                ratings.iteration, ratings.weighted_total, ratings.weighted_areas, 
                ratings.average_grades,
                (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa1) as opc1,
                (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa2) as opc2,
                (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa3) as opc3,
                (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa4) as opc4,
                (SELECT programs.name_program FROM programs WHERE programs.id = program_options.id_programa5) as opc5,
                program_options.semestre_ingreso
                from student_profile
                INNER JOIN ratings on ratings.id_student = student_profile.id
                INNER JOIN programs ON programs.id = ratings.id_definitive_program
                INNER JOIN program_options on program_options.id_estudiante = ratings.id_student
                WHERE ratings.id_student = ".$id_student."");
        if($data != null){
            return $data;
        }else{
            return [];
        }
    }
}
