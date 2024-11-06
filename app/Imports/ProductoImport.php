<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Serie;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductoImport implements OnEachRow, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    public function onRow(Row $row)
    {
        $categoria = Categoria::where('abreviatura',$row['categoria'])->first();
        $serie = Serie::where('nombre',$row['serie'])->first();

        $texto_limpiado_categoria = preg_replace('/[\s.]+/', '', $categoria->abreviatura);
        $texto_limpiado_talla = preg_replace('/[\s.]+/', '', $row['talla']);

        $producto= Producto::firstOrCreate([
            'categoria_id' => $categoria->id,
            'nombre' => $row['talla'],
            'serie_id' => $serie->id,
            'codigo' => $texto_limpiado_categoria . $texto_limpiado_talla,
        ],[
            'precio' => $row['precio'],
            'precio_compra' => 0,
            'stock' => 0,
        ]);
    }

    public function batchSize(): int
    {
        return 4000;
    }
    
    public function chunkSize(): int
    {
        return 4000;
    }

    public function rules(): array
    {
        return [
            '*.categoria' => 'required',
            '*.serie' => 'required',
            '*.talla' => 'required',
            '*.precio' => 'required',
        ];
    }
}
