<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramOptions2 extends Model
{
    use SoftDeletes;

    protected $table = 'program_options2';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_estudiante',
        'id_programa1',
        'nota_ponderada1',
        'nota_prueba_1',
        'id_programa2',
        'nota_ponderada2',
        'nota_prueba_2',
        'id_programa3',
        'nota_ponderada3',
        'nota_prueba_3',
        'id_programa4',
        'nota_ponderada4',
        'nota_prueba_4',
        'id_programa5',
        'nota_ponderada5',
        'nota_prueba_5',
        'semestre_ingreso',
        'estado',
        'prioridad'
    ];

    protected $dates = ['delete_at'];

}