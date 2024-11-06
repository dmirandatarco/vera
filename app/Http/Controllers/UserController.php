<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Maquina;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.index')->only('index');
        $this->middleware('can:user.edit')->only('edit','update');
        $this->middleware('can:user.create')->only('create','store');
        $this->middleware('can:user.destroy')->only('destroy');
        $this->middleware('can:user.show')->only('show');
    }

    public function index()
    {
        $users=User::all();
        $i=0;
        return view('pages.user.index',compact('users','i'));
    }

    public function create()
    {
        $roles=Role::all();
        $sucursales = Sucursal::where('estado',1)->get();
        return view('pages.user.create',compact('roles','sucursales'));
    }

    public function store(UserRequest $request)
    {
        if($request->hasFile('imagen'))
        {
            $nombreimg=Str::slug($request->usuario,'-').'.'.$request->file('imagen')->getClientOriginalExtension();
            $ruta=$request->imagen->storeAs('/usuario',$nombreimg);
        }else{
            $nombreimg="default.png";
        }
        $user=User::create($request->all());
        $user->imagen = 'storage/usuario/'.$nombreimg;
        $user->save();
        $user->roles()->sync($request->idrol);
        return redirect()->route('user.index')
            ->with('success', 'Usuario Agregado Correctamente.');
    }

    public function update(UserRequest $request,User $user)
    {
        if($request->hasFile('imagen'))
        {
            $nombreimg=Str::slug($request->usuario,'-').'.'.$request->file('imagen')->getClientOriginalExtension();
            $ruta=$request->imagen->storeAs('/usuario',$nombreimg);
        }
        // Obtener los datos que se desean actualizar
        $datosActualizados = $request->except(['password']);

        // Verificar si se proporcionó una nueva contraseña
        if ($request->filled('password')) {
            // Hash de la nueva contraseña
            $datosActualizados['password'] = $request->password;
        }

        // Actualizar el usuario con los datos modificados
        $user->update($datosActualizados);
        
        if($request->hasFile('imagen'))
        {
            $user->imagen = 'storage/usuario/'.$nombreimg;
            $user->save();
        }
        $user->roles()->sync($request->idrol);
        return redirect()->route('user.index')->with('success','Usuario Modificado Correctamente!');
    }

    public function destroy(Request $request)
    {
        $user= User::findOrFail($request->id_usuario_2);
        $user->estado= $user->estado == 1 ? '0':'1';
        $user->save();
        return redirect()->back()->with('success','Usuario Eliminado Correctamente!');
    }

    public function show(User $user)
    {
        return view('pages.user.show',compact('user'));
    }

    public function edit(User $user)
    {
        $roles=Role::all();
        $sucursales = Sucursal::where('estado',1)->get();
        return view('pages.user.edit',compact('user','roles','sucursales'));
    }

    public function perfil(User $user)
    {
        $roles=Role::all();
        $sucursales = Sucursal::where('estado',1)->get();
        return view('pages.user.perfil',compact('user','roles','sucursales'));
    }

    public function perfilguardar(UserRequest $request,User $user)
    {
        if($request->hasFile('imagen'))
        {
            $nombreimg=Str::slug($request->usuario,'-').'.'.$request->file('imagen')->getClientOriginalExtension();
            $ruta=$request->imagen->storeAs('/usuario',$nombreimg);
        }
        $user->update($request->all());
        if($request->hasFile('imagen'))
        {
            $user->imagen = 'storage/usuario/'.$nombreimg;
            $user->save();
        }
        $user->roles()->sync($request->idrol);
        return redirect()->back()->with('success','Guardado Correctamente!');
    }

    public function cambiar(Request $request)
    {
        $request->validate( [
            'sucursal_id' => 'required|exists:sucursals,id'
        ]); 

        $user = User::find(\Auth::user()->id);
        $user->sucursal_id = $request->sucursal_id;
        $user->save();

        return redirect()->back();
    }
}
