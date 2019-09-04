<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    public function municipios(){
        return $this->hasMany(Municipio::class);
    }
}
