<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ClientesDocumento;
use App\ClientesTipo;
use App\Configuracion;
use App\Domicilio;
use App\Estado;
use App\Mail\SolicitudDocumentosCargados;
use App\Mail\SolicitudMasInformacion;
use App\ObligadoSolidario;
use App\Solicitud;
use App\SolicitudesEstatus;
use App\Plan;
use App\GiroComercial;
use App\Referencia;
use App\TipoProyecto;

use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use FontLib\EOT\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use NumeroALetras;

use App\Mail\SolicitudPreautorizada;
use App\Mail\SolicitudAutorizada;

use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class SolicitudesController extends Controller
{

    public function solicitudes_cliente(){
        if ( Auth::user()->grupo_id != 5){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $solicitudes = Solicitud::where('cliente_id',Auth::user()->cliente->id)->get();

        $cliente = $solicitudes[0]->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);


        #//Tipo documento dependiendo el tipo de cliente
        #//solo Autorización para revisión de buró de crédito
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',1)->whereIn('id',[29,30,32,33]);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        foreach($tipos_documentos as $k => $tipo){

            $apartados[ $tipo->acerca_de][$k] = $tipo;
            $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitudes[0]->id)->first();
            if($documento){
                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
            }
        }

        return view('clientes.solicitudes_cliente',compact('solicitudes','tipo_cliente','tipos_documentos','files','apartados'));
    }

    public function documentos_cliente(){

        $cliente = auth()->user()->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);

        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos;

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        $apartados_firmados = [];

        $solicitud = $cliente->solicitudes[0];
        foreach($tipos_documentos as $k => $tipo){


            if ( $tipo->firmado ){
                $apartados_firmados[ $tipo->acerca_de][$k] = $tipo;
            }else{
                $apartados[ $tipo->acerca_de][$k] = $tipo;
            }

            $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud->id)->first();
            if($documento){
                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
            }
        }

        return view('clientes.documentos_cliente',compact('apartados','tipos_documentos ','files','apartados_firmados'));
    }

    public function view_carga_documentos($solicitud_id = null){
        if ( Auth::user()->grupo_id != 5){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $solicitud = Solicitud::findOrFail($solicitud_id);
        if ($solicitud->cliente_id != Auth::user()->cliente->id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        if ($solicitud->estatus_id != 4 && $solicitud->estatus_id != 5){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"No puedes agregar documentos por el momento.");
        }

        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);




        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0)->where('activo',1);
        #return($tipos_documentos);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        foreach($tipos_documentos as $k => $tipo){

                $apartados[ $tipo->acerca_de][$k] = $tipo;
                $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud_id)->first();
                if($documento){
                    $files[ $tipo->id]['id'] = $documento->id;
                    $files[ $tipo->id]['filename'] = $documento->filename;
                    $files[ $tipo->id]['encname'] = $documento->encname;
                    $files[ $tipo->id]['filepath'] = $documento->filepath;
                    $files[ $tipo->id]['aprobado'] = $documento->aprobado;
                }

        }
        //        return $apartados;
        return view('solicitudes.carga_documentos',compact('solicitud','files','apartados'));
    }

    public function carga_documentos(Request $request){
        if($request->hasFile('archivo')){
            $solicitud_id = $request->solicitud_id;

            $file = $request->file('archivo');
            $path = $request->file('archivo')->store('files_solicitudes/' . $solicitud_id );
            $filename = $file->getClientOriginalName();


            if(!is_null($request->documento_id)){
                $documento = ClientesDocumento::where('id',$request->documento_id)->first();
                $archivo_anterior = $documento->filepath;
                $documento->filename = $filename;
                $documento->filepath = $path;
                $documento->save();
                Storage::delete($archivo_anterior);
            }
            else{
                $documento = ClientesDocumento::create(
                    [
                        'cliente_id'=>1,
                        'documento_tipo_id'=>$request->documento_tipo_id,
                        'filename'=>$filename,
                        'filepath'=>$path,
                        'solicitud_id'=>$solicitud_id,
                        'aprobado'=>false
                    ]
                );
            }

            #//Revisamos si la solicitud ya tiene cargados todos los documentos para cambiar de estatus
            $completos = $this->setRevDocumentos($solicitud_id);

            $response = [];
            $response['msj']='ok';
            $response['docs_completos']= $completos;
            $response['data'] = $documento;

            return $response;
        }
    }

    public function view_carga_documentos_firmados($solicitud_id = null){
        if ( Auth::user()->grupo_id != 5){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $solicitud = Solicitud::findOrFail($solicitud_id);
        if ($solicitud->cliente_id != Auth::user()->cliente->id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        #//No se puede acceder a esta vista si la solicitud no esta
        if ($solicitud->estatus_id != 2){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"No puedes agregar documentos por el momento.");
        }


        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);


        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',1)->where('activo',1);
        #return($tipos_documentos);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        foreach($tipos_documentos as $k => $tipo){

            $apartados[ $tipo->acerca_de][$k] = $tipo;
            $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud_id)->first();
            if($documento){
                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
            }

        }
        #return $apartados;

        return view('solicitudes.carga_documentos_firmados',compact('solicitud','files','apartados'));
    }

    private function setRevDocumentos($solicitud_id){
        $solicitud = Solicitud::find($solicitud_id);
        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);

        if ($solicitud->estatus_id == 2){
            #//autorizada
            $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',1)->where('activo',1);
        }else{
            $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0)->where('activo',1);
        }
        #return $tipos_documentos;

        $completos = false;

        #//Tipo documento dependiendo el tipo de cliente
        $todos_los_documentos = true;
        foreach($tipos_documentos as $k => $tipo){
            if ($tipo->pivot->obligatorio){
                $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud_id)->first();
                if(!$documento){
                    $todos_los_documentos = false;
                    break;
                }
            }
        }

        if ($todos_los_documentos){
            if ($solicitud->estatus_id != 2){
                #//Si la solicitud no esta autorizada, se hace cambio de estatus
                $solicitud->estatus_id = 5;
                $solicitud->save();

                #//Enviamos mail a usuario, notificando que ya tiene todos los documentos cargados
                #TODO descomentar
                Mail::to($cliente->correo)->send(new SolicitudDocumentosCargados($cliente));
            }else{
                #//nuevo estatus
                $solicitud->estatus_id = 7;
                $solicitud->save();
            }
            $completos = true;
        }


        return $completos;

    }

    public function admin_index(Request $request){
        #//Se agregan solicitudes de estatus "creada", las que estan en estatus creada, aun no tienen bandera de terminada como true
        $solicitudes = Solicitud::orderBy('id','desc')
                        ->estatus($request->estatus_id)
                        ->fecha($request->fecha)
                        ->nombreCliente($request->cliente)
                        ->whereIn("estatus_id",[1,2,3,4,5,6,7])
                        ->paginate(20);

        $estatus = SolicitudesEstatus::whereIn("id",[1,2,3,4,5,6,7])->pluck('nombre','id');
        $estatus->prepend('Todas', ' ');

        return view('solicitudes.admin.solicitudes',compact('solicitudes','estatus'));
    }

    public function admin_view($id = null){
        $solicitud = Solicitud::findOrFail($id);

        $cliente = $solicitud->cliente;
        $obligado_solidario = ObligadoSolidario::where('cliente_id',$cliente->id)->first();

        $tipo_cliente = $this->getTipoCliente($cliente);
        
        $cliente_files = [
            "ine_file" => $cliente['ine_file'],
            "ine_path" => $cliente['ine_path'],
            "ine_atras_file" => $cliente['ine_atras_file'],
            "ine_atras_path" => $cliente['ine_atras_path'],
            "hoja_buro_file" => $cliente['hoja_buro_file'],
            "hoja_buro_path" => $cliente['hoja_buro_path'],
            "foto_buro_file" => $cliente['foto_buro_file'],
            "foto_buro_path" => $cliente['foto_buro_path'],
        ];

        $obligado_solidario_files = [
            "ine_file" => $obligado_solidario['ine_file'],
            "ine_path" => $obligado_solidario['ine_path'],
            "hoja_buro_file" => $obligado_solidario['hoja_buro_file'],
            "hoja_buro_path" => $obligado_solidario['hoja_buro_path'],
            "ine_atras_file" => $obligado_solidario['ine_atras_file'],
            "ine_atras_path" => $obligado_solidario['ine_atras_path'],
            "foto_buro_file" => $obligado_solidario['foto_buro_file'],
            "foto_buro_path" => $obligado_solidario['foto_buro_path']
        ];
        
        #// dd($obligado_solidario_files);

        #dd($cliente_files);
        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('activo',1);
        #dd($tipos_documentos);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        $apartados_firmados = [];

        foreach($tipos_documentos as $k => $tipo){


            if ( $tipo->firmado ){
                $apartados_firmados[ $tipo->acerca_de][$k] = $tipo; #//Titulos (Distribuidor, Negocio, Socio, etc).
            }else{
                $apartados[ $tipo->acerca_de][$k] = $tipo; // 
            }
            $documento = $tipo->clientes_documentos()->where('solicitud_id',$id)->first();

            if($documento){

                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
                $files[ $tipo->id]['client_id'] = 0;
                $files[ $tipo->id]['tipo_id'] = 0;
                
                

            }
            else if($cliente->persona_tipo == "moral"){
                // Documentos del socio
                if($tipo->id == 25 && $tipo->acerca_de == 'Socio'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 25;
                }
                if($tipo->id == 57 && $tipo->acerca_de == 'Socio'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_atras_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_atras_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 57;
                }
                if($tipo->id == 33 && $tipo->acerca_de == 'Socio'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['hoja_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['hoja_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 33;
                }
                if($tipo->id == 58 && $tipo->acerca_de == 'Socio'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['foto_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['foto_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 58;
                }
                // Documentos del Aval
                if($tipo->id == 9 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $obligado_solidario_files['ine_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $obligado_solidario_files['ine_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 9;
                }
                if($tipo->id == 11 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['hoja_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['hoja_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 11;
                }
                if($tipo->id == 39 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_atras_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_atras_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 39;
                }
                if($tipo->id == 40 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['foto_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['foto_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 40;
                }
            }
            else if($cliente->persona_tipo == "fisica"){
                // Agregamos los documentos del solicitante.
                if($tipo->id == 1 && $tipo->acerca_de == 'Solicitante'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 1;
                }
                if($tipo->id == 29 && $tipo->acerca_de == 'Solicitante'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['hoja_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['hoja_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 29;
                }
                if($tipo->id == 36 && $tipo->acerca_de == 'Solicitante'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_atras_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_atras_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 36;
                }
                if($tipo->id == 38 && $tipo->acerca_de == 'Solicitante'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['foto_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['foto_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 38;
                }

                // Agregamos los documentos del Aval
                if($tipo->id == 9 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $obligado_solidario_files['ine_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $obligado_solidario_files['ine_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 9;
                }
                if($tipo->id == 11 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['hoja_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['hoja_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 11;
                }
                if($tipo->id == 39 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['ine_atras_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['ine_atras_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 39;
                }
                if($tipo->id == 40 && $tipo->acerca_de == 'Aval'){
                    $files[ $tipo->id]['id'] = 0;
                    $files[ $tipo->id]['filename'] = $cliente_files['foto_buro_file'];
                    $files[ $tipo->id]['encname'] = null;
                    $files[ $tipo->id]['filepath'] = $cliente_files['foto_buro_path'];
                    $files[ $tipo->id]['aprobado'] = 1;
                    $files[ $tipo->id]['client_id'] = $cliente->id ;
                    $files[ $tipo->id]['tipo_id'] = 40;
                }
            }
        }
        #dd($apartados);
        #dd($files);
        #dd($solicitud->integrador->user);
        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);

        #dd($tipos_documentos);

        unset($periodos['suma_amortizaciones']);
        #dd($files);
        return view('solicitudes.admin.view',compact('solicitud','files','apartados','periodos','tipo_cliente','apartados_firmados'));
    }

    public function admin_autorizar_datos($id = null){
        $solicitud = Solicitud::findOrFail($id);

        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);

        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0)->where('activo',1);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        foreach($tipos_documentos as $k => $tipo){
            $apartados[ $tipo->acerca_de][$k] = $tipo;

            $documento = $tipo->clientes_documentos()->where('solicitud_id',$id)->first();
            if($documento){
                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
            }
        }
        return view('solicitudes.admin.autorizar_datos',compact('solicitud','files','apartados'));

    }

    public function admin_estatus(Request $request){
        $solicitud = Solicitud::findOrFail($request->solicitud_id);

        #//Revisamos que todos los documentos ya esten cargados antes de autorizar
        if ($request->estatus_id == 2){
            $cliente = $solicitud->cliente;
            $tipo_cliente = $this->getTipoCliente($cliente);
            $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0)->where('activo',1);

            #//Tipo documento dependiendo el tipo de cliente
            #$tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0);
            $todos_los_documentos = true;
            foreach($tipos_documentos as $k => $tipo){
                $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud->id)->first();
                if(!$documento){
                    $todos_los_documentos = false;
                    break;
                }
            }

            if (!$todos_los_documentos){
                return redirect('/admin/solicitudes/' . $solicitud->id)->with('danger','Aún no se cargan todos los documentos.');
            }
        }

        $solicitud->estatus_id = $request->estatus_id;

        #//Solicitud autorizada
        #//Guardamos datos dependiendo si es plan o custom
        if($request->estatus_id == 2){
            #//Al momento de autorizar revisamos el plan para planchar con los valores que tiene BD
            if(is_null($solicitud->plan_id))
            {
                #//Plan custom
                $configuracion = Configuracion::find(1);
                $interes_anual = $configuracion->interes_anual;
                $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;
                $aplica_costo_anual_seguro = true; #//Si no tiene plan es custom y siempre aplica
            }
            else{
                #//Plan normal
                $plan = Plan::find($solicitud->plan_id);
                $interes_anual = $plan->interes_anual;
                $porcentaje_comision_por_apertura = $plan->comision_por_apertura;
                $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
            }

            $monto_financiar = $solicitud->monto_financiar;
            $comision_por_apertura = $solicitud->monto_financiar * ($porcentaje_comision_por_apertura / 100);
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

            $solicitud->pago_inicial = $pago_inicial;
            $solicitud->costo_anual_seguro = $costo_anual_seguro;
            $solicitud->porcentaje_comision_por_apertura = $porcentaje_comision_por_apertura;
            $solicitud->comision_por_apertura = $comision_por_apertura;
            $solicitud->interes_anual = $interes_anual;
            $solicitud->aplica_costo_anual_seguro = $aplica_costo_anual_seguro;
        }


        $solicitud->save();

        if($request->estatus_id == 4){
            #//La solicitud se preautoriza.
            $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);

            Mail::to($solicitud->cliente->correo)->send(new SolicitudPreautorizada($solicitud,$periodos));
        }
        elseif($request->estatus_id == 3){
            Mail::to($solicitud->cliente->correo)->send(new SolicitudMasInformacion($solicitud->cliente));
        }
        elseif ($request->estatus_id == 2){
            #//Solicitud autorizada
            Mail::to($solicitud->cliente->correo)->send(new SolicitudAutorizada($solicitud));
        }

        return redirect('/admin/solicitudes/'.$request->solicitud_id)->with('success','Estatus actualizado correctamente');
    }

    private function getTipoCliente($cliente){
        $tipo_cliente = 0;
        if($cliente->persona_tipo == 'moral'){
            $tipo_cliente = 5;
        }else{
            if ($cliente->dueno_casa){
                if ($cliente->historial_credito == "Bueno" || $cliente->historial_credito == "No se"){
                    $tipo_cliente = 1;
                }else{
                    $tipo_cliente = 2;
                }
            }else{
                if ($cliente->historial_credito == "Bueno" || $cliente->historial_credito == "No se"){
                    $tipo_cliente = 3;
                }else{
                    $tipo_cliente = 4;
                }
            }
        }
        return $tipo_cliente;
    }

    public function pdf($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }
        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);


        #//Calculamos variables dependiendo estatus y tipo de plan
        if($solicitud->estatus_id == 2)
        {
            #//autorizada
            $comision_por_apertura = $solicitud->comision_por_apertura;
            $pago_inicial = $solicitud->pago_inicial;
            $costo_anual_seguro = $solicitud->costo_anual_seguro;
            $aplica_costo_anual_seguro = $solicitud->aplica_costo_anual_seguro;
        }
        else{
            $costo_anual_seguro = 0;
            if(is_null($solicitud->plan_id))
            {
                #//Plan custom
                $configuracion = Configuracion::find(1);
                $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;
                $aplica_costo_anual_seguro = true; #//Si no tiene plan es custom y siempre aplica
            }
            else{
                #//Plan normal
                $plan = Plan::find($solicitud->plan_id);
                $porcentaje_comision_por_apertura = $plan->comision_por_apertura;
                $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
            }

            $comision_por_apertura = $solicitud->monto_financiar * ($porcentaje_comision_por_apertura / 100);
            $monto_financiar = $solicitud->monto_financiar;
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
        }



        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.detalle_solicitud',compact('solicitud','periodos','costo_anual_seguro','pago_inicial','comision_por_apertura'));
        return $pdf->stream();
    }

    public function pagare($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);
        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.pagare',compact('solicitud','periodos'));
        return $pdf->stream();
    }

    public function autorizacion_crediticia($solicitud_id = null){

        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.autorizacion_crediticia',compact('solicitud'));
        return $pdf->stream();
    }

    public function autorizacion_crediticia_obligado_solidario($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $tipo_cliente = $this->getTipoCliente($solicitud->cliente);

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.autorizacion_crediticia_obligado_solidario',compact('solicitud','tipo_cliente'));
        return $pdf->stream();
    }

    public function autorizacion_crediticia_negocio($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.autorizacion_crediticia_socio',compact('solicitud'));
        return $pdf->stream();
    }

    public function pagare_obligado_solidario($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);


        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.pagare_obligado_solidario',compact('solicitud','periodos'));
        return $pdf->stream();
    }

    public function carta_propietario($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView('pdfs.carta_propietario',compact('solicitud'));
        return $pdf->stream();
    }

    public function contrato($solicitud_id = null){
        ini_set('max_execution_time', 180); //3 minutes
        $solicitud = Solicitud::findOrFail($solicitud_id);
        if ( Auth::user()->grupo_id == 5 && Auth::user()->cliente->id != $solicitud->cliente_id){
            return redirect(Auth::user()->grupo->home_page )->with('danger',"Información no disponible");
        }

        $tipo_cliente = $this->getTipoCliente($solicitud->cliente);
        $formato = 'pdfs.contrato_tipo_'.$tipo_cliente;
        if ($tipo_cliente == 5){
            $formato = 'pdfs.contrato_persona_moral';
        }

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);
        $configuracion = Configuracion::find(1);

        #//Calculamos variables dependiendo estatus y tipo de plan
        if($solicitud->estatus_id == 2)
        {
            #//autorizada
            $comision_por_apertura = $solicitud->comision_por_apertura;
            $pago_inicial = $solicitud->pago_inicial;
            $costo_anual_seguro = $solicitud->costo_anual_seguro;
            $aplica_costo_anual_seguro = $solicitud->aplica_costo_anual_seguro;
            $interes_anual = $solicitud->interes_anual;
        }
        else{
            $costo_anual_seguro = 0;
            if(is_null($solicitud->plan_id))
            {
                #//Plan custom
                $configuracion = Configuracion::find(1);
                $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;
                $aplica_costo_anual_seguro = true; #//Si no tiene plan es custom y siempre aplica
                $interes_anual = $configuracion->interes_anual;
            }
            else{
                #//Plan normal
                $plan = Plan::find($solicitud->plan_id);
                $porcentaje_comision_por_apertura = $plan->comision_por_apertura;
                $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
                $interes_anual = $plan->interes_anual;
            }

            $comision_por_apertura = $solicitud->monto_financiar * ($porcentaje_comision_por_apertura / 100);
            $monto_financiar = $solicitud->monto_financiar;
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
        }



        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
        $pdf = PDF::loadView($formato,compact('solicitud','periodos','configuracion','comision_por_apertura','pago_inicial','costo_anual_seguro','interes_anual'));
        return $pdf->stream();

    }

    public function update_deuda_fico(Request $request){
        #return $request;

        $request->validate([
            'fico'=>'required|numeric',
            'deuda_mensual'=>'required|numeric',
        ]);

        $solicitud = Solicitud::findOrFail($request->solicitud_id);
        $solicitud->fico = $request->fico;
        $solicitud->deuda_mensual = $request->deuda_mensual;
        $solicitud->save();

        return redirect('/admin/solicitudes/'. $request->solicitud_id)->with('success','Datos editados correctamente');
    }

    public function admin_show_edit($solicitud_id){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);
        #$tipo_cliente = 5;

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);
        unset($periodos['suma_amortizaciones']);

        $configuracion = Configuracion::find(1);
        $minFinanciar = $configuracion->monto_min_financiar;
        $maxEnganche = $solicitud->precio_sistema - $minFinanciar;

        $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio', 7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];

        $estados = Estado::pluck('nombre','id');

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

        $razones_sociales = \App\RazonSocial::all()->pluck('razon_social','id');
        return view('solicitudes.admin.edit',compact('solicitud','cliente','tipo_cliente','periodos','minFinanciar','maxEnganche','meses','estados','planes','planes_list','razones_sociales'));
    }

    public function admin_edit(Request $request){
        
        $rules = [];
        #dd($request->all());

        $solicitud = Solicitud::findOrFail($request->id);
        $cliente = Cliente::findOrFail($solicitud->cliente_id);
        #dd($cliente);

        if($request->has('obligado_solidario_nombre')){
            #$rules['obligado_solidario_nombre'] = 'required';
            #$rules['obligado_solidario_dia'] = 'required';
            #$rules['obligado_solidario_apellido_paterno'] = 'required';
            #$rules['obligado_solidario_apellido_materno'] = 'required';


            #$rules['obligado_municipio_id'] = 'required';
            #$rules['obligado_estado_id'] = 'required';
            #//Aqui irian las reglas faltantes de obligado solidario, si se llega a necesitar
        }


        #//Dependera del input de dueño casa
        $cliente->dueno_casa = 1;
        if (!$request->has('cliente_dueno_casa')){
            $rules['rentero_nombre'] = 'required';
            $cliente->rentero_nombre = $request->rentero_nombre;

            $rules['rentero_folio_predial'] = 'required';
            $cliente->rentero_folio_predial = $request->rentero_folio_predial;
            $cliente->dueno_casa = 0;
        }


        #dd($request->all());

        $rules['precio_sistema'] = 'numeric|required';
        $rules['enganche'] = 'numeric|required';
        $rules['plazo_financiar'] = 'numeric|required';
        $rules['razon_social_id'] = 'numeric|required';

        #//Reglas de datos del cliente
        $rules['cliente_nombre'] =  'required|string';
        $rules['cliente_apellido_paterno'] =  'required|string';
        $rules['cliente_apellido_materno'] =  'required|string';

        #//reglas de domicilio del cliente
        $rules['domicilio_calle'] =  'required|string';
        $rules['domicilio_num_ext'] =  'string';
        $rules['domicilio_colonia'] =  'required|string';
        $rules['domicilio_estado_id'] =  'required|integer';
        $rules['domicilio_municipio_id'] = 'required|integer';
        $rules['domicilio_cp'] = 'required|integer';

        $request->validate($rules);
        #//SAVE del cliente
        $cliente->nombre = $request->cliente_nombre;
        $cliente->nombre_empresa = $request->nombre_empresa;
        $cliente->apellido_paterno = $request->cliente_apellido_paterno;
        $cliente->apellido_materno = $request->cliente_apellido_materno;
        $cliente->historial_credito = $request->cliente_historial_credito;
        $cliente->curp = $request->cliente_curp;
        $cliente->rfc = $request->cliente_rfc;

        $cliente->save();

        #//SAVE de domicilio
        $domicilio = [];
        $domicilio['calle'] = $request->domicilio_calle;
        $domicilio['numero_ext'] = $request->domicilio_num_ext;
        $domicilio['numero_int'] = $request->domicilio_numero_int;
        $domicilio['colonia'] = $request->domicilio_colonia;
        $domicilio['estado_id'] = $request->domicilio_estado_id;
        $domicilio['municipio_id'] = $request->domicilio_municipio_id;
        $domicilio['cp'] = $request->domicilio_cp;

        Domicilio::where('id',$request->domicilio_id)->update($domicilio);


        $flag_obligado = false;
        if($request->cliente_tipo_persona == 'moral'  || ( $request->cliente_tipo_persona == 'fisica' && $request->cliente_historial_credito != 'Bueno') ){
            $flag_obligado = true;
        }

        if ($flag_obligado){
            #//saves del obligado
            $fecha_nacimiento = date('Y-m-d',strtotime($request->obligado_solidario_dia.'-'.$request->obligado_solidario_mes.'-'.$request->obligado_solidario_anio));
            $obligado_solidario = ObligadoSolidario::updateOrCreate(
                ['cliente_id'=>$cliente->id],
                [
                    'nombre'=>$request->obligado_solidario_nombre,
                    'apellido_paterno'=>$request->obligado_solidario_apellido_paterno,
                    'apellido_materno'=>$request->obligado_solidario_apellido_materno,
                    'fecha_nacimiento'=>$fecha_nacimiento,
                    'estado_nacimiento_id'=>$request->obligado_solidario_estado_id,
                    'sexo'=>$request->obligado_solidario_sexo,
                    'curp'=>$request->obligado_solidario_curp,
                    'rfc'=>$request->obligado_solidario_rfc,
                ]
            );


            #//Guardamos el domicilio
            $domicilio_obligado = Domicilio::updateOrCreate(
                ['obligado_id'=>$obligado_solidario->id],
                [
                    'calle'=>$request->obligado_calle,
                    'numero_ext'=>$request->obligado_num_ext,
                    'numero_int'=>$request->obligado_numero_int,
                    'colonia'=>$request->obligado_colonia,
                    'estado_id'=>$request->obligado_estado_id,
                    'municipio_id'=>$request->obligado_municipio_id,
                    'cp'=>$request->obligado_cp,
                    'fiscal'=>0
                ]
            );
        }

        if($request->cliente_tipo_persona == 'moral'){
            #//Datos de la empresa
            $domicilio_empresa = Domicilio::find( $request->empresa_domicilio_id );
            $domicilio_empresa->calle = $request->empresa_domicilio_calle;
            $domicilio_empresa->numero_ext = $request->empresa_domicilio_num_ext;
            $domicilio_empresa->numero_int = $request->empresa_domicilio_numero_int;
            $domicilio_empresa->colonia = $request->empresa_domicilio_colonia;
            $domicilio_empresa->estado_id = $request->empresa_domicilio_estado_id;
            $domicilio_empresa->municipio_id = $request->empresa_domicilio_municipio_id;
            $domicilio_empresa->cp = $request->empresa_domicilio_cp;

            $domicilio_empresa->save();
        }

        #//Obtenemos registros de config
        $configuracion = Configuracion::find(1);



        if($solicitud->estatus_id == 2)
        {
            #//Si ya esta autorizada no cambiamos valores al menos que seleccionen un nuevo plan
            #//Seleccionan un plan distinto a custom
            if($request->plan_id != null){
                #//Plan seleccionado distinto al plan que tiene la solicitud
                if( $request->plan_id != $solicitud->plan_id ){
                    #//Buscamos plan
                    $plan = Plan::find($request->plan_id);
                    $porcentaje_comision_por_apertura = (!is_null($plan->comision_por_apertura))?$plan->comision_por_apertura:0;
                    $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
                }else{
                    $porcentaje_comision_por_apertura = $solicitud->porcentaje_comision_por_apertura;
                    $aplica_costo_anual_seguro = $solicitud->aplica_costo_anual_seguro;
                }
            }
            else{
                #//Si se selecciona el custom
                if($request->plan_id == $solicitud->plan_id){
                    #//Y si el plan ya estaba como custom, usamos los mismos valores que ya tenía
                    $aplica_costo_anual_seguro = $solicitud->aplica_costo_anual_seguro;
                    $porcentaje_comision_por_apertura = $solicitud->porcentaje_comision_por_apertura;
                }else{
                    #//era de un plan y cambio al custom
                    #//Aplicamos los valores del config general
                    $aplica_costo_anual_seguro = true;
                    $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;
                }
            }
        }
        else{
            if(is_null($request->plan_id)){
                #//Tomamos valores del config
                $aplica_costo_anual_seguro = true;
                $porcentaje_comision_por_apertura = $configuracion->comision_por_apertura;
            }else{
                #//Tomamos valores del plan
                $plan = Plan::find($request->plan_id);
                $porcentaje_comision_por_apertura = (!is_null($plan->comision_por_apertura))?$plan->comision_por_apertura:0;
                $aplica_costo_anual_seguro = $plan->costo_anual_seguro;
            }
        }

        $monto_financiar = $request->input('precio_sistema') - $request->input('enganche');
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

        #//mismo valor de cuando se creo la solicitud "porcentaje_comision_por_apertura "
        $comision_por_apertura = $monto_financiar * ($porcentaje_comision_por_apertura / 100);
        $pago_inicial = $costo_anual_seguro + $comision_por_apertura;

        $solicitud->razon_social_id = $request->input('razon_social_id');
        $solicitud->precio_sistema = $request->input('precio_sistema');
        $solicitud->enganche = $request->input('enganche');
        $solicitud->monto_financiar = $monto_financiar;
        $solicitud->descripcion_de_bienes = $request->input('descripcion_de_bienes');

        $solicitud->porcentaje_comision_por_apertura = $porcentaje_comision_por_apertura;
        $solicitud->comision_por_apertura = $comision_por_apertura;
        $solicitud->costo_anual_seguro = $costo_anual_seguro;
        $solicitud->pago_inicial = $pago_inicial;
        $solicitud->aplica_costo_anual_seguro = ($aplica_costo_anual_seguro)?true:false;

        $solicitud->primer_fecha_vencimiento = $request->solicitud_primer_fecha_vencimiento;


        if($solicitud->estatus_id == 2)
        {
            #//Seleccionan el custom
            if(is_null($request->plan_id)){
                #//Si la solicitud originalmente era de un plan distinto al costum, calculamos el
                #//interes anual nuevamente porque el del plan ya no le corresponde
                if( $request->plan_id != $solicitud->plan_id ){
                    #//Buscamos config y guardamos valor de interes anual
                    $solicitud->interes_anual = $configuracion->interes_anual;
                }
            }
            else{
                #//Si la solicitud cambió de plan, calculamos el nuevo interes anual
                if( $request->plan_id != $solicitud->plan_id ){
                    $solicitud->interes_anual = $plan->interes_anual;
                }
            }

            $solicitud->plazo_financiar = $request->input('plazo_financiar');
            $solicitud->plan_id = $request->plan_id;
        }
        else{
            #//Tomamos valores directo de BD
            if(is_null($request->plan_id)){
                $solicitud->interes_anual = $configuracion->interes_anual;
            }else{
                $solicitud->interes_anual = $plan->interes_anual;
            }

            $solicitud->plazo_financiar = $request->input('plazo_financiar');
            $solicitud->plan_id = $request->plan_id;
        }


        $solicitud->save();
        return redirect('/admin/solicitudes/'.$request->id)->with('success','Datos agregados correctamente');
    }

    public function admin_destroy($solicitud_id = null){
        #//Pasar a post
        $solicitud = Solicitud::findOrFail($solicitud_id);
        $success = true;
        DB::beginTransaction();
        try{
            $solicitud->delete();
        }
        catch (\Exception $exception){
            #dd($exception->getMessage());
            $success = $exception->getMessage();
            DB::rollBack();
        }

        if ($success === true){
            DB::commit();
            return redirect('/admin/solicitudes')->with('success','Solicitud eliminada correctamente.');
        }
        return redirect('/admin/solicitudes')->with('sdangeruccess','La solicitud no se pudo eliminar. Intenta nuevamente.');

    }

    public function showSolicitudCotizacion($solicitud_id){
        $solicitud = Solicitud::findOrFail($solicitud_id);
        /* if ($solicitud->estatus_id == 6) {
            return redirect()->route('integrador.showSolicitudCotizacion')->with('danger','No tienes acceso a esta información');
        } */
        
        $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio', 7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
        $estados = Estado::pluck('nombre','id');

        $giros = GiroComercial::where('activo',1)->orderByRaw('nombre ASC')->pluck('nombre','id');

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema, $solicitud->enganche, $solicitud->plazo_financiar, $solicitud, false,$solicitud->plan_id);

        $cliente = $solicitud->cliente;

        #return $cliente->user;
        $tipos_proyectos = TipoProyecto::all()->pluck('nombre','id');
        return view('solicitudes.integrador.create',compact('solicitud','meses','estados','giros','periodos','tipos_proyectos','cliente'));
    }

    public function integrador_postSteps(Request $request){        
        if($request->input('step') == 1){
            #dd($request->all());
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
                    'nombre'=>$request->input('nombre') . ' ' . $request->input('apellido_paterno') . ' '. $request->input('apellido_materno'),
                    'password'=>Hash::make($request->input('password'))
                ];
            }else{
                $update = [
                    'email'=>$request->input('correo'),
                    'nombre'=>$request->input('nombre') . ' ' . $request->input('apellido_paterno') . ' '. $request->input('apellido_materno'),
                ];
            }
            $cliente->user()->update($update);
            return ['msg'=>'ok'];

        }elseif ($request->input('step') == 2){
            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->estado_nacimiento_id = $request->input('estado_nacimiento_id');
            $cliente->sexo = $request->input('sexo');
            $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
            $cliente->rfc = $request->input('rfc');
            $cliente->curp = $request->input('curp');
            $cliente->save();

            return ['msg'=>'ok'];
        }elseif ($request->input('step') == 3) {
            #dd($request->all());
            # code...
                $cliente = Cliente::find($request->input('cliente_id'));
                $cliente->dueno_casa = $request->input('dueno_casa');
                $cliente->telefono_fijo = $request->input('telefono_casa');
                $cliente->telefono_movil = $request->input('telefono_movil');
                $cliente->rentero_nombre = $request->input('rentero_nombre');
                $cliente->rentero_folio_predial = $request->input('rentero_folio_predial');
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
        }elseif ($request->input('step') == 4) {
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
        }elseif($request->input('step') == 5){
            #dd($request->all());
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
        }elseif($request->input('step') == 8){
            $cliente = Cliente::find($request->input('cliente_id'));
            $cliente->tarjeta_credito_titular = $request->input('tarjeta_credito_titular');
            $cliente->ultimos_digitos = $request->input('ultimos_digitos');
            $cliente->credito_hipotecario = $request->input('credito_hipotecario');
            $cliente->historial_credito = $request->input('historial_credito');
            $cliente->credito_automotriz = $request->input('credito_automotriz');
            $cliente->save();

            $solicitud = Solicitud::find($request->input('solicitud_id'));
            $tipo_persona = ($cliente->persona_tipo == 'fisica')?"PF":"PM";
            $folio = $solicitud->id . "-" . $tipo_persona;
            $solicitud->folio = $folio;
            $solicitud->save();
            return ['msg'=>'ok'];
        }elseif($request->input('step') == 7){
            #dd($request->all());
            $solicitud = Solicitud::find($request->input('solicitud_id'));
            $solicitud->tipo_proyecto_id = $request->tipo_proyecto_id;
            $solicitud->descripcion_de_bienes = $request->descripcion_de_bienes;
            $solicitud->estatus_id = 4;
            $solicitud->save();

            $cliente = $solicitud->cliente;
            $cliente->registro_completo = 1;
            $cliente->save();

            return ['msg'=>'ok'];
        }
    }

    public function integrador_solicitudes(){
        $solicitudes = Solicitud::where('integrador_id', Auth::user()->integrador_id )->get();

        return view('solicitudes.integrador.index',compact('solicitudes'));
        return $solicitudes;
    }

    public function integrador_show_carga_documentos($solicitud_id = null){
        $solicitud = Solicitud::findOrFail($solicitud_id);
        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);

        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('firmado',0)->where('activo',1);
        #return($tipos_documentos);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        foreach($tipos_documentos as $k => $tipo){

                $apartados[ $tipo->acerca_de][$k] = $tipo;
                $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud_id)->first();
                if($documento){
                    $files[ $tipo->id]['id'] = $documento->id;
                    $files[ $tipo->id]['filename'] = $documento->filename;
                    $files[ $tipo->id]['encname'] = $documento->encname;
                    $files[ $tipo->id]['filepath'] = $documento->filepath;
                    $files[ $tipo->id]['aprobado'] = $documento->aprobado;
                }

        }
        //        return $apartados;
        return view('solicitudes.integrador.carga_documentos',compact('solicitud','files','apartados'));
    }

    public function integrador_show($solicitud_id = null){        
        $solicitud = Solicitud::findOrFail($solicitud_id);        
        if(Auth::user()->integrador_id != $solicitud->integrador_id)
            return redirect()->route('integrador.solicitudes')->with('danger','No tienes acceso a esta información');

        if ($solicitud->estatus_id == 6) {
            return redirect()->route('integrador.showSolicitudCotizacion',$solicitud->id);
        }

        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);
        #dd($tipo_cliente);

        #//Tipo documento dependiendo el tipo de cliente
        $tipos_documentos = ClientesTipo::find($tipo_cliente)->documentos_tipos->where('activo',1);
        #dd($tipos_documentos);

        #//Obtenemos archivos de cada tipo de documento. Armamos array donde indice es el tipo_documento_id
        $files = [];
        $apartados = []; #//Formateamos los $tipos_documentos en este array para que indice principal sea titulo del h2 en la vista
        $apartados_firmados = [];

        foreach($tipos_documentos as $k => $tipo){


            if ( $tipo->firmado ){
                $apartados_firmados[ $tipo->acerca_de][$k] = $tipo;
            }else{
                $apartados[ $tipo->acerca_de][$k] = $tipo;
            }

            $documento = $tipo->clientes_documentos()->where('solicitud_id',$solicitud_id)->first();
            if($documento){
                $files[ $tipo->id]['id'] = $documento->id;
                $files[ $tipo->id]['filename'] = $documento->filename;
                $files[ $tipo->id]['encname'] = $documento->encname;
                $files[ $tipo->id]['filepath'] = $documento->filepath;
                $files[ $tipo->id]['aprobado'] = $documento->aprobado;
            }
        }

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);


        unset($periodos['suma_amortizaciones']);
        return view('solicitudes.integrador.view',compact('solicitud','files','apartados','periodos','tipo_cliente','apartados_firmados'));
    }

    public function integrador_edit($solicitud_id){
        $solicitud = Solicitud::findOrFail($solicitud_id);

        $cliente = $solicitud->cliente;
        $tipo_cliente = $this->getTipoCliente($cliente);
        #$tipo_cliente = 5;

        $periodos = Solicitud::periodosCotizacion($solicitud->precio_sistema,$solicitud->enganche,$solicitud->plazo_financiar,$solicitud);
        unset($periodos['suma_amortizaciones']);

        $configuracion = Configuracion::find(1);
        $minFinanciar = $configuracion->monto_min_financiar;
        $maxEnganche = $solicitud->precio_sistema - $minFinanciar;

        $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio', 7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];

        $estados = Estado::pluck('nombre','id');

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

        $razones_sociales = \App\RazonSocial::all()->pluck('razon_social','id');
        return view('solicitudes.integrador.edit',compact('solicitud','cliente','tipo_cliente','periodos','minFinanciar','maxEnganche','meses','estados','planes','planes_list','razones_sociales'));
    }

    public function integrador_update(Request $request){

        #dd($request->all());
        #//reglas de domicilio del cliente
        $rules['domicilio_calle'] =  'required|string';
        $rules['domicilio_num_ext'] =  'string';
        $rules['domicilio_colonia'] =  'required|string';
        $rules['domicilio_estado_id'] =  'required|integer';
        $rules['domicilio_municipio_id'] = 'required|integer';
        $rules['domicilio_cp'] = 'required|integer';
        $request->validate($rules);

        #//SAVE de domicilio
        $domicilio = [];
        $domicilio['calle'] = $request->domicilio_calle;
        $domicilio['numero_ext'] = $request->domicilio_num_ext;
        $domicilio['numero_int'] = $request->domicilio_numero_int;
        $domicilio['colonia'] = $request->domicilio_colonia;
        $domicilio['estado_id'] = $request->domicilio_estado_id;
        $domicilio['municipio_id'] = $request->domicilio_municipio_id;
        $domicilio['cp'] = $request->domicilio_cp;

        Domicilio::where('id',$request->domicilio_id)->update($domicilio);
        return redirect()->route('integrador.solicitud.show',$request->solicitud_id)->with('success','Datos editados correctamente.');
    }
}
