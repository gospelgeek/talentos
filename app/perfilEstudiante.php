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
        'landline',
        'cellphone',
        'phone',
        'id_neighborhood',
        'student_code',
        'college',
        'registration_date',
        'direction',
        'id_group',
        'id_cohort',
        'id_tutor',
        'id_state',
    ];

    protected $dates = ['delete_at'];

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
        return $this->hasOne(Tutor::class, 'id', 'id_tutor');
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

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla Formalization
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Formalization>
     */
    public function formalization(){

        return $this->hasOne(Formalization::class, 'id_student', 'id');
    }

    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla StudentDevices
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<StudentDevices>
     */
    public function studentdevices(){

        return $this->hasMany(StudentDevices::class, 'id_student', 'id');
    }

    public static function Estudiantes_cohort_linea1(){

        $estudiantes = DB::select("select student_profile.id,student_profile.name,
                                          student_profile.lastname,
                                          student_profile.document_number,
                                          student_profile.id_moodle,groups.id as grupo,
                                          groups.name as grupo_name
                                   from   student_profile,student_groups,groups
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 1
                                   and    student_profile.deleted_at is null");
        if($estudiantes != null){
            return $estudiantes;
        }else{
            return null;
        }
    }
    public static function Estudiantes_cohort_linea2(){

        $estudiantes = DB::select("select student_profile.id,student_profile.name,
                                          student_profile.lastname,
                                          student_profile.document_number,
                                          student_profile.id_moodle,groups.id as grupo,
                                          groups.name as grupo_name
                                   from   student_profile,student_groups,groups
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 2
                                   and    student_profile.deleted_at is null");
        if($estudiantes != null){
            return $estudiantes;
        }else{
            return null;
        }
    }
    public static function Estudiantes_cohort_linea3(){

        $estudiantes = DB::select("select student_profile.id,student_profile.name,
                                          student_profile.lastname,
                                          student_profile.document_number,
                                          student_profile.id_moodle,groups.id as grupo,
                                          groups.name as grupo_name
                                   from   student_profile,student_groups,groups
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 3
                                   and    student_profile.deleted_at is null");
        if($estudiantes != null){
            return $estudiantes;
        }else{
            return null;
        }
    }
}
