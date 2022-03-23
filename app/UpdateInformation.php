<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateInformation extends Model
{
    protected $table = 'update_information';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_log',
        'changed_information',
        'new_information',
    ];
}
