<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Documento;
use App\Models\Medio;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CompraController extends Controller
{
    public function getTicketById($id)
    {
        $ticket = Ticket::with(['user', 'proveedor', 'almacen', 'sucursal', 'detallesTickets','detallesTickets.producto','detallesTickets.producto.categoria'])->findOrFail($id);
        return response()->json($ticket);
    }

    public function getCompraById($id)
    {
        $compra = Compra::with(['user', 'proveedor', 'almacen', 'sucursal', 'detallesCompra','detallesCompra.producto','detallesCompra.producto.categoria','pagosCompra','pagosCompra.medio','tickets'])->findOrFail($id);
        $compra->ver_pago = $compra->verPago();
        return response()->json($compra);
    }

    public function create()
    {
        return view('pages.compras.create');
    }

    public function ticketpdf($compraId)
    {
        $venta = Ticket::findOrFail($compraId);
        $pdf = \PDF::loadView('pages.pdf.ticketcompra', ['venta' => $venta])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait')
            ->setOptions([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0
            ]);
        return $pdf->stream('Pedido-' . $venta->id . '.pdf');
    }

    public function tickets(Request $request)
    {
        $tickets = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchProveedor2 = $request->searchProveedor;

        $tickets = Ticket::where('compra', '0')->where('sucursal_id',\Auth::user()->sucursal_id)->where('estado',1)->orderBy('fecha','desc');

        if ($request->filled('searchFechaInicio')) {
            $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
            $tickets = $tickets->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
        }
        if ($request->filled('searchCliente')) {
            $tickets = $tickets->where('cliente_id', $request->searchCliente);
        }
        $tickets = $tickets->get();

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchProveedor){
            $tickets = Ticket::where('compra', '0')->whereDate('fecha',now())->where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $proveedores = Proveedor::whereHas('tickets', function($query) use ($fechaInicio2, $fechaFin2) {
            $query->whereBetween('fecha', [$fechaInicio2.' 00:00:00', $fechaFin2.' 23:59:59'])
            ->where('compra','0');
        })->get();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $medios = Medio::all();
        $i=0;
        return view('pages.compras.tickets', compact('medios','documentos','i','tickets', 'proveedores','fechaFin2','fechaInicio2','searchProveedor2'));
    }

    public function ticketguardar(Request $request)
    {
        try{
            DB::beginTransaction();
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();

            $mytime= Carbon::now('America/Lima');
            $total = 0;
            $ticketsids = [];
            $nuevaCompras = [];
            foreach($request->ids as $data){
                $ticket = Ticket::find($data);
                $ticket->compra = 1;
                $ticket->save();

                $ticketsids[] = $ticket->id;

                foreach($ticket->detallesTickets as $i => $detalle)
                {
                    $nuevaCompra = ([
                        'producto_id' => $detalle->producto_id,
                        'cantidad' => $detalle->cantidad,
                        'precio' => $detalle->precio,
                    ]);
                    $nuevaCompras[] = $nuevaCompra ;
                    $total+=$detalle->precio*$detalle->cantidad;
                };
            }

            $compra = new Compra();
            $compra->sucursal_id = \Auth::user()->sucursal->id;
            $compra->almacen_id = \Auth::user()->sucursal->almacen->id;
            $compra->user_id = \Auth::user()->id;
            $compra->proveedor_id = $request->proveedor_id;
            $compra->documento_id = $request->tipo_documento;
            $compra->nume_doc = $request->nume_doc;
            $compra->fecha = $mytime->toDateTimeString();
            $compra->acuenta = $request->acuenta;
            $compra->saldo = $total - $request->acuenta;
            $compra->total = $total;
            $compra->estadoPagado = $total <= $request->acuenta ? 1 : 0;
            $compra->save();

            if($request->acuenta > 0){
                $pago=Pago::create([
                    'user_id' => \Auth::user()->id,
                    'medio_id' => $request->medioId,
                    'compra_id' => $compra->id,
                    'caja_id' => $caja->id,
                    'tipo' => 2,
                    'fecha' => $mytime->toDateTimeString(),
                    'total' => $compra->acuenta,
                ]);
            }

            foreach($nuevaCompras as $i => $detalle)
            {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                ]);
            }

            $compra->tickets()->attach($ticketsids);

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return redirect()->route('compra.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroyticket(Request $request)
    {
        $ticket= Ticket::findOrFail($request->id_ticket_2);
        $ticket->estado = 0;
        $ticket->save();

        foreach($ticket->detallesTickets as $detalle){
            $detalle->estado = 0;
            $detalle->save();
            $producto=Producto::find($detalle->producto_id);
            $stock = Stock::where('almacen_id',$ticket->almacen_id)->where('producto_id',$detalle->producto_id)->first();
            $producto->stock = $producto->stock - $detalle->cantidad;
            $producto->save();
            $stock->cantidad = $stock->cantidad - $detalle->cantidad;
            $stock->save();
        }

        return back()
            ->with('success','Ticket Anulado Correctamente!');
    }

    public function edit(Request $request)
    {
        $ticket = Ticket::find($request->compra);
        return view('pages.compras.edit',compact('ticket'));
    }

    public function index(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchProveedor2 = $request->searchProveedor;
        $searchDocumento2 = $request->searchDocumento;


            $compras = Compra::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $compras = $compras->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchProveedor')) {
                $compras = $compras->where('proveedor_id', $request->searchProveedor);
            }
            if ($request->filled('searchDocumento')) {
                $compras = $compras->where('documento_id', $request->searchDocumento);
            }
            if ($request->filled('searchNroDocumento')) {
                $compras = $compras->where('nume_doc', $request->searchNroDocumento);
            }
            $compras = $compras->get();
        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchProveedor && !$request->searchDocumento){
            $compras = Compra::whereDate('fecha',now())->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $proveedores = Proveedor::all();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $i=0;
        $medios = Medio::all();
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.compras.index', compact('medios','i','documentos','compras', 'proveedores','fechaFin2','fechaInicio2','nume_documento2','searchProveedor2','searchDocumento2','caja'));
    }

    public function pagar(Request $request)
    {
        try{
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');

            DB::beginTransaction();

            $compra= Compra::findOrFail($request->id_compra_pagar);
            $compra->acuenta = $compra->acuenta + $request->totalpago;
            $saldo = $compra->saldo - $request->totalpago;
            $compra->saldo = $compra->saldo - $request->totalpago;
            if($saldo == 0){
                $compra->estadoPagado = 1;
            }
            $compra->save();


            $pago=Pago::create([
                'user_id' => \Auth::user()->id,
                'medio_id' => $request->medioId,
                'compra_id' => $compra->id,
                'caja_id' => $caja->id,
                'tipo' => 2,
                'fecha' => $mytime->toDateTimeString(),
                'total' => $request->totalpago,
            ]);

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return back()->with('success', 'Pago Agregado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $compra= Compra::findOrFail($request->id_compra_2);
        $compra->estado = 0;
        $compra->save();

        foreach($compra->detallesCompra as $detalle){
            $detalle->estado = 0;
            $detalle->save();
            $producto=Producto::find($detalle->producto_id);
            $stock = Stock::where('almacen_id',$compra->almacen_id)->where('producto_id',$detalle->producto_id)->first();
            $producto->stock = $producto->stock - $detalle->cantidad;
            $producto->save();
            $stock->cantidad = $stock->cantidad - $detalle->cantidad;
            $stock->save();
        }

        foreach($compra->pagosCompra as $pago){
            $pago->estado = 0;
            $pago->save();
        }

        foreach($compra->tickets as $ticket){
            $ticket->compra = 0;
            $ticket->save();
        }

        return back()
            ->with('success','Compra Anulado Correctamente!');
    }

    public function anularpago($id)
    {
        $pago = Pago::find($id);
        $pago->estado = 0;
        $pago->save();
        $compra= Compra::findOrFail($pago->compra_id);
        $compra->acuenta = $compra->acuenta - $pago->total;
        $compra->saldo = $compra->saldo + $pago->total;
        $compra->estadoPagado = 0;
        $compra->save();

        return back()
            ->with('success','Compra Anulado Correctamente!');
    }
}
