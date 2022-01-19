<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
    protected $table = 'ethnicities';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
