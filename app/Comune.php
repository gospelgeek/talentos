<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comune extends Model
{
     protected $table = 'comune';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
