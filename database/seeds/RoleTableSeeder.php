<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
          'id' => '1',
          'nombre_rol'  =>'sistemas',
          'descripcion' => 'Sistemas',            
        ]);
        Role::create([
          'id' => '2',
          'nombre_rol'  =>'socioeducativo',
          'descripcion' =>'Socioeducativo',            
        ]);
        Role::create([
          'id' => '3',
          'nombre_rol'  =>'academico',
          'descripcion' => 'Seguimineto academico',            
        ]);
        Role::create([
          'id' => '4',
          'nombre_rol'=>'seguimiento administrativo',
          'descripcion' => 'Seguimineto administrativo',            
        ]);
        Role::create([
          'id' => '5 ',
          'nombre_rol'=>'reportes',
          'descripcion' => 'Auditor/reportes',            
        ]);
    }
}
