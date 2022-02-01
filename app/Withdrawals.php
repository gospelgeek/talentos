<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawals extends Model
{
    protected $table = 'withdrawals';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_reasons',
        'observation',
    ];

    /**
     * Relacion con los  datos que se tiene de Withdrawals  
     * con la tabla Reasons
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Reasons>
     */
    public function reasons (){

        return $this->hasOne(Reasons::class, 'id', 'id_reasons');
    }
}
