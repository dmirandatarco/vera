<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\detalleMovimiento;
use App\Models\Producto;
use App\Models\Serie;
use App\Models\Stock;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MovimientoImport implements OnEachRow, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    public function __construct(public $movimiento,public $tipo,public $almacen)
    {
    }

    public function onRow(Row $row)
    {
        $categoria = Categoria::where('abreviatura',$row['categoria'])->first();
        $serie = Serie::where('nombre',$row['serie'])->first();

        $producto = Producto::where('categoria_id',$categoria->id)->where('nombre',$row['talla'])
        ->where('serie_id',$serie->id)->first();

        if($row['cantidad']>0 && $producto){
            $detalle = detalleMovimiento::create([
                'movimiento_id' => $this->movimiento,
                'producto_id' => $producto->id,
                'cantidad' => $row['cantidad'],
            ]);

            $stock = Stock::where('almacen_id', $this->almacen)->where('producto_id',$producto->id)->first();
            
            if($this->tipo == 1){
                $producto->stock = $producto->stock + $row['cantidad'];
                $producto->save();
                if($stock){
                    $stock->cantidad = $stock->cantidad + $row['cantidad'];
                    $stock->save();
                }else{
                    $stock=Stock::create([
                        'almacen_id' => $this->almacen,
                        'producto_id' => $producto->id,
                        'cantidad' => $row['cantidad'],
                    ]);
                }
            }else{
                $producto->stock = $producto->stock - $row['cantidad'];
                $producto->save();
                if($stock){
                    $stock->cantidad = $stock->cantidad - $row['cantidad'];
                    $stock->save();
                }else{
                    $stock=Stock::create([
                        'almacen_id' => $this->almacen,
                        'producto_id' => $producto->id,
                        'cantidad' => $row['cantidad'],
                    ]);
                }
            }
        }
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
        ];
    }
}
