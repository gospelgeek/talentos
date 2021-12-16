<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'tutor';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
        'lastname',
        'email',
        'id_document_type',
        'document_number',
        'birth_date',
        'cellphone',
        'occupation',
    ];

    public function documenttype(){

        return $this->hasOne(DocumentType::class, 'id', 'id_document_type')
    }
}
