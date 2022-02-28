<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $table = 'disabilities';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
