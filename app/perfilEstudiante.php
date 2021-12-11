<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class perfilEstudiante extends Model
{
    use softDeletes;
    protected $table = 'student_profile';

    protected $primarykey = 'id';

    protected $fillable = [
        'name',
        'lastname',
        'id_document_type',
        'document_number',
        'document_expedition_date',
        'email',
        'birth_date',
        'id_birth_department',
        'id_birth_city',
        'sex',
        'id_gender',
        'cellphone',
        'phone',
        'id_commune',
        'id_neighborhood',
        'direction',
        'id_tutor',
    ];

    protected $dates = ['delete_at'];

     public function roles()

    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
