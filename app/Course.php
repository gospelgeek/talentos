<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $primarykey = 'id';

    protected $fillable = [
        'id', 
        'name',
        'course_code',
        'id_cohort', 
    ];

      /**
     * Relacion con los  datos que se tiene de Course  
     * con la tabla Cohort
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Cohort>
     */
    public function cohortcourse(){
        return $this->hasOne(Cohort::class, 'id', 'id_cohort');
    }
}
