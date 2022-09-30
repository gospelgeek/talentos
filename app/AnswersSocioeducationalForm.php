<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class AnswersSocioeducationalForm extends Model
{
    protected $table = 'answers_socioeducational_forms';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_question',
        'answers',
        'date_diligence',
        'try',
        'score',
    ];

    /**
     * Relacion con los  datos que se tiene de SocioeconomicData  
     * con la tabla SocioeducationalForm
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocioeducationalForm>
     */
    public function socioeducationalform(){

        return $this->hasOne(SocioeducationalForm::class, 'id', 'id_question');
    }

}
