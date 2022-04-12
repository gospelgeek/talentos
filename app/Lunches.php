<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Lunches extends Model
{
    use SoftDeletes;

    protected $table = 'lunches';

    protected $primarykey = 'id';

    protected $fillable = [
        'date',
        'number_lunches_line1',
        'number_lunches_line2',
        'number_lunches_line3',
    ];

    protected $dates = ['delete_at'];
}
