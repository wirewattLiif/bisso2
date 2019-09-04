<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosTipo extends Model
{
    protected $table = 'documentos_tipos';

    public function clientes_tipos(){
        return $this->belongsToMany(ClientesTipo::class,'clientes_tipos_documentos');
    }

    public function clientes_documentos(){
        return $this->hasMany(ClientesDocumento::class,'documento_tipo_id');
    }

}
