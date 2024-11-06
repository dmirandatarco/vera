<?php

namespace App\Http\Controllers;

use App\Exports\MermaExport;
use Illuminate\Http\Request;
use App\Http\Requests\MermaRequest;
use App\Models\Merma;
use App\Models\Trabajo;
use App\Models\Cliente;
use App\Models\Producto;
use Maatwebsite\Excel\Facades\Excel;

class MermaController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:merma.index')->only('index');
        $this->middleware('can:merma.edit')->only('update');
        $this->middleware('can:merma.create')->only('store');
        $this->middleware('can:merma.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->whereDate('fecha',now())->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc');
            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $mermas = $mermas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            
            $mermas = $mermas->get();
        }
        
        $trabajos = Trabajo::where('sucursal_id',\Auth::user()->sucursal_id)->get();
        $productos = Producto::all();
        $i=0;
        return view('pages.merma.index',compact('mermas','i','trabajos','productos','fechaInicio2','fechaFin2'));
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => \Auth::user()->id]);
        $request->merge(['sucursal_id' => \Auth::user()->sucursal_id]);
        if($request->trabajo_id){
            $trabajo = Trabajo::find($request->trabajo_id);
            $request['cliente_id'] = $trabajo->cliente_id;
        }else{
            $request['cliente_id'] = null;
        }
        $merma=Merma::create($request->all());
        $producto = Producto::find($request->producto_id);
        $producto->stock = $producto->stock - $request->cantidad;
        $producto->save();

        return redirect()->route('merma.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $merma= Merma::findOrFail($request->id_merma_2);
        $merma->estado= $merma->estado == 1 ? '0':'1';
        $producto = Producto::find($merma->producto_id);
        $producto->stock = $producto->stock + $merma->cantidad;
        $producto->save();
        $merma->save();
        return redirect()->back()->with('success','Merma Eliminado Correctamente!');
    }

    public function mermaspdf(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->whereDate('fecha',now())->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc');
            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $mermas = $mermas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            
            $mermas = $mermas->get();
        }
        $i=0;
        $pdf= \PDF::loadView('pages.pdf.mermaspdf',compact('i','mermas','fechaFin2','fechaInicio2'))->setPaper('a4','landscape');
        return $pdf->download('REPORTE DE MERMAS.pdf');
    }

    public function mermasexcel(Request $request)
    {
        $fechaInicio2 = $request->searchFechaInicio;
        $fechaFin2 = $request->searchFechaFin;
        if(!$request->searchFechaInicio && !$request->searchFechaFin){
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->whereDate('fecha',now())->orderBy('fecha','desc')->get();
            $fechaInicio2 = now()->format('Y-m-d');
            $fechaFin2 = now()->format('Y-m-d');
        }else{
            $mermas=Merma::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fecha','desc');
            if ($request->filled('searchFechaInicio')) {
                $fechaFin = $request->filled('searchFechaFin') ? $request->searchFechaFin : now()->toDateString();
                $mermas = $mermas->whereBetween('fecha', [$request->searchFechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
            }
            
            $mermas = $mermas->get();
        }
        return Excel::download(new MermaExport($mermas,$fechaFin2,$fechaInicio2), 'reporte-merma.xlsx');
    }
}
