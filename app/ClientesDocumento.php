<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientesDocumento extends Model
{
    protected $table = 'clientes_documentos';

    protected $fillable = ['cliente_id','documento_tipo_id','filename','encname','filepath','solicitud_id','aprobado'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function documento_tipo(){
        return $this->belongsTo(DocumentosTipo::class);
    }

}
