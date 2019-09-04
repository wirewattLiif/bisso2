<?php

namespace App\Http\Controllers;

use App\ClientesDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Cliente;

class ClientesDocumentosController extends Controller
{
    public function attach($id = null, $client_id = null, $tipo_id = null){
        if($id == 0){
            $cliente_documento = Cliente::findOrFail($client_id);
            #dd($cliente_documento);
            // Persona moral - Socio || Aval
            /*
            if($tipo->id == 25){
                if (Storage::exists($cliente_documento->ine_path,$cliente_documento->ine_file)){
                    $filename = Str::ascii($cliente_documento->ine_file);
                    return Storage::download($cliente_documento->ine_path,$filename);
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            } elseif($tipo->id == 57){
                if (Storage::exists($cliente_documento->ine_atras_path,$cliente_documento->ine_atras_file)){
                    $filename = Str::ascii($cliente_documento->ine_atras_file);
                    return Storage::download($cliente_documento->ine_atras_path,$filename);
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            } elseif($tipo->id == 33){
                if (Storage::exists($cliente_documento->hoja_buro_path,$cliente_documento->hoja_buro_file)){
                    $filename = Str::ascii($cliente_documento->hoja_buro_file);
                    return Storage::download($cliente_documento->hoja_buro_path,$filename);
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }elseif($tipo->id == 58){
                if (Storage::exists($cliente_documento->foto_buro_path,$cliente_documento->foto_buro_file)){
                    $filename = Str::ascii($cliente_documento->foto_buro_file);
                    return Storage::download($cliente_documento->foto_buro_path,$filename);
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }
            */
            // Persona fisica - Solicitante || Aval
            if($tipo_id == 1 || $tipo_id == 9 || $tipo_id == 25){
                if (Storage::disk('public')->exists($cliente_documento->ine_path)){
                    //$filename = Str::ascii($cliente_documento->ine_file);
                    //return Storage::download($cliente_documento->ine_path,$filename);
                    return response()->download(storage_path("app/public/{$cliente_documento->ine_path}"));
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }
            elseif($tipo_id == 29 || $tipo_id == 11 || $tipo_id == 33){
                if (Storage::disk('public')->exists($cliente_documento->hoja_buro_path)){
                    return response()->download(storage_path("app/public/{$cliente_documento->hoja_buro_path}"));
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }
            elseif($tipo_id == 36 || $tipo_id == 39 || $tipo_id == 57){
                if (Storage::disk('public')->exists($cliente_documento->ine_atras_path)){
                    return response()->download(storage_path("app/public/{$cliente_documento->ine_atras_path}"));
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }
            elseif($tipo_id == 38 || $tipo_id== 40 || $tipo_id == 58){
                if (Storage::disk('public')->exists($cliente_documento->foto_buro_path)){
                    //$filename = Str::ascii($cliente_documento->foto_buro_file);
                    //return Storage::download($cliente_documento->foto_buro_path,$filename);
                    return response()->download(storage_path("app/public/{$cliente_documento->foto_buro_path}"));
                }else{
                    return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
                }
            }

        }else{
            $documento = ClientesDocumento::findOrFail($id);
            #dd(Storage::disk('public')->exists($documento->filepath));
            if (Storage::exists($documento->filepath)){
                return response()->download(storage_path("app/{$documento->filepath}"));
            }else{
                return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
            }
            /*if (Storage::exists($documento->filepath,$documento->filename)){
                $filename = Str::ascii($documento->filename);
                return Storage::download($documento->filepath,$filename);
            }else{
                return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
            }*/
        }
        /*$documento = ClientesDocumento::findOrFail($id);
        if (Storage::exists($documento->filepath,$documento->filename)){
            $filename = Str::ascii($documento->filename);
            return Storage::download($documento->filepath,$filename);
        }else{
            return redirect()->back()->with('info','No se encuentra el documento seleccionado.');
        }*/
    }

    public function aprobar(Request $request){
        $state = ($request->state == 'true')?1:0;
        $doc = ClientesDocumento::where('id',$request->doc_id)->update(['aprobado'=>$state ]);
        $response['msj'] = 'ok';
        return $response;
    }
}
