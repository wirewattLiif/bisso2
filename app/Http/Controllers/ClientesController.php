<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Configuracion;
use App\Domicilio;
use App\Estado;
use App\GiroComercial;
use App\Http\Requests\AprobacionCredito;
use App\Http\Requests\RegistroCliente;
use App\Inmueble;
use App\Plan;

use App\Mail\SolicitudAutorizada;
use App\Referencia;
use App\Solicitud;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\View\View;

use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionInicial;


use Spatie\ArrayToXml\ArrayToXml;


class ClientesController extends Controller
{

    public function registro(){
        if (Auth::check() && Auth::user()->grupo_id == 5 && Auth::user()->cliente->registro_completo == 1){
            return redirect(Auth::user()->grupo->home_page);
        }

        $estados = Estado::pluck('nombre','id');
        $inmuebles = Inmueble::pluck('nombre','id');

        $configuracion = Configuracion::find(1);
        $minFinanciar = $configuracion->monto_min_financiar;

        $_planes = Plan::all()->where('activo',true);
        $planes = [];
        $planes_list = [];
        foreach ($_planes as $p){
            $planes[$p->id]['id'] = $p->id;
            $planes[$p->id]['nombre'] = $p->nombre;
            $planes[$p->id]['merchant_fee'] = floatval($p->merchant_fee);
            $planes[$p->id]['interes_anual'] = floatval($p->interes_anual);
            $planes[$p->id]['plazo'] = $p->plazo;

            $planes[$p->id]['aplica_costo_anual_seguro'] = boolval($p->costo_anual_seguro);
            $planes[$p->id]['comision_por_apertura'] = floatval($p->comision_por_apertura);

            $planes_list[$p->id] = $p->nombre;
        }


        $planes = json_encode($planes);
        return view('clientes.registro',compact('estados','inmuebles','minFinanciar','configuracion','planes_list','planes'));
    }

