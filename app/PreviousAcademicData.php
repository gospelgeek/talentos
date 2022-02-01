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
        'institution_name',
        'year_graduation',
        'bachelor_title',
        'url_academic_support',
        'icfes_date',
        'snp_register',
        'icfes_score',
        'graduate',
        'graduate_schooling',
    ];

    /**
     * Relacion con los  datos que se tiene de previos_academic_date con la tabla institution_type 
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocioeconomicData>
    */

    public function institutiontype(){

        return $this->hasOne(InstitutionType::class, 'id', 'id_institution_type');
    }
    
}
