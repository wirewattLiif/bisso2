<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password','grupo_id','creado_por','cliente_id','integrador_id','phone','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function grupo(){
        return $this->belongsTo(Grupo::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function integrador(){
        return $this->belongsTo(Integrador::class);
    }


    public function scopeNombre($query,$nombre){
        if(!empty($nombre)){
            $query->where('nombre','like','%'.$nombre.'%');
        }
    }

    public function scopeEmail($query,$email){
        if (!empty($email)){
            $query->where('email','like','%'.$email.'%');
        }
    }

    public function scopeGrupo($query,$grupo_id){
        if (!empty($grupo_id)){
            $query->where('grupo_id',$grupo_id);
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
