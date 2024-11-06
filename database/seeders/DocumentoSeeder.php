<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'razon_social' => "ZOLUX PRODUCTOS OPTICOS E.I.R.L.",
            'ruc' => "20602583474",
            'direccion' => "CAL. MATARA NRO 274 CENTRO HISTORICO",
            'sol_user' => "BSTCHUMB",
            'sol_pass' => "erstruine",
            'client_id' => null,
            'client_secret' => null,
            'distrito' => "CUSCO", 
            'provincia' => "CUSCO", 
            'departamento' => "CUSCO", 
            'ubigeo' => "080101", 
            'production' => 0,
        ]);
        
        Documento::create([
            'nombre'       =>    'NOTA DE VENTA',
            'incremento'   =>    '1',
            'cantidad'    =>    '0',
            'abreviatura'=>    'NP',
            'serie'        =>    'N001',
            'sucursal_id'        =>    '1',
        ]);
    }
}
