@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/integrador/cotizaciones" class="btn btn-default2 btn-rounded">Cotizaciones</a>
            <h4 class="page-title d-inline ml-3">Preautorizar</h4>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-3">
            <p>$Prestamo</p>
            ${{ number_format($detalle->monto_financiar,2) }}
        </div>

        <div class="col-md-3">
            <p>$Mensualidad</p>
            ${{ number_format($detalle->mensualidad,2) }}
        </div>
    </div>

    
    {!! Form::open(['method' => 'POST','url'=>route('integrador.preautorizar',$detalle->id),'autocomplete'=>'false','files'=>true,"data-toggle"=>"validator","id"=>"form"]) !!}
        
        <div class="row">
            <div class="col-md-12">
                <br>
                <h2>Aplicante</h2>
                <div class="row">
                    <div class="col-md-4">
                        <p>Tipo de solicitante</p>
                        <input type="hidden" name="detalle_id" value="{{ $detalle->id }}">
                        <input type="hidden" name="aplicante[id]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->id:'' }}">
                        {{ Form::select('persona_tipo',['fisica'=>'Fisica','moral'=>'Moral'], (isset($cotizacion->aplicante))?$cotizacion->aplicante->persona_tipo:'' ,['name'=>'aplicante[persona_tipo]','class'=>'input_underline form-control estados','data-target'=>'#municipios_aplicante']) }}
                        {{-- <input placeholder="{{ __('Tipo de solicitante') }}" type="text" class="input_underline form-control" name="aplicante[persona_tipo]"> --}}
                    </div>

                    <div class="col-md-4">
                        <p>Ingresos Mensuales</p>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">$</span>                                
                            <input name="aplicante[salario_mensual]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->salario_mensual:'' }}" placeholder="{{ __('Ingresos Mensuales') }}" type="text" class="input_underline form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p>Nombre(s)</p>
                        <input name="aplicante[nombre]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->nombre:'' }}" placeholder="{{ __('Nombre') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-4">
                        <p>Apellido Paterno</p>
                        <input name="aplicante[apellido_paterno]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->apellido_paterno:'' }}" placeholder="{{ __('Apellido Paterno') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-4">
                        <p>Apellido Materno</p>
                        <input name="aplicante[apellido_materno]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->apellido_materno:'' }}" placeholder="{{ __('Apellido Materno') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-4">
                        <p>Email</p>
                        <input name="aplicante[correo]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->correo:'' }}" placeholder="{{ __('Email') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-4">
                        <p>Cel</p>
                        <input name="aplicante[telefono_movil]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->telefono_movil:'' }}" placeholder="{{ __('Cel') }}" type="text" class="input_underline form-control" required>
                    </div>

                    {{-- <div class="col-md-4">
                        <p>Fecha Nacimiento</p>
                        <input name="aplicante[fecha_nacimiento]" placeholder="{{ __('Fecha Nacimiento') }}" type="text" class="input_underline form-control">
                    </div> --}}

                    <div class="col-md-4">
                        <p>Fecha Nacimiento</p>
                        <div class="row">
                            <div class="col-md-3">
                                <select id="f_dia" class="form-control input_underline" name="aplicante[fecha_nacimiento_dia]" required>
                                    @php
                                        $dia = "";
                                        if ( isset($cotizacion->aplicante) ){
                                            $dia = date('d',strtotime($cotizacion->aplicante->fecha_nacimiento));
                                        }
                                    @endphp
                                    <option value="">Día</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ ($dia == $i) ?'selected':''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="f_mes" class="form-control input_underline" name="aplicante[fecha_nacimiento_mes]" required>
                                    @php
                                        $mes = "";
                                        if ( isset($cotizacion->aplicante) ){
                                            $mes = date('m',strtotime($cotizacion->aplicante->fecha_nacimiento));
                                        }
                                    @endphp
                                    <option value="">Mes</option>
                                    @foreach($meses as $k => $v)
                                        <option value="{{ $k }}" {{ ($k == $mes) ?'selected':''}}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="f_anio" class="form-control input_underline" name="aplicante[fecha_nacimiento_anio]" required>
                                    @php
                                        $anio  = "";
                                        if ( isset($cotizacion->aplicante) ){
                                            $anio = date('Y',strtotime($cotizacion->aplicante->fecha_nacimiento));
                                        }
                                    @endphp
                                    <option value="">Año</option>
                                    @for ($i = (date('Y') - 90); $i <= (date('Y') - 17); $i++)
                                        <option value="{{ $i }}" {{ ($anio == $i) ?'selected':''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p>RFC</p>
                        <input name="aplicante[rfc]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->rfc:'' }}" placeholder="{{ __('RFC') }}" type="text" class="input_underline form-control" maxlength="13">
                    </div>

                    <div class="col-md-4">
                        <p>CURP</p>
                        <input name="aplicante[curp]" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->curp:'' }}" placeholder="{{ __('CURP') }}" type="text" class="input_underline form-control" maxlength="18">
                    </div>

                    <div class="col-md-4 divGenero">
                        <p>Género</p>
                        <button class="btn btn-success btnGenero" data-value="Masculino" data-target="#aplicante_genero">Masculino</button>
                        <button class="btn btn-default btn-outline btnGenero" data-value="Femenino" data-target="#aplicante_genero">Femenino</button>
                        <input type="hidden" id="aplicante_genero" value="{{ (isset($cotizacion->aplicante))?$cotizacion->aplicante->sexo:'masculino' }}"  name="aplicante[genero]">
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <br>
                        <b>Residencia</b>
                    </div>
                    <div class="col-md-4">
                        <p>Calle</p>
                        <input type="hidden" name="aplicante[domicilio][id]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->id:'' }}">
                        <input name="aplicante[domicilio][calle]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->calle:'' }}" placeholder="{{ __('Calle') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-2">
                        <p># ext</p>
                        <input name="aplicante[domicilio][numero_ext]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->numero_ext:'' }}" placeholder="{{ __('# ext') }}" type="text" class="input_underline form-control" required>
                    </div>

                    <div class="col-md-2">
                        <p># int</p>
                        <input name="aplicante[domicilio][numero_int]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->numero_int:'' }}" placeholder="{{ __('# int') }}" type="text" class="input_underline form-control">
                    </div>

                    <div class="col-md-4">
                        <p>Colonia</p>
                        <input name="aplicante[domicilio][colonia]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->colonia:'' }}" placeholder="{{ __('Colonia') }}" type="text" class="input_underline form-control" required>
                    </div>
                    
                    <div class="col-md-4">
                        <p>Estado</p>
                        {{ Form::select('estados',$estados,(isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->estado_id:'',['name'=>'aplicante[domicilio][estado_id]', 'id'=>'aplicante_estados','class'=>'input_underline form-control estados','data-target'=>'#municipios_aplicante']) }}
                    </div>
                    
                    <div class="col-md-4">
                        <p>Municipio</p>
                        {{ Form::select('municipios',[],null,['name'=>'aplicante[domicilio][municipio_id]','class'=>'input_underline form-control','id'=>'municipios_aplicante']) }}
                    </div>

                    <div class="col-md-4">
                        <p>Ciudad</p>
                        <input name="aplicante[domicilio][ciudad]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->ciudad:'' }}" placeholder="{{ __('Ciudad') }}" type="text" class="input_underline form-control">
                    </div>

                    

                    <div class="col-md-4">
                        <p>CP</p>
                        <input name="aplicante[domicilio][cp]" value="{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->cp:'' }}" placeholder="{{ __('CP') }}" type="text" class="input_underline form-control" maxlength="5" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <br>
                    <b>Documentos</b>
                </div>
                <div class="col-md-4">
                    <p>
                        Foto INE (frente)
                        @if (!empty($detalle->cotizacion->aplicante->ine_file))
                            <a class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'aplicante','ine']) }}">(Descargar)</a>
                        @endif
                    </p>
                    <input name="aplicante[ine]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M" required />
                </div>

                <div class="col-md-4">
                    <p>
                        Foto INE (atras)
                        @if (!empty($detalle->cotizacion->aplicante->ine_atras_file))
                            <a class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'aplicante','ine_atras']) }}">(Descargar)</a>
                        @endif
                    </p>
                    <input name="aplicante[ine_atras]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M" required />
                </div>

                <div class="col-md-4">
                    <p>
                        Foto hoja buro
                        @if (!empty($detalle->cotizacion->aplicante->hoja_buro_file))
                            <a  class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'aplicante','hoja_buro']) }}">(Descargar)</a>
                        @endif
                    </p>
                    <input name="aplicante[hoja_buro]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M" required/>
                </div>

                <div class="col-md-4">
                    <p>
                        Foto cliente buro
                        @if (!empty($detalle->cotizacion->aplicante->foto_buro_file))
                            <a  class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'aplicante','foto_buro_file']) }}">(Descargar)</a>
                        @endif
                    </p>
                    <input name="aplicante[foto_buro_file]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br>
                <h2>
                    Co-Aplicante
                    <input type="checkbox" name="aplica_coaplicante"  id="coaplicante" class="bootstrapSwitch" data-on-color="success" data-on-text="SI" data-off-text="NO" value="1" {{ (isset($cotizacion->requiere_coaplicante) && $cotizacion->requiere_coaplicante)?'checked':'' }}>
                </h2>
            </div>
        </div>
        
        
        <div class="row" id="divCoaplicante" style="display:none">
            <div class="col-md-4">
                <p>Ingresos Mensuales</p>
                <input type="hidden" name="coaplicante[id]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->id:'' }}">
                <input name="coaplicante[salario_mensual]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->salario_mensual :'' }}" placeholder="{{ __('Ingresos Mensuales') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-4">
                <p>Nombre(s)</p>
                <input name="coaplicante[nombre]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->nombre :'' }}" placeholder="{{ __('Nombre') }}" type="text" class="input_underline form-control" required>
            </div>

            <div class="col-md-4">
                <p>Apellido Paterno</p>
                <input name="coaplicante[apellido_paterno]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->apellido_paterno :'' }}" placeholder="{{ __('Apellido Paterno') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-4">
                <p>Apellido Materno</p>
                <input name="coaplicante[apellido_materno]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->apellido_materno :'' }}" placeholder="{{ __('Apellido Materno') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-4">
                <p>Email</p>
                <input name="coaplicante[correo]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->email :'' }}" placeholder="{{ __('Email') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-4">
                <p>Cel</p>
                <input name="coaplicante[telefono_movil]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->telefono_movil :'' }}" placeholder="{{ __('Cel') }}" type="text" class="input_underline form-control">
            </div>      

            <div class="col-md-4">
                    <p>Fecha Nacimiento</p>
                    <div class="row">
                        <div class="col-md-3">
                            <select id="f_dia" class="form-control input_underline" name="coaplicante[fecha_nacimiento_dia]" required>
                                @php
                                    $dia = "";
                                    if ( isset($cotizacion->aplicante->obligado_solidario)){
                                        $dia = date('d',strtotime($cotizacion->aplicante->obligado_solidario->fecha_nacimiento));
                                    }
                                @endphp
                                <option value="">Día</option>
                                @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ ($dia == $i) ?'selected':''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select id="f_mes" class="form-control input_underline" name="coaplicante[fecha_nacimiento_mes]" required>
                                @php
                                    $mes = "";
                                    if ( isset($cotizacion->aplicante->obligado_solidario)){
                                        $mes = date('m',strtotime($cotizacion->aplicante->obligado_solidario->fecha_nacimiento));
                                    }
                                @endphp
                                <option value="">Mes</option>
                                @foreach($meses as $k => $v)
                                    <option value="{{ $k }}" {{ ($k == $mes) ?'selected':''}}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="f_anio" class="form-control input_underline" name="coaplicante[fecha_nacimiento_anio]" required>
                                @php
                                    $anio  = "";
                                    if ( isset($cotizacion->aplicante->obligado_solidario)){
                                        $anio = date('Y',strtotime($cotizacion->aplicante->obligado_solidario->fecha_nacimiento));
                                    }
                                @endphp
                                <option value="">Año</option>
                                @for ($i = (date('Y') - 90); $i <= (date('Y') - 17); $i++)
                                    <option value="{{ $i }}" {{ ($anio == $i) ?'selected':''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>


            <div class="col-md-4">
                <p>RFC</p>
                <input name="coaplicante[rfc]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?$cotizacion->aplicante->obligado_solidario->rfc:'' }}" placeholder="{{ __('RFC') }}" type="text" class="input_underline form-control" maxlength="13">
            </div>

            <div class="col-md-4">
                <p>CURP</p>
                <input name="coaplicante[curp]" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?$cotizacion->aplicante->obligado_solidario->curp:'' }}" placeholder="{{ __('CURP') }}" type="text" class="input_underline form-control" maxlength="18">
            </div>

            <div class="col-md-4 divGenero">                        
                <p>Género</p>
                <button class="btn btn-success btnGenero" data-value="Masculino" data-target="#coaplicante_genero">Masculino</button>
                <button class="btn btn-default btn-outline btnGenero" data-value="Femenino" data-target="#coaplicante_genero">Femenino</button>
                <input type="hidden" id="coaplicante_genero" value="{{ (isset($cotizacion->aplicante->obligado_solidario))?@$cotizacion->aplicante->obligado_solidario->sexo :'masculino' }}"  name="coaplicante[genero]">
                <br><br>
            </div>

            <div class="col-md-12">
                <br>
                <b>Residencia</b>
            </div>
            <div class="col-md-4">
                <p>Calle</p>
                <input type="hidden" name="coaplicante[domicilio][id]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->id:'' }}">
                <input name="coaplicante[domicilio][calle]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->calle :'' }}" placeholder="{{ __('Calle') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-2">
                <p># ext</p>
                <input name="coaplicante[domicilio][numero_ext]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->numero_ext :'' }}" placeholder="{{ __('# ext') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-2">
                <p># int</p>
                <input name="coaplicante[domicilio][numero_int]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->numero_int :'' }}" placeholder="{{ __('# int') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-4">
                <p>Colonia</p>
                <input name="coaplicante[domicilio][colonia]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->colonia :'' }}" placeholder="{{ __('Colonia') }}" type="text" class="input_underline form-control">
            </div>
            
            <div class="col-md-4">
                <p>Estado</p>
                {{ Form::select('estados',$estados,(isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->estado_id :'',['name'=>'coaplicante[domicilio][estado_id]', 'id'=>'coAplicante_estados','class'=>'input_underline form-control estados','data-target'=>'#municipios_coAplicante']) }}
            </div>
            
            <div class="col-md-4">
                <p>Municipio</p>
                {{ Form::select('municipios',[],null,['name'=>'coaplicante[domicilio][municipio_id]','class'=>'input_underline form-control','id'=>'municipios_coAplicante']) }}
            </div>

            <div class="col-md-4">
                <p>Ciudad</p>
                <input name="coaplicante[domicilio][ciudad]" value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->ciudad :'' }}"  placeholder="{{ __('Ciudad') }}" type="text" class="input_underline form-control">
            </div>

            

            <div class="col-md-4">
                <p>CP</p>
                <input name="coaplicante[domicilio][cp]"  value="{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->cp :'' }}" placeholder="{{ __('CP') }}" type="text" class="input_underline form-control">
            </div>

            <div class="col-md-12">
                <br>
                <b>Documentos</b>
            </div>
            <div class="col-md-4">
                <p>
                    Foto INE (frente)
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->ine_file))
                        <a class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'co_aplicante','ine']) }}">(Descargar)</a>
                    @endif
                </p>
                <input name="coaplicante[ine]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M"/>
            </div>

            <div class="col-md-4">
                <p>
                    Foto INE (atras)
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->ine_atras_file))
                        <a class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'co_aplicante','ine_atras_file']) }}">(Descargar)</a>
                    @endif
                </p>
                <input name="coaplicante[ine_atras]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M"/>
            </div>

            <div class="col-md-4">
                <p>
                    Foto hoja buro
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->hoja_buro_file))
                        <a  class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'co_aplicante','hoja_buro']) }}">(Descargar)</a>
                    @endif
                </p>
                <input name="coaplicante[hoja_buro]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M"/>
            </div>

            <div class="col-md-4">
                <p>
                    Foto cliente buro
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->foto_buro_file))
                        <a  class="pull-right" href="{{ route('integrador.attach_file_dotizacion',[$detalle->id, 'co_aplicante','foto_buro_file']) }}">(Descargar)</a>
                    @endif
                </p>
                <input name="coaplicante[foto_buro_file]" type="file" class="dropify" data-show-remove="false" data-max-file-size="5M"/>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <br>
                <button class="btn btn-success">Aceptar</button>
            </div>
        </div>
    {!! Form::close() !!}



