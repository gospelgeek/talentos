<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $table = 'occupations';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
