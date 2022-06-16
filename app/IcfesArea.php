<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcfesArea extends Model
{
    use SoftDeletes;
    //use Notifiable;
    
    protected $table = 'icfes_areas';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $dates = ['deleted_at'];
}
