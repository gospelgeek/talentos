<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
    protected $table = 'institution_types';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
