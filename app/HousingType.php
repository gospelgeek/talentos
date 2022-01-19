<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HousingType extends Model
{
    protected $table = 'housing_types';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
