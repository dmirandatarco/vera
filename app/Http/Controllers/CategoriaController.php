<?php

namespace App\Http\Controllers;

use App\Http\Requests\categoriaRequest;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categoria.index')->only('index');
        $this->middleware('can:categoria.edit')->only('update');
        $this->middleware('can:categoria.editprice')->only('editprice');
        $this->middleware('can:categoria.create')->only('store');
        $this->middleware('can:categoria.destroy')->only('destroy');
    }

    public function index()
    {
        $categorias=Categoria::where('categoria_id',null)->where('estado',1)->orderBy('orden','asc')->get();
        $i=0;
        return view('pages.categoria.index',compact('categorias','i'));
    }

    public function store(categoriaRequest $request)
    {
        if($request->id == null){
            $orden = Categoria::count()+1;
            $request['orden'] = $orden;
            $categoria=Categoria::create($request->all());
        }else{
            $categoria=Categoria::find($request->id);
            $categoria->update($request->all());
        }
        return redirect()->route('categoria.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $categoria= Categoria::findOrFail($request->id_categoria_2);
        $categoria->estado= $categoria->estado == 1 ? '0':'1';
        $categoria->save();
        return redirect()->back()->with('success','Categoria Eliminado Correctamente!');
    }
    public function editprice(Request $request)
    {
        $productos = Producto::where('categoria_id',$request->id_categoria_2)->get();
        foreach ($productos as $producto) {
            $producto->precio += $request->monto;
            $producto->save();
        }
        return redirect()->route('categoria.index')
            ->with('success', 'Precios Editados Correctamente.');
    }

    public function ordenar()
    {
        $categorias=Categoria::where('categoria_id',null)->where('estado',1)->orderBy('orden','asc')->get();
        return view('pages.categoria.ordenar',compact('categorias'));
    }

    public function guardarordenar(Request $request)
    {
        foreach($request->detalle as $i => $detalle1){
            $detalle=Categoria::find($request->detalle[$i]);
            $detalle->orden=1+$i;
            $detalle->save();
        }
        return redirect()->route('categoria.index')
            ->with('success', 'Categorias ordenadas.');
    }
}
