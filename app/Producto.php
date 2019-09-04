<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['nombre','descripcion','activo'];

    public function planes()
    {
        return $this->hasMany('App\Plan');
    }
}
