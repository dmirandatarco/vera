<?php
namespace App\Http\Controllers;
use App\Models\Movimiento;
use App\Models\Serie;
use App\Models\Categoria;
use App\Exports\MovimientosExport;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\detalleMovimiento;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class MovimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:movimiento.index')->only('index');
        $this->middleware('can:movimiento.edit')->only('update');
        $this->middleware('can:movimiento.create')->only('store');
        $this->middleware('can:movimiento.destroy')->only('destroy');
    }
    public function index()
    {
        $series = Serie::all();
        $categorias=Categoria::orderBy('orden','asc')->get();

        $movimientos = Movimiento::all();
        $i = 0;
        return view('pages.movimientos.index',compact('movimientos','i','series','categorias'));
    }
    public function create()
    {
        return view('pages.movimientos.create');
    }
    public function createmovimientomasivo()
    {
        return view('pages.movimientos.createmasivo');
    }
    public function store(Request $request)
    {
    }
    public function show(Movimiento $movimiento)
    {
        $detall = detalleMovimiento::where('movimiento_id',$movimiento->id)->get();
        return view('pages.movimientos.show',compact('movimiento','detall'));
    }
    public function edit(Movimiento $movimiento)
    {
    }
    public function update(Request $request, Movimiento $movimiento)
    {
    }
    public function destroy(Request $request)
    {
        $movimiento= Movimiento::findOrFail($request->id_movimiento_2);
        if($movimiento->estado == 1){
            $movimiento->estado = 0;
            $movimiento->save();
            foreach($movimiento->detalles as $detalle){
                $detalle->estado = 0;
                $detalle->save();
                $producto=Producto::find($detalle->producto_id);
                $stock = Stock::where('almacen_id',$movimiento->almacen_id)->where('producto_id',$detalle->producto_id)->first();
                if($movimiento->tipo->tipo == 1){
                    $producto->stock = $producto->stock - $detalle->cantidad;
                    $producto->save();
                    $stock->cantidad = $stock->cantidad - $detalle->cantidad;
                    $stock->save();
                }else{
                    $producto->stock = $producto->stock + $detalle->cantidad;
                    $producto->save();
                    $stock->cantidad = $stock->cantidad + $detalle->cantidad;
                    $stock->save();
                }
            }
            $movimientoreverse = $movimiento?->movimientos;
            if($movimientoreverse){
                if($movimientoreverse->estado == 1){
                    $movimientoreverse->estado = 0;
                    $movimientoreverse->save();
                    foreach($movimientoreverse->detalles as $detalle){
                        $detalle->estado = 0;
                        $detalle->save();
                        $producto=Producto::find($detalle->producto_id);
                        $stock = Stock::where('almacen_id',$movimientoreverse->almacen_id)->where('producto_id',$detalle->producto_id)->first();
                        if($movimientoreverse->tipo->tipo == 1){
                            $producto->stock = $producto->stock - $detalle->cantidad;
                            $producto->save();
                            $stock->cantidad = $stock->cantidad - $detalle->cantidad;
                            $stock->save();
                        }else{
                            $producto->stock = $producto->stock + $detalle->cantidad;
                            $producto->save();
                            $stock->cantidad = $stock->cantidad + $detalle->cantidad;
                            $stock->save();
                        }
                    }
                }
            }
        return redirect()->route('producto.index')
            ->with('success','Movimiento Anulado Correctamente!');
        }
    }
    public function informesexcel(Movimiento $movimiento)
    {
        return Excel::download(new MovimientosExport($movimiento), 'movimiento-report.xlsx');
    }
    public function plantillaexcelcrear()
    {
        return view('pages.movimientos.plantillaexcelcrear');


    }
}
