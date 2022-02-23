<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignementStudents extends Model
{
    protected $table = 'asignement_students';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_asignements',
        'id_student',
    ];
}
