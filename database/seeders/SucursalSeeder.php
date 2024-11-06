<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Sucursal::create([
            'id'            => '1',
            'nombre'        => 'ZOLUX CUSCO',
            'direccion'     =>  0,
            'estado'        =>  1,
        ]);

    }
}
