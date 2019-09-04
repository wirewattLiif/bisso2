<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadosController extends Controller
{
    public function getMunicipios($estado_id){
        $municipios = DB::table('municipios')->where('estado_id',$estado_id)->orderBy('nombre','asc')->pluck('nombre','id');
        return $municipios;
    }
}
