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
        'eps_name',
    ];
    
    //para datos pendientes
    public static function socioeconomicos(){
        $data = DB::select("
                    select student_profile.id, student_profile.name, 
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
                    student_profile.id_state) as estado,
                    (SELECT occupations.name FROM occupations WHERE occupations.id = 
                    socioeconomic_data.id_ocupation) as ocupacion,
                    (SELECT civil_statuses.name FROM civil_statuses WHERE civil_statuses.id = 
                    socioeconomic_data.id_civil_status) as estado_civil,
                    socioeconomic_data.children_number,
                    (SELECT recidence_times.name FROM recidence_times WHERE recidence_times.id = 
                    socioeconomic_data.id_residence_time) as tiempo_residencia,
                    (SELECT housing_types.name FROM housing_types WHERE housing_types.id = 
                    socioeconomic_data.id_housing_type) as tipo_vivienda,
                    (SELECT health_regimes.name FROM health_regimes WHERE health_regimes.id = 
                    socioeconomic_data.id_health_regime) as regimen_salud,
                    socioeconomic_data.url_health_regime, socioeconomic_data.sisben_category, 
                    socioeconomic_data.url_sisben_category,
                    (SELECT benefits.name FROM benefits WHERE benefits.id = 
                    socioeconomic_data.id_benefits) as beneficios, 
                    socioeconomic_data.household_people, socioeconomic_data.economic_possition, 
                    socioeconomic_data.dependent_people, socioeconomic_data.internet_zon, 
                    socioeconomic_data.internet_home, socioeconomic_data.sex_document_identidad,
                    (SELECT social_conditions.name FROM social_conditions WHERE 
                    social_conditions.id = socioeconomic_data.id_social_conditions) as 
                    condicion_social, socioeconomic_data.url_social_conditions, 
                    socioeconomic_data.stratum, socioeconomic_data.rural_zone,
                    (SELECT disabilities.name FROM disabilities WHERE disabilities.id = 
                    socioeconomic_data.id_disability) as discapacidad,
                    (SELECT ethnicities.name FROM ethnicities WHERE ethnicities.id = 
                    socioeconomic_data.id_ethnicity) as etnia, socioeconomic_data.url_ethnicity, 
                    socioeconomic_data.eps_name 
                    FROM student_profile
                    INNER JOIN student_groups ON student_groups.id_student = student_profile.id
                    INNER JOIN groups ON groups.id = student_groups.id_group
                    INNER JOIN cohorts on cohorts.id = groups.id_cohort
                    INNER JOIN socioeconomic_data ON socioeconomic_data.id_student =
                    student_profile.id
                    WHERE student_groups.deleted_at is null");

        if($data != null) {
            return $data;
        }else{
            return null;
        }
    }

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
