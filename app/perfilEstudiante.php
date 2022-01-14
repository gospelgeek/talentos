<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use DB;


class perfilEstudiante extends Model
{
    use softDeletes;
    
    protected $table = 'student_profile';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'lastname',
        'id_document_type',
        'document_number',
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
        'id_tutor',
    ];

    protected $dates = ['delete_at'];

    //relaciones uno a uno por debajo
    public function documenttype(){

        return $this->hasOne(DocumentType::class, 'id', 'id_document_type');
    }

    public function birthcity(){
        return $this->hasOne(BirthCity::class, 'id', 'id_birth_city');
    }

    public function gender(){
        return $this->hasOne(Gender::class, 'id', 'id_gender');
    }

    public function neighborhood(){
        return $this->hasOne(Neighborhood::class, 'id', 'id_neighborhood');
    }

    public function tutor(){
        return $this->hasOne(Tutor::class, 'document_number', 'id_tutor');
    }

    public function socioeconomicdata(){

        return $this->hasOne(SocioeconomicData::class, 'id_student', 'id');
    }

    public function academicdata(){

        return $this->hasOne(AcademicDates::class, 'id_student', 'id');
    }
}

