<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaquinaRequest;
use App\Models\Maquina;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:maquina.index')->only('index');
        $this->middleware('can:maquina.edit')->only('update');
        $this->middleware('can:maquina.create')->only('store');
        $this->middleware('can:maquina.destroy')->only('destroy');
    }

    public function index()
    {
        $maquinas=Maquina::all();
        $i=0;
        $sucursales = Sucursal::all();
        return view('pages.maquina.index',compact('maquinas','i','sucursales'));
    }

    public function store(MaquinaRequest $request)
    {
        if($request->id == null){
            $maquina=Maquina::create($request->all());
        }else{
            $maquina=Maquina::find($request->id);
            $maquina->update($request->all());
        }
        return redirect()->route('maquina.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $maquina= Maquina::findOrFail($request->id_maquina_2);
        $maquina->estado= $maquina->estado == 1 ? '0':'1';
        $maquina->save();
        return redirect()->back()->with('success','Maquina Eliminado Correctamente!');
    }
}
