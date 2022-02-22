<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'periods';

    protected $primarykey = 'id';

    protected $fillable = [

        'name',
        'start_date',
        'end_date',
        'active',
        'id_campuses'
    ];
 }

