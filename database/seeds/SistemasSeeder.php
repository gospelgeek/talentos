<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role_user;

class SistemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'tipo_documento_user'=> 'Cedula Ciudadania',
            'cedula' => '123456789',
            'name' => mb_strtoupper('SISTEMAS', 'UTF-8'),
            'apellidos_user' => mb_strtoupper('SISTEMAS', 'UTF-8'),
            'email' => 'sistemas@gmail.com',
            'password' => bcrypt('&H;+$iK_&IW6'),
            'rol_id' => 1,
        ]);

        /*Role_user::create([
            'role_id' => '1',
            'user_id' => '123456789',
        ]);*/
    }
}
