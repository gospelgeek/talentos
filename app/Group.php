<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'id_cohort',
        'admission_date',
    ];

    /**
     * Relacion con los  datos que se tiene de Group  
     * con la tabla cohorte
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Cohort>
     */
    public function cohort(){
        return $this->hasOne(Cohort::class, 'id', 'id_cohort');
    }

    public function course(){
        return $this->hasOne(Course::class, 'id_cohort', 'id_cohort');
    }
}
