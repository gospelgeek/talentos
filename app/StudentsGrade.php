<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentsGrade extends Model
{
    protected $table = 'students_grades';

    protected $primarykey = 'id';

    protected $fillable = [
            'item_id',
            'id_moodle',
            'grade',
    ];
}
