<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student_group',
        'id_course',
    ];

    /**
     * Relacion con los  datos que se tiene de enrollments  
     * con la tabla StudentGroup
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<StudentGroup>
     */
    public function studentgroup(){
        return $this->hasOne(StudentGroup::class, 'id', 'id_student_group');
    }

    /**
     * Relacion con los  datos que se tiene de enrollments  
     * con la tabla Course
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Course>
     */
    public function coursematricula(){
        return $this->hasOne(Course::class, 'id', 'id_course');
    }
}
