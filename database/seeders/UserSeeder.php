<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'id'                =>  '1',
            'nombre'            =>  'David',
            'apellido'          =>  'Miranda Tarco',
            'tipo_documento'    =>  'DNI',
            'num_documento'     =>  '48507551',
            'celular'           =>  '982733597',
            'email'             =>  'dmirandatarco@gmail.com',
            'usuario'           =>  'david',
            'password'          =>  'ideascusco',
            'estado'            =>  '1',
            'imagen'            =>  '/storage/usuario/default.png',
            'sucursal_id'       =>  '1',
        ])->assignRole('Administrador');
        
    }
}
