@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-10">
            <a href="/admin/solicitudes/{{ $solicitud->id }}" class="btn btn-default2 btn-rounded">Solicitud</a>
            <h4 class="page-title d-inline">Editar.</h4>
        </div>
    </div>
@endsection


@section('content')
    <form action="/admin/solicitud/edit/{{ $solicitud->id }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h3>Datos del cliente</h3>
            </div>

            <div class="col-md-4">
                <p>Nombre</p>
                <input type="hidden" value="{{ $solicitud->cliente->persona_tipo }}" name="cliente_tipo_persona">
                <input type="text" class="input_underline form-control" name="cliente_nombre" value="{{ $solicitud->cliente->nombre }}" required>
            </div>

            <div class="col-md-4">
                <p>Apellido paterno</p>
                <input type="text" class="input_underline form-control" name="cliente_apellido_paterno" value="{{ $solicitud->cliente->apellido_paterno }}" required>
            </div>

            <div class="col-md-4">
                <p>Apellido materno</p>
                <input type="text" class="input_underline form-control" name="cliente_apellido_materno" value="{{ $solicitud->cliente->apellido_materno }}" required>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-4">
                <p>CURP</p>
                <input type="text" class="input_underline form-control" name="cliente_curp" value="{{ $solicitud->cliente->curp }}" required>
            </div>

            <div class="col-md-4">
                <p>RFC</p>
                <input type="text" class="input_underline form-control" name="cliente_rfc" value="{{ $solicitud->cliente->rfc }}" required>
            </div>

            <div class="col-md-4">
                <p>¿Es dueño de la casa?</p>
                <input type="checkbox" id="dueno_casa" class="bootstrapSwitch" data-on-color="success" name="cliente_dueno_casa"
                       data-on-text="SI" data-off-text="NO" value="1"  {{ ($solicitud->cliente->dueno_casa)?'checked':'' }}
                >
            </div>
        </div>

        @if($tipo_cliente == 5)
            <div class="row">
                <div class="col-md-12">
                    <h3>Datos de la empresa</h3>
                </div>

                <div class="col-md-4">
                    <p>Razón social</p>
                    <input type="text" class="input_underline form-control" name="nombre_empresa" value="{{ $solicitud->cliente->nombre_empresa }}" required>
                </div>


                <div class="col-md-4">
                    <p>Calle</p>
                    <input type="hidden" name="empresa_domicilio_id" value="{{ @$solicitud->cliente->domicilio_empresa->id }}">
                    <input name="empresa_domicilio_calle"
                           placeholder="{{ __('Calle') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->domicilio_empresa->calle }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Número exterior</p>
                    <input name="empresa_domicilio_num_ext"
                           placeholder="{{ __('Número exterior') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->domicilio_empresa->numero_ext }}"
                    >
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <p>Número interior (opcional)</p>
                    <input name="empresa_domicilio_numero_int"
                           placeholder="{{ __('Número interior') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->domicilio_empresa->numero_int }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Colonia</p>
                    <input name="empresa_domicilio_colonia"
                           placeholder="{{ __('Colonia') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->domicilio_empresa->colonia }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Estado</p>
                    <select name="empresa_domicilio_estado_id" id="empresa_domicilio_estado" class="form-control input_underline">
                        @foreach($estados as $k => $v)
                            <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio_empresa->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <p>Municipio / Delegación </p>
                    <select name="empresa_domicilio_municipio_id" id="empresa_domicilio_municipio" class="form-control input_underline">
                    </select>
                </div>

                <div class="col-md-4">
                    <p>Código Postal</p>
                    <input name="empresa_domicilio_cp"
                           placeholder="{{ __('Código Postal') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->domicilio_empresa->cp }}"
                           maxlength="6"
                    >
                </div>


            </div>
        @endif

        <br>
        <div class="row">
            <div class="col-md-12">
                <h3>Historial crediticio</h3>
            </div>
            <div class="col-md">
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        <input id="radio1" name="cliente_historial_credito" type="radio" class="custom-control-input historial_credito" value="No tengo historial" {{ ($solicitud->cliente->historial_credito == "No tengo historial")?"checked":"" }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">No tengo historial</span>
                    </label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        <input id="radio1" name="cliente_historial_credito" type="radio" class="custom-control-input historial_credito" value="No se" {{ ($solicitud->cliente->historial_credito == "No se")?"checked":"" }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">No se</span>
                    </label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        <input id="radio1" name="cliente_historial_credito" type="radio" class="custom-control-input historial_credito" value="Malo" {{ ($solicitud->cliente->historial_credito == "Malo")?"checked":"" }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Malo</span>
                    </label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        <input id="radio1" name="cliente_historial_credito" type="radio" class="custom-control-input historial_credito" value="Regular" {{ ($solicitud->cliente->historial_credito == "Regular")?"checked":"" }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Regular</span>
                    </label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-check">
                    <label class="custom-control custom-radio">
                        <input id="radio1" name="cliente_historial_credito" type="radio" class="custom-control-input historial_credito" value="Bueno" {{ ($solicitud->cliente->historial_credito == "Bueno")?"checked":"" }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Bueno</span>
                    </label>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <hr>
                <h3>Domicilio del cliente</h3>
            </div>

            <div class="col-md-4">
                <p>Calle</p>
                <input type="hidden" name="domicilio_id" value="{{ @$solicitud->cliente->domicilio->id }}">
                <input name="domicilio_calle"
                       placeholder="{{ __('Calle') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ @$solicitud->cliente->domicilio->calle }}"
                >
            </div>

            <div class="col-md-4">
                <p>Número exterior</p>
                <input name="domicilio_num_ext"
                       placeholder="{{ __('Número exterior') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ @$solicitud->cliente->domicilio->numero_ext }}"
                >
            </div>

            <div class="col-md-4">
                <p>Número interior (opcional)</p>
                <input name="domicilio_numero_int"
                       placeholder="{{ __('Número interior') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ @$solicitud->cliente->domicilio->numero_int }}"
                >
            </div>

            <div class="clearfix"></div>

            <div class="col-md-4">
                <p>Colonia</p>
                <input name="domicilio_colonia"
                       placeholder="{{ __('Colonia') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ @$solicitud->cliente->domicilio->colonia }}"
                >
            </div>

            <div class="col-md-4">
                <p>Estado</p>
                <select name="domicilio_estado_id" id="domicilio_estado" class="form-control input_underline">
                    @foreach($estados as $k => $v)
                        <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <p>Municipio / Delegación </p>
                <select name="domicilio_municipio_id" id="domicilio_municipio" class="form-control input_underline">
                </select>
            </div>

            <div class="col-md-4">
                <p>Código Postal</p>
                <input name="domicilio_cp"
                       placeholder="{{ __('Código Postal') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ @$solicitud->cliente->domicilio->cp }}"
                       maxlength="6"
                >
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <hr>
                <h3>Datos de la solicitud</h3>
            </div>

            <div class="col-md-3">
                <label for="">Razón Social</label><br>
                {!! Form::select('razon_social_id',$razones_sociales,$solicitud->razon_social_id,['class'=>'input_underline form-control','placeholder'=>'Sin asignar','id'=>'razon_social_id','required'=>true]) !!}
                <br>
            </div>
            <div class="col-md-9"></div>


            <div class="col-md-3">
                <label for="">Plan</label><br>
                {!! Form::select('plan_id',$planes_list,$solicitud->plan_id,['class'=>'input_underline form-control','placeholder'=>'Plan personalizado','id'=>'plan_id']) !!}
            </div>

            <div class="col-md-3">
                <p>¿Cuál es el precio del sistema solar FV?</p>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">$</span>
                    <input id="solicitud_precio_sistema"
                           placeholder="{{ __('$') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ $solicitud->precio_sistema }}"
                           name="precio_sistema"
                    >

                    <input type="hidden" name="id" value="{{ $solicitud->id }}">
                </div>
            </div>



            <div class="col-md-3">
                <p>Primer fecha de vencimiento</p>
                <input name="solicitud_primer_fecha_vencimiento"
                       id="solicitud_primer_fecha_vencimiento"
                       placeholder="{{ __('Primer fecha de vencimiento') }}"
                       type="text"
                       readonly="readonly"
                       class="input_underline form-control"
                       value="{{ $solicitud->primer_fecha_vencimiento }}"
                >
            </div>

            <div class="col-md-3">
                <p>Primer mensualidad</p>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">$</span>
                    <input id=""
                           placeholder="{{ __('$') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ number_format($periodos[1]['subtotal'],2) }}"
                           name=""
                           readonly
                    >
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-8">
                <p >Selecciona el monto del enganche</p>
                <input id="enganche" name="enganche">
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <p >Selecciona el plazo a financiar del sistema</p>
                <input  id="rango_meses" >
                <input  id="rango_meses_value" type="hidden" name="plazo_financiar" value="{{ $solicitud->plazo_financiar }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <label for="">Descripción de los bienes</label>
                <textarea id="" cols="30" rows="10" class="form-control" name="descripcion_de_bienes">{{ @$solicitud->descripcion_de_bienes }}</textarea>
            </div>
        </div>

        <div class="div_obligado">
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <h3>Obligado Solidario</h3>
                </div>
                <!-- Obligado Solidario-->
                <div class="col-md-4">
                    <p>Nombre</p>
                    <input type="text" class="input_underline form-control" name="obligado_solidario_nombre" value="{{ @$solicitud->cliente->obligado_solidario->nombre }}" >
                </div>

                <div class="col-md-4">
                    <p>Apellido paterno</p>
                    <input type="text" class="input_underline form-control" name="obligado_solidario_apellido_paterno" value="{{ @$solicitud->cliente->obligado_solidario->apellido_paterno }}" >
                </div>

                <div class="col-md-4">
                    <p>Apellido materno</p>
                    <input type="text" class="input_underline form-control" name="obligado_solidario_apellido_materno" value="{{ @$solicitud->cliente->obligado_solidario->apellido_materno }}" >
                </div>

                <!-- fecha nacimiento-->
                <div class="col-md-2">
                    <p>Fecha de nacimiento</p>
                    <select id="f_dia" class="form-control input_underline" name="obligado_solidario_dia">
                        @php
                            $dia = "";
                            if ( !is_null(@$solicitud->cliente->obligado_solidario->fecha_nacimiento)){
                                $dia = date('d',strtotime(@$solicitud->cliente->obligado_solidario->fecha_nacimiento));
                            }
                        @endphp
                        <option value="">Día</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ ($dia == $i) ?'selected':''}}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1">

                    <select id="f_mes" class="form-control input_underline" style="margin-top:32px" name="obligado_solidario_mes">
                        @php
                            $mes = "";
                            if ( !is_null(@$solicitud->cliente->obligado_solidario->fecha_nacimiento)){
                                $mes = date('m',strtotime(@$solicitud->cliente->obligado_solidario->fecha_nacimiento));
                            }
                        @endphp
                        <option value="">Mes</option>
                        @foreach($meses as $k => $v)
                            <option value="{{ $k }}" {{ ($k == $mes) ?'selected':''}}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <br>
                    <select class="form-control input_underline" style="margin-top:12px" name="obligado_solidario_anio">
                        @php
                            $anio  = "";
                            if ( !is_null(@$solicitud->cliente->obligado_solidario->fecha_nacimiento)){
                                $anio = date('Y',strtotime(@$solicitud->cliente->obligado_solidario->fecha_nacimiento));
                            }
                        @endphp
                        <option value="">Año</option>
                        @for ($i = (date('Y') - 90); $i <= (date('Y') - 17); $i++)
                            <option value="{{ $i }}" {{ ($anio == $i) ?'selected':''}}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-4">
                    <p>Estado de nacimiento</p>
                    <select name="obligado_solidario_estado_id" id="obligado_solidario_estado_id" class="form-control input_underline">
                        @foreach($estados as $k => $v)
                            <option value="{{ $k }}" {{ ( @$solicitud->cliente->obligado_solidario->estado_nacimiento_id == $k)?'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <p>Género</p>
                    <select name="obligado_solidario_sexo" id="obligado_solidario_sexo" class="form-control input_underline">
                        <option value="Masculino" {{ ( @$solicitud->cliente->obligado_solidario->sexo == 'Masculino'?'selected':'' ) }}>Masculino</option>
                        <option value="Femenino" {{ ( @$solicitud->cliente->obligado_solidario->sexo == 'Femenino'?'selected':'' ) }}>Femenino</option>
                    </select>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <p>CURP</p>
                    <input type="text" class="input_underline form-control" name="obligado_solidario_curp" value="{{ @$solicitud->cliente->obligado_solidario->curp }}">
                </div>

                <div class="col-md-4">
                    <p>RFC</p>
                    <input type="text" class="input_underline form-control" name="obligado_solidario_rfc" value="{{ @$solicitud->cliente->obligado_solidario->rfc }}">
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <h3>Domicilio del obligado solidario</h3>
                </div>

                <div class="col-md-4">
                    <p>Calle</p>
                    <input name="obligado_calle"
                           placeholder="{{ __('Calle') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->obligado_solidario->domicilio->calle }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Número exterior</p>
                    <input name="obligado_num_ext"
                           placeholder="{{ __('Número exterior') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->obligado_solidario->domicilio->numero_ext }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Número interior (opcional)</p>
                    <input name="obligado_numero_int"
                           placeholder="{{ __('Número interior') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->obligado_solidario->domicilio->numero_int }}"
                    >
                </div>


                <div class="clearfix"></div>

                <div class="col-md-4">
                    <p>Colonia</p>
                    <input name="obligado_colonia"
                           placeholder="{{ __('Colonia') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->obligado_solidario->domicilio->colonia }}"
                    >
                </div>

                <div class="col-md-4">
                    <p>Estado</p>
                    <select name="obligado_estado_id" id="obligado_estado_id" class="form-control input_underline">
                        @foreach($estados as $k => $v)
                            <option value="{{ $k }}" {{ ( @$solicitud->cliente->obligado_solidario->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-4">
                    <p>Municipio / Delegación </p>
                    <select name="obligado_municipio_id" id="obligado_domicilio_municipio" class="form-control input_underline">
                    </select>
                </div>

                <div class="col-md-4">
                    <p>Código Postal</p>
                    <input name="obligado_cp"
                           placeholder="{{ __('Código Postal') }}"
                           type="text"
                           class="input_underline form-control"
                           value="{{ @$solicitud->cliente->obligado_solidario->domicilio->cp }}"
                           maxlength="6"
                    >
                </div>
            </div>
        </div>


        {{--@if($tipo_cliente == 3 || $tipo_cliente == 4 || $tipo_cliente == 5)--}}
            <div class="row div_rentero">
                <div class="col-md-12">
                    <hr>
                    <h3>Rentero</h3>
                </div>
                <!-- Obligado Solidario-->
                <div class="col-md-4">
                    <p>Nombre</p>
                    <input type="text" class="input_underline form-control" name="rentero_nombre" value="{{ $solicitud->cliente->rentero_nombre }}" >
                </div>

                <div class="col-md-4">
                    <p>Folio predial</p>
                    <input type="text" class="input_underline form-control" name="rentero_folio_predial" value="{{ $solicitud->cliente->rentero_folio_predial }}" >
                </div>
            </div>
        {{--@endif--}}


        <div class="row">
            <div class="col-md-6">
                <br><br>
                <button type="submit" class="btn btn-success" id="btnGetPerdiodos">Guardar</button>
                <a href="/admin/solicitudes/{{ $solicitud->id }}" class="btn btn-default waves-effect">Cancelar</a>
            </div>
        </div>
    </form>

@endsection


@section('extra-js')


    <script src="{{ asset('assets/plugins/bower_components/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>

<script>
    var tipo_persona = '{{ $solicitud->cliente->persona_tipo }}';
    var planes = {!! $planes !!};
    var plazo_original = {{ ($solicitud->plazo_financiar > 0)?$solicitud->plazo_financiar:0 }};
    $(function(){

        $(".bootstrapSwitch").bootstrapSwitch();

        showObligado(tipo_persona);
        $('input[name="cliente_historial_credito"]').change(function(){
            showObligado(tipo_persona);
        });

        showRentero()
        $('#dueno_casa').on('switchChange.bootstrapSwitch', function(event, state) {
            showRentero()
        })



        $('#solicitud_primer_fecha_vencimiento').datepicker({
            format:'yyyy-mm-dd',
            startDate: new Date(),
            beforeShowDay:function(date){
                if (date.getDate() <= 28) {
                    return true;
                }
                return false;
            }
        });

        $("#enganche").ionRangeSlider({
            min: 0,
            max: {{ $maxEnganche }},
            from: {{ $solicitud->enganche }},
            prefix: "$",
            grid: true,
            step:1000,
            onFinish:function(data){

            }
        });

        $("#rango_meses").ionRangeSlider({
            min: 0,
            max: 120,
            from: {{ $solicitud->plazo_financiar }},
            grid: true,
            step:3,
            postfix:' meses',
            onFinish:function(data){
                $('#rango_meses_value').val(data.from);
            }
        });

        $('#solicitud_precio_sistema').keyup(function(e){
            e.preventDefault();
            setEnganche();
        })


        $('#btnGetPerdiodos').click(function(){
        })

        var municipio_id = {{ ( @$solicitud->cliente->domicilio->municipio_id > 0)?@$solicitud->cliente->domicilio->municipio_id:0 }};
        getMunicipios($('#domicilio_estado'),municipio_id,$('#domicilio_municipio'));

        $('#domicilio_estado').change(function(){
            getMunicipios($(this),municipio_id,$('#domicilio_municipio'));
        });

        var obligado_municipio_id = {{ ( @$solicitud->cliente->obligado_solidario->domicilio->municipio_id > 0)?@$solicitud->cliente->obligado_solidario->domicilio->municipio_id:0 }};
        getMunicipios($('#obligado_estado_id'),obligado_municipio_id,$('#obligado_domicilio_municipio'));

        $('#obligado_estado_id').change(function(){
            getMunicipios($(this),"0",$('#obligado_domicilio_municipio'));
        })


        @if($solicitud->cliente->persona_tipo == 'moral')
            var empresa_municipio_id = {{ ( @$solicitud->cliente->domicilio_empresa->municipio_id > 0)?@$solicitud->cliente->domicilio_empresa->municipio_id:0 }};
            getMunicipios($('#empresa_domicilio_estado'),empresa_municipio_id,$('#empresa_domicilio_municipio'));

            $('#empresa_domicilio_estado').change(function(){
                getMunicipios($(this),"0",$('#empresa_domicilio_municipio'));
            })
        @endif

        setPlan();
        $('#plan_id').change(function(){
            setPlan();
        })

    })

    var minFinanciar = {{ $minFinanciar }};
    function setEnganche(){
        var precio_sistema = 0;

        if (!isNaN( parseFloat($('#solicitud_precio_sistema').val()) )){
            precio_sistema = parseFloat($('#solicitud_precio_sistema').val());
        }
        maxEnganche = precio_sistema - minFinanciar;
        medio = {{ $solicitud->enganche }};

        var slider = $("#enganche").data("ionRangeSlider");
        slider.reset();
        slider.update({
            max: maxEnganche,
            from :medio
        });
    }

    function setPlan(){
        var plan_id = $('#plan_id').val();

        if (plan_id != ''){
            //Obtenemos el plan
            var slider = $("#rango_meses").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: planes[plan_id].plazo,
                from :planes[plan_id].plazo,
                disable:true
            });

            $('#rango_meses_value').val(planes[plan_id].plazo);
        }else{
            var slider = $("#rango_meses").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: 120,
                from :plazo_original,
                disable:false
            });

            $('#rango_meses_value').val(plazo_original);
        }

    }

    function getMunicipios(_this,set_selected,elemento){
        var estado_id = _this.val();
        $.get('/estados/getMunicipios/'+estado_id,function(data){
            elemento.html('');
            $.each(data,function(k,v){
                var selected = "";
                if( set_selected == k){ selected = 'selected'; }
                var option = '<option value="'+ k +'" '+ selected +'  >'+ v +'</option>';
                elemento.append(option);
            })
        })
    }

    function showObligado(tipo_persona){
        var historial = '';
        if(tipo_persona == 'moral'){
            $('.div_obligado').show();
        }else{
            var historial = $('input[name="cliente_historial_credito"]:checked').val();
            if( historial == 'Bueno' ){
                $('.div_obligado').hide();
            }else{
                $('.div_obligado').show();
            }
        }

        console.log('persona:' + tipo_persona);
        console.log('historial:' + historial);
    }

    function showRentero(){
        if( $('#dueno_casa').is(':checked') ) {
            $('.div_rentero').hide();
        }else{
            $('.div_rentero').show();
        }
    }
</script>
@endsection