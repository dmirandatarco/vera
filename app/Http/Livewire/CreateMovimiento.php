<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Serie;

use App\Models\Tipo;
use App\Models\Movimiento;
use App\Models\detalleMovimiento;
use App\Models\Stock;
use Livewire\Component;
use DB;
use Carbon\Carbon;

class CreateMovimiento extends Component
{
    public $preciodetalle=0.00;
    public $cantidaddetalle=0;
    public $almacenes;
    public $condAlmacen=0;
    public $documentoo = 0;
    public $producto;
    public $cont =0;
    public $detalleMovimiento = [];
    public $total=0.00;
    public $tipo_movimiento;
    public $nro_doc;
    public $fecha;
    public $proveedor;
    public $tipos;
    public $proveedores;
    public $categoria;
    public $serie;
    public $almacen_id;
    public $almacen_2;
    public $tipo_doc='NINGUNO';

    public $categorias;
    public $series;

    public $productos=[];
    public $buscarProducto='';

    public function mount(){
        $this->almacenes = Almacen::where('estado',1)->get();
        $this->tipos=Tipo::where('estado',1)->get();
        $this->proveedores=Proveedor::where('estado',1)->get();
        $this->categorias=Categoria::orderBy('orden','asc')->get();
        $this->series=Serie::all();
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
        return view('livewire.create-movimiento');
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
                $this->calcularStock($this->detalleMovimiento,$movimiento,$tipo);
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
                $this->calcularStock($this->detalleMovimiento,$movimiento,$tipo);
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
                $this->calcularStock($this->detalleMovimiento,$movimiento2,$tipo);
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

    public function ReducirCantidad(){
        if($this->cantidaddetalle != 0)
        {
            $this->cantidaddetalle--;
        }
    }
    public function AumentarCantidad(){
        $this->cantidaddetalle++;
    }
    public function AumentarMovimiento()
    {
        $this->cont++;
        if ($this->producto != null) {
            $producto = Producto::find( $this->producto);
            $detalle = [
                'idproducto' => $producto->id,
                'categoria' => $producto->categoria?->abreviatura,
                'producto' => $producto->nombre,
                'cantidad' => $this->cantidaddetalle,
                'precio' => ($this->cantidaddetalle * $this->preciodetalle),
            ];
            $this->total = ($this->total + $detalle['precio']);
            $this->detalleMovimiento[] = $detalle;
            $this->producto = null;
            $this->cantidaddetalle = 0;
            $this->preciodetalle = 0.00;
        }
    }
    public function loadProductos() {
        if (!empty($this->categoria) && !empty($this->serie)) {
            $this->productos = Producto::where('categoria_id', $this->categoria)
                                        ->where('serie_id', $this->serie)
                                        ->get();
        } else {
            $this->productos = [];
        }
    }
    public function updatedCategoria() {
        $this->serie = null;
        $this->productos = [];
        $this->loadProductos();
    }
    public function updatedSerie() {
        $this->loadProductos();
    }

    public function updatedbuscarProducto($value)
    {
        if($value!=''){
            $this->productos = Producto::where('nombre', 'LIKE', '%' . $value . '%')
            ->orWhereHas('categoria', function ($query) use ($value) {
                $query->where('nombre', 'LIKE', '%' . $value . '%');
            })
            ->orWhereHas('serie', function ($query) use ($value) {
                $query->where('nombre', 'LIKE', '%' . $value . '%');
            })
            ->take(3)
            ->get();

        }else{
            $this->productos=[];
        }
    }
    public function asignarProducto($nombreProducto) {
        $producto = Producto::where('nombre', $nombreProducto)->first();
        if ($producto) {
            $this->producto = $producto->id;
        }
        $this->buscarProducto = $producto->nombre.' '.$producto->categoria->nombre.' '.$producto->categoria->abreviatura.' '.$producto->serie->nombre;
        $this->productos = [];
    }

    public function calcularStock($detalles,$movimiento,$tipo)
    {
        foreach ($detalles as $detalle) {
            $detalleMovimiento = new detalleMovimiento([
                'movimiento_id' => $movimiento->id,
                'producto_id' => $detalle['idproducto'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio'],
            ]);
            $detalleMovimiento->save();

            $producto = Producto::find($detalle['idproducto']);

            $stock = Stock::where('almacen_id', $movimiento->almacen_id)->where('producto_id',$producto->id)->first();
            
            if($tipo == 1){
                $producto->stock = $producto->stock + $detalle['cantidad'];
                $producto->save();
                if($stock){
                    $stock->cantidad = $stock->cantidad + $detalle['cantidad'];
                    $stock->save();
                }else{
                    $stock=Stock::create([
                        'almacen_id' =>  $movimiento->almacen_id,
                        'producto_id' => $producto->id,
                        'cantidad' => $detalle['cantidad'],
                    ]);
                }
            }else{
                $producto->stock = $producto->stock - $detalle['cantidad'];
                $producto->save();
                if($stock){
                    $stock->cantidad = $stock->cantidad - $detalle['cantidad'];
                    $stock->save();
                }else{
                    $stock=Stock::create([
                        'almacen_id' =>  $movimiento->almacen_id,
                        'producto_id' => $producto->id,
                        'cantidad' => $detalle['cantidad'],
                    ]);
                }
            }
        }
    }


}
