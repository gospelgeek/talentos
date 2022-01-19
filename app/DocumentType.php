<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'document_type';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];
}
