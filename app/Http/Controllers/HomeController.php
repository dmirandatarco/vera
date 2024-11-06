<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Pago;
use App\Models\Venta;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $fechaInicio2 = $request->fechaInicio;
        // $fechaFin2 = $request->fechaFin;

        // $categorias = Categoria::all()->sortBy('nombre');
        
        // $categoriasConCantidadVendida = Categoria::select('categorias.nombre', DB::raw('COALESCE(SUM(detalle_ventas.cantidad), 0) as cantidad_vendida'))
        //     ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
        //     ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
        //     ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        //     ->whereBetween('ventas.fecha', [$fechaInicio2.' 00:00:00', $fechaFin2.' 23:59:59'])
        //     ->where('ventas.estado',1)
        //     ->where('detalle_ventas.estado',1)
        //     ->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
        //     ->groupBy('categorias.id', 'categorias.nombre')
        //     ->orderBy('categorias.nombre')
        //     ->get();
        // $pagos = Pago::whereBetween('fecha', [$fechaInicio2.' 00:00:00', $fechaFin2.' 23:59:59'])->where('estado',1)->get();

        // if(!$request->fechaInicio && !$request->fechaFin){
        //     $categoriasConCantidadVendida = Categoria::select('categorias.nombre', DB::raw('COALESCE(SUM(detalle_ventas.cantidad), 0) as cantidad_vendida'))
        //     ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
        //     ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
        //     ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        //     ->whereDate('ventas.fecha',now())
        //     ->where('ventas.estado',1)
        //     ->where('detalle_ventas.estado',1)
        //     ->where('ventas.sucursal_id',\Auth::user()->sucursal_id)
        //     ->groupBy('categorias.id', 'categorias.nombre')
        //     ->orderBy('categorias.nombre')
        //     ->get();

        //     $fechaInicio2 = now()->format('Y-m-d');
        //     $fechaFin2 = now()->format('Y-m-d');
        //     $pagos = Pago::whereDate('fecha',now())->whereRelation('caja','sucursal_id',\Auth::user()->sucursal_id)->where('estado',1)->get();
        // }

        // $pagoSolesIngreso = $pagos->where('medio_id',1)->where('tipo',1)->sum('total');
        // $pagoSolesEgreso = $pagos->where('medio_id',1)->where('tipo',2)->sum('total');
        // $pagoSolesTotal = $pagoSolesIngreso - $pagoSolesEgreso;
        // $pagoTransferenciaIngreso = $pagos->where('medio_id','!=',1)->where('tipo',1)->sum('total');
        // $pagoTransferenciaEgreso = $pagos->where('medio_id','!=',1)->where('tipo',2)->sum('total');
        // $pagoTransferenciaTotal = $pagoTransferenciaIngreso - $pagoTransferenciaEgreso;

        // $mayor = 0;

        // foreach ($categoriasConCantidadVendida as $categoria) {
        //     if ($categoria->cantidad_vendida > $mayor) {
        //         $mayor = $categoria->cantidad_vendida;
        //     }
        // }

        return view('dashboard');
        // return view('dashboard', compact('categorias', 'categoriasConCantidadVendida', 'mayor','pagoSolesTotal','pagoTransferenciaTotal','fechaInicio2','fechaFin2'));
    }
}
