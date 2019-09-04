<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use SoftDeletes;

    protected $table = 'cotizaciones';
    protected $guarded = [];


    public function cotizacion_detalle()
    {
        return $this->hasMany('App\CotizacionDetalle', 'cotizacion_id');
    }

    public function aplicante()
    {
        return $this->hasOne('App\Cliente', 'cotizacion_id');
    }

    public function integrador(){
        return $this->belongsTo('App\Integrador');   
    }

    
}
