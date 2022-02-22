<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignates extends Model
{
    protected $table = 'assignments';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_user',
        'id_period',
    ];
}
