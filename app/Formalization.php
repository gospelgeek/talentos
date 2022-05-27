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
        'especial_case',
        'kit_date',
        'pre_registration_icfes',
        'inscription_icfes',
        'presented_icfes',
        'observations',
    ];
    
    public static function formalizacion(){

        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,student_profile.document_number,  
            student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, 
            formalizations.acceptance_v2 as acceptance_v2, formalizations.tablets_v2 as tablets_v2,
            formalizations.serial_tablet as serial_tablet 
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id 
            WHERE student_groups.deleted_at is null
            AND student_profile.id_state = 1");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
}
