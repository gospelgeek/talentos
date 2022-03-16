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
        'srtatum',
        'rural_zone',
        'id_disability',
        'id_ethnicity',
        'url_ethnicity',
    ];

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla Occupation
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Occupation>
     */
    public function occupation(){

        return $this->hasOne(Occupation::class, 'id', 'id_ocupation');
    }

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla CivilStatus
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<CivilStatus>
     */
    public function civilstatus(){

        return $this->hasOne(CivilStatus::class, 'id', 'id_civil_status');
    } 

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla RecidenceTime
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<RecidenceTime>
     */
    public function recidencetime(){

        return $this->hasOne(RecidenceTime::class, 'id', 'id_residence_time');
    }  

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla HousingType
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<HousingType>
     */
    public function housingtype(){

        return $this->hasOne(HousingType::class, 'id', 'id_housing_type');
    }

     /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla HealthRegime
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<HealthRegime>
     */
    public function healthregime(){

        return $this->hasOne(HealthRegime::class, 'id', 'id_health_regime');
    }

     /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla Benefits
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Benefits>
     */
    public function benefits(){

        return $this->hasOne(Benefits::class, 'id', 'id_benefits');
    }

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla SocialConditions
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocialConditions>
     */
    public function socialconditions(){

        return $this->hasOne(SocialConditions::class, 'id', 'id_social_conditions');
    }

     /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla Disability
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Disability>
     */
    public function disability(){

        return $this->hasOne(Disability::class, 'id', 'id_disability');
    }

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla Ethnicity
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Ethnicity>
     */
    public function ethnicity(){

        return $this->hasOne(Ethnicity::class, 'id', 'id_ethnicity');
    }
}
