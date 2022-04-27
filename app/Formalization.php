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
    ];
    
    public static function formalizacion(){

        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,student_profile.document_number,
        (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
        (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort) as cohorte,
        formalizations.id_student,formalizations.acceptance_v1, formalizations.acceptance_v2, formalizations.tablets_v1, formalizations.tablets_v2, formalizations.serial_tablet 
        FROM student_profile, formalizations, groups, student_groups
        WHERE student_profile.id = student_groups.id_student
        AND student_groups.id_group = groups.id
        AND student_profile.id = formalizations.id_student
        AND student_profile.id_state = 1
        AND student_groups.deleted_at is null");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
}
