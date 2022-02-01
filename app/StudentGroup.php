<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $table = 'student_groups';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_group',
    ];

     /**
     * Relacion con los  datos que se tiene de estudiante_grupo  
     * con la tabla Group
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Group>
     */
    public function group(){
        return $this->hasOne(Group::class, 'id', 'id_group');
    }

    public function student(){
        return $this->hasOne(perfilEstudiante::class, 'id', 'id_student');
    }
}