@endsection


@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(function(){
            
            $(".bootstrapSwitch").bootstrapSwitch();
            $('#coaplicante').on('switchChange.bootstrapSwitch', function(event, state) {
                checkCoaplicante()
 
            })
            
            $('.dropify').dropify({
                error:{
                    'fileSize': 'El peso del archivo no puede ser mayor a 5MB.'
                },
                tpl: {
                    errorLine:'<p class="dropify-error"></p>',
                    message:'<div class="dropify-message"><span class="file-icon" /> <p>Arrasta aquí el archivo o da click para cargarlo.</p></div>',

                }
            });

            getMunicipios($('#aplicante_estados'),$('#municipios_aplicante'),{{ (isset($cotizacion->aplicante->domicilio))?$cotizacion->aplicante->domicilio->municipio_id:'null' }});
            getMunicipios($('#coAplicante_estados'),$('#municipios_coAplicante'),{{ (isset($cotizacion->aplicante->obligado_solidario->domicilio))?@$cotizacion->aplicante->obligado_solidario->domicilio->municipio_id :'null'}});
            $('.estados').change(function(){
                var target = $(this).data('target');
                console.log(target);
                var selector = $(target);
                getMunicipios($(this),selector,null);
            });

            setSexo();
            $('.btnGenero').click(function(e){
                e.preventDefault();
                var target = $(this).data('target');
                var div_parent = $(this).parent();
                div_parent.find('.btnGenero').removeClass('btn-success').addClass('btn-default').addClass('btn-outline');
                $(this).addClass('btn-success').removeClass('btn-outline');
                $(target).val( $(this).data('value') );
            })
            checkCoaplicante()
        })

        function getMunicipios(parent,selector, set_selected){
            var estado_id = parent.val();            
            $.get('/estados/getMunicipios/'+estado_id,function(data){
                selector.html('');
                $.each(data,function(k,v){
                    var selected = "";
                    if( set_selected == k){ selected = 'selected'; }
                    var option = '<option value="'+ k +'" '+ selected +'  >'+ v +'</option>';
                    selector.append(option);
                })
            })
        }


        function setSexo(){
            var sexo = '';
            if(sexo != ''){
                $('.btnGenero').removeClass('btn-success').addClass('btn-default').addClass('btn-outline');
                $('.btnGenero[data-value="'+ sexo +'"]').addClass('btn-success').removeClass('btn-outline');
                $('#genero').val( sexo);
            }
        }

        function checkCoaplicante(){
            var check = $('#coaplicante').is(':checked');
            if(check)  
                $('#divCoaplicante').show();
              else
                $('#divCoaplicante').hide();

            //Agregar los inputs de los archivos
            //Falta quitar los que no van a ser requeridos
            if(check){
                $('input[name="coaplicante[nombre]"]').attr('required',true)
                $('select[name="coaplicante[fecha_nacimiento_dia]"]').attr('required',true)
                $('select[name="coaplicante[fecha_nacimiento_mes]"]').attr('required',true)
                $('select[name="coaplicante[fecha_nacimiento_anio]"]').attr('required',true)

                $('input[name="coaplicante[ine]"]').attr('required',true)
                $('input[name="coaplicante[hoja_buro]"]').attr('required',true)

                $('#divCoaplicante').find('input[type="text"]').attr('required',true)

                //quitar los que no van a ser requeridos
                $('input[name="coaplicante[rfc]"]').attr('required',false)
                $('input[name="coaplicante[domicilio][numero_int]"]').attr('required',false)

            }
            else{
                $('#divCoaplicante').attr('required',false)
                $('select[name="coaplicante[fecha_nacimiento_dia]"]').attr('required',false)
                $('select[name="coaplicante[fecha_nacimiento_mes]"]').attr('required',false)
                $('select[name="coaplicante[fecha_nacimiento_anio]"]').attr('required',false)
                $('input[name="coaplicante[ine]"]').attr('required',false)
                $('input[name="coaplicante[hoja_buro]"]').attr('required',false)

                $('#divCoaplicante').find('input[type="text"]').attr('required',false)
            }
        }
    </script>
@endsection