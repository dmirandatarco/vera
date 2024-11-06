<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{   
    public function showLoginForm(){
        return view('pages.auth.login');
    }

    public function login(Request $request){

        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('usuario', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->estado==1){
                if(Auth::user()->roles[0]->id == 2){
                    return redirect()->intended('/ventas');
                }
                if(Auth::user()->roles[0]->id == 4){
                    return redirect()->intended('/cobrar/cobrar');
                }
                return redirect()->intended('/');
            }else{
                Auth::logout();
            }
        }
        return back()->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario']));
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
