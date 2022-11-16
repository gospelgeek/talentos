<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programs extends Model
{
    use SoftDeletes;

    protected $table = 'programs';

    protected $primarykey = 'id';

    protected $fillable = [
        'code_program', 
        'name_program',
        'working_day',
        'critical_reading_weight',
        'weighting_mathematics',
        'weighting_social',
        'weighting_natural',
        'weighting_english',
        'weighting_test_specific',
        'quotas_I_2023',
        'remaining_quotas_I_2023',
        'quotas_II_2023',
        'remaining_quotas_II_2023',
        'iteration_group', 
    ];

    protected $dates = ['delete_at'];
}
