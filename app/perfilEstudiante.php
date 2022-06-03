<?php

namespace App;
use Auth;

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
        'id_birth_department',
        'sex',
        'id_gender',
        'landline',
        'cellphone',
        'phone',
        'id_commune',
        'id_neighborhood',
        'student_code',
        'college',
        'registration_date',
        'direction',
        'id_group',
        'id_cohort',
        'id_tutor',
        'id_moodle',
        'id_state',
        'first_name',
        'emergency_contact',
        'emergency_contact_name',
        'relationship',
    ];

    protected $dates = ['delete_at'];
    
   //consultas estudiantes asignacion
    public static function estudiantes_asignacion(){
        

        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND assignment_students.id_user = '".Auth::user()->id."'
            ");

        if($data != null){
            return $data;
        }else{
            return null;
        }

    }
    //

    //Consulta estudiantes admitidos asignacion
     public static function estudiantes_admitidos_asignacion(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN formalizations on formalizations.id_student = student_profile.id
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND formalizations.acceptance_v1 IS null AND formalizations.acceptance_v2 IS null
            AND student_profile.id_state != 2
            AND student_profile.id_state != 3
            AND student_profile.id_state != 5
            AND assignment_students.id_user = '".Auth::user()->id."'
            ");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //

    //Consulta estudiantes activos asignacion
     public static function estudiantes_activos_asignacion(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, 
                student_profile.document_number, student_profile.student_code, 
                student_profile.email,student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as
                grupoid,groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado,
                formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
                FROM student_profile
                INNER JOIN student_groups ON student_groups.id_student = student_profile.id
                INNER JOIN groups ON groups.id = student_groups.id_group
                INNER JOIN cohorts on cohorts.id = groups.id_cohort
                INNER JOIN conditions on conditions.id = student_profile.id_state
                INNER JOIN formalizations on formalizations.id_student = student_profile.id 
                INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
                INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
                WHERE student_groups.deleted_at IS null
                AND student_profile.id_state != 2 
                AND student_profile.id_state != 3
                AND student_profile.id_state != 5
                AND (formalizations.acceptance_v1 IS NOT null OR formalizations.acceptance_v2 IS NOT null)
                AND assignment_students.id_user = '".Auth::user()->id."'
                ");

            if($data != null){
                return $data;
            }else{
                return null;
            }        
    }
    //

    //consulta inactivos asignacion
    public static function estudiantes_inactivos_asignacion(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state 
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            INNER JOIN formalizations on formalizations.id_student = student_profile.id
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND student_profile.id_state != 1
            AND student_profile.id_state != 4
            AND assignment_students.id_user = '".Auth::user()->id."'
            ");

        if($data != null){
            return $data;
        }else{
                return null;
        }    
    }
    //

    //consulta que trae todos los estudiantes 
    public static function estudiantes(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone,  student_profile.id_state, student_profile.first_name, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            ");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    //estudiantes admitidos
    public static function estudiantes_admitidos(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_profile.id_state, student_profile.first_name,  student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN formalizations on formalizations.id_student = student_profile.id
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND formalizations.acceptance_v1 IS null AND formalizations.acceptance_v2 IS null
            AND student_profile.id_state != 2
            AND student_profile.id_state != 3
            AND student_profile.id_state != 5");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //

    //Estudiantes activos
    public static function estudiantes_activos(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, 
                student_profile.document_number, student_profile.student_code, 
                student_profile.email,student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as
                grupoid,groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado,
                formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
                FROM student_profile
                INNER JOIN student_groups ON student_groups.id_student = student_profile.id
                INNER JOIN groups ON groups.id = student_groups.id_group
                INNER JOIN cohorts on cohorts.id = groups.id_cohort
                INNER JOIN conditions on conditions.id = student_profile.id_state
                INNER JOIN formalizations on formalizations.id_student = student_profile.id 
                INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
                WHERE student_groups.deleted_at IS null
                AND student_profile.id_state != 2 
                AND student_profile.id_state != 3
                AND student_profile.id_state != 5
                AND (formalizations.acceptance_v1 IS NOT null OR formalizations.acceptance_v2 IS NOT null)"
            );

            if($data != null){
                return $data;
            }else{
                return null;
            }        
    }
    //

    //estudiantes inactivos
    public static function estudiantes_inactivos(){
        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_profile.id_state, student_profile.first_name, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, socioeconomic_data.eps_name as eps
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state 
            INNER JOIN socioeconomic_data ON socioeconomic_data.id_student = student_profile.id
            INNER JOIN formalizations on formalizations.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND student_profile.id_state != 1
            AND student_profile.id_state != 4");

        if($data != null){
            return $data;
        }else{
                return null;
        }    
    }
    //

    //consulta que trae estudiantes que cumplen lña mayoria deedad durante el proceso
    public static function mayoriaEdad(){

        $consulta = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.student_code, student_profile.birth_date, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort    
            WHERE student_groups.deleted_at IS null
            AND MONTH(birth_date) BETWEEN 02 AND MONTH(NOW())
            AND YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) = 18
            AND student_profile.id_state = 1
            AND YEAR(birth_date) = 2004");

        if($consulta != null){
            return $consulta;
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
    
   /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla AssignmentStudent
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<AssignmentStudent>
    */
    public function assignmentstudent(){
        return $this->hasOne(AssignmentStudent::class, 'id_student', 'id');
    }
    
    /**
     * Relacion con los  datos que se tiene de student_profile  
     * con la tabla HealthCondition
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<HealthCondition>
    */
    public function healthcondition(){
        return $this->hasOne(HealthCondition::class, 'id_student', 'id');
    }
    
    public static function Estudiantes_cohort_linea1(){

        $estudiantes = DB::select("select student_profile.id,student_profile.name,
                                          student_profile.lastname,
                                          student_profile.document_number,
                                          student_profile.id_moodle,groups.id as grupo,
                                          groups.name as grupo_name,
                                          CONCAT(users.name,' ', users.apellidos_user) encargado
                                   from   student_profile,student_groups,groups,assignment_students,users
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 1
                                   and    student_profile.deleted_at is null
                                   and    student_profile.id = assignment_students.id_student
                                   and    assignment_students.id_user = users.id
                                   and    assignment_students.deleted_at is null");
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
                                          groups.name as grupo_name,
                                          CONCAT(users.name,' ', users.apellidos_user) encargado
                                   from   student_profile,student_groups,groups,assignment_students,users
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 2
                                   and    student_profile.deleted_at is null
                                   and    student_profile.id = assignment_students.id_student
                                   and    assignment_students.id_user = users.id
                                   and    assignment_students.deleted_at is null");
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
                                          groups.name as grupo_name,
                                          CONCAT(users.name,' ', users.apellidos_user) encargado
                                   from   student_profile,student_groups,groups,assignment_students,users
                                   where  student_profile.id = student_groups.id_student
                                   and    groups.id = student_groups.id_group
                                   and    groups.id_cohort = 3
                                   and    student_profile.deleted_at is null
                                   and    student_profile.id = assignment_students.id_student
                                   and    assignment_students.id_user = users.id
                                   and    assignment_students.deleted_at is null");
        if($estudiantes != null){
            return $estudiantes;
        }else{
            return null;
        }
    }
}
