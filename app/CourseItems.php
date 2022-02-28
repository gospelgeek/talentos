<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseItems extends Model
{
    protected $table = 'course_items';

        protected $primarykey = 'id';

        protected $fillable = [
            'id',
            'id_course',
            'name_items',
            'weight_items',
            'description',
        ];
    }

     /**
     * Relacion con los  datos que se tiene de CourseItems  
     * con la tabla Course
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Course>
     */
    public function coursecourseitems(){
        return $this->hasOne(Course::class, 'id', 'id_course');
    }
}
