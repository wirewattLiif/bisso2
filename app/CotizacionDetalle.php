<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CotizacionDetalle extends Model
{
    use SoftDeletes;
    
    protected $table = 'cotizaciones_detalle';
    protected $guarded = [];


    public function cotizacion()
    {
        return $this->belongsTo('App\Cotizacion');
    }

    public function solicitud()
    {
        return $this->hasOne('App\Solicitud', 'preautorizacion_id');
    }

    /* public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'preautorizacion_id');
    } */

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function estatus()
    {
        return $this->belongsTo('App\CotizacionDetalleEstatus','estatus_id');
    }

}
