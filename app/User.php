<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Role;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primarykey = 'id';

    protected $fillable = [
        'name', 
        'apellidos_user', 
        'tipo_documento_user', 
        'cedula', 
        'email', 
        'rol_id', 
        'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['delete_at'];

    //relacion uno a uno con tipo documento
    /**
     * Relacion con los  datos que se tiene de User  
     * con la tabla DocumentType
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<DocumentType>
     */
    public function documenttype(){

        return $this->hasOne(DocumentType::class, 'id', 'tipo_documento_user');
    }

    /**
     * Relacion con los  datos que se tiene de User  
     * con la tabla Role
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<Role>
     */
    public function roles(){
        return $this->hasOne(Role::class, 'id','rol_id');
    }


    public function authorizeRoles($roles){
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }
    /*public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                 return true; 
            }   
        }
        return false;
    }
    
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }*/

    public static function getRealIP(){

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
        return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
        return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
        return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
        return $_SERVER["REMOTE_ADDR"];
        }
    }
}
