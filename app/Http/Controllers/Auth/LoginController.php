<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if(!$user->active && $user->grupo_id == 6){
            #//Solo aplica para integradores, no pueden hacer login si su usuario aun no esta autorizado.
            Auth::logout($request);
            return redirect()->back();
        }
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function redirectPath()
    {
        if (Auth::user()->grupo_id == 5 && !Auth::user()->cliente->registro_completo){
            return '/aprobacion_credito';
        }elseif (Auth::user()->grupo_id == 6 && Auth::user()->active) {
            return '/integrador/cotizaciones';
        }


        return Auth::user()->grupo->home_page;
    }
}
