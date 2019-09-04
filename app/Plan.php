<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre','abreviacion','id_producto','merchant_fee','interes_anual','plazo','activo','creado_por','modificado_por','comision_por_apertura','costo_anual_seguro','producto_id','personalizado','dti_pre','dti_post','ltv','enganche_min'
    ];

    protected $table = 'planes';

    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
    
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (in_array('creado_por', $model->getFillable())) {
                $model->creado_por = auth()->user()->id;
            }
            if (in_array('modificado_por', $model->getFillable())) {
                $model->modificado_por = auth()->user()->id;
            }
        });
        static::updating(function ($model) {
            if (in_array('modificado_por', $model->getFillable())) {
                $model->modificado_por = auth()->user()->id;
            }
        });
    }
}
