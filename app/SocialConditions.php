<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialConditions extends Model
{
    protected $table = 'social_conditions';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
