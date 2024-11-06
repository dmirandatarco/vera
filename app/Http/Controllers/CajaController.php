<?php

namespace App\Http\Controllers;

use App\Http\Requests\AperturaRequest;
use App\Http\Requests\CierreRequest;
use App\Http\Requests\PagosRequest;
use App\Models\Caja;
use App\Models\Medio;
use App\Models\Pago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    public function index()
    {
        $users = User::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->get();
        $cajas = Caja::where('sucursal_id',\Auth::user()->sucursal_id)->orderBy('fechaApertura','desc')->get();
        $i = 0;
        $ultimacaja = Caja::where('estado',0)->where('sucursal_id',\Auth::user()->sucursal_id)->latest()->first();
        $cajaactiva = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        return view('pages.caja.index', compact('i','cajas','users','ultimacaja','cajaactiva'));
    }

    public function reporte(Request $request)
    {
        $cajaid = $request->searchCaja;
        $cajaactiva = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        if(!$request->searchCaja){
            if($cajaactiva ){
                $pagos = Pago::where('caja_id',$cajaactiva->id)->orderBy('fecha','desc')->get();
            }
        }else{
            $pagos = Pago::where('caja_id',$cajaid)->orderBy('fecha','desc')->get();
        }
        if(!$request->searchCaja && !$cajaactiva){
            $pagos = [];
            $pagoSolesIngreso = 0;
            $pagoSolesEgreso = 0;
            $pagoSolesTotal = 0;
            $pagoTransferenciaIngreso = 0;
            $pagoTransferenciaEgreso = 0;
            $pagoTransferenciaTotal = 0;
        }else{
            $pagoSolesIngreso = $pagos->where('medio_id',1)->where('tipo',1)->where('estado',1)->sum('total');
            $pagoSolesEgreso = $pagos->where('medio_id',1)->where('tipo',2)->where('estado',1)->sum('total');
            $pagoSolesTotal = $pagoSolesIngreso - $pagoSolesEgreso;
            $pagoTransferenciaIngreso = $pagos->where('medio_id','!=',1)->where('tipo',1)->where('estado',1)->sum('total');
            $pagoTransferenciaEgreso = $pagos->where('medio_id','!=',1)->where('tipo',2)->where('estado',1)->sum('total');
            $pagoTransferenciaTotal = $pagoTransferenciaIngreso - $pagoTransferenciaEgreso;
        }
        $i = 0;
        $medios = Medio::where('estado',1)->get();
        
        return view('pages.caja.reporte', compact('i','pagos','medios','cajaactiva','pagoSolesTotal','pagoTransferenciaTotal','pagoSolesIngreso','pagoSolesEgreso'));
    }

    public function store(AperturaRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');
            if($request->id){
                $caja = Caja::find($request->id);
                $caja->update([
                    'totalApertura' => $request->totalApertura,
                    'user_id' => $request->user_id,
                    'observacion' => $request->observacion,
                ]);
            }else{
                $caja = Caja::create([
                    'fechaApertura' => $mytime->toDateTimeString(),
                    'totalApertura' => $request->totalApertura,
                    'estado' => 1,
                    'user_id' => $request->user_id,
                    'sucursal_id' => Auth::user()->sucursal_id,
                    'observacion' => $request->observacion,
                ]);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('caja.index')
            ->with('success', 'Caja Aperturada Correctamente.');
    }

    public function cerrar(CierreRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');
            $caja = Caja::find($request->id_caja);
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
        return redirect()->route('caja.index')
            ->with('success', 'Caja Cerrado Correctamente.');
    }

    public function pagos(PagosRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
            $mytime= Carbon::now('America/Lima');
            $pagos = Pago::create([
                'user_id' => \Auth::user()->id,
                'medio_id' => $request->medio_id,
                'caja_id' => $caja->id,
                'tipo' => $request->tipo,
                'fecha' => $mytime->toDateTimeString(),
                'total' => $request->total,
                'documento' => $request->documento,
                'observacion' => $request->observacion,
            ]);
            
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('caja.reporte')
            ->with('success', 'Agregado Correctamente.');
    }

    public function show(Caja $caja)
    {
        $i=0;
        return view('pages.caja.show',compact('caja','i'));
    }

    public function destroy(Request $request)
    {
        $pago= Pago::findOrFail($request->id_pago_2);
        $pago->estado= 0;
        $pago->save();
        return redirect()->back()->with('success','Pago Anulado Correctamente!');
    }
}
