<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelProductoRequest;
use App\Http\Requests\ProductoRequest;
use App\Imports\ProductoImport;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Serie;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:producto.index')->only('index');
        $this->middleware('can:producto.edit')->only('update');
        $this->middleware('can:producto.create')->only('store');
        $this->middleware('can:producto.destroy')->only('destroy');
    }

    public function consultatableproductos(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $totalRecords = Producto::count();
        $searchValue = $request->get('search')['value'];
        $query = Producto::query();
        if ($searchValue) {
            $query->where(function($q) use ($searchValue) {
                $q->where('nombre', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('categoria', function($q) use ($searchValue) {
                        $q->where('nombre', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhere('codigo', 'like', '%' . $searchValue . '%')
                    ->orWhere('precio_compra', 'like', '%' . $searchValue . '%');
            });
        }

        $recordsFiltered = $query->count();
        $productos = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($productos as $producto) {
            $text = '<b>Cantidades:</b><br>';
            foreach($producto->stocks as $stock){
                $text = $text.$stock->almacen->nombre. ': '.$stock->cantidad.'<br>';
            }
            $popoverButton = '<a type="button" class="btn btn-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-popover-color="default" data-bs-placement="top"
            data-bs-html="true"  data-bs-content="'.htmlspecialchars($text, ENT_QUOTES, 'UTF-8').'">'.$producto->stock.'</a>';

            $editButton = '<button type="button" class="btn btn-info" onclick="editar('.$producto->id.',\''.$producto->nombre.'\',\''.$producto->codigo.'\','.$producto->precio.','.$producto->precio_doc.')"><i class="fa fa-edit"></i></button>';

            $data[] = [

                $producto->id,
                $producto->nombre,
                $producto->codigo,
                number_format($producto->precio,2),
                number_format($producto->precio_compra,2),
                $popoverButton,
                $producto->estado ? 'Activo':'Inactivo',
                $editButton,
            ];
        }
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];
        return response()->json($response);
    }

    public function index()
    {
        $productos=Producto::all();
        $categorias=Categoria::orderBy('orden','asc')->get();
        $i=0;
        return view('pages.producto.index',compact('productos','i','categorias'));
    }

    public function store(ProductoRequest $request)
    {
        if($request->id == null){
            $producto=Producto::create($request->all());
        }else{
            $producto=Producto::find($request->id);
            $producto->update($request->all());
        }
        return redirect()->route('producto.index')
            ->with('success', 'Guardado Correctamente.');
    }



    public function destroy(Request $request)
    {
        $producto= Producto::findOrFail($request->id_producto_2);
        $producto->estado= $producto->estado == 1 ? '0':'1';
        $producto->save();
        return redirect()->back()->with('success','Producto Eliminado Correctamente!');
    }

    public function editpricemassive()
    {
        $series     = Serie::all();
        $categorias = Categoria::orderBy('orden','asc')->get();
        $i=0;
        return view('pages.producto.editpricemassive',compact('i','series','categorias'));
    }
    public function editpricemassivestore(Request $request)
    {
        $productos  = Producto::where('estado','1');
        if($request->serie_id != null)
        {
            $productos = $productos->where('serie_id',$request->serie_id);
        }
        if($request->categoria_id != null)
        {
            $productos = $productos->where('categoria_id',$request->categoria_id);
        }
        if($request->categoria_id == null && $request->serie_id == null)
        {
            return redirect()->back()->with('danger','Falta Serie o Categoria!');
        }
        else{
            $productos = $productos->get();
        }
        $cantidadProductos = $productos->count();
        if($request->changeorup == null)
        {
            foreach ($productos as $producto) {
                $producto->precio = $request->precio;
                $producto->save();
            }
            return redirect()->back()->with('success', $cantidadProductos . ' productos fueron Cambiados correctamente.');
        }
        else{
            foreach ($productos as $producto) {
                $producto->precio += $request->precio;
                $producto->save();
            }
            return redirect()->back()->with('success', $cantidadProductos . ' productos fueron Sumados correctamente.');
        }

    }

    public function producto_excel()
    {
        return view('pages.producto.producto-excel');
    }

    public function cargamasiva(ExcelProductoRequest $request)
    {
        Excel::import(new ProductoImport(), $request->archivo);

        return redirect()->route('producto.index')
            ->with('success', 'Productos Agregados Correctamente.');
    }

    public function buscar(Request $request)
    {
        $search = $request->get('search');

        $search2 = str_replace("'", "-", $search);
        $search2 = str_replace("¡", "+", $search2);
        $search2 = str_replace(".", "", $search2);
        
        $productos = Producto::where('nombre', 'like', '%' . $search . '%')
        ->orWhere('codigo',$search2)
        ->get()
        ->map(function ($producto) {
            return [
                'id' => $producto->id,
                'text' => $producto->nombre.'-'.$producto->codigo
            ];
        });

        return response()->json($productos);
}

}
