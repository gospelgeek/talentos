<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirthCity extends Model
{
     protected $table = 'birth_city';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'id_departament',
    ];

    /**
     * Relacion con los datos que se tiene de BirthCity  
     * con la tabla BirthDepartament
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<BirthDepartament>
     */
    public function birthdepartament(){
        
        return $this->hasOne(BirthDepartament::class, 'id', 'id_departament');
    }
}
