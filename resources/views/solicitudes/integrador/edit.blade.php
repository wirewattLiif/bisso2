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
    <form action="{{ route('integrador.solicitudes.update', $solicitud->id) }}" method="post">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <h3>Domicilio de la instalación</h3>
            </div>

            <div class="col-md-4">
                <p>Calle</p>
                <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
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