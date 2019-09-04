<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $fillable = ['cliente_id','nombre','apellido_paterno','apellido_materno','telefono','tipo'];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
