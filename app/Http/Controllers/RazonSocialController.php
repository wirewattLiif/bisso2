<?php

namespace App\Http\Controllers;

use App\Estado;
use App\RazonSocial;
use Illuminate\Http\Request;

class RazonSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $razones = RazonSocial::all();
        $estados = Estado::all()->pluck('nombre','id');
        return view('razones_sociales.admin.index',compact('razones','estados'));
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
        $request->request->add(['activo'=>1]);
        $razon = new RazonSocial($request->all());
        $razon->save();

        return redirect(route('razones_sociales.index'))->with('success','Razón social agregada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RazonSocial  $razonSocial
     * @return \Illuminate\Http\Response
     */
    public function show(RazonSocial $razonSocial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RazonSocial  $razonSocial
     * @return \Illuminate\Http\Response
     */
    public function edit(RazonSocial $razonSocial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RazonSocial  $razonSocial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        #dd($request->all());
        $razon = RazonSocial::findOrFail($id);
        $razon->id = $request->id;
        $razon->razon_social = $request->razon_social;
        $razon->rfc = $request->rfc;
        $razon->nombre_comercial = $request->nombre_comercial;
        $razon->representante_legal = $request->representante_legal;
        $razon->calle = $request->calle;
        $razon->numero_ext = $request->numero_ext;
        $razon->numero_int = $request->numero_int;
        $razon->colonia = $request->colonia;
        $razon->estado_id = $request->estado_id;
        $razon->municipio_id = $request->municipio_id;
        $razon->cp = $request->cp;
        $razon->activo = 0;
        if(isset($request->activo)){
            $razon->activo = 1;
        }

        $razon->telefono = $request->telefono;
        $razon->correo = $request->correo;
        $razon->web = $request->web;
        $razon->banco = $request->banco;
        $razon->beneficiario = $request->beneficiario;
        $razon->cuenta = $request->cuenta;
        $razon->clabe = $request->clabe;
        $razon->rfc_beneficiario = $request->rfc_beneficiario;
        $razon->interes_moratorio = $request->interes_moratorio;
        $razon->gastos_administrativos = $request->gastos_administrativos;




        $razon->save();

        return redirect('/admin/razones_sociales')->with('success','Razón social editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RazonSocial  $razonSocial
     * @return \Illuminate\Http\Response
     */
    public function destroy(RazonSocial $razonSocial)
    {
        //
    }
}
