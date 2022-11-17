<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculties extends Model
{
    protected $table = 'faculties';

    protected $primarykey = 'id';

    protected $fillable = [
        'name',
    ];
}
