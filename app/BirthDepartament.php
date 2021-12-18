<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirthDepartament extends Model
{
    protected $table = 'birth_departaments';

    protected $primarykey = 'id';
    
    protected $fillable = [
        'id',
        'name',
    ];
}
