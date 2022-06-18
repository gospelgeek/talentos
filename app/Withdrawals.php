<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Withdrawals extends Model
{
    use SoftDeletes;
    protected $table = 'withdrawals';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_reasons',
        'observation',
        'url',
        'fecha',
    ];
    protected $dates = ['delete_at'];
    
    //Ultimo registro de actualizacion de estado
    public static function ultimo_registro(){

        $data = DB::select('
                select *
                from withdrawals
                order by id desc
                limit 1;'
            );
        
        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //
    /**
     * Relacion con los  datos que se tiene de Withdrawals  
     * con la tabla Reasons
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Reasons>
     */
    public function reasons(){

        return $this->hasOne(Reasons::class, 'id', 'id_reasons');
    }
}
