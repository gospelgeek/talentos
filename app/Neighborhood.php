<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    protected $table = 'neighborhood';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'id_commune',
    ];
    
    /**
     * Relacion con los  datos que se tiene de Neighborhood  
     * con la tabla Comune
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Comune>
     */
    public function comune(){

        return $this->hasOne(Comune::class, 'id', 'id_commune');
    }
}
