<?php

namespace App\Http\Controllers;

use App\Exports\BiseladosExport;
use App\Exports\SeriesExport;
use App\Exports\VentasExport;
use App\Exports\VentasProductosExport;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\DetalleTrabajo;
use App\Models\Documento;
use App\Models\Maquina;
use App\Models\Medio;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ReporteController extends Controller
{
    public function ventas(Request $request)
    {
        $ventas = collect();
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;
        $notacredito = Documento::where('nombre','NOTA DE CRÉDITO')->first();

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchResponsable && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::where('estado', '1')->where('facturacion',0)->whereDate('fecha',now())->orderBy('fecha','desc')->where('sucursal_id',\Auth::user()->sucursal_id)->where('documento_id','!=',$notacredito->id)->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->orderBy('fecha','desc');

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
                $ventas = $ventas->where('estadoPagado', $request->searchNroDocumento);
            }
            $ventas = $ventas->get();
        }
        $responsables = User::where('sucursal_id',\Auth::user()->sucursal_id)->get();
        $clientes = Cliente::all();
        $documentos = Documento::where('sucursal_id',\Auth::user()->sucursal_id)->where('nombre','!=','NOTA DE CRÉDITO')->get();
        $medios = Medio::all();
        $i=0;
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.reportes.ventas', compact('i','documentos','ventas', 'responsables', 'clientes','fechaFin2','fechaInicio2','nume_documento2','searchResponsable2','searchCliente2','searchDocumento2','medios','caja'));
    }

    public function ventaspdf(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;
        $notacredito = Documento::where('nombre','NOTA DE CRÉDITO')->first();
        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchResponsable && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::where('estado', '1')->whereDate('fecha',now())->orderBy('fecha','desc')->where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->orderBy('fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchResponsable')) {
                $ventas = $ventas->where('user_id', $request->searchResponsable);
                $user = User::find($request->searchResponsable);
                $searchResponsable2 = $user->nombre;
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('cliente_id', $request->searchCliente);
                $cliente = Cliente::find($request->searchCliente);
                $searchCliente2 = $cliente->nombre_comercial;
            }
            if ($request->filled('searchDocumento')) {
                $ventas = $ventas->where('documento_id', $request->searchDocumento);
                $documento = Documento::find($request->searchDocumento);
                $searchDocumento2 = $documento->nombre;
            }
            if ($request->filled('searchNroDocumento')) {
                $ventas = $ventas->where('estadoPagado', $request->searchNroDocumento);
                $nume_documento2 = $request->searchNroDocumento ? 'CANCELADO':'PENDIENTE';
            }
            $ventas = $ventas->get();
        }
        
        $i=0;
        $pdf= \PDF::loadView('pages.pdf.ventaspdf',compact('i','ventas','fechaFin2','fechaInicio2','nume_documento2','searchResponsable2','searchCliente2','searchDocumento2'))->setPaper('a4','landscape');
        return $pdf->download('REPORTE DE VENTAS.pdf');
    }

    public function ventasexcel(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $nume_documento2 = $request->searchNroDocumento;
        $searchResponsable2 = $request->searchResponsable;
        $searchCliente2 = $request->searchCliente;
        $searchDocumento2 = $request->searchDocumento;
        $notacredito = Documento::where('nombre','NOTA DE CRÉDITO')->first();
        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchNroDocumento && !$request->searchResponsable && !$request->searchCliente && !$request->searchDocumento){
            $ventas = Venta::where('estado', '1')->whereDate('fecha',now())->orderBy('fecha','desc')->where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Venta::where('sucursal_id',\Auth::user()->sucursal_id)->where('facturacion',0)->where('documento_id','!=',$notacredito->id)->orderBy('fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchResponsable')) {
                $ventas = $ventas->where('user_id', $request->searchResponsable);
                $user = User::find($request->searchResponsable);
                $searchResponsable2 = $user->nombre;
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('cliente_id', $request->searchCliente);
                $cliente = Cliente::find($request->searchCliente);
                $searchCliente2 = $cliente->nombre_comercial;
            }
            if ($request->filled('searchDocumento')) {
                $ventas = $ventas->where('documento_id', $request->searchDocumento);
                $documento = Documento::find($request->searchDocumento);
                $searchDocumento2 = $documento->nombre;
            }
            if ($request->filled('searchNroDocumento')) {
                $ventas = $ventas->where('estadoPagado', $request->searchNroDocumento);
                $nume_documento2 = $request->searchNroDocumento ? 'CANCELADO':'PENDIENTE';
            }
            $ventas = $ventas->get();
        }
        
        return Excel::download(new VentasExport($ventas,$fechaFin2,$fechaInicio2,$nume_documento2,$searchResponsable2,$searchCliente2,$searchDocumento2), 'reporte-ventas.xlsx');
    }

    public function ventasproductos(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchCliente2 = $request->searchCliente;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchCliente){
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->whereDate('ventas.fecha',now())
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('ventas.cliente_id', $request->searchCliente);
            }
            $ventas = $ventas->get();
        }
            
        
        $clientes = Cliente::all();
        $i=0;
        return view('pages.reportes.ventas-productos', compact('i','ventas', 'clientes','fechaFin2','fechaInicio2','searchCliente2'));
    }

    public function ventasproductospdf(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchCliente2 = $request->searchCliente;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchCliente){
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->whereDate('ventas.fecha',now())
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('ventas.cliente_id', $request->searchCliente);
                $cliente = Cliente::find($request->searchCliente);
                $searchCliente2 = $cliente->nombre_comercial;
            }
            $ventas = $ventas->get();
        }
        $i=0;
        $pdf= \PDF::loadView('pages.pdf.ventas-productos-pdf',compact('i','ventas','fechaFin2','fechaInicio2','searchCliente2'))->setPaper('a4','landscape');
        return $pdf->download('REPORTE POR PRODUCTO.pdf');
    }

    public function ventasproductosexcel(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $searchCliente2 = $request->searchCliente;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchCliente){
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->whereDate('ventas.fecha',now())
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('categorias','productos.categoria_id','=','categorias.id')
            ->join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('productos.id','series.nombre as serie','productos.nombre','categorias.abreviatura as categoria',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre','productos.nombre','categorias.abreviatura')
            ->orderBy('categorias.orden','asc')->orderBy('productos.id','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchCliente')) {
                $ventas = $ventas->where('ventas.cliente_id', $request->searchCliente);
                $cliente = Cliente::find($request->searchCliente);
                $searchCliente2 = $cliente->nombre_comercial;
            }
            $ventas = $ventas->get();
        }
        return Excel::download(new VentasProductosExport($ventas,$fechaFin2,$fechaInicio2,$searchCliente2), 'reporte-por-producto.xlsx');
    }

    public function ventasseries(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;

        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)
            ->whereDate('ventas.fecha',now())->where('ventas.facturacion',0)
            ->groupBy('series.id','series.nombre')
            ->orderBy('series.nombre','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre')
            ->orderBy('series.orden','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            $ventas = $ventas->get();
        }
        $i=0;
        return view('pages.reportes.ventas-series', compact('i','ventas','fechaFin2','fechaInicio2'));
    }

    public function ventasseriespdf(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;

        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->whereDate('ventas.fecha',now())
            ->groupBy('series.id','series.nombre')
            ->orderBy('series.nombre','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre')
            ->orderBy('series.nombre','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            $ventas = $ventas->get();
        }
        $i=0;
        $pdf= \PDF::loadView('pages.pdf.ventas-series-pdf',compact('i','ventas','fechaFin2','fechaInicio2'))->setPaper('a4','landscape');
        return $pdf->download('REPORTE POR SERIES.pdf');
    }

    public function ventasseriesexcel(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;

        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->whereDate('ventas.fecha',now())
            ->groupBy('series.id','series.nombre')
            ->orderBy('series.nombre','asc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $ventas = Producto::join('series','productos.serie_id','=','series.id')
            ->join('detalle_ventas','detalle_ventas.producto_id','=','productos.id')
            ->join('ventas','detalle_ventas.venta_id','=','ventas.id')
            ->select('series.id','series.nombre as serie',
            DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
            ->where('ventas.estado',1)->where('detalle_ventas.estado',1)->where('ventas.facturacion',0)
            ->groupBy('productos.id','series.nombre')
            ->orderBy('series.nombre','asc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $ventas = $ventas->whereBetween('ventas.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            $ventas = $ventas->get();
        }
        return Excel::download(new SeriesExport($ventas,$fechaFin2,$fechaInicio2), 'reporte-por-serie.xlsx');
    }

    public function biselados(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $maquina2 = $request->searchMaquina;
        $trabajador2 = $request->searchTrabajador;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchMaquina && !$request->searchTrabajador){
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->whereDate('trabajos.fecha',now())
            ->orderBy('trabajos.fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->orderBy('trabajos.fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $trabajos = $trabajos->whereBetween('trabajos.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchMaquina')) {
                $trabajos = $trabajos->where('trabajos.maquina_id',$request->searchMaquina);
            }
            if ($request->filled('searchTrabajador')) {
                $trabajos = $trabajos->where('trabajos.user_id',$request->searchTrabajador);
            }
            $trabajos = $trabajos->get();
        }
        $i=0;
        $usuarios = User::where('sucursal_id',\Auth::user()->sucursal_id)->whereHas('estacion')->get();
        $maquinas = Maquina::where('sucursal_id',\Auth::user()->sucursal_id)->get();
        return view('pages.reportes.biselados', compact('i','trabajos','fechaFin2','fechaInicio2','maquina2','trabajador2','usuarios','maquinas'));
    }

    public function biseladospdf(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $maquina2 = $request->searchMaquina;
        $trabajador2 = $request->searchTrabajador;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchMaquina && !$request->searchTrabajador){
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->whereDate('trabajos.fecha',now())
            ->orderBy('trabajos.fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->orderBy('trabajos.fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $trabajos = $trabajos->whereBetween('trabajos.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchMaquina')) {
                $trabajos = $trabajos->where('trabajos.maquina_id',$request->searchMaquina);
            }
            if ($request->filled('searchTrabajador')) {
                $trabajos = $trabajos->where('trabajos.user_id',$request->searchTrabajador);
            }
            $trabajos = $trabajos->get();
        }
        $i=0;
        $maquina2 = Maquina::find($request->searchMaquina);
        $trabajador2 = User::find($request->searchTrabajador);
        $pdf= \PDF::loadView('pages.pdf.biseladospdf',compact('i','trabajos','fechaFin2','fechaInicio2','maquina2','trabajador2'))->setPaper('a4','landscape');
        return $pdf->download('REPORTE DE BISELADOS.pdf');
    }

    public function biseladosexcel(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        $maquina2 = $request->searchMaquina;
        $trabajador2 = $request->searchTrabajador;

        if(!$request->searchFechaInicio && !$request->searchFechaFin && !$request->searchMaquina && !$request->searchTrabajador){
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->whereDate('trabajos.fecha',now())
            ->orderBy('trabajos.fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $trabajos = DetalleTrabajo::join('trabajos','trabajos.id','=','detalle_trabajos.trabajo_id')
            ->join('maquinas','maquinas.id','=','trabajos.maquina_id')
            ->join('users','users.id','=','trabajos.user_id')
            ->join('clientes','clientes.id','=','trabajos.cliente_id')
            ->join('users as vendedor','vendedor.id','=','trabajos.vendedor_id')
            ->join('productos','productos.id','=','detalle_trabajos.producto_id')
            ->select('trabajos.fecha','trabajos.numero','maquinas.nombre as nombremaquina','users.nombre as nombreuser','clientes.nombre_comercial as nombrecliente',
            'vendedor.nombre as nombrevendedor','detalle_trabajos.cantidad','productos.nombre as producto')
            ->where('trabajos.sucursal_id',\Auth::user()->sucursal_id)
            ->where('trabajos.estado',1)->where('detalle_trabajos.estado',1)
            ->orderBy('trabajos.fecha','desc');

            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $trabajos = $trabajos->whereBetween('trabajos.fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            if ($request->filled('searchMaquina')) {
                $trabajos = $trabajos->where('trabajos.maquina_id',$request->searchMaquina);
            }
            if ($request->filled('searchTrabajador')) {
                $trabajos = $trabajos->where('trabajos.user_id',$request->searchTrabajador);
            }
            $trabajos = $trabajos->get();
        }
        $maquina2 = Maquina::find($request->searchMaquina);
        $trabajador2 = User::find($request->searchTrabajador);
        return Excel::download(new BiseladosExport($trabajos,$fechaFin2,$fechaInicio2,$maquina2,$trabajador2), 'reporte-biselados.xlsx');
    }
}
