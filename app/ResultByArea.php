<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultByArea extends Model
{
    use SoftDeletes;
    //use Notifiable;
    
    protected $table = 'result_by_areas';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_icfes_student',
        'id_icfes_area',
        'qualification'
    ];

    protected $dates = ['deleted_at'];
}
