<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AprobacionCredito extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        #dd($this->all());
        if ($this->input('step') == 1){
            return [
                'nombre' => 'required|string',
                'apellido_paterno' => 'required|string',
                'apellido_materno' => 'required|string',
                'correo' => 'required|string|email|max:255|unique:users,email,'. Auth::user()->id.',id,deleted_at,NULL',
                'password' => 'confirmed',
                'persona_tipo' => 'required|string',
            ];
        }
        elseif ($this->input('step') == 2){
            $this['fecha_nacimiento'] = Carbon::parse($this->input('fecha_nacimiento'))->format('Y-m-d');

            return [
                'fecha_nacimiento' => 'required|date',
                'estado_nacimiento_id' => 'required',
                'sexo' => 'required|string',
                'rfc' => 'required|string',
                'curp' => 'required|string',
            ];
        }
        elseif($this->input('step') == 3){
            return [
                'cliente_id'=>'integer|required',
                'calle' => 'required|string',
                'num_ext' => 'string',
                'colonia' => 'required|string',
                'estado_id' => 'required|integer',
                'municipio_id'=>'required|integer',
                'cp'=>'required|integer',
                'dueno_casa'=>'required|boolean'
            ];
        }
        elseif($this->input('step') == 4){
            if ($this->input('persona_tipo') == 'fisica'){
                return [
                    'cliente_id'=>'integer|required',
                    'giro_comercial_id'=>'integer|required',
                    'trabaja' => 'required|boolean',
                    'nombre_empresa' => 'string',
                    'puesto' => 'required|string',
                    'salario_mensual'=>'required|numeric',
                    'salario_familiar'=>'required|numeric',
                    'telefono_oficina' => 'required|string',
                    'pago_banco'=>'required|boolean',
                    'dependientes'=>'required|integer'
                ];
            }else{
                return[
                    'cliente_id'=>'integer|required',
                    'rfc_facturar'=>'string|required',
                    'telefono_oficina' => 'required|string',
                    'nombre_empresa' => 'string|required',
                    'giro_comercial_id'=>'integer|required',
                    'dependientes'=>'integer',
                    'domicilio_calle'=>'string',
                    'domicilio_estado_id'=>'required|integer',
                    'domicilio_municipio_id'=>'required|integer',
                    'domicilio_colonia'=>'string',
                ];
            }
        }
        elseif($this->input('step') == 5){
            return [
                'cliente_id'=>'integer|required',
            ];
        }
        elseif($this->input('step') == 6){
            return [
                'cliente_id'=>'integer|required',
                'solicitud_id'=>'integer|required',
                'total_paneles'=>'integer|required',
                'capacidad_paneles'=>'string|required',
                'cfe_promedio'=>'required|numeric',
                'ahorros_proyectados_mes'=>'required|numeric',
                'empresa_instaladora_solar'=>'string|nullable',
                'fecha_instalacion_tentativa'=>'required|date',
                'capacidad_sistema'=>'numeric|required',
            ];
        }
        elseif($this->input('step') == 7){
            return [
                'cliente_id'=>'integer|required',
                'solicitud_id'=>'integer|required',
                'precio_sistema'=>'numeric|required',
                'enganche'=>'numeric|required',
                'plazo_financiar'=>'numeric|required',
            ];
        }
        elseif($this->input('step') == 8){

            if($this->input('tarjeta_credito_titular')){
                return [
                    'cliente_id'=>'integer|required',
                    'tarjeta_credito_titular'=>'boolean',
                    'ultimos_digitos'=>'numeric|digits:4|required',
                    'credito_hipotecario'=>'boolean',
                    'credito_automotriz'=>'boolean',
                    'historial_credito'=>'string|required',
                ];
            }else{
                return [
                    'cliente_id'=>'integer|required',
                    'tarjeta_credito_titular'=>'boolean',
                    'credito_hipotecario'=>'boolean',
                    'credito_automotriz'=>'boolean',
                    'historial_credito'=>'string|required',
                ];
            }

        }
    }
}
