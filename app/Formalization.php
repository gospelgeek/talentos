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
            serial_loan_tablet, formalizations.loan_document_url as loan_document_url,  
            (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, conditions.name as estado,
            (SELECT withdrawals.id_reasons FROM withdrawals WHERE withdrawals.id_student = student_profile.id) as motivoid
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
}
