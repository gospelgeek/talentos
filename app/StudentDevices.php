<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentDevices extends Model
{
    protected $table = 'student_devices';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_devices',
    ];

     /**
     * Relacion con los  datos que se tiene de student_devices 
     * con la tabla Devices
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Devices>
     */
    public function devices(){
        return $this->hasOne(Devices::class, 'id', 'id_devices');
    }
}
