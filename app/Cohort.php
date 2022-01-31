<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
     protected $table = 'cohorts';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    
}
