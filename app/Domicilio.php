<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $fillable = [
        'cliente_id','obligado_id','calle','numero_ext','numero_int','colonia','estado_id','municipio_id','cp','fiscal','ciudad','integrador_id','socio_id'
    ];

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
