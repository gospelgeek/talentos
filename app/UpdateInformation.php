<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateInformation extends Model
{
    protected $table = 'update_information';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_action',
        'changed_information',
        'new_information',
    ];
}
