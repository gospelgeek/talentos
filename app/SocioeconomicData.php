<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SocioeconomicData extends Model
{
    protected $table = 'socioeconomic_data';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_ocupation',
        'id_civil_status',
        'children_number',
        'id_residence_time',
        'id_housing_type',
        'id_health_regime',
        'url_health_regime',
        'sisben_category',
        'url_sisben_category',
        'id_benefits',
        'household_people',
        'economic_possition',
        'dependent_people',
        'internet_zon',
        'internet_home',
        'sex_document_identidad',
        'id_social_conditions',
        'url_social_conditions',
        'id_disability',
        'id_ethnicity',
        'url_ethnicity',
    ];


    public function occupation (){

        return $this->hasOne(Occupation::class, 'id', 'id_ocupation');
    }

    public function civilstatus (){

        return $this->hasOne(CivilStatus::class, 'id', 'id_civil_status');
    } 

    public function recidencetime (){

        return $this->hasOne(RecidenceTime::class, 'id', 'id_residence_time');
    }  

    public function housingtype (){

        return $this->hasOne(HousingType::class, 'id', 'id_housing_type');
    }

    public function healthregime (){

        return $this->hasOne(HealthRegime::class, 'id', 'id_health_regime');
    }

    public function benefits (){

        return $this->hasOne(Benefits::class, 'id', 'id_benefits');
    }

    public function socialconditions (){

        return $this->hasOne(SocialConditions::class, 'id', 'id_disability');
    }

    public function disability (){

        return $this->hasOne(Disability::class, 'id', 'id_social_conditions');
    }

    public function ethnicity (){

        return $this->hasOne(Ethnicity::class, 'id', 'id_ethnicity');
    }
}