    public function registro_cliente(Request $request){
        if ($request->ajax()){

            $request->validate([
                'cliente_nombre' => 'required|string',
                'cliente_apellido_paterno' => 'required|string',
                'cliente_correo' => 'required|string|email|max:255',
                'cliente_estado_nacimiento_id' => 'required|integer',
                'solicitud_precio_sistema'=>'required|numeric',
                'solicitud_plazo_financiar'=>'required|numeric',
            ]);


            #dd($request->all());

            #//Revisamos si algun cliente esta registrado con correo
            $cliente = Cliente::where('correo',$request->cliente_correo)->first();
            if (!is_null($cliente) && $cliente->registro_completo){
                #//El cliente ya tiene un registro completo de solicitud.
                return ['error'=>true,'msj'=>'El correo ingresado ya tiene un registro de solicitud completo.'];
            }


            $success = true;
            DB::beginTransaction();
            try{
                #//Find a configuraciones y guardar los datos a nivel de solicitud
                $configuracion = Configuracion::find(1);
                $monto_financiar = $request->solicitud_precio_sistema - $request->solicitud_enganche;
                $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;

                $aplica_costo_anual_seguro = true; #//Si no tiene plan es custom y siempre aplica

                $plan_id = $request->solicitud_plan_id;
                $interes_anual = $configuracion->interes_anual;
                if(!empty($plan_id)){
                    $plan = Plan::find($plan_id);
                    $interes_anual = $plan->interes_anual;
                    $porcentaje_comision_por_apertura = (!is_null($plan->comision_por_apertura))?$plan->comision_por_apertura:0;
                    $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
                }
                #//Calcular
                $comision_por_apertura = $monto_financiar * ($porcentaje_comision_por_apertura / 100);



                $costo_anual_seguro = 0;
                if($aplica_costo_anual_seguro){
                    if ($monto_financiar <= 110000){
                        $costo_anual_seguro = 2085;
                    }elseif($monto_financiar > 110000 && $monto_financiar <= 220000){
                        $costo_anual_seguro = 2464;
                    }elseif($monto_financiar > 220000 && $monto_financiar <= 310000){
                        $costo_anual_seguro = 3601;
                    }elseif($monto_financiar > 310000){
                        $costo_anual_seguro = 3980;
                    }
                }
                $pago_inicial = $costo_anual_seguro + $comision_por_apertura;

                #//Si existe en BD
                if(!is_null($cliente))
                {
                    #//Si existe el cliente, solo debería de tener una solicitud
                    #//Hacemos update a los datos
                    $cliente->nombre = $request->cliente_nombre;
                    $cliente->apellido_paterno = $request->cliente_apellido_paterno;
                    $cliente->apellido_materno = $request->cliente_apellido_materno;
                    $cliente->telefono_movil = $request->cliente_telefono_movil;
                    $cliente->estado_nacimiento_id = $request->cliente_estado_nacimiento_id;
                    $cliente->inmueble_id = $request->cliente_inmueble_id;
                    $cliente->save();


                    $solicitud = $cliente->solicitudes->first();
                    $solicitud->precio_sistema = $request->solicitud_precio_sistema;
                    $solicitud->enganche = $request->solicitud_enganche;
                    $solicitud->plazo_financiar = $request->solicitud_plazo_financiar;
                    $solicitud->monto_financiar = $monto_financiar;
                    $solicitud->plan_id = $request->solicitud_plan_id;

                    $solicitud->interes_anual = $interes_anual;
                    $solicitud->porcentaje_iva = $configuracion->iva ;
                    $solicitud->descuento_opcion_compra = $configuracion->descuento_opcion_compra;
                    $solicitud->porcentaje_pago_valor_residual = $configuracion->porcentaje_pago_valor_residual ;
                    $solicitud->escalador = $configuracion->escalador;

                    $solicitud->porcentaje_comision_por_apertura = $porcentaje_comision_por_apertura;
                    $solicitud->comision_por_apertura = $comision_por_apertura;
                    $solicitud->costo_anual_seguro = $costo_anual_seguro;
                    $solicitud->aplica_costo_anual_seguro = ($aplica_costo_anual_seguro)?true:false;

                    $solicitud->pago_inicial = $pago_inicial;


                    $solicitud->deuda_mensual = 0;
                    $solicitud->fico = 0;

                    $solicitud->save();

                    $user = $cliente->user;

                }
                else
                {

                    #//Nuevo registro

                    #//Si no existe el cliente es un save
                    $save_cliente = Cliente::create([
                        'nombre'=>$request->cliente_nombre,
                        'apellido_paterno'=>$request->cliente_apellido_paterno,
                        'apellido_materno'=>$request->cliente_apellido_materno,
                        'telefono_movil'=>$request->cliente_telefono_movil,
                        'correo'=>$request->cliente_correo,
                        'estado_nacimiento_id'=>$request->cliente_estado_nacimiento_id,
                        'persona_tipo'=>null,
                        'uuid'=>Str::uuid()
                    ]);

                    $user = new User([
                        'nombre'=>$request->cliente_nombre,
                        'email'=>$request->cliente_correo,
                        'grupo_id'=>5
                    ]);
                    $user = $save_cliente->user()->save($user);

                    #//Agregar plan id
                    #//Dependiendo del plan es el interes anual que se debe de guardar
                    $solicitud = new Solicitud([
                        'estatus_id'=>6,
                        'precio_sistema'=>$request->solicitud_precio_sistema,
                        'monto_financiar'=>$monto_financiar,
                        'plazo_financiar'=>$request->solicitud_plazo_financiar,
                        'enganche'=>$request->solicitud_enganche,
                        'interes_anual'=>$interes_anual,
                        'porcentaje_iva'=>$configuracion->iva,
                        'descuento_opcion_compra'=>$configuracion->descuento_opcion_compra,
                        'porcentaje_pago_valor_residual'=>$configuracion->porcentaje_pago_valor_residual,
                        'escalador'=>$configuracion->escalador,
                        'porcentaje_comision_por_apertura'=>$porcentaje_comision_por_apertura,
                        'comision_por_apertura'=>$comision_por_apertura,
                        'costo_anual_seguro'=>$costo_anual_seguro,
                        'aplica_costo_anual_seguro'=>($aplica_costo_anual_seguro)?true:false,
                        'pago_inicial'=>$pago_inicial,
                        'deuda_mensual'=>0,
                        'fico'=>0,
                        'plan_id'=>$request->solicitud_plan_id
                    ]);


                    $save_cliente->solicitudes()->save($solicitud);
                    #dd($solicitud);

                }

                #//Notificacion de nueva solicitud
                $this->mailNuevaSolicitud($solicitud);



            }catch (\Exception $exception){
                $success = $exception->getMessage();
                return ['error'=>true,'msj'=>$exception->getMessage()];
                DB::rollBack();
            }

            if ($success === true){
                DB::commit();
                auth()->loginUsingId($user->id);
                return ['error'=>false,'msj'=>'ok','solicitud'=>$solicitud];
                #return redirect()->route('aprobacion_credito')->with('success','Registrado correctamente');
            }
            abort(404);
        }
        abort(404);
    }

