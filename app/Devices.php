<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
    {
        protected $table = 'devices';

        protected $primarykey = 'id';

        protected $fillable = [
            'id',
            'name',
            'description',
        ];
    }
}
