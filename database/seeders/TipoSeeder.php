<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;


class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create([
            'id'                =>  '1',
            'nombre'            =>  'Transferencia Egreso',
            'tipo'              =>  '2',
            'proveedor'         =>  '0',
            'almacen'           =>  '1',
            'documento'         =>  '0',
            'estado'            =>  '1',

        ]);
        Tipo::create([
            'id'                =>  '2',
            'nombre'            =>  'Transferencia Ingreso',
            'tipo'              =>  '1',
            'proveedor'         =>  '0',
            'almacen'           =>  '1',
            'documento'         =>  '0',
            'estado'            =>  '1',

        ]);
        Tipo::create([
            'id'                =>  '3',
            'nombre'            =>  'Ingreso Directo',
            'tipo'              =>  '1',
            'proveedor'         =>  '0',
            'almacen'           =>  '0',
            'documento'         =>  '0',
            'estado'            =>  '1',

        ]);
    }
}
