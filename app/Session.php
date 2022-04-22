<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

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
