<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CivilStatus extends Model
{
    protected $table = 'civil_statuses';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
