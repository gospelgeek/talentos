<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
     protected $table = 'gender';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
