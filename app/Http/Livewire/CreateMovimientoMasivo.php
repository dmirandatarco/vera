<?php

namespace App\Http\Livewire;

use App\Imports\MovimientoImport;
use App\Models\Almacen;
use App\Models\Movimiento;
use App\Models\Tipo;
use Livewire\Component;
use Livewire\WithFileUploads;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class CreateMovimientoMasivo extends Component
{
    use WithFileUploads;
    public $tipos;
    public $almacenes;
    public $condAlmacen=0;
    public $documentoo = 0;
    public $tipo_movimiento;
    public $almacen_id;
    public $almacen_2;
    public $tipo_doc='NINGUNO';
    public $nro_doc;
    public $fecha;
    public $archivo;
    public function mount(){
        $this->tipos = Tipo::where('proveedor',0)->where('estado',1)->get();
        $this->almacenes = Almacen::where('estado',1)->get();
    }
    public function updatedtipomovimiento($id){
        $movimiento = Tipo::find($id);
        $almacen = Almacen::where('predeterminada',1)->first();
        if($movimiento){
            $this->condAlmacen=$movimiento->almacen;
            $this->documentoo=$movimiento->documento;
            if($movimiento->almacen==0){
                $this->almacen_id = $almacen->id;
                $this->emit('Encontrar',$almacen->id);
            }else{
                $this->almacen_id = '';
                $this->emit('sinEncontrar',$almacen->id);
            }
        }
    }
    public function render()
    {
        return view('livewire.create-movimiento-masivo');
    }
    public function register()
    {
        try
        {
            DB::beginTransaction();
            $this->validate([
                'tipo_movimiento'           => 'required|exists:tipos,id',
                'almacen_id'                => 'required|exists:almacens,id',
                'almacen_2'                   => 'nullable|exists:almacens,id',
                'nro_doc'                   => 'nullable|max:150',
                'fecha'                   =>    'required|date',
                'archivo'                   => 'required|file|mimes:xls,xlsx,csv',
            ]);
            $tipomovimiento = Tipo::find($this->tipo_movimiento);
            $tipo=$tipomovimiento->tipo;
            $fechaConHoraActual = Carbon::createFromFormat('Y-m-d', $this->fecha)->setTimeFrom(Carbon::now());
            if($this->condAlmacen==0){
                $movimiento = Movimiento::create([
                    'sucursal_id' => 1,
                    'almacen_id' => $this->almacen_id,
                    'tipo_id' => $this->tipo_movimiento,
                    'user_id' => \Auth::user()->id,
                    'almacen_2' => $this->almacen_2,
                    'tipo_doc' => $this->tipo_doc,
                    'nume_doc' => $this->nro_doc,
                    'fecha' => $fechaConHoraActual
                ]);
                Excel::import(new MovimientoImport($movimiento->id,$tipo,$movimiento->almacen_id), $this->archivo);
            }else{
                $movimiento = Movimiento::create([
                    'sucursal_id' => 1,
                    'almacen_id' => $this->almacen_id,
                    'tipo_id' => $this->tipo_movimiento,
                    'user_id' => \Auth::user()->id,
                    'tipo_doc' => $this->tipo_doc,
                    'nume_doc' => $this->nro_doc,
                    'fecha' => $fechaConHoraActual
                ]);
                Excel::import(new MovimientoImport($movimiento->id,$tipo,$movimiento->almacen_id), $this->archivo);
                if($tipo==1){
                    $tipomovimiento = Tipo::where('tipo',0)->where('almacen',1)->first();
                    $tipo=$tipomovimiento->tipo;
                }else{
                    $tipomovimiento = Tipo::where('tipo',1)->where('almacen',1)->first();
                    $tipo=$tipomovimiento->tipo;
                }
                $movimiento2 = Movimiento::create([
                    'sucursal_id' => 1,
                    'almacen_id' => $this->almacen_2,
                    'tipo_id' => $tipomovimiento->id,
                    'user_id' => \Auth::user()->id,
                    'movimiento_id' => $movimiento->id,
                    'tipo_doc' => $this->tipo_doc,
                    'nume_doc' => $this->nro_doc,
                    'fecha' => $fechaConHoraActual
                ]);
                $movimiento->movimiento_id = $movimiento2->id;
                $movimiento->save();
                Excel::import(new MovimientoImport($movimiento2->id,$tipo,$movimiento2->almacen_id), $this->archivo);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('movimiento.index')
            ->with('success', 'Movimiento Agregado Correctamente.');
    }
}
