<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use Illuminate\Http\Request;
use App\Models\Proveedor;


class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proveedor.index')->only('index');
        $this->middleware('can:proveedor.edit')->only('update');
        $this->middleware('can:proveedor.create')->only('store');
        $this->middleware('can:proveedor.show')->only('show');
        $this->middleware('can:proveedor.destroy')->only('destroy');
    }

    public function index()
    {
        $proveedors=Proveedor::all();
        $i=0;
        return view('pages.proveedor.index',compact('proveedors','i'));
    }
    public function create()
    {
        return view('pages.proveedor.create');
    }
    public function edit(Proveedor $proveedor)
    {
        return view('pages.proveedor.edit',compact('proveedor'));
    }


    public function store(ProveedorRequest $request)
    {
        $proveedor=Proveedor::create($request->all());
        return redirect()->route('proveedor.index')->with('success', 'Guardado Correctamente.');
    }
    public function show(Proveedor $proveedor)
    {
        return view('pages.proveedor.show',compact('proveedor'));
    }

    public function update(ProveedorRequest $request,Proveedor $proveedor)
    {
        $proveedor->update($request->all());
        return redirect()->route('proveedor.index')->with('success', 'Guardado Correctamente.');
    }


    public function destroy(Request $request)
    {
        $proveedor= Proveedor::findOrFail($request->id_proveedor_2);
        $proveedor->estado= $proveedor->estado == 1 ? '0':'1';
        $proveedor->save();
        return redirect()->back()->with('success','Proveedor Eliminado Correctamente!');
    }
}
