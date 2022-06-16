<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcfesTest extends Model
{
    use SoftDeletes;
    //use Notifiable;
    
    protected $table = 'icfes_tests';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    protected $dates = ['deleted_at'];
}
