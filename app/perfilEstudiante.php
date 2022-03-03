<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use DB;


class perfilEstudiante extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $table = 'student_profile';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'foto',
        'name',
        'lastname',
        'student_code',
        'id_document_type',
        'document_number',
        'url_document_type',
        'document_expedition_date',
        'email',
        'birth_date',
        'id_birth_city',
        'sex',
        'id_gender',
        'cellphone',
        'phone',
        'id_neighborhood',
        'direction',
        'id_group',
        'id_cohort',
        'id_tutor',
        'id_state',
    ];

    protected $dates = ['delete_at'];

    public static function consultaPrincipal(){

        $perfilEstudiantes= DB::select("SELECT student_profile.id as idstudiante, student_profile.*,socioeconomic_data.id as idtabla, socioeconomic_data.id_student as idstudent, socioeconomic_data.id_civil_status as estadocivil, socioeconomic_data.id_ethnicity as etnia, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad, 
            (SELECT document_type.name FROm document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento,
            (SELECT birth_departaments.name FROM birth_departaments WHERE student_profile.id_birth_department = birth_departaments.id) as departamentoN,
            (SELECT birth_city.name FROM birth_city WHERE student_profile.id_birth_city = birth_city.id) as ciudadN,
            (SELECT comune.name FROM comune WHERE student_profile.id_commune = comune.id) as comuna,
            (SELECT neighborhood.name FROM neighborhood WHERE student_profile.id_neighborhood = neighborhood.id) as barrio,
            (SELECT gender.name FROM gender WHERE gender.id = student_profile.id_gender) as genero,
            (SELECT tutor.name FROM tutor WHERE tutor.id = student_profile.id_tutor) as tutor,
            (SELECT conditions.name FROM conditions WHERE conditions.id = student_profile.id_state) as estado,
            (SELECT civil_statuses.name FROM civil_statuses WHERE socioeconomic_data.id_civil_status = civil_statuses.id) as nombreEstadocivil,
            (SELECT ethnicities.name FROM ethnicities WHERE socioeconomic_data.id_ethnicity = ethnicities.id) as nombreEtnia,
            (SELECT student_groups.id_group FROM student_groups WHERE student_groups.id_student = student_profile.id) as grupoid,
            (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
            (SELECT cohorts.name FROM cohorts WHERE groups.id_cohort = cohorts.id) as cohorte
            FROM student_profile, socioeconomic_data, student_groups, groups
            WHERE student_profile.id = socioeconomic_data.id_student 
            AND student_groups.id_student = student_profile.id 
            AND student_groups.id_group = groups.id
        ");

            if ($perfilEstudiantes != null) {
                return $perfilEstudiantes;
            }else{
                return null;
            }
    }

    public function static consultaMayoriaEdad(){
        
        $mayoriaedad = DB::select("SELECT student_profile.id, student_profile.*, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad, 
            (SELECT student_groups.id_group FROM student_groups WHERE student_groups.id_student = student_profile.id) as grupoid,
            (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
            (SELECT cohorts.name FROM cohorts WHERE groups.id_cohort = cohorts.id) as cohorte,
            (SELECT birth_departaments.name FROM birth_departaments WHERE student_profile.id_birth_department = birth_departaments.id) as departamentoN,
            (SELECT birth_city.name FROM birth_city WHERE student_profile.id_birth_city = birth_city.id) as ciudadN,
            (SELECT comune.name FROM comune WHERE student_profile.id_commune = comune.id) as comuna,
            (SELECT neighborhood.name FROM neighborhood WHERE student_profile.id_neighborhood = neighborhood.id) as barrio
            FROM student_profile, socioeconomic_data, student_groups, groups
            WHERE student_profile.id = socioeconomic_data.id_student 
            AND student_groups.id_student = student_profile.id 
            AND student_groups.id_group = groups.id
            AND YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) = 18
            AND MONTH(birth_date) >= 02 AND MONTH(birth_date) <= MONTH(NOW())
        ");

        if ($mayoriaedad != null) {
            
            return $mayoriaedad;
        }else{
            return null;
        }
    }


    //RELACIONES UNO A UNO POR DEBAJO
    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla DocumentType
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<DocumentType>
    */
    public function documenttype(){
        return $this->hasOne(DocumentType::class, 'id', 'id_document_type');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla BirthCity
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<BirthCity>
    */
    public function birthcity(){
        return $this->hasOne(BirthCity::class, 'id', 'id_birth_city');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Gender
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Gender>
    */

    public function gender(){
        return $this->hasOne(Gender::class, 'id', 'id_gender');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Neighborhood
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Neighborhood>
    */

    public function neighborhood(){
        return $this->hasOne(Neighborhood::class, 'id', 'id_neighborhood');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Tutor
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Tutor>
    */

    public function tutor(){
        return $this->hasOne(Tutor::class, 'document_number', 'id_tutor');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Group
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Group>
    */

    public function group(){
        return $this->hasOne(Group::class, 'id', 'id_group');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla SocioeconomicData
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocioeconomicData>
    */

    public function socioeconomicdata(){

        return $this->hasOne(SocioeconomicData::class, 'id_student', 'id');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla AcademicDates
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<AcademicDates>
    */

    public function previousacademicdata(){

        return $this->hasOne(PreviousAcademicData::class, 'id_student', 'id');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla AdmissionScores
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<AdmissionScores>
    */

    public function admissionScores(){

        return $this->hasOne(AdmissionScores::class, 'id_student', 'id');
    }

    /**
     * Relacion con los  datos que se tiene de estudiante  
     * con la tabla grupo_estudiante
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<StudentGroup>
    */

    public function studentGroup(){
        return $this->hasOne(StudentGroup::class, 'id_student', 'id');
    }
  
    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Withdrawals
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Withdrawals>
    */  
    public function withdrawals(){

        return $this->hasOne(Withdrawals::class, 'id_student', 'id');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Condition
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Condition>
     */
    public function condition(){

        return $this->hasOne(Condition::class, 'id', 'id_state');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla SocioEducationalFollowUp
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocioEducationalFollowUp>
     */
    public function socioeducationalfollowup(){

        return $this->hasOne(SocioEducationalFollowUp::class, 'id_student', 'id');
    }
}
