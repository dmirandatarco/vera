<?php

namespace App\Http\Controllers;

use App\Exports\FacturacionExport;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Company;
use App\Models\DetalleVenta;
use App\Models\Documento;
use App\Models\DocumentoSunat;
use App\Models\Venta;
use App\Models\Trabajo;
use App\Services\SunatService;
use Carbon\Carbon;
use DB;
use Greenter\Report\XmlUtils;
use Maatwebsite\Excel\Facades\Excel;

class FacturacionController extends Controller
{
    //
    public function facturaciontrabajo(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;

        $documentoventa = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','NOTA DE VENTA')->first();

            $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('facturado',0)
            ->where('estado',1)->where('documento_id',$documentoventa->id)->orderBy('fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('cliente_id', $request->searchCliente);
            }
            $ventas = $ventas->get();
        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchResponsable && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::where('estado', '1')->where('documento_id',$documentoventa->id)
            ->where('facturado',0)->whereDate('fecha',now())->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE VENTA')->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $clientes = Cliente::all();
        $i=0;
        return view('pages.facturacion.facturaciontrabajo', compact('documentos','i','ventas', 'clientes','fechaFin2','fechaInicio2','nume_documento2','searchResponsable2','searchCliente2','searchDocumento2'));
    }

    public function facturaciontrabajoguardar(Request $request)
    {
        try{
            DB::beginTransaction();
            $mytime= Carbon::now('America/Lima');
            $total = 0;
            $trabajoids = [];
            $nuevaVentas = [];
            foreach($request->ids as $data){
                $trabajo = Venta::find($data);
                $trabajo->facturado = 1;
                $trabajo->save();
                $trabajoids[] = $trabajo->id;
                foreach($trabajo->detallesVenta as $i => $detalle)
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
            $venta->facturacion = 1;
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
            $venta->ventas()->attach($trabajoids);
            if($documento->nombre == 'BOLETA DE VENTA ELECTRÓNICA' || $documento->nombre == 'FACTURA ELECTRÓNICA'){
                $company = Company::find(1);
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
                if($response['sunatResponse']['success'] && $response['sunatResponse']['cdrResponse']['code']== 0){
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
        return redirect()->route('facturacion.notaventa')
            ->with('success', 'Guardado Correctamente.')
            ->with('openPopup', route('venta.ticketpdf', $venta->id));
    }

    public function listado(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;

        $documentoventa = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','NOTA DE VENTA')->first();

        $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('documento_id','!=',$documentoventa->id)->orderBy('fecha','desc');

        if ($request->filled('searchFechaInicio')) {
            $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
            $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
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
            $ventas = Venta::where('documento_id','!=',$documentoventa->id)->whereDate('fecha',now())->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE VENTA')->get();
        $clientes = Cliente::all();
        $i=0;
        return view('pages.facturacion.listado', compact('documentos','i','ventas', 'clientes','fechaFin2','fechaInicio2','nume_documento2','searchResponsable2','searchCliente2','searchDocumento2'));
    }

    public function descargarXml($id)
    {
        $modelo = DocumentoSunat::where('venta_id',$id)->first();
        $venta=Venta::find($id);
        $contenidoXml = $modelo->xml;
        $nombre = $venta->documento?->serie.'-'.$venta->nume_doc;
        $headers = [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename='.$nombre.'.xml',
        ];
        return response()->make($contenidoXml, 200, $headers);
    }

    public function destroyfactura(Request $request)
    {
        try{
            DB::beginTransaction();
            $venta= Venta::findOrFail($request->id_venta_2);
            $venta->sunat = 2;
            $venta->save();

            if($venta->facturacion == 1){
                foreach($venta->ventas as $venta2){
                    $venta2->facturado = 0;
                    $venta2->save();
                }
            }
            $mytime= Carbon::now('America/Lima');
            $documento = Documento::where('nombre','NOTA DE CRÉDITO')->where('serie','LIKE','%F%')->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $documento->cantidad = $documento->incremento + $documento->cantidad;
            $documento->save();
            $note = new Venta();
            $note->sucursal_id = \Auth::user()->sucursal->id;
            $note->almacen_id = \Auth::user()->sucursal->almacen->id;
            $note->user_id = \Auth::user()->id;
            $note->cliente_id = $venta->cliente_id;
            $note->documento_id = $documento->id;
            $note->nume_doc = $documento->cantidad;
            $fechaConHoraActual = Carbon::parse($request->fecha)->setTime(now()->hour, now()->minute, now()->second);
            $note->fecha = $fechaConHoraActual;
            $note->acuenta = 0;
            $note->saldo = 0;
            $note->total = $venta->total;
            $note->pago = 0;
            $note->tipo = 0;
            $note->estadoPagado = 0;
            $note->facturacion = 0;
            $note->descripcion = $request->descripcion;
            $note->cod_note = $request->type_anular;
            $note->factura_id = $venta->id;
            $note->save();

            $company = Company::find(1);
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
            $invoice = $sunat->getNote($company,$documento,$venta,$totales,$note);
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
                'venta_id' => $note->id,
            ]);
            if($response['sunatResponse']['success'] && $response['sunatResponse']['cdrResponse']['code'] == 0){
                $note->sunat = 1;
                $note->save();
            }else{
                $note->sunat = 0;
                $note->save();
            }
            DB::commit();
            return back()
                ->with('success','Factura Anulado Correctamente!');

        }catch(Exception $e){
            DB::rollBack();
        }
    }
    
    public function enviarfactura(Venta $venta)
    {
        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');
            $documento = Documento::find($venta->documento_id);

            $company = Company::find(1);
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
            $documentoSunat = DocumentoSunat::updateOrCreate([
                'venta_id' => $venta->id,
            ],[
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
            ]);
            if($response['sunatResponse']['success'] && $response['sunatResponse']['cdrResponse']['code'] == 0){
                $venta->sunat = 1;
                $venta->save();
            }else{
                $venta->sunat = 0;
                $venta->save();
            }
            DB::commit();
            return back()
                ->with('success','Factura Enviada Correctamente!');

        }catch(Exception $e){
            DB::rollBack();
        }
    }

    public function reporte(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;

        $documentoventa = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','NOTA DE VENTA')->first();

        $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)
        ->where('estado',1)->where('documento_id','!=',$documentoventa->id)->orderBy('fecha','desc');

        if ($request->filled('searchFechaInicio')) {
            $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
            $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
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
            $ventas = Venta::where('estado', '1')->where('documento_id','!=',$documentoventa->id)->whereDate('fecha',now())->where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }
        
        return Excel::download(new FacturacionExport($ventas,$fechaFin2,$fechaInicio2,$nume_documento2,$searchResponsable2,$searchCliente2,$searchDocumento2), 'reporte-facturacion.xlsx');
    }
}
