<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordsActionsUpdateDelete extends Model
{
    protected $table = 'records_actions_update_delete';

    protected $primarykey = 'id';

    protected $fillable = [
        'identificacion',
        'nombres',
        'apellidos',
        'email',
        'rol',
        'ip',
        'id_usuario_accion',
        'nombres_usuario_accion',
        'apellidos_usuario_accion',
        'email_usuario_accion',
        'actividad_realizada',
    ];
}
