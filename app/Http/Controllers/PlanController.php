<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Producto;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planes = Plan::all();
        $productos = Producto::all()->pluck('nombre','id');
        return view('planes.admin.index',compact('planes','productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #dd($request->all());
        $request->validate([
            'nombre' => 'required|string',
            'abreviacion' => 'string',
            'id_producto' => 'required|integer',
            'merchant_fee' => 'required|numeric',
            'interes_anual' => 'required|numeric',
            'plazo' => 'required|integer',
            'comision_por_apertura' => 'required|numeric',
            'producto_id' => 'required',
        ]);

        $request->request->add(['activo'=>1]);
        if(!isset($request->costo_anual_seguro)){
            $request->request->add(['costo_anual_seguro'=>0]);
        }

        $request->request->add(['personalizado'=>1]);
        if(!isset($request->personalizado)){
            $request->request->add(['personalizado'=>0]);
        }
        $plan = new Plan($request->all());
        $plan->save();

        return back()->with('success','Plan agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        #dd($request->all());
        $plan = Plan::findOrFail($id);
        
        $plan->nombre = $request->nombre;
        $plan->abreviacion = $request->abreviacion;
        $plan->id_producto = $request->id_producto;
        $plan->producto_id = $request->producto_id;
        $plan->merchant_fee = $request->merchant_fee;
        $plan->interes_anual = $request->interes_anual;
        $plan->plazo = $request->plazo;
        $plan->ltv = $request->ltv;
        $plan->enganche_min = $request->enganche_min;

        $plan->dti_pre = $request->dti_pre;
        $plan->dti_post = $request->dti_post;

        $plan->activo = 0;
        if(isset($request->activo)){
            $plan->activo = 1;
        }

        $plan->personalizado = 0;
        if(isset($request->personalizado)){
            $plan->personalizado = 1;
        }


        $plan->costo_anual_seguro = 0;
        if(isset($request->costo_anual_seguro)){
            $plan->costo_anual_seguro = 1;
        }
        $plan->comision_por_apertura = $request->comision_por_apertura;

        $plan->save();
        return back()->with('success','Plan editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::destroy($id);
        return redirect('/admin/planes')->with('success','Plan eliminado correctamente');   
    }
}
