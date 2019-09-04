@extends('layouts.app')

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/admin/solicitudes" class="btn btn-default2 btn-rounded">Solicitudes</a>
            <h4 class="page-title d-inline">Detalle de la Solicitud.</h4>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h2 class="d-inline">
                {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}
            </h2>
            <label class="label label-default label-rouded">Persona {{ $solicitud->cliente->persona_tipo }}</label>


            @if($solicitud->estatus_id == 5)
                <a href="#" data-target="#modal_autorizar" data-toggle="modal">
                    <label class="label label-rouded" style="cursor: pointer !important;background-color:{{ $solicitud->estatus->color }}">{{ $solicitud->estatus->nombre }}</label>
                </a>
            @elseif($solicitud->estatus_id == 1)
                <a href="#" data-target="#modal_preautorizar_rechazar" data-toggle="modal">
                    <label class="label label-rouded" style="cursor: pointer !important;background-color:{{ $solicitud->estatus->color }}">{{ $solicitud->estatus->nombre }}</label>
                </a>
            @elseif($solicitud->estatus_id == 2)
                <a href="#" data-target="#modal_autorizar" data-toggle="modal">
                    <label class="label label-rouded" style="cursor: pointer !important;background-color:{{ $solicitud->estatus->color }}">{{ $solicitud->estatus->nombre }}</label>
                </a>
            @else
                <label class="label label-rouded" style="background-color:{{ $solicitud->estatus->color }}">{{ $solicitud->estatus->nombre }}</label>
            @endif

            @if (!empty($solicitud->integrador))                
                <h5>Integrador: {{ $solicitud->integrador->user->nombre }}</h5>
            @endif
        </div>

        <div class="col-md-4">
            <div class="btn-group m-r-10">
                <button class="btn btn-rounded btn-outline btn-success waves-effect waves-light dropdown-toggle" aria-expanded="true" data-toggle="dropdown" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">

                        <li>
                            <a href="/solicitud/contrato/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                Contrato
                            </a>
                        </li>

                    @if($tipo_cliente == 1)
                        <li>
                            <a href="/solicitud/pagare/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                Formato Pagare
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                Autorización Crediticia - Solicitante
                            </a>
                        </li>
                    @elseif($tipo_cliente == 2)
                        <li>
                            <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario" target="_blank" style="">
                                Formato Pagare - Obligado Solidario
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                Autorización Crediticia - Solicitante
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario" target="_blank" style="">
                                Autorización Crediticia - Obligado Solidario
                            </a>
                        </li>
                    @elseif($tipo_cliente == 3)
                        <li>
                            <a href="/solicitud/pagare/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                Formato Pagare
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                Carta Propietario
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante"  target="_blank" style="">
                                Autorización Crediticia - Solicitante
                            </a>
                        </li>
                    @elseif($tipo_cliente == 4)
                        <li>
                            <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario" target="_blank" style="">
                                Formato Pagare - Obligado Solidario
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                Carta Propietario
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                Autorización Crediticia - Solicitante
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                Autorización Crediticia - Obligado Solidario
                            </a>
                        </li>
                    @elseif($tipo_cliente == 5)
                        <li>
                            <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario"  target="_blank" style="">
                                Formato Pagare - Obligado Solidario
                            </a>
                        </li>
                        <li>
                            <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                Carta Propietario
                            </a>
                        </li>
                        @if(isset($solicitud->cliente->obligado_solidario) && !empty($solicitud->cliente->obligado_solidario->nombre))
                            <li>
                                <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                    Autorización Crediticia - Socio
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="/solicitud/autorizacion_crediticia_negocio/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                Autorización Crediticia - Negocio
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <a href="/solicitud/pdf/{{ $solicitud->id }}" target="_blank" class="btn btn-rounded btn-outline btn-success waves-effect waves-light">
                <i class="fa fa-file-pdf-o m-r-5"></i>
                Descargar PDF
            </a>

            @if($solicitud->estatus_id != 7)
                <a href="/admin/solicitud/edit/{{ $solicitud->id }}" class="btn btn-rounded btn-outline btn-success waves-effect waves-light">
                    Editar
                </a>
            @endif
        </div>
    </div>
        <br><br><br>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <h5>Folio</h5>
                    <p>{{ $solicitud->folio }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Correo</h5>
                    <p>{{ $solicitud->cliente->correo }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Teléfono móvil</h5>
                    <p>{{ $solicitud->cliente->telefono_movil }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Teléfono casa</h5>
                    <p>{{ $solicitud->cliente->telefono_fijo }}</p>
                </div>

                <div class="col-md-4">
                    <h5>RFC</h5>
                    <p>{{ $solicitud->cliente->rfc }}</p>
                </div>

                <div class="col-md-4">
                    <h5>CURP</h5>
                    <p>{{ $solicitud->cliente->curp }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Género</h5>
                    <p>{{ $solicitud->cliente->sexo }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Fecha de nacimiento</h5>
                    <p>{{ date('d-m-Y',strtotime($solicitud->cliente->fecha_nacimiento)) }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Lugar de Nacimiento</h5>
                    <p>{{ $solicitud->cliente->estado_nacimiento->nombre }}</p>
                </div>

                <div class="col-md-4">
                    <h5>Dirección</h5>
                    <p>
                        {{ @$solicitud->cliente->domicilio->calle  }} Ext:{{ @$solicitud->cliente->domicilio->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio->numero_int  }}
                        Col. {{ @$solicitud->cliente->domicilio->colonia }}, {{ @$solicitud->cliente->domicilio->municipio->nombre }}, {{ @$solicitud->cliente->domicilio->estado->nombre }}
                        C.P: {{ @$solicitud->cliente->domicilio->cp }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-11">
            <div class="white-box">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-item " aria-expanded="false">
                        <a href="#trabajo" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            @if( $solicitud->cliente->persona_tipo == 'fisica')
                                Trabajo
                            @else
                                Datos del Negocio
                            @endif
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#referencias" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Referencias
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#sistema_solar" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Proyecto
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#cotizacion" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Detalle de la Cotización
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#credito" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Historial Crediticio
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#documentos" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Documentos
                        </a>
                    </li>
                    <li role="presentation" class="nav-item" aria-expanded="false">
                        <a href="#pre_aprobacion" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Pre-aprobación
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="documentos" aria-expanded="false">
                        @if( $solicitud->estatus_id == 5)
                            <div class="col-md-12">
                                <a href="/admin/autorizar_datos/{{ $solicitud->id }}" class="btn btn-success btn-rounded pull-right btn-outline">Revisión de documentos</a>
                            </div>
                        @endif


                        @php $i = 1; @endphp
                        @foreach($apartados as $apartado => $tipos_documentos)
                            <div class="col-md-6">
                                <h3 class="naranja" style="margin-top:20px">{{ $apartado }}</h3>
                                @foreach($tipos_documentos as $tipo)
                                    <p class="">
                                        @if(isset($files[$tipo->id]))
                                            <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}/{{ $files[$tipo->id]['client_id'] }}/{{ $files[$tipo->id]['tipo_id'] }}" style="font-size: 20px;">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </a>
                                        @endif


                                        <b>{{ $tipo->nombre }}</b>
                                        @if( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])
                                            <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i> </button>
                                        @endif
                                    </p>
                                @endforeach
                            </div>

                            @if( $i % 2 == 0)
                                <div class="clearfix"></div>
                            @endif
                            @php $i++; @endphp
                        @endforeach

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <hr>
                            <h3>Documentos firmados</h3>


                            @php $i = 1; @endphp
                            @foreach($apartados_firmados as $apartado => $tipos_documentos)
                                <div class="col-md-6">
                                    <h3 class="naranja" style="margin-top:20px">{{ $apartado }}</h3>
                                    @foreach($tipos_documentos as $tipo)
                                        <p class="">
                                            @if(isset($files[$tipo->id]))
                                                <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}/{{ $files[$tipo->id]['client_id'] }}/{{ $files[$tipo->id]['tipo_id'] }}" style="font-size: 20px;">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                            @endif


                                            <b>{{ $tipo->nombre }}</b>
                                            @if( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])
                                                <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i> </button>
                                            @endif
                                        </p>
                                    @endforeach
                                </div>

                                @if( $i % 2 == 0)
                                    <div class="clearfix"></div>
                                @endif
                                @php $i++; @endphp
                            @endforeach


                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="referencias" aria-expanded="false">
                        @if( $solicitud->cliente->persona_tipo == 'fisica')
                            <h4 class="naranja">Referencias</h4>
                            @foreach($solicitud->cliente->referencias_personales as $k => $referencia)
                                <div class="col-md-4">
                                    <h5>Referencia {{ $k + 1}}</h5>
                                    <p>{{ $referencia->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Teléfono Referencia {{ $k + 1 }}</h5>
                                    <p>{{ $referencia->telefono }}</p>
                                </div>
                                <div class="clearfix"></div>
                            @endforeach
                        @else

                            <h4 class="naranja">Proveedores</h4>
                            @foreach($solicitud->cliente->referencias_proveedores as $k => $referencia)
                                <div class="col-md-4">
                                    <h5>Proveedor {{ $k + 1}}</h5>
                                    <p>{{ $referencia->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Teléfono {{ $k + 1 }}</h5>
                                    <p>{{ $referencia->telefono }}</p>
                                </div>
                                <div class="clearfix"></div>
                            @endforeach

                            <h4 class="naranja">Clientes</h4>
                            @foreach($solicitud->cliente->referencias_clientes as $k => $referencia)
                                <div class="col-md-4">
                                    <h5>Cliente {{ $k + 1}}</h5>
                                    <p>{{ $referencia->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Teléfono {{ $k + 1 }}</h5>
                                    <p>{{ $referencia->telefono }}</p>
                                </div>
                                <div class="clearfix"></div>
                            @endforeach
                        @endif

                        <div class="clearfix"></div>

                            @if($tipo_cliente == 2 || $tipo_cliente == 4 || $tipo_cliente == 5)
                                <div class="col-md-12">
                                    <h4 class="naranja">Obligado Solidario</h4>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>Nombre</h5>
                                    <p>{{ @$solicitud->cliente->obligado_solidario->nombre }} {{ @$solicitud->cliente->obligado_solidario->apellido_paterno }} {{ @$solicitud->cliente->obligado_solidario->apellido_materno }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Fecha de nacimiento</h5>
                                    <p>{{ @$solicitud->cliente->obligado_solidario->fecha_nacimiento }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Dirección</h5>
                                    <p>
                                        {{ @$solicitud->cliente->obligado_solidario->domicilio->calle  }} Ext:{{ @$solicitud->cliente->obligado_solidario->domicilio->numero_ext  }} Int:{{ @$solicitud->cliente->obligado_solidario->domicilio->numero_int  }}
                                        Col. {{ @$solicitud->cliente->obligado_solidario->domicilio->colonia }}, {{ @$solicitud->cliente->obligado_solidario->domicilio->municipio->nombre }}, {{ @$solicitud->cliente->obligado_solidario->domicilio->estado->nombre }}
                                        C.P: {{ @$solicitud->cliente->obligado_solidario->domicilio->cp }}
                                    </p>
                                </div>
                            @endif

                            @if($tipo_cliente == 3 || $tipo_cliente == 4)
                                <div class="col-md-12">
                                    <h4 class="naranja">Rentero</h4>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>Nombre</h5>
                                    <p>{{  $solicitud->cliente->rentero_nombre}}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Folio predial</h5>
                                    <p>{{  $solicitud->cliente->rentero_folio_predial }}</p>
                                </div>
                            @endif
                    </div>

                    <div role="tabpanel" class="tab-pane" id="sistema_solar" aria-expanded="false">
                        <div class="col-md-4">
                            <h5>Número de páneles</h5>
                            <p>{{ $solicitud->total_paneles }}</p>
                        </div>

                        <div class="col-md-4">
                            <h5>Capacidad por panel</h5>
                            <p>{{ $solicitud->capacidad_paneles }} Wts</p>
                        </div>

                        <div class="col-md-4">
                            <h5>Capacidad del sistema</h5>
                            <p>{{ $solicitud->capacidad_sistema }} Wts</p>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-4">
                            <h5>Recibo de luz</h5>
                            <p>${{ number_format($solicitud->cfe_promedio,2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Ahorros mensuales</h5>
                            <p>${{ number_format($solicitud->ahorros_proyectados_mes,2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Empresa instaladora</h5>
                            <p>{{ $solicitud->empresa_instaladora_solar }}</p>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-4">
                            <h5>Contacto instaladora</h5>
                            <p>{{ $solicitud->contacto_instaladora }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Fecha de instalación</h5>
                            <p>{{ date('d-m-Y',strtotime($solicitud->fecha_instalacion_tentativa)) }}</p>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <h5>Descripción de los bienes</h5>
                            <p>
                                {{ @$solicitud->descripcion_de_bienes }}
                            </p>
                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="credito" aria-expanded="false">

                        <div class="col-md-4">
                            <h5>Titular de tarjeta</h5>
                            <p>{{ ($solicitud->cliente->tarjeta_credito_titular)?'Si':'No' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Últimos 4 dígitos</h5>
                            <p>{{ $solicitud->cliente->ultimos_digitos }}</p>
                        </div>

                        <div class="col-md-4">
                            <h5>Titular hipoteca</h5>
                            <p>{{ ($solicitud->cliente->credito_hipotecario)?'Si':'No' }}</p>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-4">
                            <h5>Credito automotriz</h5>
                            <p>{{ ($solicitud->cliente->credito_automotriz)?'Si':'No' }}</p>
                        </div>

                        <div class="col-md-4">
                            <h5>Calificación de historial crediticio</h5>
                            <p>{{ $solicitud->cliente->historial_credito }}</p>
                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane active" id="trabajo" aria-expanded="false">
                        @if( $solicitud->cliente->persona_tipo == 'fisica')
                            <div>
                                <div class="col-md-4">
                                    <h5>Empresa</h5>
                                    <p>{{ $solicitud->cliente->nombre_empresa }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Puesto</h5>
                                    <p>{{ $solicitud->cliente->puesto }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Industria</h5>
                                    <p>{{ @$solicitud->cliente->giro_comercial->nombre }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>Salario mensual</h5>
                                    <p>${{ number_format($solicitud->cliente->salario_mensual,2) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Salario familiar total</h5>
                                    <p>${{ number_format($solicitud->cliente->salario_familiar,2) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Dependientes</h5>
                                    <p>{{ $solicitud->cliente->dependientes }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>Número de trabajo</h5>
                                    <p>{{ $solicitud->cliente->telefono_oficina }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Pago a través de banco</h5>
                                    <p>{{ ($solicitud->cliente->pago_banco)?'Si':'No'  }}</p>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        @else
                            <div>
                                <div class="col-md-4">
                                    <h5>Empresa</h5>
                                    <p>{{ $solicitud->cliente->nombre_empresa }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Industria</h5>
                                    <p>{{ @$solicitud->cliente->giro_comercial->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Número de empleados</h5>
                                    <p>{{ $solicitud->cliente->dependientes }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>RFC para facturar</h5>
                                    <p>{{ $solicitud->cliente->rfc_facturar }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Contraseña SAT (CIEC)</h5>
                                    <p>{{ @$solicitud->cliente->contrasenia_sat }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-12">
                                    <br><br>
                                    <h5 class="naranja">Dirección del Negocio</h5>
                                </div>

                                <div class="col-md-4">
                                    <h5>Calle</h5>
                                    <p>{{  @$solicitud->cliente->domicilio_empresa->calle }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Número exterior</h5>
                                    <p>{{ @$solicitud->cliente->domicilio_empresa->numero_ext }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Número interior</h5>
                                    <p>{{ @$solicitud->cliente->domicilio_empresa->numero_int }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <h5>Estado de nacimiento</h5>
                                    <p>{{ @$solicitud->cliente->domicilio_empresa->estado->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Municipio</h5>
                                    <p>{{ @$solicitud->cliente->domicilio_empresa->municipio->nombre }}</p>
                                </div>

                                <div class="col-md-4">
                                    <h5>Colonia</h5>
                                    <p>{{ @$solicitud->cliente->domicilio_empresa->colonia }}</p>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                <h5>Teléfono del negocio</h5>
                                <p>{{ $solicitud->cliente->telefono_oficina }}</p>
                            </div>
                            </div>
                        @endif
                    </div>

                    <div role="tabpanel" class="tab-pane" id="cotizacion" aria-expanded="false">

                        <div class="col-md-3">
                            <h5>Plan</h5>
                            <p>
                                {{ (!is_null($solicitud->plan_id))?$solicitud->plan->nombre:'Custom' }}
                            </p>
                        </div>

                        <div class="col-md-3">
                            <h5>Razon social</h5>
                            <p>
                                {{ (!is_null($solicitud->razon_social_id))?$solicitud->razon_social->razon_social:'Sin asignar' }}
                            </p>
                        </div>

                        <div class="col-md-3">
                            <h5>Merchant fee</h5>
                            <p>
                                {{ (!is_null($solicitud->plan_id))?$solicitud->plan->merchant_fee:'Sin asignar' }}%
                            </p>
                        </div>

                        <div class="col-md-3">
                            <h5>Comisión por apertura</h5>
                            <p>
                                {{ $solicitud->porcentaje_comision_por_apertura }}%
                            </p>
                        </div>

                        <div class="col-md-3">
                            <h5>Precio del sistema</h5>
                            <p>${{ number_format($solicitud->precio_sistema,2) }}</p>
                        </div>

                        <div class="col-md-3">
                            <h5>Enganche</h5>
                            <p>${{ number_format($solicitud->enganche,2) }}</p>
                        </div>

                        <div class="col-md-3">
                            <h5>Monto financiar</h5>
                            <p>${{ number_format($solicitud->monto_financiar,2) }}</p>
                        </div>

                        <div class="col-md-3">
                            <h5>Plazo a financiar</h5>
                            <p>{{ $solicitud->plazo_financiar }} meses</p>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <br><br>
                            <table class="table" id="tablePeriodos">
                                <thead>
                                <tr>
                                    <th>Pago No.</th>
                                    <th>Fecha de vencimiento</th>
                                    <th>Pago mensual a capital</th>
                                    <th>Pago mensual interés</th>
                                    <th>Pago mensual IVA interés</th>
                                    <th>Pago total mensual</th>
                                    <th>Precio opción compra</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($periodos as $k => $periodo)
                                        <tr>
                                            <td>{{ $k }}</td>
                                            <td>{{   \Carbon\Carbon::parse($periodo['fecha_pago'])->formatLocalized('%d de %B de %Y')    }}</td>
                                            <td style="text-align: right">${{ number_format($periodo['pago_mensual_a_capital'],2) }}</td>
                                            <td style="text-align: right">${{ number_format($periodo['pago_mensual_a_interes'],2) }}</td>
                                            <td style="text-align: right">${{ number_format($periodo['pago_mensual_IVA_interes'],2) }}</td>
                                            <td style="text-align: right">${{ number_format($periodo['subtotal'],2) }}</td>
                                            <td style="text-align: right">${{ number_format($periodo['precio_opcion_compra'],2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="pre_aprobacion" aria-expanded="false">
                        @php
                            $debt_to_income_pre_solar = 0;
                            $ahorros_mensuales_mensualidad = 0;
                            $debt_to_income_post_solar = 0;
                            $loan_to_value = 0;



                            $ingreso_mensual = $solicitud->cliente->salario_mensual;
                            if($tipo_cliente == 5){
                                #//moral
                                $ingreso_mensual = $solicitud->cliente->ingresos_anuales/ 12;
                            }

                            $ahorros_proyectados = $solicitud->ahorros_proyectados_mes / 2;
                            $loan_to_value = ($solicitud->monto_financiar / $solicitud->precio_sistema) * 100;


                            if($solicitud->deuda_mensual > 0 && $solicitud->fico > 0 && $ingreso_mensual > 0){
                                $debt_to_income_pre_solar = ($solicitud->deuda_mensual / $ingreso_mensual) * 100;
                                $ahorros_mensuales_mensualidad = ($ahorros_proyectados / $periodos[1]['subtotal']) * 100;

                                #// $debt_to_income_post_solar = (($solicitud->deuda_mensual + $periodos[1]['subtotal']) / ($ingreso_mensual + $solicitud->ahorros_proyectados_mes)) * 100;
                                $debt_to_income_post_solar = (($solicitud->deuda_mensual + $periodos[1]['subtotal'] - $ahorros_proyectados) / $ingreso_mensual) * 100;


                            }
                        @endphp

                        <div class="col-md-2 offset-10">
                            <button class="btn btn-rounded btn-outline btn-success waves-effect waves-light" data-target="#modal_fico" data-toggle="modal">Editar</button>
                        </div>

                        <div class="clearfix"></div>


                        <div class="col-md-4">
                            <di class="row">
                                <div class="col-md-12">
                                    <h3>Solicitante</h3>
                                    <h5>Deuda mensual:</h5>
                                    <p>${{ number_format($solicitud->deuda_mensual,2) }}</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Ingresos mensuales:</h5>
                                    @if( $tipo_cliente == 5)
                                        <p>${{ number_format( ($solicitud->cliente->ingresos_anuales/ 12) ,2) }}</p>
                                    @else
                                        <p>${{ number_format($solicitud->cliente->salario_mensual,2) }}</p>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <h5>FICO Score:</h5>
                                    <p>{{ $solicitud->fico }}</p>
                                </div>
                            </di>
                        </div>

                        {{--<div class="col-md-4">--}}
                            {{--<di class="row">--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<h3>Aval</h3>--}}
                                {{--</div>--}}
                            {{--</di>--}}
                        {{--</div>--}}

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Métricas</h3>
                                    <h5>Debt-to-Income pre-solar:</h5>
                                    <p>{{ number_format($debt_to_income_pre_solar,2) }} %</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Ahorros mensuales >	Mensualidad:</h5>
                                    <p>{{ number_format($ahorros_mensuales_mensualidad,2) }} %</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Debt-to-Income post-solar:</h5>
                                    <p>{{ number_format($debt_to_income_post_solar,2) }} %</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Loan-to-Value:</h5>
                                    <p>{{ number_format($loan_to_value,2) }} %</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Ahorros	 proyectados:</h5>
                                    <p>${{ number_format($ahorros_proyectados,2) }}</p>
                                </div>

                                <div class="col-md-12">
                                    <h5>Mensualidad:</h5>
                                    <p>${{ number_format($periodos[1]['subtotal'],2) }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modal_autorizar" aria-labelledby="" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/solicitudes/estatus" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="lbl_msj_estatus">Cambio de estatus de solicitud</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                            @if( $solicitud->estatus_id == 1)
                                <p>¿Seguro de cambiar el estatus de la solicitud a "Pre Autorizada"?</p>
                                <input type="hidden" name="estatus_id" value="4">
                            @elseif($solicitud->estatus_id == 5)
                                <p>¿Seguro de cambiar el estatus de la solicitud a "Autorizada"?</p>
                                <input type="hidden" name="estatus_id" value="2">
                            @elseif($solicitud->estatus_id == 2)
                                <p>¿Seguro de cambiar el estatus de la solicitud a "Documentos de cierre firmados"?</p>
                                <input type="hidden" name="estatus_id" value="7">
                            @endif

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success pull-bottom">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modal_preautorizar_rechazar" aria-labelledby="" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/solicitudes/estatus" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="lbl_msj_estatus">Cambio de estatus de solicitud</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf

                            <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">

                            <p>¿Seguro de cambiar el estatus de la solicitud?</p>
                            <select name="estatus_id" class="form-control">
                                <option value="4">Pre-autorizar</option>
                                <option value="3">Rechazar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success pull-bottom">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modal_fico" aria-labelledby="" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/solicitudes/fico_deuda" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="lbl_msj_estatus">FICO y deuda mensual</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-12">
                                <label for="">Deuda mensual</label>
                                <input type="hidden" value="{{ $solicitud->id }}" name="solicitud_id">
                                <input type="text" class="form-control" name="deuda_mensual" value="{{ $solicitud->deuda_mensual }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="">FICO Score</label>
                                <input type="text" class="form-control" name="fico" value="{{ $solicitud->fico}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success pull-bottom">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop