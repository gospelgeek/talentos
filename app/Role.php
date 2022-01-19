<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $table = 'roles';

    protected $primarykey = 'id';

    protected $fillable = [
        'nombre_rol', 
        'descripcion', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
