<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    protected $table = 'attendance_students';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_moodle',
        'session_id',
        'grade',
        'notes',
    ];
}
