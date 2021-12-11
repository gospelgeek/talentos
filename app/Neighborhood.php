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
}
