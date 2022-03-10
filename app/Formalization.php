<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formalization extends Model
{
    protected $table = 'formalizations';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'acceptance_v1',
        'acceptance_v2',
        'tablets_v1',
        'tablets_v2',
    ];
}