    private function mailNuevaSolicitud($solicitud){

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $nombre_archivo = $solicitud->id.'.pdf';

        $primer_mensualidad = $periodos[1]['subtotal'];

        $pdf = PDF::loadView('pdfs.detalle_solicitud',compact('solicitud','periodos'))->save($nombre_archivo);
        Mail::to($solicitud->cliente->correo)->send(new CotizacionInicial($solicitud,$primer_mensualidad));
        #//eliminamos PDF generado del server
        \File::delete($nombre_archivo);
    }

    public function aprobacion_credito(){
        if (Auth::check() && !Auth::user()->cliente->registro_completo){
            $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio', 7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
            $estados = Estado::pluck('nombre','id');

            $giros = GiroComercial::where('activo',1)->orderByRaw('nombre ASC')->pluck('nombre','id');

            $configuracion = Configuracion::find(1);
            $minFinanciar = $configuracion->monto_min_financiar;
            $maxEnganche = Auth::user()->cliente->solicitudes[0]->precio_sistema - $minFinanciar;

            $_planes = Plan::all()->where('activo',true);
            $planes = [];
            $planes_list = [];
            foreach ($_planes as $p){
                $planes[$p->id]['id'] = $p->id;
                $planes[$p->id]['nombre'] = $p->nombre;
                $planes[$p->id]['merchant_fee'] = floatval($p->merchant_fee);
                $planes[$p->id]['interes_anual'] = floatval($p->interes_anual);
                $planes[$p->id]['plazo'] = $p->plazo;

                $planes_list[$p->id] = $p->nombre;
            }
            $planes = json_encode($planes);

            return view('clientes.aprobacion_credito',compact('meses','estados','giros','minFinanciar','maxEnganche','planes_list','planes'));
        }

        //Mensaje que ya tiene la solicitud completa
        return redirect(Auth::user()->grupo->home_page);
    }

