<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotesItems extends Model
{
    protected $table = 'notes_items';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_course_items',
        'id_enrollment',
        'value',
        'registration_date',
    ];

    /**
     * Relacion con los  datos que se tiene de NotesItems  
     * con la tabla CourseItems
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<CourseItems>
     */
    public function courseitems(){
        return $this->hasOne(CourseItems::class, 'id', 'id_course_items');
    }    

    /**
     * Relacion con los  datos que se tiene de NotesItems  
     * con la tabla Enrollment
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Enrollment>
     */
    public function enrollment(){
        return $this->hasOne(Enrollment::class, 'id', 'id_enrollment');
    }    
}
