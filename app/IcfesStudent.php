<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcfesStudent extends Model
{
    use SoftDeletes;
    //use Notifiable;
    
    protected $table = 'icfes_students';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_icfes_test',
        'total_score'
    ];

    protected $dates = ['deleted_at'];
}
