<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogsCrudActions extends Model
{
    protected $table = 'logs_crud_actions';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'rol',
        'ip',
        'id_usuario_accion',
        'actividad_realizada',
    ];

}
