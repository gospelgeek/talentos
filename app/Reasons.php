<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reasons extends Model
{
    protected $table = 'reasons';

    protected $primarykey = 'id';

    protected $fillable = [
        'id', 
        'name', 
    ];
}
