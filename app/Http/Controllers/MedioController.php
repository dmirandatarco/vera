<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedioRequest;
use App\Models\Medio;
use Illuminate\Http\Request;

class MedioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:medio.index')->only('index');
        $this->middleware('can:medio.edit')->only('update');
        $this->middleware('can:medio.create')->only('store');
        $this->middleware('can:medio.destroy')->only('destroy');
    }

    public function index()
    {
        $medios=Medio::all();
        $i=0;
        return view('pages.medio.index',compact('medios','i'));
    }

    public function store(MedioRequest $request)
    {
        if($request->id == null){
            $medio=Medio::create($request->all());
        }else{
            $medio=Medio::find($request->id);
            $medio->update($request->all());
        }
        return redirect()->route('medio.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $medio= Medio::findOrFail($request->id_medio_2);
        $medio->estado= $medio->estado == 1 ? '0':'1';
        $medio->save();
        return redirect()->back()->with('success','Medio de Pago Eliminado Correctamente!');
    }
}
