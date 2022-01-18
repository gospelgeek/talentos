<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicDates extends Model
{
    protected $table = 'academic_dates';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'institution_name',
        'id_institution_type',
        'year_graduation',
        'bachelor_title',
        'icfes_date',
        'snp_register',
        'icfes_score',
        'graduate',
        'graduate_schooling',
    ];

    public function institutiontype() {

        return $this->hasOne(InstitutionType::class, 'id', 'id_institution_type');
    }
}
