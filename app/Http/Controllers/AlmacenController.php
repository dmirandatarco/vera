<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlmacenRequest;
use App\Models\Almacen;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:almacen.index')->only('index');
        $this->middleware('can:almacen.edit')->only('update');
        $this->middleware('can:almacen.create')->only('store');
        $this->middleware('can:almacen.destroy')->only('destroy');
    }

    public function index()
    {
        $almacenes=Almacen::all();
        $sucursales=Sucursal::all();
        $i=0;
        return view('pages.almacen.index',compact('almacenes','i','sucursales'));
    }

    public function store(AlmacenRequest $request)
    {
        $almacen = Almacen::all();
        if($request->predeterminada){
            $request['predeterminada'] = 1;
            Almacen::query()->update(['predeterminada' => 0]);
        }else{
            $request['predeterminada'] = 0;
            if(count($almacen)<1){
                $request['predeterminada'] = 1;
            }
        }
        if($request->id == null){
            $almacen=Almacen::create($request->all());
        }else{
            $almacen=Almacen::find($request->id);
            $almacen->update($request->all());
        }
        return redirect()->route('almacen.index')
            ->with('success', 'Guardado Correctamente.');
    }    

    public function destroy(Request $request)
    {
        $almacen= Almacen::findOrFail($request->id_almacen_2);
        $almacen->estado= $almacen->estado == 1 ? '0':'1';
        $almacen->save();
        return redirect()->back()->with('success','Almacen Eliminado Correctamente!');
    }
}
