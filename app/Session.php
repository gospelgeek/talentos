<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use DB;

class Session extends Model
{
    use SoftDeletes;

    protected $table = 'sessions';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_group',
        'id_course',
        'date_session',
    ];

    protected $dates = ['delete_at'];


    //consultas sesiones
    public static function sesiones_linea1(){
        $data = DB::select("select sessions.id, sessions.id_group, sessions.id_course, sessions.date_session, cohorts.id as idcohorte, cohorts.name as linea, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group BETWEEN 1 AND 40
            AND sessions.deleted_at IS null");

        if($data != null) {
            return $data;
        }else{
            return null;
        }

    }

    public static function sesiones_linea2(){
        $data = DB::select("select sessions.id, sessions.id_group, sessions.id_course, sessions.date_session, cohorts.id as idcohorte, cohorts.name as linea, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group BETWEEN 1004 AND 1044
            AND sessions.deleted_at IS null");

        if($data != null) {
            return $data;
        }else{
            return null;
        }

    }

    public static function sesiones_linea3(){
        $data = DB::select("select sessions.id, sessions.id_group, sessions.id_course, sessions.date_session, cohorts.id as idcohorte, cohorts.name as linea, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group BETWEEN 50 AND 89
            AND sessions.deleted_at IS null");

        if($data != null) {
            return $data;
        }else{
            return null;
        }

    }

    public static function grupos($grupo){
        $data = DB::select("select sessions.id, sessions.id_group, sessions.id_course, sessions.date_session, cohorts.id as idcohorte, cohorts.name as linea, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group = '".$grupo."'
            AND sessions.deleted_at IS null");

        if($data != null) {
            return $data;
        }else{
            return null;
        }

    }

    public static function general($grupo, $curso){
        $data = DB::select("select sessions.id, sessions.id_group, sessions.id_course, sessions.date_session, cohorts.id as idcohorte, cohorts.name as linea, groups.name as grupo, courses.name as asignatura
            FROM sessions
            INNER JOIN groups ON groups.id = sessions.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN courses ON courses.id = sessions.id_course
            WHERE sessions.id_group = '".$grupo."'
            AND sessions.id_course = '".$curso."'
            AND sessions.deleted_at IS null"
            );

        if($data != null) {
            return $data;
        }else{
            return null;
        }

    }


    /**
     * Relacion con los  datos que se tiene de Session  
     * con la tabla Group
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Group>
     */
    public function sesionGroup(){
        return $this->hasOne(Group::class, 'id', 'id_group');
    }

    /**
     * Relacion con los  datos que se tiene de Sesion  
     * con la tabla course
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Course>
     */
    public function sesionCourse(){
        return $this->hasOne(Course::class, 'id', 'id_course');
    }
}
