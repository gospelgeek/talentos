<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocioeducationalForm extends Model
{
    protected $table = 'socioeducational_forms';

    protected $primarykey = 'id';

    protected $fillable = [
        'question',  
    ];
}
