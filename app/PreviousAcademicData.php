<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousAcademicData extends Model
{
    protected $table = 'previous_academic_data';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_institution_type',
        'year_graduation',
        'bachelor_title',
        'url_academic_support',
        'icfes_date',
        'snp_register',
        'icfes_score',
        'graduate',
        'graduate_schooling',
    ];
}