    public function postSteps(AprobacionCredito $request){
        if ($request->input('step') == 1){
            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->nombre = $request->input('nombre');
            $cliente->correo = $request->input('correo');
            $cliente->apellido_paterno = $request->input('apellido_paterno');
            $cliente->apellido_materno = $request->input('apellido_materno');
            $cliente->telefono_movil = $request->input('telefono_movil');
            $cliente->persona_tipo = $request->input('persona_tipo');
            $cliente->save();

            if (isset($request->password)){
                $update = [
                    'email'=>$request->input('correo'),
                    'nombre'=>$request->input('nombre'),
                    'password'=>Hash::make($request->input('password'))
                ];
            }else{
                $update = [
                    'email'=>$request->input('correo'),
                    'nombre'=>$request->input('nombre'),
                ];
            }
            $cliente->user()->update($update);
            return ['msg'=>'ok'];
        }
        elseif( $request->input('step') == 2){
            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->estado_nacimiento_id = $request->input('estado_nacimiento_id');
            $cliente->sexo = $request->input('sexo');
            $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
            $cliente->rfc = $request->input('rfc');
            $cliente->curp = $request->input('curp');
            $cliente->save();

            return ['msg'=>'ok'];
        }
        elseif( $request->input('step') == 3){

            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->dueno_casa = $request->input('dueno_casa');
            $cliente->telefono_fijo = $request->input('telefono_casa');
            $cliente->save();

            $domicilio = Domicilio::updateOrCreate(
                ['cliente_id'=>$request->input('cliente_id'), 'fiscal'=>0 ],
                [
                    'calle'=>$request->input('calle'),
                    'numero_ext'=>$request->input('numero_ext'),
                    'numero_int'=>$request->input('numero_int'),
                    'colonia'=>$request->input('colonia'),
                    'estado_id'=>$request->input('estado_id'),
                    'municipio_id'=>$request->input('municipio_id'),
                    'cp'=>$request->input('cp'),
                    'ciudad'=>$request->input('ciudad'),
                    'fiscal'=>0,
                ]
            );
            return ['msg'=>'ok'];
        }
        elseif( $request->input('step') == 4){
            #dd($request->all());
            $cliente = Cliente::find($request->input('cliente_id'));

            if ($request->persona_tipo == 'fisica'){
                $cliente->trabaja = $request->input('trabaja');
                $cliente->nombre_empresa = $request->input('nombre_empresa');
                $cliente->puesto = $request->input('puesto');
                $cliente->salario_mensual = $request->input('salario_mensual');
                $cliente->salario_familiar = $request->input('salario_familiar');
                $cliente->telefono_oficina = $request->input('telefono_oficina');
                $cliente->pago_banco = $request->input('pago_banco');
                $cliente->dependientes = $request->input('dependientes');
                $cliente->giro_comercial_id = $request->input('giro_comercial_id');
                $cliente->save();
            }else{
                $cliente->persona_tipo = $request->input('persona_tipo');
                $cliente->rfc_facturar = $request->input('rfc_facturar');
                $cliente->contrasenia_sat = $request->input('contrasenia_sat');
                $cliente->telefono_oficina = $request->input('telefono_oficina');
                $cliente->nombre_empresa = $request->input('nombre_empresa');
                $cliente->giro_comercial_id = $request->input('giro_comercial_id');
                $cliente->dependientes = $request->input('dependientes');
                $cliente->ingresos_anuales= $request->input('ingresos_anuales');

                $cliente->save();

                $domicilio = Domicilio::updateOrCreate(
                    ['cliente_id'=>$request->input('cliente_id'), 'fiscal'=>1 ],
                    [
                        'calle'=>$request->input('domicilio_calle'),
                        'numero_ext'=>$request->input('domicilio_numero_ext'),
                        'numero_int'=>$request->input('domicilio_numero_int'),
                        'colonia'=>$request->input('domicilio_colonia'),
                        'estado_id'=>$request->input('domicilio_estado_id'),
                        'municipio_id'=>$request->input('domicilio_municipio_id'),
                        'fiscal'=>1,
                    ]
                );
            }
            return ['msg'=>'ok'];
        }
        elseif($request->input('step') == 5) {
            if ($request->persona_tipo == 'fisica'){

                foreach ($request->input('referencias') as $k => $referencia) {
                    if (!empty($referencia['nombre'])) {
                        $referencia = Referencia::updateOrCreate(
                            ['id' => $referencia['id'],'tipo'=>'personal'],
                            [
                                'cliente_id' => $request->input('cliente_id'),
                                'nombre' => $referencia['nombre'],
                                'telefono' => $referencia['telefono'],
                                'tipo'=>'personal'
                            ]
                        );
                    }
                }

            }else{
                #//Referencias de proveedores
                foreach ($request->input('referencias_proveedor') as $k => $ref) {
                    if (!empty($ref['nombre'])){
                        $referencia = Referencia::updateOrCreate(
                            ['id' => $ref['id'],'tipo'=>'proveedor'],
                            [
                                'cliente_id' => $request->input('cliente_id'),
                                'nombre' => $ref['nombre'],
                                'telefono' => $ref['telefono'],
                                'tipo'=>'proveedor'
                            ]
                        );
                    }
                }

                #//Referencias de clientes
                foreach ($request->input('referencias_cliente') as $k => $ref) {
                    if (!empty($ref['nombre'])){
                        $referencia = Referencia::updateOrCreate(
                            ['id' => $ref['id'],'tipo'=>'cliente'],
                            [
                                'cliente_id' => $request->input('cliente_id'),
                                'nombre' => $ref['nombre'],
                                'telefono' => $ref['telefono'],
                                'tipo'=>'cliente'
                            ]
                        );
                    }
                }
            }

            return ['msg' => 'ok'];
        }
        elseif($request->input('step') == 6){

            $solicitud = Solicitud::find($request->input('solicitud_id'));
            $solicitud->total_paneles = $request->input('total_paneles');
            $solicitud->capacidad_paneles = $request->input('capacidad_paneles');
            $solicitud->cfe_promedio = $request->input('cfe_promedio');
            $solicitud->ahorros_proyectados_mes = $request->input('ahorros_proyectados_mes');
            $solicitud->empresa_instaladora_solar = $request->input('empresa_instaladora_solar');
            $solicitud->fecha_instalacion_tentativa = $request->input('fecha_instalacion_tentativa');

            $solicitud->capacidad_sistema = $request->input('capacidad_sistema');
            $solicitud->contacto_instaladora = $request->input('contacto_instaladora');
            $solicitud->save();
            return ['msg' => 'ok'];
        }
        elseif($request->input('step') == 7){
            #//dd($request->all());

            $solicitud = Solicitud::find($request->input('solicitud_id'));
            $configuracion = Configuracion::find(1);
            $monto_financiar = $request->input('precio_sistema') - $request->input('enganche');
            $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;

            $aplica_costo_anual_seguro = true; #//Si no tiene plan es custom y siempre aplica

            $plan_id = $request->plan_id;
            $interes_anual = $configuracion->interes_anual;


            if(!empty($plan_id)){
                $plan = Plan::find($plan_id);
                $interes_anual = $plan->interes_anual;
                $porcentaje_comision_por_apertura = (!is_null($plan->comision_por_apertura))?$plan->comision_por_apertura:0;
                $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
            }

            $comision_por_apertura = $monto_financiar * ($porcentaje_comision_por_apertura / 100);

            $costo_anual_seguro = 0;
            #//Solo si aplica, lo calculamos
            if($aplica_costo_anual_seguro){
                if ($monto_financiar <= 110000){
                    $costo_anual_seguro = 2085;
                }elseif($monto_financiar > 110000 && $monto_financiar <= 220000){
                    $costo_anual_seguro = 2464;
                }elseif($monto_financiar > 220000 && $monto_financiar <= 310000){
                    $costo_anual_seguro = 3601;
                }elseif($monto_financiar > 310000){
                    $costo_anual_seguro = 3980;
                }
            }
            $pago_inicial = $costo_anual_seguro + $comision_por_apertura;

            $solicitud->precio_sistema = $request->input('precio_sistema');
            $solicitud->plazo_financiar = $request->input('plazo_financiar');
            $solicitud->enganche = $request->input('enganche');
            $solicitud->monto_financiar = $monto_financiar;

            $solicitud->porcentaje_comision_por_apertura = $porcentaje_comision_por_apertura;
            $solicitud->comision_por_apertura = $comision_por_apertura;
            $solicitud->costo_anual_seguro = $costo_anual_seguro;
            $solicitud->aplica_costo_anual_seguro = ($aplica_costo_anual_seguro)?true:false;

            $solicitud->pago_inicial = $pago_inicial;

            $solicitud->plan_id = $request->plan_id;
            $solicitud->interes_anual = $interes_anual;

            $solicitud->save();
            return ['msg' => 'ok'];
        }
        elseif($request->input('step') == 8){
            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->tarjeta_credito_titular = $request->input('tarjeta_credito_titular');
            $cliente->ultimos_digitos = $request->input('ultimos_digitos');
            $cliente->credito_hipotecario = $request->input('credito_hipotecario');
            $cliente->historial_credito = $request->input('historial_credito');
            $cliente->credito_automotriz = $request->input('credito_automotriz');
            $cliente->registro_completo = 1;
            $cliente->save();


            $solicitud = Solicitud::find($request->input('solicitud_id'));
            $tipo_persona = ($cliente->persona_tipo == 'fisica')?"PF":"PM";
            $folio = $solicitud->id . "-" . $tipo_persona;
            $solicitud->estatus_id = 1;
            $solicitud->folio = $folio;
            $solicitud->save();


            return ['msg'=>'ok'];
        }
    }

