<?php

namespace App;
use DB;

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
    
    public static function fecha_carga(){
        $data = DB::select('
            select students_grades.created_at
            from students_grades
            WHERE students_grades.id = 1
            ');

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
}
