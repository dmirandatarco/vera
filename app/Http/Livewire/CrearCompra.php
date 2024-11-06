<?php

namespace App\Http\Livewire;

use App\Models\DetalleTicket;
use App\Models\Documento;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use App\Models\Ticket;
use Livewire\Component;
use Carbon\Carbon;
use DB;

class CrearCompra extends Component
{
    public $proveedorId;
    public $proveedores;
    public $documentos;

    public $total=0;
    public $totalproductos=0;
    public $productos = [];
    public $detalleProductos  =[];

    public $productoId;
    public $precio;
    public $cantidad;
    public $subtotal;
    public $isEdit;

    public $idTicket;

    public function mount(Ticket $ticket = null)
    {
        if($ticket){
            $this->idTicket = $ticket->id;
            $this->proveedorId = $ticket->proveedor_id;
            foreach($ticket->detallesTickets as $detail){
                $detalle = [
                    'cantidad' => $detail->cantidad,
                    'productoId' => $detail->producto_id,
                    'productonombre' => $detail->producto->nombre.'-'.$detail->producto->categoria->nombre.'-'.$detail->producto->categoria->abreviatura.'-'.$detail->producto->serie->nombre,
                    'precio' => $detail->precio,
                    'subtotal' => $detail->precio*$detail->cantidad,
                ];
                $this->detalleProductos[] = $detalle;
            }
            $this->calcularTotal();
        }
        $this->proveedores = Proveedor::where('estado',1)->get();
        $this->documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
    }

    public function updatedproductoId($value)
    {
        $producto=Producto::find($value);
        // Verifica que el índice esté dentro del rango válido.
        $this->isEdit = null;
        if ($producto) {
            $this->cantidad = 1;
            $this->precio = $producto->precio;
            $this->emit('modalproducto');
        }
    }

    public function agregar()
    {
        $this->validate([
            'cantidad'             => 'required',
            'precio'        => 'required',
        ]);

        $producto=Producto::find($this->productoId);

        if($producto){
            $detalle = [
                'cantidad' => $this->cantidad,
                'productoId' => $this->productoId,
                'productonombre' => $producto->nombre.'-'.$producto->categoria->nombre.'-'.$producto->categoria->abreviatura.'-'.$producto->serie->nombre,
                'precio' => $this->precio,
                'subtotal' => $this->precio*$this->cantidad,
            ];
            if($this->isEdit != '' ){
                $this->detalleProductos[$this->isEdit] = $detalle;
            }else{
                $this->detalleProductos[] = $detalle;
            }
            $this->productoId = '';
            $this->cantidad = 1;
            $this->precio = $producto->precio;
            $this->calcularTotal();
            $this->emit('cerrarModalproducto');
        }
    }

    public function cancelarProducto(){
        $this->productoId = '';
        $this->cantidad = 1;
        $this->precio = 0;
        $this->emit('cerrarModalproducto');
    }

    public function editarProducto($index)
    {
        $this->isEdit = $index;
        $this->productoId = $this->detalleProductos[$index]['productoId'];
        $this->cantidad = $this->detalleProductos[$index]['cantidad'];
        $this->precio = $this->detalleProductos[$index]['precio'];
        $this->emit('modalproducto');
    }

    public function eliminarProducto($index)
    {
        unset($this->detalleProductos[$index]);
        $this->detalleProductos = array_values($this->detalleProductos);
        $this->calcularTotal();
    }


    public function registrarVenta($valor)
    {
        $this->validate([
            'proveedorId'             => 'required|exists:proveedors,id',
        ]);

        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            if($this->idTicket){
                $ticket = Ticket::find($this->idTicket);
                foreach($ticket->detallesTickets as $i => $detalle)
                {
                    $producto = Producto::find($detalle->producto_id);
                    $producto->stock = $producto->stock - $detalle->cantidad;
                    $producto->save();

                    $stock= Stock::where('almacen_id',\Auth::user()->sucursal->almacen->id)->where('producto_id',$detalle->producto_id)->first();
                    if($stock){
                        $stock->cantidad = $stock->cantidad - $detalle->cantidad;
                        $stock->save();
                    }else{
                        $stock = new Stock();
                        $stock->almacen_id = \Auth::user()->sucursal->almacen->id;
                        $stock->producto_id = $detalle->producto_id;
                        $stock->cantidad = 0 - $detalle->cantidad;
                        $stock->save();
                    }
                    $detalle->delete();
                }
            }else{
                $numeracion = Ticket::where('sucursal_id',\Auth::user()->sucursal_id)->count()+1;
                $ticket = new Ticket();
                $ticket->numero = $numeracion;
                $ticket->fecha = $mytime->toDateTimeString();
            }

            $ticket->user_id = \Auth::user()->id;
            $ticket->sucursal_id = \Auth::user()->sucursal->id;
            $ticket->almacen_id = \Auth::user()->sucursal->almacen->id;
            $ticket->proveedor_id = $this->proveedorId;
            $ticket->total = $this->total;
            $ticket->compra = 0;
            $ticket->save();

            foreach($this->detalleProductos as $i => $detalle)
            {
                DetalleTicket::create([
                    'ticket_id' => $ticket->id,
                    'producto_id' => $detalle['productoId'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                ]);

                $producto = Producto::find($detalle['productoId']);
                $producto->stock = $producto->stock + $detalle['cantidad'];
                $producto->save();

                $stock= Stock::where('almacen_id',\Auth::user()->sucursal->almacen->id)->where('producto_id',$detalle['productoId'])->first();
                if($stock){
                    $stock->cantidad = $stock->cantidad + $detalle['cantidad'];
                    $stock->save();
                }else{
                    $stock = new Stock();
                    $stock->almacen_id = \Auth::user()->sucursal->almacen->id;
                    $stock->producto_id = $detalle['productoId'];
                    $stock->cantidad = 0 + $detalle['cantidad'];
                    $stock->save();
                }
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        $this->emit('abrirTicket', $ticket->id);
        
        return redirect()->route('compra.create')
            ->with('success', 'Compra Agregado Correctamente.');
    }

    public function calcularTotal()
    {
        $totalcantidad = 0;
        $total=0;
        foreach($this->detalleProductos as $i => $detalle)
        {
            $total += $detalle['subtotal'];
            $totalcantidad += $detalle['cantidad'];
        }
        $this->total = $total;
        $this->totalproductos = $totalcantidad;
    }

    public function render()
    {
        return view('livewire.crear-compra');
    }
}