    public function calculaPeriodos(Request $request){
        $meses = $request->periodos;
        $precio_sistema = $request->precio_sistema;
        $enganche = $request->enganche;
        $plan_id = $request->plan_id;

        $formato_fecha = false;
        if(isset($request->formato_fecha)){
            $formato_fecha = true;
        }

        if (isset($request->solicitud_id)){
            #//Desde vista de 8 pasos
            $solicitud = Solicitud::find($request->solicitud_id);
            $periodos = Solicitud::periodosCotizacion($precio_sistema,$enganche,$meses,$solicitud,$formato_fecha,$plan_id);
        }else{
            #//desde vista de 3 pasos
            $periodos = Solicitud::periodosCotizacion($precio_sistema,$enganche,$meses,null,$formato_fecha,$plan_id);
        }

        unset($periodos['suma_amortizaciones']);

        return $periodos;
    }

    public function check($uuid){
        $cliente = Cliente::where('uuid',$uuid)->firstOrFail();

        if (Auth::check()){
            return redirect(Auth::user()->grupo->home_page);
        }else{
            if ($cliente->registro_completo){
                #//Redireccionamos al login
                return redirect('/login');
            }else{
                #//Le iniciamos sesion y redireccionamos a los 8 pasos
                auth()->loginUsingId($cliente->user->id);
                return redirect(Auth::user()->grupo->home_page);
            }
        }
    }




}
