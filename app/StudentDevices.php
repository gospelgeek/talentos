<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentDevices extends Model
{
    protected $table = 'student_devices';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_devices',
    ];
}
