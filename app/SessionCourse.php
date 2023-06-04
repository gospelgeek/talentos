<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
    
    public static function fecha_carga(){
        $data = DB::select('
            select session_courses.created_at
            from session_courses
            WHERE session_courses.id = 1
            ');

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
}
