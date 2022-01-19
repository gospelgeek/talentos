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

    public function comune(){

        return $this->hasOne(Comune::class, 'id', 'id_commune');
    }
}
