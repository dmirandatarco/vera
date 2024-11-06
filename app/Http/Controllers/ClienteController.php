<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cliente.index')->only('index');
        $this->middleware('can:cliente.edit')->only('create','update');
        $this->middleware('can:cliente.create')->only('create','store');
        $this->middleware('can:cliente.destroy')->only('destroy');
    }

    public function index()
    {
        $clientes=Cliente::all();
        $i=0;
        return view('pages.cliente.index',compact('clientes','i'));
    }


    public function store(ClienteRequest $request)
    {
        if($request->id == null){
            $cliente=Cliente::create($request->all());
        }else{
            $cliente=Cliente::find($request->id);
            $cliente->update($request->all());
        }
        return redirect()->route('cliente.index')
            ->with('success', 'Guardado Correctamente.');
    }

    public function destroy(Request $request)
    {
        $cliente= Cliente::findOrFail($request->id_cliente_2);
        $cliente->estado= $cliente->estado == 1 ? '0':'1';
        $cliente->save();
        return redirect()->back()->with('success','Cliente Eliminado Correctamente!');
    }

    public function edit($cliente)
    {
        if($cliente == 0)
        {
            $cliente = null;
        }else{
            $cliente = Cliente::find($cliente);
        }
        return view('pages.cliente.guardar',compact('cliente'));
    }
}
