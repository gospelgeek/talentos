<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class perfilEstudiante extends Model
{
    use softDeletes;

    protected $table = 'perfil_estudiante';

    protected $primarykey = 'id';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'departamento_nacimiento',
        'ciudad_nacimiento',
        'sexo',
        'genero',
        'departamento_residencia',
        'ciudad_residencia',
        'barrio_residencia',
        'direccion',
        'email',
        'telefono1',
        'telefono2',
    ];

    protected $dates = ['delete_at'];
}
