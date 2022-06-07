<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class EconomicalSupport extends Model
{
    use SoftDeletes;

    protected $table = 'economical_supports';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'date',
        'url_banco',
        'monto',
    ];

    protected $dates = ['delete_at'];
}
