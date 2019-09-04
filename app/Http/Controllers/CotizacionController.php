<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\CotizacionDetalle;
use App\Solicitud;
use App\Plan;
use App\User;
use App\Estado;
use App\Configuracion;
use App\Integrador;
use App\Producto;
use App\Cliente;
use App\Domicilio;
use App\ObligadoSolidario;

use App\Custom\ComponenteCredito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$cotizaciones = Cotizacion::where('integrador_id',Auth::user()->integrador->id)->get();
        $cotizaciones = CotizacionDetalle::where('estatus_id',1)->with(['cotizacion','plan','solicitud'])->whereHas('cotizacion',function($query){
            $query->where('integrador_id',Auth::user()->integrador->id)->where('terminada',false);
        })->get();
        

        #return $cotizaciones;
        return view('cotizaciones.integrador.index',compact('cotizaciones'));
    }

    public function preautorizadas(){
        $cotizaciones = CotizacionDetalle::where('estatus_id',2)->with(['cotizacion','plan','solicitud'])->whereHas('cotizacion',function($query){
            $query->where('integrador_id',Auth::user()->integrador->id)->where('terminada',false);
        })->get();

        return view('cotizaciones.integrador.preautorizadas',compact('cotizaciones'));
    }

    public function admin_preautorizadas(){
        $cotizaciones = CotizacionDetalle::where('estatus_id',1)->where('error_ws',true)->with(['cotizacion','cotizacion.aplicante','plan','solicitud'])->whereHas('cotizacion',function($query){
            $query->where('terminada',false);
        })->get();

        #return $cotizaciones;
        return view('cotizaciones.admin.cotizaciones_preautorizadas',compact('cotizaciones'));
    }

    public function admin_listadoPreautorizadas(){
        $cotizaciones = CotizacionDetalle::where('estatus_id',2)->where('error_ws',true)->with(['cotizacion','cotizacion.aplicante','plan','solicitud'])->whereHas('cotizacion',function($query){
            $query->where('terminada',false);
        })->get();

        #return $cotizaciones;
        return view('cotizaciones.admin.listadoPreautorizadas',compact('cotizaciones'));
    }




    public function admin_preautorizacion_detalle($detalle_cotizacion_id){
        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        if($detalle->estatus_id != 1)
            return redirect()->route('integrador.cotizaciones')->with('danger','La cotización aún no se encuentra pre-autorizada.');
        
        // return $detalle->cotizacion
        #return $detalle->plan;

        #return $detalle->cotizacion->aplicante->obligado_solidario;        
        return view('cotizaciones.admin.preautorizacion_detalle',compact('detalle'));        
    }

    public function admin_preautorizada($detalle_cotizacion_id){        
        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        if($detalle->estatus_id != 2)
            return redirect()->route('integrador.cotizaciones')->with('danger','La cotización aún no se encuentra pre-autorizada.');
        
        // return $detalle->cotizacion->aplicante;
        #return $detalle->plan;

        #return $detalle->cotizacion->aplicante->obligado_solidario;
        #dd($detalle->aplicante);
        return view('cotizaciones.admin.preautorizada',compact('detalle'));        
    }

    public function admin_preautorizacion_autorizar(Request $request, $detalle_cotizacion_id){
        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        $detalle->estatus_id = 2;
        $detalle->fecha_preautorizacion = date('Y-m-d');
        $detalle->save();        
        return redirect()->route('admin.preautorizadas')->with('success','Cotización pre autorizada correctamente.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cotizacion_id = null)
    {
        $integrador = Integrador::where('id', Auth::user()->integrador->id )->with(['productos','productos.planes'])->first();

        $productos = $integrador->productos;
        $planes = [];
        foreach ($productos as $k => $p) {
            foreach ($p->planes as $j => $plan) {
                if ( $plan->activo)
                    $planes[] = $plan;
            }
        }

        $configuracion = Configuracion::find(1);
        $minFinanciar = $configuracion->monto_min_financiar;

        $cotizacion = null;
        $planes_agregados = [];
        if (!is_null($cotizacion_id)) {
            $cotizacion = Cotizacion::where('id',$cotizacion_id)->with(['cotizacion_detalle','cotizacion_detalle.plan','cotizacion_detalle.plan.producto'])->first();
            foreach ($cotizacion->cotizacion_detalle as $detalle) {
                #return $detalle;
                $planes_agregados[$detalle->plan->producto->nombre][] = $detalle;
            }
            #return $planes_agregados;
        }

        #return $planes_agregados;
        
        return view('cotizaciones.integrador.create',compact('integrador','productos','planes','minFinanciar','cotizacion','planes_agregados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #dd($request->all());
        #dd(Auth::user()->integrador->id);
        $periodos = Solicitud::periodosCotizacion(floatval($request->monto_solicitado), floatval($request->enganche) , floatval($request->plazo_financiar), null,false,$request->plan_id);
        #return $periodos;

        if(empty($request->cotizacion_id)){
            $cotizacion = Cotizacion::create([
                'titulo'=>$request->titulo,
                'integrador_id'=>Auth::user()->integrador->id
            ]);
        }else{
            $cotizacion = Cotizacion::updateOrCreate(
                ['id'=>$request->cotizacion_id],
                [ 
                    'titulo' => $request->titulo,
                    'integrador_id'=>Auth::user()->integrador->id
                ]
            );
        }

        $plan = Plan::find($request->plan_id);


        $monto_merchant_fee = 1.16 * ($request->monto_financiar * ( $plan->merchant_fee / 100));
        $detalle = new CotizacionDetalle([
            'plan_id'=> $request->plan_id,
            'monto_solicitado'=> $request->monto_solicitado,
            'monto_financiar'=> $request->monto_financiar,
            'plazo_financiar'=> $request->plazo_financiar,
            'enganche'=> $request->enganche,
            'mensualidad'=> $periodos[1]['subtotal'],
            'pago_inicial'=>$request->pago_inicial,
            'precio_lista'=>$request->precio_lista,
            'estatus_id'=>1,
            'merchant_fee'=>$monto_merchant_fee
        ]);

        $cotizacion->cotizacion_detalle()->save($detalle);

        
        
        return response()->json([
            'mensualidad'=> number_format($periodos[1]['subtotal'],2),
            'cotizacion_id' => $cotizacion->id,
            'detalle_id' => $detalle->id,
            'interes_anual'=>$plan->interes_anual,
            'comision_por_apertura'=>$plan->comision_por_apertura,
            'merchant_fee' => $plan->merchant_fee
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion $cotizacion)
    {
        //
    }

    public function show_preautorizar($detalle_cotizacion_id){
        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        $estados = Estado::pluck('nombre','id');        
        $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio', 7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];

        $cotizacion = Cotizacion::findOrFail($detalle->cotizacion_id);
        #return $cotizacion->aplicante->obligado_solidario;
        return view('cotizaciones.integrador.preautorizar',compact('detalle','estados','meses','cotizacion'));
    }
    
    public function preautorizar(Request $request,$detalle_cotizacion_id){
        #dd($request->all());
        $request->validate([
            'aplicante.nombre' => 'required',
            'aplicante.correo' => 'required|email',
            'aplicante.apellido_paterno' => 'required',
            'aplicante.fecha_nacimiento_dia' => 'required',
            'aplicante.fecha_nacimiento_mes' => 'required',
            'aplicante.fecha_nacimiento_anio' => 'required',
        ]);

        if( isset($request->aplica_coaplicante)){
            $request->validate([
                'coaplicante.nombre' => 'required',
                'coaplicante.apellido_paterno' => 'required',
                'coaplicante.fecha_nacimiento_dia' => 'required',
                'coaplicante.fecha_nacimiento_mes' => 'required',
                'coaplicante.fecha_nacimiento_anio' => 'required',
            ]); 
        }
        
        
        $success = true;
        DB::beginTransaction();
        try {            
            $cotizacion_detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
            $cotizacion_detalle->estatus_id = 1;
            $cotizacion_detalle->save();
            $cotizacion = Cotizacion::findOrFail($cotizacion_detalle->cotizacion_id);

            $cotizacion->requiere_coaplicante = (isset($request->aplica_coaplicante))?true:false;
            $cotizacion->save();
            
            #return $cotizacion_detalle;
            
            $data_aplicante = $request->aplicante;        
            $data_domicilio_aplicante = $data_aplicante['domicilio'];
            unset($data_aplicante['domicilio']);        
            
            
            
            if(!empty($data_aplicante['id'])){
                $cliente_id = $data_aplicante['id'];
                unset($data_aplicante['id']);
                $aplicante = Cliente::updateOrCreate(
                    ['id' => $cliente_id],
                    $data_aplicante
                );
            }else{
                $aplicante = new Cliente($data_aplicante);   
            }
            $aplicante->estado_nacimiento_id = $data_domicilio_aplicante['estado_id'];
            $fecha_nacimiento = date('Y-m-d',strtotime( $data_aplicante['fecha_nacimiento_anio'] . '-' . $data_aplicante['fecha_nacimiento_mes'] . '-' . $data_aplicante['fecha_nacimiento_dia'] ));
            $data_aplicante['fecha_nacimiento'] = $fecha_nacimiento;
            $aplicante->fecha_nacimiento = $fecha_nacimiento;
            $aplicante->creado_por = auth()->user()->id;
            $aplicante->modificado_por = auth()->user()->id;
            $cotizacion->aplicante()->save($aplicante);

            

            #//Creamos usuario al cliente
            $user = new User([
                'nombre'=>$request->aplicante['nombre'] .' ' . $request->aplicante['apellido_paterno'] . ' ' . $request->aplicante['apellido_materno'],
                'email'=>$request->aplicante['correo'],
                'grupo_id'=>5
            ]);
            $user = $aplicante->user()->save($user);


            #//DOCUMENTOS
            if($request->hasFile('aplicante.ine')){
                $file = $request->file('aplicante.ine');
                $path = 'documentos_cliente/'.$aplicante->id.'/';
                #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                Storage::disk('public')->put($path.$filename,  File::get($file));
                $aplicante->ine_file = $file->getClientOriginalName();
                $aplicante->ine_path = $path . $filename;
                $aplicante->save();
            }

            if($request->hasFile('aplicante.ine_atras')){
                $file = $request->file('aplicante.ine_atras');
                $path = 'documentos_cliente/'.$aplicante->id.'/';
                #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                Storage::disk('public')->put($path.$filename,  File::get($file));
                $aplicante->ine_atras_file = $file->getClientOriginalName();
                $aplicante->ine_atras_path = $path . $filename;
                $aplicante->save();
            }

            if($request->hasFile('aplicante.hoja_buro')){
                $file = $request->file('aplicante.hoja_buro');
                $path = 'documentos_cliente/'.$aplicante->id.'/';
                #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                Storage::disk('public')->put($path.$filename,  File::get($file));
                $aplicante->hoja_buro_file = $file->getClientOriginalName();
                $aplicante->hoja_buro_path = $path . $filename;
                $aplicante->save();
            }

            if($request->hasFile('aplicante.foto_buro_file')){
                $file = $request->file('aplicante.foto_buro_file');
                $path = 'documentos_cliente/'.$aplicante->id.'/';
                #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                Storage::disk('public')->put($path.$filename,  File::get($file));
                $aplicante->foto_buro_file = $file->getClientOriginalName();
                $aplicante->foto_buro_path = $path . $filename;
                $aplicante->save();
            }

            #die;
            #//DOMICILIO
            if(!empty($data_domicilio_aplicante['id'])){
                $domicilio_aplicante_id = $data_domicilio_aplicante['id'];
                unset($data_domicilio_aplicante['id']);
                $domicilio_aplicante = Domicilio::updateOrCreate(
                    ['id'=>$domicilio_aplicante_id],
                    $data_domicilio_aplicante
                );
            }else{
                $domicilio_aplicante = new Domicilio($data_domicilio_aplicante);
            }
            $domicilio_aplicante->fiscal = 0;
            

            $aplicante->domicilio()->save($domicilio_aplicante);
            #dd($domicilio_aplicante);
            
            #//CO APLICANTE
            $data_co_aplicante = [];
            if( isset($request->aplica_coaplicante)){
                #//Marcamos la cotizacion con bandera de requiere coaplicante
                $cotizacion->requiere_coaplicante = true;
                $cotizacion->save();

                $data_co_aplicante = $request->coaplicante;        
                $data_domicilio_co_aplicante = $data_co_aplicante['domicilio'];
                unset($data_co_aplicante['domicilio']);

                if(!empty($data_co_aplicante['id'])){
                    $co_aplicante_id = $data_co_aplicante['id'];
                    unset($data_co_aplicante['id']);
                    $co_aplicante = ObligadoSolidario::updateOrCreate(
                        ['id' => $co_aplicante_id],
                        $data_co_aplicante
                    );
                }else{
                    $co_aplicante = new ObligadoSolidario($data_co_aplicante);
                }

                $co_aplicante->estado_nacimiento_id = $data_domicilio_co_aplicante['estado_id'];
                $fecha_nacimiento = date('Y-m-d',strtotime( $data_co_aplicante['fecha_nacimiento_anio'] . '-' . $data_co_aplicante['fecha_nacimiento_mes'] . '-' . $data_co_aplicante['fecha_nacimiento_dia'] ));
                $co_aplicante->fecha_nacimiento = $fecha_nacimiento;
                $data_co_aplicante['fecha_nacimiento'] = $fecha_nacimiento;
                $co_aplicante->email = $data_co_aplicante['correo'];
                $co_aplicante->sexo = $data_co_aplicante['genero'];
                $co_aplicante->salario_mensual = $data_co_aplicante['salario_mensual'];
                $co_aplicante->telefono_movil = $data_co_aplicante['telefono_movil'];
                unset($co_aplicante->correo);
                $aplicante->obligado_solidario()->save($co_aplicante);
    
                #//DOCUMENTOS
                if($request->hasFile('coaplicante.ine')){
                    $file = $request->file('coaplicante.ine');
                    $path = 'documentos_obligado_solidario/'.$co_aplicante->id.'/';
                    #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                    $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                    Storage::disk('public')->put($path.$filename,  File::get($file));
                    $co_aplicante->ine_file = $file->getClientOriginalName();
                    $co_aplicante->ine_path = $path . $filename;
                    $co_aplicante->save();
                }

                if($request->hasFile('coaplicante.ine_atras')){
                    $file = $request->file('coaplicante.ine_atras');
                    $path = 'documentos_cliente/'.$co_aplicante->id.'/';
                    #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                    $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                    Storage::disk('public')->put($path.$filename,  File::get($file));
                    $co_aplicante->ine_atras_file = $file->getClientOriginalName();
                    $co_aplicante->ine_atras_path = $path . $filename;
                    $co_aplicante->save();
                }

                if($request->hasFile('coaplicante.hoja_buro')){
                    $file = $request->file('coaplicante.hoja_buro');
                    $path = 'documentos_obligado_solidario/'.$co_aplicante->id.'/';
                    #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                    $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                    Storage::disk('public')->put($path.$filename,  File::get($file));
                    $co_aplicante->hoja_buro_file = $file->getClientOriginalName();
                    $co_aplicante->hoja_buro_path = $path . $filename;
                    $co_aplicante->save();
                }
        
                if($request->hasFile('coaplicante.foto_buro_file')){
                    $file = $request->file('coaplicante.foto_buro_file');
                    $path = 'documentos_obligado_solidario/'.$co_aplicante->id.'/';
                    #//Nombre random del archivo para que no se sobreescriban si se llegan a subir con el mismo nombre
                    $filename = md5(uniqid()).'.'. $file->getClientOriginalExtension();
                    Storage::disk('public')->put($path.$filename,  File::get($file));
                    $co_aplicante->foto_buro_file = $file->getClientOriginalName();
                    $co_aplicante->foto_buro_path = $path . $filename;
                    $co_aplicante->save();
                }

                #//DOMICILIO
                if(!empty($data_domicilio_co_aplicante['id'])){
                    $domicilio_co_aplicante_id = $data_domicilio_co_aplicante['id'];
                    unset($data_domicilio_co_aplicante['id']);
                    $domicilio_coaplicante = Domicilio::updateOrCreate(
                        ['id'=>$domicilio_co_aplicante_id],
                        $data_domicilio_co_aplicante
                    );
                }else{
                    $domicilio_coaplicante = new Domicilio($data_domicilio_co_aplicante);
                }

                $domicilio_coaplicante->fiscal = 0;
                $co_aplicante->domicilio()->save($domicilio_coaplicante);

                $data_co_aplicante['Domicilio'] = $data_domicilio_co_aplicante;
            }
    
            
        } catch (\Exception $exception) {
            $success = $exception->getMessage();
            DB::rollBack();
        }

        if ($success === true){
            DB::commit();

            #//Si se salvan los datos en BD, hacemos consulta a WS. Depende si aplica o no coaplicante, son los datos que vamos a mandar
            try {
                #//DATOS DEL APLICANTE
                $data_aplicante['Domicilio'] = $data_domicilio_aplicante;
                #//Si cliente ya tiene datos de FICO, ignoramos la consulta                
                if (is_null($aplicante->fico_score) && is_null($aplicante->deuda_mensual)) {
                    $persona_1 = new ComponenteCredito($data_aplicante, $cotizacion_detalle);
                    $persona_1->revisaBuro();
                    #//Errores devueltos por Circulo de credito
                    if($persona_1->error){
                        $msj = implode('<br>*', $persona_1->msj_credito);
                        $cotizacion_detalle->msj_error_ws = 'Errores círculo de credito con el Aplicante:<br> *' . $msj;
                        $cotizacion_detalle->error_ws = true;
                        $cotizacion_detalle->save();

                        return redirect()->route('integrador.show_preautorizar',$cotizacion_detalle->id)->with('danger','Errores círculo de credito con el Aplicante:<br> *' . $msj);
                    }
                    $fico = $persona_1->fico_score;
                    $deuda_mensual = $persona_1->deuda_mensual;

                    #//Guardamos FICO y deuda mensual

                    Cliente::where('id',$aplicante->id)->update(['fico_score'=>$persona_1->fico_score,'deuda_mensual'=>$persona_1->deuda_mensual]);
                }else{
                    $fico = $aplicante->fico_score;
                    $deuda_mensual = $aplicante->deuda_mensual;
                }


                $ltv = $cotizacion_detalle->monto_financiar / $cotizacion_detalle->monto_solicitado;        
                $ingresos_mensuales = $data_aplicante['salario_mensual'];
                

                if( isset($request->aplica_coaplicante)){
                    #//DATOS DEL CO-APLICANTE
                    $persona_2 = new ComponenteCredito($data_co_aplicante, $cotizacion_detalle);
                    $persona_2->revisaBuro();

                    #//Errores devueltos por Circulo de credito
                    if($persona_2->error){
                        $msj = implode('<br>*', $persona_2->msj_credito);
                        $cotizacion_detalle->msj_error_ws = 'Errores círculo de credito con el Co-aplicante:<br> *' . $msj;
                        $cotizacion_detalle->error_ws = true;
                        $cotizacion_detalle->save();
                        return redirect()->route('integrador.show_preautorizar',$cotizacion_detalle->id)->with('danger','Errores círculo de credito con el Co-aplicante:<br> *' . $msj);
                    }

                    $deuda_mensual += $persona_2->deuda_mensual;
                    $ingresos_mensuales += $data_co_aplicante['salario_mensual'];
                    #//SI EL FICO DEL APLICANTE ES MENOR AL DEL CO-APLICANTE, TOMAMOS EL DEL CO-APLICANTE
                    if($persona_2->fico_score > $fico)
                        $fico = $persona_2->fico_score;

                    #//Guardar datos de deuda mensual y FICO SCORE en coaplicante
                    ObligadoSolidario::where('id',$co_aplicante->id)->update(['fico_score'=>$persona_2->fico_score,'deuda_mensual'=>$persona_2->deuda_mensual]);                    
                }

                $dti_pre = $deuda_mensual / $ingresos_mensuales;
                $dti_post = ($deuda_mensual + $cotizacion_detalle->mensualidad) / $ingresos_mensuales;
                #dd($dti_post);

                #//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $msj_error = [];
                $apto_credito = true;
                #// CALCULOS PARA SABER SI PREAUTORIZAMOS O NO EL CLIENTE PARA DAR O NO EL CREDITO
                #//FICO                
                if($fico < 620){
                    $msj_error[] = 'El Fico score es menor a 620';
                    $apto_credito = false;
                }                            
                #// LTV
                if($ltv > ($cotizacion_detalle->plan->ltv / 100) ){
                    $msj_error[] = 'El LTV calcuado sobrepasa al '. $cotizacion_detalle->plan->ltv .'% configurado en el plan';
                    $apto_credito = false;
                }

                #dd($cotizacion_detalle->plan);

                #//VALORES FIJOS SEGUN EL PLAZO A FINANCIAR (EXCEL QUE JOEL PASÓ)
                // $max_dti_pre = .3; #//mas de 18 meses
                // $max_dti_post = .6; #//mas de 18 meses
                // if ($cotizacion_detalle->plazo_financiar < 18) {
                //     $max_dti_pre = .6;
                //     $max_dti_post = .9;
                // }
                #//Tomar el configurado en el plan
                $max_dti_pre = $cotizacion_detalle->plan->dti_pre;
                $max_dti_post = $cotizacion_detalle->plan->dti_post;

                if ($dti_pre > $max_dti_pre) {
                    $msj_error[] = 'El DTI PRE calculado es de '. number_format(( $dti_pre * 100),2).'% y no debería ser mayor a '. ($max_dti_pre * 100 ) .'%';
                    $apto_credito = false;
                }
                #DTI POST Menor a 90%
                if ($dti_post > $max_dti_post) {
                    $msj_error[] = 'El DTI POST calculado es de '. number_format(( $dti_post * 100),2).'% y no debería ser mayor a '. ($max_dti_post * 100 ) .'%';
                    $apto_credito = false;
                }
                #//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                if(!$apto_credito){
                    $msj = implode('<br>*', $msj_error);
                    $cotizacion_detalle->msj_error_ws = 'Errores de validaciones del crédito:<br> *' . $msj;
                    $cotizacion_detalle->error_ws = true;
                    $cotizacion_detalle->save();

                    return redirect()->route('integrador.show_preautorizar',$cotizacion_detalle->id)->with('danger','No se pudó preautorizar la cotización por los siguientes motivos:<br> *' . $msj);
                }else{

                    $cotizacion_detalle->estatus_id = 2;
                    $cotizacion_detalle->fecha_preautorizacion = date('Y-m-d');
                    $cotizacion_detalle->save();
                    return redirect()->route('integrador.preautorizacion_detalle',$cotizacion_detalle->id)->with('success','Tu cliente ha sido pre-autorizado.');
                }
                   

                #return response($componente->getXmlGenerado(), 200)->header('Content-Type', 'text/xml');                
            } catch (\Exception $e) {
                //#Guardamos el error en la cotización
                $cotizacion_detalle->msj_error_ws = 'Error al consumir WS de consulta de credito.';
                $cotizacion_detalle->error_ws = true;
                $cotizacion_detalle->save();
                return redirect()->route('integrador.show_preautorizar',$cotizacion_detalle->id)->with('danger','Error al consumir WS de consulta de credito.');                
            }            
        }
        return redirect()->route('integrador.cotizaciones')->with('danger','Error al preautorizar la cotización.');
    }

    public function getMensualidad(Request $request){
        
        #dd($request);
        $periodos = Solicitud::periodosCotizacion(floatval($request->monto_solicitado), floatval($request->enganche) , floatval($request->plazo_financiar),null,false, $request->plan_id);
        $plan = Plan::find($request->plan_id);
        return response()->json([
            'mensualidad'=> number_format($periodos[1]['subtotal'],2,'.',''),
            'interes_anual'=>$plan->interes_anual,
            'comision_por_apertura'=> $plan->comision_por_apertura,
            'merchant_fee' => $plan->merchant_fee
        ]);
    }


    public function preautorizacion_detalle($detalle_cotizacion_id){
        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        if($detalle->estatus_id != 2)
            return redirect()->route('integrador.cotizaciones')->with('danger','La cotización aún no se encuentra pre-autorizada.');
        
        // return $detalle->cotizacion->aplicante;
        #return $detalle->plan;

        #return $detalle->cotizacion->aplicante->obligado_solidario;
        #dd($detalle->aplicante);
        return view('cotizaciones.integrador.preautorizacion_detalle',compact('detalle'));        
    }

    public function preautorizacion_autorizar(Request $request, $detalle_cotizacion_id){
        

        $detalle = CotizacionDetalle::findOrFail($detalle_cotizacion_id);
        $cotizacion = $detalle->cotizacion;
        #return $request->all();

        if($cotizacion->terminada){
            return redirect()->back()->with("danger","Ya existe una solicitud de esta cotizacion");
        }
        $configuracion = Configuracion::find(1);
        $plan = Plan::find($detalle->plan_id);
        $interes_anual = $plan->interes_anual;
        $porcentaje_comision_por_apertura = (!is_null($plan->comision_por_apertura))?$plan->comision_por_apertura:0;
        $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
        $comision_por_apertura = $detalle->monto_financiar * ($porcentaje_comision_por_apertura / 100);
        $costo_anual_seguro = 0;
        if($aplica_costo_anual_seguro){
            if ($detalle->monto_financiar <= 110000){
                $costo_anual_seguro = 2085;
            }elseif($detalle->monto_financiar > 110000 && $detalle->monto_financiar <= 220000){
                $costo_anual_seguro = 2464;
            }elseif($detalle->monto_financiar > 220000 && $detalle->monto_financiar <= 310000){
                $costo_anual_seguro = 3601;
            }elseif($detalle->monto_financiar > 310000){
                $costo_anual_seguro = 3980;
            }
        }
        #// $comision_por_apertura + enganche + fee + costo anual seguro
        #$pago_inicial = $costo_anual_seguro + $comision_por_apertura  #//Anterior mente solo contemplaba costo anual + comision aperura. Se agregan valores del fee y el enganche
        $pago_inicial = $costo_anual_seguro + $comision_por_apertura + $detalle->merchant_fee + $detalle->enganche;
        #return $plan;
        
        $detalle->estatus_id = 3; //Marcamos como autorizada la preautorizacion
        $detalle->save();

        $cotizacion->terminada = 1; //Marcamos la cotizacion como terminada
        $cotizacion->save();        

        $configuracion = Configuracion::find(1);
        

        #dd($detalle);
        $solicitud = new Solicitud();
        $solicitud->precio_sistema = $detalle->monto_solicitado;
        $solicitud->enganche = $detalle->enganche;
        $solicitud->plazo_financiar = $detalle->plazo_financiar;
        $solicitud->monto_financiar = $detalle->monto_financiar;
        $solicitud->plan_id = $detalle->plan_id;
        $solicitud->cliente_id = $detalle->cotizacion->aplicante->id;

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
        
        $solicitud->preautorizacion_id = $detalle_cotizacion_id;
        $solicitud->estatus_id = 6;
        $solicitud->integrador_id = Auth::user()->integrador_id;
        
        $solicitud->precio_lista = $detalle->precio_lista;
        $solicitud->merchant_fee = $detalle->merchant_fee;

        $solicitud->fico = $detalle->cotizacion->aplicante->fico_score;
        $solicitud->deuda_mensual = $detalle->cotizacion->aplicante->deuda_mensual;

        $solicitud->save();
        
        return redirect()->route('integrador.showSolicitudCotizacion',$solicitud->id)->with('success','Cotización pre autorizada correctamente.');
    }


    public function attach_file_dotizacion($cotizacion_detalle_id,$tipo_persona,$archivo){
        $detalle = CotizacionDetalle::findOrFail($cotizacion_detalle_id);
        if ($tipo_persona == 'aplicante') {            
            if ($archivo == 'ine') {
                $file = 'public/'.$detalle->cotizacion->aplicante->ine_path;
                $name = $detalle->cotizacion->aplicante->ine_file;
            }elseif ($archivo == 'ine_atras') {
                $file = 'public/'.$detalle->cotizacion->aplicante->ine_atras_path;
                $name = $detalle->cotizacion->aplicante->ine_atras_file;
            }elseif ($archivo == 'hoja_buro') {
                $file = 'public/'.$detalle->cotizacion->aplicante->hoja_buro_path;
                $name = $detalle->cotizacion->aplicante->hoja_buro_file;
            }elseif ($archivo == 'foto_buro_file') {
                $file = 'public/'.$detalle->cotizacion->aplicante->foto_buro_path;
                $name = $detalle->cotizacion->aplicante->foto_buro_file;
            }
        }else{            
            if ($archivo == 'ine') {
                $file = 'public/'.$detalle->cotizacion->aplicante->obligado_solidario->ine_path;
                $name = $detalle->cotizacion->aplicante->obligado_solidario->ine_file;
            }elseif ($archivo == 'ine_atras_file') {
                $file = 'public/'.$detalle->cotizacion->aplicante->obligado_solidario->ine_atras_path;
                $name = $detalle->cotizacion->aplicante->obligado_solidario->ine_atras_file;
            }elseif ($archivo == 'hoja_buro') {
                $file = 'public/'.$detalle->cotizacion->aplicante->obligado_solidario->hoja_buro_path;
                $name = $detalle->cotizacion->aplicante->obligado_solidario->hoja_buro_file;
            }elseif ($archivo == 'foto_buro_file') {
                $file = 'public/'.$detalle->cotizacion->aplicante->obligado_solidario->foto_buro_path;
                $name = $detalle->cotizacion->aplicante->obligado_solidario->foto_buro_file;
            }
        }


        
        #dd('public/'.$file);
        if (Storage::exists($file)){
            $filename = Str::ascii($name);
            return Storage::download($file,$filename);
        }else{
            return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
        }
    }   
}
