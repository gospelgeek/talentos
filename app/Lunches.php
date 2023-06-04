<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use DB;

class Lunches extends Model
{
    use SoftDeletes;

    protected $table = 'lunches';

    protected $primarykey = 'id';

    protected $fillable = [
        'date',
        'number_lunches_line1',
        'number_lunches_line2',
        'number_lunches_line3',
    ];

    protected $dates = ['delete_at'];
    
    //ultimo registro
    public static function ultimo_lunche(){
        $data = DB::select('
                select *
                from lunches
                order by id desc
                limit 1
            ');

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //
    //ultimo lunche actualizado
    public static function lunches_update_ultimo(){
        $data = DB::select("select * FROM `logs_crud_actions` 
                WHERE logs_crud_actions.actividad_realizada = 'SE ACTUALIZO UN REGISTRO DE ALMUERZOS'
                order by id desc
                limit 1"
            );

        if($data !=null){
            return $data;
        }else{
            return null;
        }
    }
    //
}
