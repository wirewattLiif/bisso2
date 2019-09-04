<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObligadoSolidario extends Model
{
    protected $table = 'obligados_solidarios';

    protected $fillable = ['cliente_id','nombre','apellido_paterno','apellido_materno','fecha_nacimiento','estado_nacimiento_id','sexo','curp','rfc','fico_score','deuda_mensual'];

    public function domicilio(){
        return $this->hasOne(Domicilio::class,'obligado_id');
    }
}
