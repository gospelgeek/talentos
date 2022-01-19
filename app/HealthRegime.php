<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthRegime extends Model
{
    protected $table = 'health_regimes';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
