<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcfesStudent extends Model
{
    use SoftDeletes;
    //use Notifiable;
    
    protected $table = 'icfes_students';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_icfes_test',
        'total_score',
        'url_support'
    ];

    protected $dates = ['deleted_at'];
    
    public static function infoPruebas($test)
    {
       return DB::select("SELECT student_profile.id, student_profile.name as nombre, student_profile.lastname as apellidos, student_profile.document_number as documento, student_profile.student_code as codigo, student_groups.id_group as grupo_id, groups.name as grupo, cohorts.name as linea, icfes_students.url_support as url, icfes_students.total_score as Total,
       (SELECT qualification FROM result_by_areas WHERE
       result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 1) as LC,
       (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 2) as MT,
       (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 3) as CS,
       (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 4) as CN,
       (SELECT qualification FROM result_by_areas WHERE result_by_areas.id_icfes_student = icfes_students.id AND result_by_areas.id_icfes_area = 5) as ING
       FROM student_profile
       INNER JOIN student_groups ON student_groups.id_student = student_profile.id
       INNER JOIN groups ON groups.id = student_groups.id_group
       INNER JOIN cohorts on cohorts.id = groups.id_cohort
       INNER JOIN icfes_students ON icfes_students.id_student = student_profile.id
       AND icfes_students.id_icfes_test = ?", [$test]);
       
    }
}
