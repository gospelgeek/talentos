<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SessionCourse;
use DB;

class CourseMoodle extends Model
{
    protected $table = 'course_moodles';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'fullname',
        'course_id',
        'instance_id',
        'attendance_id',
        'group_id',
        'docente_id',
    ];

    public function sesiones()
    {
        return $this->hasMany(SessionCourse::class, 'attendance_id','attendance_id');
    }

    public static function asistencias_virtuales($id_group,$id_moodle,$fecha_inicial,$fecha_final){
        if($fecha_final != null && $fecha_final != null){
            $asistencias = DB::select("select course_moodles.id,course_moodles.fullname,COUNT(*) as Total 
                            FROM `course_moodles`,session_courses,attendance_students 
                            WHERE session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and session_courses.sessdate between '".$fecha_inicial."' 
                            and '".$fecha_final."'
                            and (attendance_students.grade = 'P' or attendance_students.grade = 'R')
                            and attendance_students.id_moodle = '".$id_moodle."'
                            and DAYNAME(session_courses.sessdate) != 'Saturday' 
                            GROUP BY course_moodles.fullname
                            ");
        }else{
            $asistencias = DB::select("select course_moodles.id,course_moodles.fullname,COUNT(*) as Total 
                            FROM `course_moodles`,session_courses,attendance_students 
                            WHERE session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and attendance_students.grade = 'P' 
                            and attendance_students.id_moodle = '".$id_moodle."'
                            and DAYNAME(session_courses.sessdate) != 'Saturday' 
                            GROUP BY course_moodles.fullname");

        }

        if($asistencias != null){
            return $asistencias;
        }else{
            return null;
        }
    }

    public static function asistencias_presenciales($id_group,$id_moodle,$fecha_inicial,$fecha_final){
        if($fecha_final != null && $fecha_final != null){
            $asistencias = DB::select("select course_moodles.id,course_moodles.fullname,COUNT(*) as Total 
                            FROM `course_moodles`,session_courses,attendance_students  
                            where session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and session_courses.sessdate between '".$fecha_inicial."' 
                            and '".$fecha_final."'
                            and (attendance_students.grade = 'P' or attendance_students.grade = 'R')
                            and attendance_students.id_moodle = '".$id_moodle."'
                            and DAYNAME(session_courses.sessdate) = 'Saturday' 
                            GROUP BY course_moodles.fullname
                            ");
        }else{
            $asistencias = DB::select("select course_moodles.id,course_moodles.fullname,COUNT(*) as Total 
                            FROM `course_moodles`,session_courses,attendance_students 
                            WHERE session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and attendance_students.grade = 'P' 
                            and attendance_students.id_moodle = '".$id_moodle."'
                            and DAYNAME(session_courses.sessdate) = 'Saturday' 
                            GROUP BY course_moodles.fullname");

        }

        if($asistencias != null){
            return $asistencias;
        }else{
            return null;
        }
    }
    
    public static function fecha_carga(){
        $data = DB::select('
            select course_moodles.created_at
            from course_moodles
            WHERE course_moodles.id = 1
            ');

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    
    public static function asignaturas($grupo, $moodle){
        $data = DB::select("
                    select course_moodles.id,course_moodles.fullname,course_items.category_name,students_grades.grade
                    FROM course_moodles,course_items,students_grades
                    WHERE course_moodles.group_id = '".$grupo."'
                    and course_items.course_id = course_moodles.course_id 
                    and course_items.item_id = students_grades.item_id
                    and (course_items.item_type = 'category' or course_items.item_type = 'total curso' or course_items.category_name = 'ITEM HUERFANO')
                    and students_grades.id_moodle = '".$moodle."'");
        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    
    public static function asignaturas_items_asistencia($moodle,$course_id){
        $data = DB::select("select course_items.item_name,students_grades.grade
                    FROM course_items
                    INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                    Where students_grades.id_moodle = '".$moodle."'
                    AND course_items.item_type != 'category'
                    AND course_items.category_name like 'asistencia%'
                    AND course_items.course_id = '".$course_id."'");
        if($data != null){
            return $data;
        }else{
            return null;
        }   
    }

    public static function asignaturas_items_seguimientos($moodle,$course_id){
        $data = DB::select("select course_items.item_name,students_grades.grade
                    FROM course_items
                    INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                    Where students_grades.id_moodle = '".$moodle."'
                    AND course_items.item_type != 'category'
                    AND (course_items.category_name like 'seguimiento%' OR course_items.category_name like 'componente%'
                        OR course_items.category_name like 'actividades%' OR course_items.category_name like 'parciales%'
                        OR course_items.category_name like 'seminario%')
                    AND course_items.course_id = '".$course_id."'");
        if($data != null){
            return $data;
        }else{
            return null;
        }   
    }

    public static function asignaturas_items_autoevaluacion($moodle,$course_id){
        $data = DB::select("select course_items.item_name,students_grades.grade
                    FROM course_items
                    INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                    Where students_grades.id_moodle = '".$moodle."'
                    AND course_items.item_type != 'category'
                    AND course_items.category_name like 'auto%'
                    AND course_items.course_id = '".$course_id."'");
        if($data != null){
            return $data;
        }else{
            return null;
        }   
    }

    public static function asignaturas_items_huerfanos($moodle,$course_id){
        $data = DB::select("select course_items.item_name,students_grades.grade
                    FROM course_items
                    INNER JOIN students_grades ON students_grades.item_id = course_items.item_id
                    Where students_grades.id_moodle = '".$moodle."'
                    AND course_items.category_name = 'ITEM HUERFANO'
                    AND course_items.course_id = '".$course_id."'");
        if($data != null){
            return $data;
        }else{
            return null;
        }   
    }
}
