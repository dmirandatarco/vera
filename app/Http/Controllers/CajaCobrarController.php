<?php

namespace App\Http\Controllers;

use App\Http\Requests\AperturaRequest;
use App\Http\Requests\CierreRequest;
use App\Models\Caja;
use App\Models\CajaCobrar;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CajaCobrarController extends Controller
{
    public function index()
    {
        $users = User::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->get();
        $cajas = CajaCobrar::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fechaApertura','desc')->get();
        $i = 0;
        $ultimacaja = CajaCobrar::where('estado',0)->where('sucursal_id',\Auth::user()->sucursal_id)->latest()->first();
        $cajaactiva = CajaCobrar::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.cajacobrar.index', compact('i','cajas','users','ultimacaja','cajaactiva'));
    }

    public function store(AperturaRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');
            if($request->id){
                $caja = CajaCobrar::find($request->id);
                $caja->update([
                    'totalApertura' => $request->totalApertura,
                    'user_id' => $request->user_id,
                    'observacion' => $request->observacion,
                ]);
            }else{
                $caja = CajaCobrar::create([
                    'fechaApertura' => $mytime->toDateTimeString(),
                    'totalApertura' => $request->totalApertura,
                    'estado' => 1,
                    'user_id' => $request->user_id,
                    'sucursal_id' => \Auth::user()->sucursal_id,
                    'observacion' => $request->observacion,
                ]);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('cajacobrar.index')
            ->with('success', 'Caja Aperturada Correctamente.');
    }

    public function cerrar(CierreRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');
            $caja = CajaCobrar::find($request->id_caja);
            $caja->update([
                'fechaCierre' => $mytime->toDateTimeString(),
                'totalCierre' => $request->totalCierre,
                'totalGlobal' => $request->totalGlobal,
                'estado' => 0,
                'observacion' => $request->observacion,
            ]);
            
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('cajacobrar.index')
            ->with('success', 'Caja Cerrado Correctamente.');
    }

    public function show( $cajacobrar)
    {
        $caja = CajaCobrar::find($cajacobrar);
        $i=0;
        return view('pages.cajacobrar.show',compact('caja','i'));
    }
}
