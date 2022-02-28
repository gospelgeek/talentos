<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentStudent extends Model
{
    protected $table = 'assignment_students';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_user',
        'id_student',
        'id_periods'
    ];
}