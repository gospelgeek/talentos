<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = 'campuses';

    protected $primarykey = 'id';

    protected $fillable = [
        'name',
        'code_uv',
    ];
}

