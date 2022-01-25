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
    ];

    protected $dates = ['delete_at'];
    
    //Relaciones uno a uno por debajo

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
}