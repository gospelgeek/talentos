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
}
