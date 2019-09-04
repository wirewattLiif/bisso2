<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{

    public function perfil(){
        return view('usuarios.perfil');
    }

    public function edit_perfil(Request $request){
        $usuario = User::findOrFail(Auth::user()->id);
        if ($request->caso == 1){
            $validatedData = $request->validate([
                'nombre' => 'required',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            ]);

            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
        }elseif($request->caso == 2){
            $validatedData = $request->validate([
                'password' => 'required|confirmed',
            ]);
            $usuario->password = bcrypt($request->password);
        }
        $usuario->save();
        return redirect('/mi_perfil')->with('success','Información editada correctamente.');
    }

    public function admin_index(Request $request){
        if (!in_array(Auth::user()->grupo_id,[1,2])){
            return redirect(Auth::user()->grupo->home_page)->with('danger','Información no disponible.');
        }


        if (Auth::user()->grupo_id == 1){
            $conditions = [
                ['grupo_id','!=','5'],
            ];

            $conditions_grupo = [
                ['id','!=','5'],
            ];
        }else{
            $conditions = [
                ['grupo_id','!=','5'],
                ['grupo_id','!=','1'],
            ];

            $conditions_grupo = [
                ['id','!=','5'],
                ['id','!=','1'],
            ];
        }

        $usuarios = User::where($conditions)
                    ->nombre($request->nombre_filtro)
                    ->email($request->email_filtro)
                    ->grupo($request->grupo_id_filtro)
                    ->paginate(20);

        $grupos = Grupo::where($conditions_grupo)->pluck('nombre','id');
        $grupos->prepend('Todos', ' ');

        $grupos_add = $grupos->reject(function($value,$key){
            return $value == 'Todos';
        });

        return view('usuarios.admin.index',compact('usuarios','grupos','grupos_add'));
    }

    public function admin_store(Request $request){
        if (!in_array(Auth::user()->grupo_id,[1,2])){
            return redirect(Auth::user()->grupo->home_page)->with('danger','Información no disponible.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|confirmed',
        ]);

        $usuario = User::create([
            'nombre'=>$request->nombre,
            'email'=>$request->email,
            'grupo_id'=>$request->grupo_id,
            'password'=>bcrypt($request->password)
        ]);

        return redirect('/admin/usuarios')->with('success','Usuario creado correctamente.');
    }

    public function admin_edit(Request $request){
        if (!in_array(Auth::user()->grupo_id,[1,2])){
            return redirect(Auth::user()->grupo->home_page)->with('danger','Información no disponible.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required',
            // 'email' => 'required|email|unique:users,email,'.$request->id,
            'email' => 'required|email|unique:users,email,'.$request->id.',id,deleted_at,NULL',
        ]);

        $usuario = User::findOrFail($request->id);
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->grupo_id = $request->grupo_id;

        $usuario->save();
        return redirect('/admin/usuarios')->with('success','Usuario editado correctamente.');
    }
}
