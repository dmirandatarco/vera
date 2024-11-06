<?php

namespace App\Http\Controllers;

use App\Http\Requests\SucursalRequest;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sucursal.index')->only('index');
        $this->middleware('can:sucursal.edit')->only('update');
        $this->middleware('can:sucursal.create')->only('store');
        $this->middleware('can:sucursal.destroy')->only('destroy');
    }

    public function index()
    {
        $sucursales=Sucursal::all();
        $i=0;
        return view('pages.sucursal.index',compact('sucursales','i'));
    }

    public function store(SucursalRequest $request)
    {
        if($request->id == null){
            $sucursal=Sucursal::create($request->all());
        }else{
            $sucursal=Sucursal::find($request->id);
            $sucursal->update($request->all());
        }
        return redirect()->route('sucursal.index')
            ->with('success', 'Guardado Correctamente.');
    }    

    public function destroy(Request $request)
    {
        $sucursal= Sucursal::findOrFail($request->id_sucursal_2);
        $sucursal->estado= $sucursal->estado == 1 ? '0':'1';
        $sucursal->save();
        return redirect()->back()->with('success','Sucursal Eliminado Correctamente!');
    }
}
