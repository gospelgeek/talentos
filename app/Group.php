<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'id_student',
        'id_cohort',
        'admission_date',
    ];
}
