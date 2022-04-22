<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionCourse extends Model
{
    protected $table = 'session_courses';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'attendance_id',
        'session_id',
        'sessdate',
        'lasttaken',
        'description',
        'type',
    ];
}
