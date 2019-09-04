<?php

namespace App\Http\Controllers;

use App\CotizacionDetalle;
use Illuminate\Http\Request;

class CotizacionDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CotizacionDetalle  $cotizacionDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(CotizacionDetalle $cotizacionDetalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CotizacionDetalle  $cotizacionDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(CotizacionDetalle $cotizacionDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CotizacionDetalle  $cotizacionDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CotizacionDetalle $cotizacionDetalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CotizacionDetalle  $cotizacionDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detalle = CotizacionDetalle::findOrFail($id);
        $detalle->delete();

        return response()->json(['ok' => true ], 200);
    }
}
