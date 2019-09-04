<?php

namespace App\Http\Controllers;

use App\Integrador;
use App\Estado;
use App\User;
use App\Domicilio;
use App\Producto;

use App\Notifications\ActivacionIntegrador;
use App\Notifications\RegistroIntegrador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#use Illuminate\Notifications\Notifiable;
use Notification;


class IntegradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $integradores = Integrador::all();

        return view('integradores.admin.index',compact('integradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::pluck('nombre','id');
        return view('integradores.admin.create',compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user.email' => 'required|email|unique:users,email',
            'user.nombre' => 'required',
            'user.password' => 'required|confirmed',
            'user.phone' => 'required',
            'integrador.razon_social'=> 'required',
            'integrador.nombre_comercial'=> 'required',
            'integrador.rfc'=> 'required',
        ]);

        $success = true;
        DB::beginTransaction();
        try {
            #dd($request->all());
            $integrador = new Integrador([
                "razon_social"=> $request->integrador['razon_social'],
                "nombre_comercial"=> $request->integrador['nombre_comercial'],
                "rfc"=> $request->integrador['rfc'],
                "pagina_internet"=> $request->integrador['pagina_internet'],
                "anios_operando"=> $request->integrador['anios_operando'],
                "nombre_socio"=> $request->integrador['nombre_socio'],
                "apellido_paterno_socio"=> $request->integrador['apellido_paterno_socio'],
                "apellido_materno_socio"=> $request->integrador['apellido_materno_socio'],
                "ventas_anuales" => $request->integrador['ventas_anuales'],
                "producto_principal" => $request->integrador['producto_principal'],
                "activo"=>0
            ]);
            $integrador->save();
                
            
            $user = new User([
                'nombre'=>$request->user['nombre'],
                'email'=>$request->user['email'],
                'password'=>bcrypt($request->user['password']),
                'grupo_id'=>6,
                'integrador_id'=>$integrador->id,
                'phone'=>$request->user['phone'],
                'active'=>0
            ]);
            $user->save();
    
            $direccion = new Domicilio([
                'calle'=>$request->direccion['calle'],
                'numero_ext'=>$request->direccion['num_ext'],
                'numero_int'=>$request->direccion['numero_int'],
                'colonia'=>$request->direccion['colonia'],
                'estado_id'=>$request->direccion['estado_id'],
                'municipio_id'=>$request->direccion['municipio_id'],
                'cp'=>$request->direccion['cp'],
                'integrador_id'=>$integrador->id,
                'socio_id'=>null,
                'fiscal'=>0
            ]);
    
            $direccion->save();

            $direccion_socio = new Domicilio([
                'calle'=>$request->direccionSocio['calle'],
                'numero_ext'=>$request->direccionSocio['num_ext'],
                'numero_int'=>$request->direccionSocio['numero_int'],
                'colonia'=>$request->direccionSocio['colonia'],
                'estado_id'=>$request->direccionSocio['estado_id'],
                'municipio_id'=>$request->direccionSocio['municipio_id'],
                'cp'=>$request->direccionSocio['cp'],
                'integrador_id'=>null,
                'socio_id'=>$integrador->id,
                'fiscal'=>0
            ]);
            $direccion_socio->save();
        } catch (\Exception $exception) {
            $success = $exception->getMessage();
            DB::rollBack();
            dd($success);
        }
        
        if ($success === true){
            DB::commit();
            return redirect()->route('integradores.index')->with('success','Integrador creado.');
        }
        return back()->with('danger',"Error al agregar.");


        #dd('ok');

        
        #//Creamos usuario
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Integrador  $integrador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $integrador = Integrador::findOrFail($id);
        $productos = Producto::all()->pluck('nombre','id');

        $prods_integrador = $integrador->productos->pluck('id','id')->toArray();
        return view('integradores.admin.show',compact('integrador','productos','prods_integrador'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Integrador  $integrador
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $integrador = Integrador::findOrFail($id);
        $estados = Estado::pluck('nombre','id');

        $financiamientos_ofrecidos = [
            'FIDE' => 'FIDE',
            'Tarjeta de Crédito' => 'Tarjeta de Crédito',
            'Otro' => 'Otro',
        ];

        $tipo_persona = [
            'Persona Física' => 'Persona Física',
            'Persona Física con Actividad Empresarial' => 'Persona Física con Actividad Empresarial',
            'Persona Moral' => 'Persona Moral',
            'Otro' => 'Otro',            
        ];

        return view('integradores.admin.edit',compact('integrador','estados','financiamientos_ofrecidos','tipo_persona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Integrador  $integrador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        #dd($request->all());
        $success = true;
        DB::beginTransaction();
        try {
            $integrador = Integrador::updateOrCreate(
                ['id'=>$request->integrador['id']],
                [
                    "razon_social"=> $request->integrador['razon_social'],
                    "nombre_comercial"=> $request->integrador['nombre_comercial'],
                    "rfc"=> $request->integrador['rfc'],
                    "pagina_internet"=> $request->integrador['pagina_internet'],
                    "anios_operando"=> $request->integrador['anios_operando'],
                    "nombre_socio"=> $request->integrador['nombre_socio'],
                    "apellido_paterno_socio"=> $request->integrador['apellido_paterno_socio'],
                    "apellido_materno_socio"=> $request->integrador['apellido_materno_socio'],
                    "ventas_anuales" => $request->integrador['ventas_anuales'],
                    "producto_principal" => $request->integrador['producto_principal'],   
                    "tipo_persona" => $request->integrador['tipo_persona'],
                    "financiamientos_ofrecidos" => $request->integrador['financiamientos_ofrecidos'],
                ]
            );
    
            $usuario = User::updateOrCreate(
                ['id'=>$request->user['id']],
                [
                    'nombre'=>$request->user['nombre'],
                    'email'=>$request->user['email'],
                    'phone'=>$request->user['phone'] 
                ]
            );
    
            $domicilio = Domicilio::updateOrCreate(
                ['id'=>$request->direccion['id']],
                [
                    'calle'=>$request->direccion['calle'],
                    'numero_ext'=>$request->direccion['num_ext'],
                    'numero_int'=>$request->direccion['numero_int'],
                    'colonia'=>$request->direccion['colonia'],
                    'estado_id'=>$request->direccion['estado_id'],
                    'municipio_id'=>$request->direccion['municipio_id'],
                    'cp'=>$request->direccion['cp'],
                ]
            );
    
            $domicilio_socio = Domicilio::updateOrCreate(
                ['id'=>$request->direccionSocio['id']],
                [
                    'calle'=>$request->direccionSocio['calle'],
                    'numero_ext'=>$request->direccionSocio['num_ext'],
                    'numero_int'=>$request->direccionSocio['numero_int'],
                    'colonia'=>$request->direccionSocio['colonia'],
                    'estado_id'=>$request->direccionSocio['estado_id'],
                    'municipio_id'=>$request->direccionSocio['municipio_id'],
                    'cp'=>$request->direccionSocio['cp'],
                ]
            );
        } catch (\Exception $exception) {
            $success = $exception->getMessage();
            DB::rollBack();
        }

        if ($success === true){
            DB::commit();
            return redirect()->route('integradores.index')->with('success','Integrador editado.');
        }
        return back()->with('danger',"Error al editar.");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Integrador  $integrador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Integrador $integrador)
    {
        //
    }

    public function registro(){
        $ventas_anuales = [
            '$0 - $2,000,000' => '$0 - $2,000,000',
            '$2,000,001 - $6,000,000'=>'$2,000,001 - $6,000,000',
            '$6,000,000 - $12,000,000'=>'$6,000,000 - $12,000,000',
            '+$12,000,000'=>'+$12,000,000'
        ];

        $producto_principal = [
            'Aires acondicionados' => 'Aires acondicionados',
            'Aislamientos' => 'Aislamientos',
            'Eficiencia energética' => 'Eficiencia energética',
            'Iluminación' => 'Iluminación',
            'Impermeabilización' => 'Impermeabilización',
            'Puertas' => 'Puertas',
            'Solar Fotovoltaico' => 'Solar Fotovoltaico',
            'Ventanas' => 'Ventanas',
            'Otro' => 'Otro'
        ];

        $financiamientos_ofrecidos = [
            'FIDE' => 'FIDE',
            'Tarjeta de Crédito' => 'Tarjeta de Crédito',
            'Otro' => 'Otro',
        ];

        $tipo_persona = [
            'Persona Física' => 'Persona Física',
            'Persona Física con Actividad Empresarial' => 'Persona Física con Actividad Empresarial',
            'Persona Moral' => 'Persona Moral',
            'Otro' => 'Otro',            
        ];

        $estados = Estado::pluck('nombre','id');
        return view('integradores.registro',compact('ventas_anuales','producto_principal','estados','tipo_persona','financiamientos_ofrecidos'));
    }

    public function registro_step1(Request $request){
        #dd($request->all());
        $validatedData = $request->validate([
            'nombre' => 'required',
            'password' => 'required|confirmed',
            'phone' => 'required',
        ]);


        $response =  [];
        $existe_usuario = User::where('email',$request->email)->first();
        if(is_null($existe_usuario)){
            #//No existe usuario con ese mail. Lo creamos
            $usuario = new User([
                'nombre'=>$request->nombre . ' ' . $request->apellidos,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'grupo_id'=>6,
                'integrador_id'=>null,
                'phone'=>$request->phone,
                'active'=>false
            ]);

            $usuario->save();
            $response['data'] = $usuario;
            $response['success'] = true;
            $response['msj'] = 'ok';

            return response()->json($response, 200);

        }else{
            if($existe_usuario->grupo_id != 6){
                #//Es un usuario distinto del gpo de integradores
                $response['data'] = $existe_usuario;
                $response['success'] = false;
                $response['msj'] = 'Ya existe un usuario creado para el mail ' . $request->email;
                return response()->json($response, 200);
            }else{

                if(is_null($existe_usuario->integrador_id)){
                    #//Hacemos edit de lo que viene en post
                    $existe_usuario->nombre = $request->nombre . ' ' . $request->apellidos;
                    $existe_usuario->phone = $request->phone;
                    $existe_usuario->password = bcrypt($request->password);
                    $existe_usuario->save();

                    $response['data'] = $existe_usuario;
                    $response['success'] = true;
                    $response['msj'] = 'ok';
                }else{
                    #//Ya existe un integrador registrado con ese mail
                    $response['data'] = $existe_usuario;
                    $response['success'] = false;
                    $response['msj'] = 'Ya existe un integrador registrdo con el mail ' . $request->email;
                }
            }

            return response()->json($response, 200);
        }
    }

    public function registro_step3(Request $request){
        #dd($request->all());

        $usuario = User::where('id',$request->usuario_id)->first();
        if(is_null($usuario->integrador_id)){
            //Create
            $integrador = new Integrador([
                "razon_social"=> $request->integrador['razon_social'],
                "nombre_comercial"=> $request->integrador['nombre_comercial'],
                "rfc"=> $request->integrador['rfc'],
                "pagina_internet"=> $request->integrador['pagina_internet'],
                "anios_operando"=> $request->integrador['anios_operando'],
                "nombre_socio"=> $request->integrador['nombre_socio'],
                "apellido_paterno_socio"=> $request->integrador['paterno_socio'],
                "apellido_materno_socio"=> $request->integrador['materno_socio'],
                "ventas_anuales" => $request->integrador['ventas_anuales'],
                "producto_principal" => $request->integrador['producto_principal'],
                "tipo_persona" => $request->integrador['tipo_persona'],
                "financiamientos_ofrecidos" => $request->integrador['financiamientos_ofrecidos'],
                "activo"=>0

            ]);
            $integrador->save();

            $direccion = new Domicilio([
                'calle'=>$request->direccion['calle'],
                'numero_ext'=>$request->direccion['num_ext'],
                'numero_int'=>null,
                'colonia'=>$request->direccion['colonia'],
                'estado_id'=>$request->direccion['estado_id'],
                'municipio_id'=>$request->direccion['municipio_id'],
                'cp'=>$request->direccion['cp'],
                'integrador_id'=>$integrador->id,
                'socio_id'=>null,
                'fiscal'=>0
            ]);
            $direccion->save();

            $direccion_socio = new Domicilio([
                'calle'=>$request->direccion['calle'],
                'numero_ext'=>$request->direccion['num_ext'],
                'numero_int'=>null,
                'colonia'=>$request->direccion['colonia'],
                'estado_id'=>$request->direccion['estado_id'],
                'municipio_id'=>$request->direccion['municipio_id'],
                'cp'=>$request->direccion['cp'],
                'integrador_id'=>null,
                'socio_id'=>$integrador->id,
                'fiscal'=>0
            ]);
            $direccion_socio->save();

            #//Agregamos el integrador al usuario
            $usuario->integrador_id =  $integrador->id;
            $usuario->save();

            
        }else{
            #dd($request->all());
            $validatedData = $request->validate([
                'integrador.razon_social'=> 'required',
                'integrador.nombre_comercial'=> 'required',
                'integrador.rfc'=> 'required'
            ]);

            $integrador = Integrador::updateOrCreate(
                ['id'=>$usuario->integrador_id],
                [
                    "razon_social"=> $request->integrador['razon_social'],
                    "nombre_comercial"=> $request->integrador['nombre_comercial'],
                    "rfc"=> $request->integrador['rfc'],
                    "pagina_internet"=> $request->integrador['pagina_internet'],
                    "anios_operando"=> $request->integrador['anios_operando'],
                    "nombre_socio"=> $request->integrador['nombre_socio'],
                    "apellido_paterno_socio"=> $request->integrador['paterno_socio'],
                    "apellido_materno_socio"=> $request->integrador['materno_socio'],
                    "ventas_anuales" => $request->integrador['ventas_anuales'],
                    "producto_principal" => $request->integrador['producto_principal'],
                    "tipo_persona" => $request->integrador['tipo_persona'],
                    "financiamientos_ofrecidos" => $request->integrador['financiamientos_ofrecidos'],
                    "activo"=>0
                ]
            );

            #//En dado caso que el integrador se llegara a crear
            $usuario->integrador_id =  $integrador->id;
            $usuario->save();

            $domicilio = Domicilio::updateOrCreate(
                ['integrador_id'=>$usuario->integrador_id],
                [
                    'calle'=>$request->direccion['calle'],
                    'numero_ext'=>$request->direccion['num_ext'],
                    'numero_int'=>null,
                    'colonia'=>$request->direccion['colonia'],
                    'estado_id'=>$request->direccion['estado_id'],
                    'municipio_id'=>$request->direccion['municipio_id'],
                    'cp'=>$request->direccion['cp'],
                    'integrador_id'=>$integrador->id,
                    'socio_id'=>null,
                    'fiscal'=>0
                ]
            );

            $domicilio_socio = Domicilio::updateOrCreate(
                ['socio_id'=>$usuario->integrador_id],
                [
                    'calle'=>$request->direccion_socio['calle'],
                    'numero_ext'=>$request->direccion_socio['num_ext'],
                    'numero_int'=>null,
                    'colonia'=>$request->direccion_socio['colonia'],
                    'estado_id'=>$request->direccion_socio['estado_id'],
                    'municipio_id'=>$request->direccion_socio['municipio_id'],
                    'cp'=>$request->direccion_socio['cp'],
                    'integrador_id'=>null,
                    'socio_id'=>$integrador->id,
                    'fiscal'=>0
                ]
            );

        }
        
        #//Notificacion a admins de nuevo integrador registrado
        Notification::send(User::where('grupo_id',2)->get(), new RegistroIntegrador($integrador));
        #Notification::route('mail','hvillasana@bisso.mx')->notify(new RegistroIntegrador($integrador));
        return redirect()->route('integradores.registro')->with('success','Integrador registrado');


    }

    public function admin_activar($id){
        
        $integrador = Integrador::findOrFail($id);

        $integrador->activo = 1;
        $integrador->save();

        $integrador->user->active = 1;
        $integrador->user->save();

        #//TODO: Notificación a usuario
        $integrador->user->notify(new ActivacionIntegrador($integrador));
        
        return redirect()->route('integradores.index')->with('success','Integrador activado correctamente.');

    }

    public function set_productos(Request $request){
        #dd($request->all());
        $integrador = Integrador::find($request->integrador_id);
        $existe = $integrador->productos()->where('producto_id',$request->product_id)->exists();
        $producto = Producto::find($request->product_id);
        if($existe){
            #//Ya existe, entonces le eliminamos el producto
            $integrador->productos()->detach($producto);
        }else{
            #//No existe, entonces se lo agregamos
            $integrador->productos()->attach($producto);
        }
        
        return redirect()->route('integradores.show',$request->integrador_id);
    }

    public function integrador_show(){
    
        $integrador = Integrador::findOrFail( Auth::user()->integrador_id);
        $productos = $integrador->productos;
        $prods_integrador = $integrador->productos->pluck('id','id')->toArray();
        #return $productos;
        #$productos = Producto::all()->pluck('nombre','id');

        return view('integradores.integrador.show',compact('integrador','productos','prods_integrador'));
    }
}
