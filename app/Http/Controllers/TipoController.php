<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoRequest;
use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tipo.index')->only('index');
        $this->middleware('can:tipo.edit')->only('update');
        $this->middleware('can:tipo.create')->only('store');
        $this->middleware('can:tipo.destroy')->only('destroy');
    }

    public function index()
    {
        $tipos=Tipo::all();
        $i=0;
        return view('pages.tipo.index',compact('tipos','i'));
    }

    public function store(TipoRequest $request)
    {
        if($request->proveedor){
            $request['proveedor'] = 1;
        }else{
            $request['proveedor'] = 0;
        }
        if($request->almacen){
            $request['almacen'] = 1;
        }else{
            $request['almacen'] = 0;
        }
        if($request->documento){
            $request['documento'] = 1;
        }else{
            $request['documento'] = 0;
        }
        if($request->id == null){
            $tipo=Tipo::create($request->all());
        }else{
            $tipo=Tipo::find($request->id);
            $tipo->update($request->all());
        }
        return redirect()->route('tipo.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $tipo= Tipo::findOrFail($request->id_tipo_2);
        $tipo->estado= $tipo->estado == 1 ? '0':'1';
        $tipo->save();
        return redirect()->back()->with('success','Tipo de Movimiento Eliminado Correctamente!');
    }
}
