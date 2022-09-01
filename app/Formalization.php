<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Formalization extends Model
{
    protected $table = 'formalizations';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'acceptance_v1',
        'acceptance_v2',
        'tablets_v1',
        'tablets_v2',
        'serial_tablet',
        'kit_date',
        'pre_registration_icfes',
        'inscription_icfes',
        'presented_icfes',
        'observations',
        'acceptance_date',
        'acceptance_observation',
        'returned_tablet',
        'loan_tablet',
        'serial_loan_tablet',
        'observation_loan',
        'loan_document_url',
        'transfer_line2_to_line1',
    ];
    
    public static function formalizacion(){

        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,student_profile.document_number, student_profile.email, student_profile.cellphone,  
            student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, 
            formalizations.acceptance_v2 as acceptance_v2, formalizations.tablets_v2 as tablets_v2,
            formalizations.serial_tablet as serial_tablet, formalizations.kit_date as kit_date, 
            formalizations.pre_registration_icfes as pre_registration_icfes, formalizations.inscription_icfes 
            as inscription_icfes, formalizations.presented_icfes as presented_icfes, 
            formalizations.acceptance_date as acceptance_date, formalizations.returned_tablet as returned_tablet, 
            formalizations.loan_tablet as loan_tablet, formalizations.serial_loan_tablet as 
            serial_loan_tablet, formalizations.loan_document_url as loan_document_url, formalizations.transfer_line2_to_line1 as cambio_linea,  
            (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipo_documento, conditions.name as estado
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state 
            WHERE student_groups.deleted_at is null");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    
    //Ultima formalizacion actualizada
    public static function ultimo_update_formalizacion(){
        
        $data = DB::select('
            select * FROM logs_crud_actions
            WHERE logs_crud_actions.actividad_realizada = "FORMALIZACION ACTUALIZADA"
            order by id desc
            limit 1');    

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //
     //para datos pendientes
    public static function formalizacion_pendientes(){
        $data = DB::select("select student_profile.id, student_profile.name, 
                    student_profile.lastname,cohorts.id as 
                    idcohort, cohorts.name as cohorte, groups.id as grupo, groups.name as 
                    grupo_name,
                    (select CONCAT(users.name,' ', users.apellidos_user)profesional 
                    FROM users,assignment_students
                    WHERE users.id = assignment_students.id_user
                    and assignment_students.deleted_at is null
                    and student_profile.id = assignment_students.id_student
                    limit 1) as profesional,
                    (SELECT conditions.name FROM conditions WHERE conditions.id = 
                    student_profile.id_state) as estado, formalizations.acceptance_v2, formalizations.acceptance_date, 
                    formalizations.acceptance_observation, formalizations.tablets_v2, formalizations.serial_tablet, 
                    formalizations.returned_tablet, formalizations.loan_tablet, formalizations.serial_loan_tablet, 
                    formalizations.observation_loan, formalizations.loan_document_url, formalizations.kit_date, 
                    formalizations.pre_registration_icfes, formalizations.inscription_icfes, formalizations.presented_icfes, 
                    formalizations.transfer_line2_to_line1, formalizations.observations
                    FROM student_profile
                    INNER JOIN student_groups ON student_groups.id_student = student_profile.id
                    INNER JOIN groups ON groups.id = student_groups.id_group
                    INNER JOIN cohorts on cohorts.id = groups.id_cohort
                    INNER JOIN formalizations ON formalizations.id_student =
                    student_profile.id
                    WHERE student_groups.deleted_at is null");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
//
}
