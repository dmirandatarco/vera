<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Almacen;


class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Almacen::create([
            'id'            => '1',
            'nombre'        => 'Almacen Principal',
            'predeterminada'=>  1,
            'sucursal_id'      =>  1,
            'estado'        =>  1,
        ]);
    }
}
