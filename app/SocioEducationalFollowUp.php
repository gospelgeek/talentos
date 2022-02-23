<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class SocioEducationalFollowUp extends Model
{
    use SoftDeletes;
    //use Notifiable;

    protected $table = 'socio_educational_follow_ups';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_user',
        'tracking_detail', 
    ];

    protected $dates = ['delete_at'];


    /**
     * Relacion con los  datos que se tiene de SocioEducationalFollowUp  
     * con la tabla student_profile
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<student_profile>
     */
    public function perfilEstudiantesegui(){

        return $this->belongsTo(perfilEstudiante::class, 'id', 'id_student');
    }
}
