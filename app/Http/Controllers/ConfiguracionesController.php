<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    public function show(){
        $configs = Configuracion::findOrFail(1);

        return view('configuraciones.show',compact('configs'));
    }


    public function update(Request $request){


        $config = Configuracion::find(1);
        if (empty($config)){
            return redirect('/admin/configuraciones')->with('danger','No se encontraron configuraciones para editar');
        }

        #validamos los datos
        $request->validate([
            'interes_anual'=>'required|numeric',
            'iva'=>'required|numeric',
            'descuento_opcion_compra'=>'required|numeric',
            'porcentaje_pago_valor_residual'=>'required|numeric',
            'escalador'=>'required|numeric',
            'comision_por_apertura'=>'required|numeric',
            'monto_min_financiar'=>'required|numeric',
            'interes_ordinario'=>'required|numeric',
            'interes_moratorio'=>'required|numeric',
        ]);



        $config->interes_anual = $request->interes_anual;
        $config->iva = $request->iva;
        $config->descuento_opcion_compra = $request->descuento_opcion_compra;
        $config->porcentaje_pago_valor_residual = $request->porcentaje_pago_valor_residual;
        $config->escalador = $request->escalador;
        $config->comision_por_apertura = $request->comision_por_apertura;
        $config->monto_min_financiar = $request->monto_min_financiar;
        $config->interes_ordinario = $request->interes_ordinario;
        $config->interes_moratorio = $request->interes_moratorio;
        $config->save();

        return redirect('/admin/configuraciones')->with('success','Información actualizada');
    }
}
