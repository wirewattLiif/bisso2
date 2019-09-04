<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RazonSocial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'razon_social','rfc','nombre_comercial','logo','encname','filepath',
        'calle','numero_ext','numero_int','colonia','poblacion','municipio_id','estado_id','cp','creado_por','modificado_por','activo',
        'telefono','correo','web','banco','beneficiario','clabe','cuenta','rfc_beneficiario','interes_moratorio','gastos_administrativos'
    ];
    protected $table = 'razones_sociales';

    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class);
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
