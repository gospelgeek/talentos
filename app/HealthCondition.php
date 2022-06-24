<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class HealthCondition extends Model
{
    use SoftDeletes;

    protected $table = 'health_conditions';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'employee',
        'physical_health',
        'mental_health',
        'psychosocial_risk',
    ];

    protected $dates = ['delete_at'];
}
