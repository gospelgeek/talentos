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

    /**
     * Relacion con los  datos que se tiene de AssignmentStudent  
     * con la tabla student_profile
     * 
     * @author Juan Sebastian Gomez Mezu <juan.mezu@correounivalle.edu.co>
     * @return Collection<perfilEstudiante>
    */

    public function StudentInfo(){
        return $this->hasOne(perfilEstudiante::class, 'id', 'id_student');
    }

    /**
     * Relacion con los  datos que se tiene de AssignmentStudent  
     * con la tabla users
     * 
     * @author Juan Sebastian Gomez Mezu <juan.mezu@correounivalle.edu.co>
     * @return Collection<User>
    */

    public function UserInfo(){
        return $this->hasOne(User::class, 'id', 'id_user');
    } 
}