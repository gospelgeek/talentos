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

    /**
     * Relacion con los  datos que se tiene de Role  
     * con la tabla User
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<User>
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
