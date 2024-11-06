<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaCobrar;
use App\Models\Company as ModelsCompany;
use App\Models\Venta;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Cobrar;
use App\Models\DetalleVenta;
use App\Models\Documento;
use App\Models\DocumentoSunat;
use App\Models\Medio;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Trabajo;
use App\Models\Union;
use App\Services\SunatService;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Greenter\Report\XmlUtils;
use Luecano\NumeroALetras\NumeroALetras;

class VentaController extends Controller
{
    // En VentaController.php
    public function getVentaById($id)
    {
        $venta = Venta::with(['user', 'cliente', 'almacen', 'sucursal','pagosVenta','detallesVenta','detallesVenta.producto','pagosVenta.medio','documento'])->findOrFail($id);
        $venta->ver_pago = $venta->verPago();
        return response()->json($venta);
    }

    public function getTrabajoById($id)
    {
        $venta = Trabajo::with(['user', 'cliente', 'almacen', 'sucursal','vendedor','maquina', 'detallesTrabajos','detallesTrabajos.producto','detallesTrabajos.producto.categoria'])->findOrFail($id);
        return response()->json($venta);
    }

    public function index(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;


            $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->orderBy('fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchResponsable')) {
                $ventas = $ventas->where('user_id', $request->searchResponsable);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('cliente_id', $request->searchCliente);
            }
            if ($request->filled('searchDocumento')) {
                $ventas = $ventas->where('documento_id', $request->searchDocumento);
            }
            if ($request->filled('searchNroDocumento')) {
                $ventas = $ventas->where('nume_doc', $request->searchNroDocumento);
            }
            $ventas = $ventas->get();
        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchResponsable && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::whereDate('fecha',now())->where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $responsables = User::where('sucursal_id',\Auth::user()->sucursal_id)->get();
        $clientes = Cliente::all();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $medios = Medio::all();
        $i=0;
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.venta.index', compact('i','documentos','ventas', 'responsables', 'clientes','fechaFin2','fechaInicio2','nume_documento2','searchResponsable2','searchCliente2','searchDocumento2','medios','caja'));
    }

    public function cobrar(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchCliente2 = $request->searchCliente;
        $nume_documento2 = $request->searchNroDocumento;
        $searchDocumento2 = $request->searchDocumento;
        $notacredito = Documento::where('nombre','NOTA DE CRÉDITO')->first();

        $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->where('saldo','>',0)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->where('estado',1);

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio, $fechaFin]);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('cliente_id', $request->searchCliente);
            }
            if ($request->filled('searchDocumento')) {
                $ventas = $ventas->where('documento_id', $request->searchDocumento);
            }
            if ($request->filled('searchNroDocumento')) {
                $ventas = $ventas->where('nume_doc', $request->searchNroDocumento);
            }
            $ventas = $ventas->get();

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::where('estado', '1')->whereDate('fecha',now())->orderBy('fecha','desc')->where('sucursal_id',\Auth::user()->sucursal_id)->where('saldo','>',0)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $responsables = User::all();
        $clientes = Cliente::all();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $medios = Medio::all();
        $i=0;
        $caja = CajaCobrar::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.venta.cobrar', compact('i','documentos','ventas', 'responsables', 'clientes','fechaFin2','fechaInicio2','nume_documento2','searchDocumento2','searchCliente2','medios','caja'));
    }

    public function create()
    {
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.venta.create',compact('caja'));
    }

    public function editartrabajo($id)
    {
        $trabajo = Trabajo::find($id);
        return view('pages.venta.edittrabajo',compact('trabajo'));
    }

    public function edit($id)
    {
        $venta = Venta::find($id);
        $trabajo = $venta->trabajos[0] ?? null;
        return view('pages.venta.edit',compact('trabajo','venta'));
    }

    public function ticketpdf($ventaId)
    {
        $formatear = new NumeroALetras();
        $compania = ModelsCompany::find(1);
        $venta = Venta::findOrFail($ventaId);
        $igv= number_format(($venta->total /1.18) * 0.18,2);
        $fecha = date("Y-m-d",strtotime($venta->fecha));
        $mensaje = $compania->ruc.'|'.$venta->documento->codSunat.'|'.$venta->documento->serie.'|'.$venta->nume_doc.'|'.$igv.'|'.$venta->total.'|'.$fecha.'|'.$venta->cliente->sunat.'|'.$venta->cliente->num_documento;
        $qrcode = base64_encode(\QrCode::size(100)->generate($mensaje));

        $letrasnumeros = $formatear->toInvoice($venta->total,2,'SOLES');
        if($venta->documento->nombre == "NOTA DE VENTA"){
            $pdf = \PDF::loadView('pages.pdf.notaventa', ['venta' => $venta, 'qrcode' => $qrcode , 'letrasnumeros' => $letrasnumeros])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait')
            ->setOptions([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0
            ]);
        }elseif($venta->documento->nombre == "NOTA DE CRÉDITO"){
            $pdf = \PDF::loadView('pages.pdf.notacredito', ['venta' => $venta, 'qrcode' => $qrcode , 'letrasnumeros' => $letrasnumeros])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait')
            ->setOptions([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0
            ]);
        }else{
            $pdf = \PDF::loadView('pages.pdf.ticketpdf', ['venta' => $venta, 'qrcode' => $qrcode , 'letrasnumeros' => $letrasnumeros])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait')
            ->setOptions([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0
            ]);
        }
        return $pdf->stream('Ticket-' . $venta->nume_doc . '.pdf');
    }

    public function ticketpedido($ventaId)
    {
        $venta = Trabajo::findOrFail($ventaId);
        $pdf = \PDF::loadView('pages.pdf.ticketpedido', ['venta' => $venta])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait')
            ->setOptions([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0
            ]);
        return $pdf->stream('Pedido-' . $venta->id . '.pdf');
    }

    public function ordentrabajo(Request $request)
    {
        $trabajos = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchCliente2 = $request->searchCliente;

        $trabajos = Trabajo::where('venta', '0')->where('sucursal_id',\Auth::user()->sucursal_id)->where('estado',1)->orderBy('fecha','desc');

        if ($request->filled('searchFechaInicio')) {
            $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
            $trabajos = $trabajos->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
        }
        if ($request->filled('searchCliente')) {
            $trabajos = $trabajos->where('cliente_id', $request->searchCliente);
        }
        $trabajos = $trabajos->get();

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchCliente){
            $trabajos = Trabajo::where('venta', '0')->whereDate('fecha',now())->where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $clientes = Cliente::whereHas('trabajos', function($query) use ($fechaInicio2, $fechaFin2) {
            $query->whereBetween('fecha', [$fechaInicio2.' 00:00:00', $fechaFin2.' 23:59:59'])
            ->where('venta','0');
        })->get();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $i=0;
        return view('pages.venta.ordentrabajo', compact('documentos','i','trabajos', 'clientes','fechaFin2','fechaInicio2','searchCliente2'));
    }

    public function ordentrabajoguardar(Request $request)
    {
        try{
            DB::beginTransaction();
            $mytime= Carbon::now('America/Lima');
            $total = 0;
            $trabajoids = [];
            $nuevaVentas = [];
            foreach($request->ids as $data){
                $trabajo = Trabajo::find($data);
                $trabajo->venta = 1;
                $trabajo->save();
                $trabajoids[] = $trabajo->id;
                foreach($trabajo->detallesTrabajos as $i => $detalle)
                {
                    $nuevaVenta = ([
                        'producto_id' => $detalle->producto_id,
                        'cantidad' => $detalle->cantidad,
                        'eje' => $detalle->eje,
                        'dip' => $detalle->dip,
                        'add' => $detalle->add,
                        'precio' => $detalle->precio,
                    ]);
                    $nuevaVentas[] = $nuevaVenta ;
                    $total+=$detalle->precio*$detalle->cantidad;
                };
            }
            $documento = Documento::find($request->tipo_documento);
            $documento->cantidad = $documento->incremento + $documento->cantidad;
            $documento->save();
            $venta = new Venta();
            $venta->sucursal_id = \Auth::user()->sucursal->id;
            $venta->almacen_id = \Auth::user()->sucursal->almacen->id;
            $venta->user_id = \Auth::user()->id;
            $venta->cliente_id = $request->cliente_id;
            $venta->documento_id = $request->tipo_documento;
            $venta->nume_doc = $documento->cantidad;
            $venta->fecha = $mytime->toDateTimeString();
            $venta->acuenta = 0;
            $venta->saldo = $total;
            $venta->total = $total;
            $venta->pago = $request->tipo;
            $venta->tipo = 0;
            $venta->estadoPagado = 0;
            $venta->save();
            foreach($nuevaVentas as $i => $detalle)
            {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'eje' => $detalle['eje'],
                    'dip' => $detalle['dip'],
                    'add' => $detalle['add'],
                    'precio' => $detalle['precio'],
                ]);
            }
            $venta->trabajos()->attach($trabajoids);
            if($documento->nombre == 'BOLETA DE VENTA ELECTRÓNICA' || $documento->nombre == 'FACTURA ELECTRÓNICA'){
                $company = ModelsCompany::find(1);
                $totales = collect([
                    'MtoOperGravadas' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18,
                    'MtoIGV' => ($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18,
                    'TotalImpuestos' => ($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18,
                    'ValorVenta' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18,
                    'SubTotal' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18 + (($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18),
                    'MtoImpVenta' => $venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18 + (($venta->detallesVenta()->sum(\DB::raw('cantidad * precio')) / 1.18) * 0.18),
                ]);
                $sunat = new SunatService();
                $see = $sunat->getSee($company);
                $invoice = $sunat->getInvoice($company,$documento,$venta,$totales);
                $result = $see->send($invoice);
                $response['xml'] = $see->getFactory()->getLastXml();
                $response['hash'] = (new XmlUtils())->getHashSign($response['xml']);
                $response['sunatResponse'] = $sunat->sunatResponse($result);
                $documentoSunat = DocumentoSunat::create([
                    'xml' => $response['xml'],
                    'hash' => $response['hash'],
                    'respuesta' => $response['sunatResponse']['success'],
                    'codeError' => $response['sunatResponse']['error']['code'] ?? null,
                    'messageError' => $response['sunatResponse']['error']['message'] ?? null,
                    'cdrZip' => $response['sunatResponse']['cdrZip'] ?? null,
                    'codeCdr' => $response['sunatResponse']['cdrResponse']['code'] ?? null,
                    'descripcionCdr' => $response['sunatResponse']['cdrResponse']['descripcion'] ?? null,
                    'notesCdr' => isset($response['sunatResponse']['cdrResponse']['notes'])
                                    ? json_encode($response['sunatResponse']['cdrResponse']['notes'])
                                    : null,
                    'venta_id' => $venta->id,
                ]);
                if($response['sunatResponse']['success'] && $response['sunatResponse']['cdrResponse']['code'] == 0){
                    $venta->sunat = 1;
                    $venta->save();
                }else{
                    $venta->sunat = 0;
                    $venta->save();
                }
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('venta.index')
            ->with('success', 'Guardado Correctamente.')
            ->with('openPopup', route('venta.ticketpdf', $venta->id));
    }

    public function destroy(Request $request)
    {
        $venta= Venta::findOrFail($request->id_venta_2);
        $venta->estado = 0;
        $venta->save();

        foreach($venta->detallesVenta as $detalle){
            $detalle->estado = 0;
            $detalle->save();
            $producto=Producto::find($detalle->producto_id);
            $stock = Stock::where('almacen_id',$venta->almacen_id)->where('producto_id',$detalle->producto_id)->first();
            $producto->stock = $producto->stock + $detalle->cantidad;
            $producto->save();
            $stock->cantidad = $stock->cantidad + $detalle->cantidad;
            $stock->save();
        }

        foreach($venta->pagosVenta as $pago){
            $pago->estado = 0;
            $pago->save();
        }

        if($venta->tipo == 0){
            foreach($venta->trabajos as $trabajo){
                $trabajo->venta = 0;
                $trabajo->save();
            }
        }

        return back()
            ->with('success','Venta Anulado Correctamente!');
    }

    public function pagoanular($id)
    {
        $pago = Pago::find($id);
        $pago->estado = 0;
        $pago->save();
        $venta= Venta::findOrFail($pago->venta_id);
        $venta->acuenta = $venta->acuenta - $pago->total;
        $venta->saldo = $venta->saldo + $pago->total;
        $venta->estadoPagado = 0;
        $venta->save();

        return back()
            ->with('success','Venta Anulado Correctamente!');
    }

    public function cobraranular($id)
    {
        $pago = Cobrar::find($id);
        $pago->estado = 0;
        $pago->save();

        return back()
            ->with('success','Venta Anulado Correctamente!');
    }

    public function pagar(Request $request)
    {
        try{
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');

            DB::beginTransaction();

            $venta= Venta::findOrFail($request->id_venta_pagar);
            $venta->acuenta = $venta->acuenta + $request->totalpago;
            $saldo = $venta->saldo - $request->totalpago;
            $venta->saldo = $venta->saldo - $request->totalpago;
            if($saldo == 0){
                $venta->estadoPagado = 1;
            }
            $venta->save();


            $pago=Pago::create([
                'user_id' => \Auth::user()->id,
                'medio_id' => $request->medioId,
                'venta_id' => $venta->id,
                'caja_id' => $caja->id,
                'tipo' => 1,
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

    public function pagarglobal(Request $request)
    {
        try{
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');

            DB::beginTransaction();

            $ventas = Venta::where('cliente_id', $request->cliente_id_global)->where('estado',1)
            ->where('estadoPagado',0)->where('saldo','>',0)
            ->whereBetween('fecha', [$request->fecha_inicio_global.' 00:00:00', $request->fecha_fin_global.' 23:59:59'])
            ->orderBy('fecha','asc')->get();

            $monto = $request->totalpagoGlobal;
            foreach($ventas as $venta)
            {
                if($monto>0){
                    if($monto >= $venta->saldo)
                    {
                        $monto = $monto - $venta->saldo;
                        $venta->acuenta = $venta->acuenta + $venta->saldo;
                        $pago=Pago::create([
                            'user_id' => \Auth::user()->id,
                            'medio_id' => $request->medioIdGlobal,
                            'venta_id' => $venta->id,
                            'caja_id' => $caja->id,
                            'tipo' => 1,
                            'fecha' => $mytime->toDateTimeString(),
                            'total' => $venta->saldo,
                        ]);
                        $venta->saldo = 0;
                        $venta->estadoPagado = 1;
                        $venta->save();


                    }else{
                        $venta->acuenta = $venta->acuenta + $monto;
                        $venta->saldo = $venta->saldo - $monto;
                        $venta->estadoPagado = 0;
                        $venta->save();

                        $pago=Pago::create([
                            'user_id' => \Auth::user()->id,
                            'medio_id' => $request->medioIdGlobal,
                            'venta_id' => $venta->id,
                            'caja_id' => $caja->id,
                            'tipo' => 1,
                            'fecha' => $mytime->toDateTimeString(),
                            'total' => $monto,
                        ]);
                        $monto = 0;
                    }
                }
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return back()->with('success', 'Pago Agregado Correctamente.');
    }

    public function destroyorden(Request $request)
    {
        $venta= Trabajo::findOrFail($request->id_trabajo_2);
        $venta->estado = 0;
        $venta->save();
        foreach($venta->detallesTrabajos as $detalle){
            $detalle->estado = 0;
            $detalle->save();
            $producto=Producto::find($detalle->producto_id);
            $stock = Stock::where('almacen_id',$venta->almacen_id)->where('producto_id',$detalle->producto_id)->first();
            $producto->stock = $producto->stock + $detalle->cantidad;
            $producto->save();
            $stock->cantidad = $stock->cantidad + $detalle->cantidad;
            $stock->save();
        }
        return back()
            ->with('success','Orden de Trabajo Anulado Correctamente!');
    }

    public function cobrarTrabajador(Request $request)
    {
        try{
            $caja = CajaCobrar::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');

            DB::beginTransaction();

            $venta= Venta::findOrFail($request->id_venta_pagar);

            $pago=Cobrar::create([
                'user_id' => \Auth::user()->id,
                'medio_id' => $request->medioId,
                'venta_id' => $venta->id,
                'caja_cobrar_id' => $caja->id,
                'tipo' => 1,
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

    public function pagarglobalTrabajador(Request $request)
    {
        try{
            $caja = CajaCobrar::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');

            DB::beginTransaction();

            $ventas = Venta::where('cliente_id', $request->cliente_id_global)->where('estado',1)
            ->where('estadoPagado',0)->where('saldo','>',0)
            ->whereBetween('fecha', [$request->fecha_inicio_global.' 00:00:00', $request->fecha_fin_global.' 23:59:59'])
            ->orderBy('fecha','asc')->get();

            $monto = $request->totalpagoGlobal;
            foreach($ventas as $venta)
            {
                if($monto>0){
                    if($monto >= $venta->saldo)
                    {
                        $monto = $monto - $venta->saldo;

                        $pago=Cobrar::create([
                            'user_id' => \Auth::user()->id,
                            'medio_id' => $request->medioIdGlobal,
                            'venta_id' => $venta->id,
                            'caja_cobrar_id' => $caja->id,
                            'tipo' => 1,
                            'fecha' => $mytime->toDateTimeString(),
                            'total' => $venta->saldo,
                        ]);
                    }else{

                        $pago=Cobrar::create([
                            'user_id' => \Auth::user()->id,
                            'medio_id' => $request->medioIdGlobal,
                            'venta_id' => $venta->id,
                            'caja_cobrar_id' => $caja->id,
                            'tipo' => 1,
                            'fecha' => $mytime->toDateTimeString(),
                            'total' => $monto,
                        ]);
                        $monto = 0;
                    }
                }
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return back()->with('success', 'Pago Agregado Correctamente.');
    }

    public function juntarcajas(Request $request)
    {
        try{
            DB::beginTransaction();

            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');
            $total = 0;
            foreach($request->ids as $data){
                $cobrar = Cobrar::find($data);

                if($cobrar->estado == 1){
                    $pago = Pago::create([
                        'user_id' => \Auth::user()->id,
                        'medio_id' => $cobrar->medio_id,
                        'venta_id' => $cobrar->venta_id,
                        'caja_id' => $caja->id,
                        'tipo' => 1,
                        'fecha' =>  $mytime->toDateTimeString(),
                        'total' => $cobrar->total,
                    ]);

                    $total += $cobrar->total;

                    $venta = Venta::find($cobrar->venta_id);
                    $venta->acuenta = $venta->acuenta + $cobrar->total;
                    $venta->saldo = $venta->saldo - $cobrar->total;
                    if($venta->saldo == 0){
                        $venta->estadoPagado = 1;
                    }
                    $venta->save();
                }
            }

            $union = Union::create([
                'fecha' => $mytime->toDateTimeString(),
                'user_id' => \Auth::user()->id,
                'caja_cobrar_id' => $request->id_caja_cobrar,
                'caja_id' => $caja->id,
                'totalTransferido' => $total,
            ]);

            $cajacobrar=CajaCobrar::find($request->id_caja_cobrar);
            $cajacobrar->contabilizado = 1;
            $cajacobrar->estado = 0;
            $cajacobrar->save();

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return redirect()->route('caja.reporte')
            ->with('success', 'Guardado Correctamente.');
    }

}