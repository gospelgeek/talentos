<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Withdrawals extends Model
{
    use SoftDeletes;
    protected $table = 'withdrawals';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_reasons',
        'observation',
        'url',
        'fecha',
    ];
    protected $dates = ['delete_at'];
    
    //Ultimo registro de actualizacion de estado
    public static function ultimo_registro(){

        $data = DB::select('
                select *
                from withdrawals
                order by id desc
                limit 1;'
            );
        
        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //
    
    public static function febrero(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 2");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function marzo(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 3");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function abril(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 4");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function mayo(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 5");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function junio(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 6");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function julio(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 7");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    public static function agosto(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 8");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    /*public static function septiembre(){
        $data = DB::select("select student_profile.id ,student_profile.name, student_profile.lastname, student_profile.id_document_type, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_groups.id_group as groupid, groups.name as grupo, cohorts.name as cohorte, assignment_students.id_user as id_profesional, CONCAT(users.name,' ', users.apellidos_user) encargado, conditions.name as condicion, withdrawals.id_reasons as id_motivo, reasons.name as motivo, withdrawals.fecha as fecha, withdrawals.observation as observacion, withdrawals.url as url, withdrawals.created_at
            FROM student_profile
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN conditions ON conditions.id = student_profile.id_state
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id 
            INNER JOIN reasons ON reasons.id = withdrawals.id_reasons
            WHERE student_groups.deleted_at IS null
            AND assignment_students.deleted_at IS null
            AND MONTH(withdrawals.created_at) = 9");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }*/
    /**
     * Relacion con los  datos que se tiene de Withdrawals  
     * con la tabla Reasons
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Reasons>
     */
    public function reasons(){

        return $this->hasOne(Reasons::class, 'id', 'id_reasons');
    }
}
