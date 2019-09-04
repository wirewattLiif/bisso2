<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Integrador extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $table = 'integradores';

    public function domicilio(){
        return $this->hasOne(Domicilio::class)->where('fiscal','=','0');
    }

    public function domicilio_socio()
    {
        return $this->hasOne(Domicilio::class, 'socio_id', 'id');
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'integradores_productos', 'integrador_id', 'producto_id');
    }

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if(Auth::check()){
                $model->creado_por = auth()->user()->id;
                $model->modificado_por = auth()->user()->id;
            }else{
                $model->creado_por = 1;
                $model->modificado_por = 1;
            }

        });

        static::updating(function ($model) {
            if(Auth::check()) {
                $model->modificado_por = auth()->user()->id;
            }else{
                $model->modificado_por = 1;
            }
        });
    }
}
