<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogosDeleteUsers extends Model
{
    protected $table = 'logs_delete_users';

    protected $primarykey = 'id';

    protected $fillable = [
        'name', 
        'email', 
        'rol',
        'ip',
        'id_user_delete',
        'name_user_delete',
        'email_user_delete',
    ];

}
