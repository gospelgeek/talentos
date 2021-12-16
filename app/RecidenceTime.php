<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecidenceTime extends Model
{
    protected $table = 'recidence_times';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
