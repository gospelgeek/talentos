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
        'special_requirements',
        'mental_health',
    ];

    protected $dates = ['delete_at'];
}
