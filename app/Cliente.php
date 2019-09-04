<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{

    use SoftDeletes;
    use Notifiable;
    protected $appends = ['email'];


    protected $fillable = [
        'persona_tipo','giro_comercial_id','nombre','apellido_paterno','apellido_materno','telefono_movil','telefono_fijo','correo',
        'fecha_nacimiento','estado_nacimiento_id','ciudad_nacimiento_id','sexo','curp','dueno_casa','trabaja','nombre_empresa','puesto',
        'industria','telefono_oficina','salario_mensual','pago_banco','salario_familiar','dependientes','tarjeta_credito_titular',
        'credito_hipotecario','credito_automotriz','historial_credito','inmueble_id','ultimos_digitos','rfc_facturar','facturacion_anual','contrasenia_sat','uuid',
        'obligado_solidario_nombre','obligado_solidario_fecha_nacimiento','obligado_solidario_direccion','rentero_nombre','rentero_folio_predial','ingreso_anual','rfc','fico_score','deuda_mensual'
    ];


    public function domicilio(){
        return $this->hasOne(Domicilio::class)->where('fiscal','=','0');
    }

    public function domicilio_empresa(){
        return $this->hasOne(Domicilio::class)->where('fiscal','=','1');
    }

    public function referencias_personales(){
        return $this->hasMany(Referencia::class)->where('tipo','=','personal');
    }

    public function referencias_clientes(){
        return $this->hasMany(Referencia::class)->where('tipo','=','cliente');
    }

    public function referencias_proveedores(){
        return $this->hasMany(Referencia::class)->where('tipo','=','proveedor');
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }

    public function clientes_documentos(){
        return $this->hasMany(ClientesDocumento::class);
    }

    public function user(){
        return $this->hasOne(User::class,'cliente_id');
    }

    public function obligado_solidario(){
        return $this->hasOne(ObligadoSolidario::class,'cliente_id');
    }

    public function estado_nacimiento(){
        return $this->belongsTo(Estado::class,'estado_nacimiento_id');
    }

    public function giro_comercial(){
        return $this->belongsTo(GiroComercial::class,'giro_comercial_id');
    }

    public function getEmailAttribute(){
        return $this->correo;
    }
    

}
