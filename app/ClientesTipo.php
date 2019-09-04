<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientesTipo extends Model
{
    protected $table = 'clientes_tipos';

    public function documentos_tipos(){
        return $this->belongsToMany(DocumentosTipo::class,'clientes_tipos_documentos','cliente_tipo_id','documento_tipo_id')
            ->withPivot(['obligatorio','activo']);
    }


}
