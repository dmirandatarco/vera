<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Serie;
use App\Exports\PlantillaExport;
use App\Models\Categoria;
use App\Models\Producto;
use Maatwebsite\Excel\Facades\Excel;


class PlantillaExcelCrear extends Component
{
    public $series;
    public $categorias;
    public $serie = [];
    public $categoria;
    public $cont =0;
    public $errorMessage;

    public $detallePlantilla = [];

    public function render()
    {
        return view('livewire.plantilla-excel-crear');
    }
    public function mount(){
        $this->series=Serie::all();
        $this->categorias=Categoria::orderBy('orden','asc')->get();
    }
    public function AumentarDetalle()
    {
        $this->cont++;
        if ($this->categoria != null && $this->serie != null ) {
            $categoria = Categoria::find($this->categoria);
            $series = Serie::whereIn('id', $this->serie)->get();
            $detalle = [
                'categoria_id' => $categoria->id,
                'categoria' => $categoria->abreviatura,
                'categoriaNombre' => $categoria->nombre,
                'series' => []
            ];
            foreach ($series as $serie) {
                $detalle['series'][] = [
                    'serie_id' => $serie->id,
                    'nombre' => $serie->nombre
                ];
            }
            $this->detallePlantilla[] = $detalle;
            $this->errorMessage = null;
        }
        else {
            $this->errorMessage = "Por favor, rellena la categoría y la serie.";
        }
    }
    public function ReducirDetalle($index){
        unset($this->detallePlantilla[$index]);
        $this->detallePlantilla = array_values($this->detallePlantilla);
    }
    public function register()
    {
        return Excel::download(new PlantillaExport($this->detallePlantilla), 'plantilla-movimiento.xlsx');
    }
}
