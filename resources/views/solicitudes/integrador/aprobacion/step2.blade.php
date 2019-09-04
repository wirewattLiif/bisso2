<div class="row">
    <div class="col-md-12">
        <h2 id="titulo_step2">Datos personales</h2>
        <p>Fecha de nacimiento</p>
    </div>

    <div class="col-md-1">
        <select id="f_dia" class="form-control input_underline">
            @php
                $dia = "";
                if ( !is_null($solicitud->cliente->fecha_nacimiento)){
                    $dia = date('d',strtotime($solicitud->cliente->fecha_nacimiento));
                }
            @endphp
            <option value="">Día</option>
            @for ($i = 1; $i <= 31; $i++)
            <option value="{{ $i }}" {{ ($dia == $i) ?'selected':''}}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-2">
        <select id="f_mes" class="form-control input_underline">
            @php
                $mes = "";
                if ( !is_null($solicitud->cliente->fecha_nacimiento)){
                    $mes = date('m',strtotime($solicitud->cliente->fecha_nacimiento));
                }
            @endphp
            <option value="">Mes</option>
            @foreach($meses as $k => $v)
                <option value="{{ $k }}" {{ ($k == $mes) ?'selected':''}}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <select id="f_anio" class="form-control input_underline">
            @php
                $anio  = "";
                if ( !is_null($solicitud->cliente->fecha_nacimiento)){
                    $anio = date('Y',strtotime($solicitud->cliente->fecha_nacimiento));
                }
            @endphp
            <option value="">Año</option>
            @for ($i = (date('Y') - 90); $i <= (date('Y') - 17); $i++)
                <option value="{{ $i }}" {{ ($anio == $i) ?'selected':''}}>{{ $i }}</option>
            @endfor
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <br>
        <p>Estado de nacimiento</p>
        <select name="estado_nacimiento_id" id="estado_nacimiento_id" class="form-control input_underline">

            @foreach($estados as $k => $v)
                <option value="{{ $k }}" {{ ($solicitud->cliente->estado_nacimiento_id == $k)?'selected':'' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <br>
        <p>Género</p>
        <button class="btn btn-success btnGenero" data-value="Masculino">Masculino</button>
        <button class="btn btn-default btn-outline btnGenero" data-value="Femenino">Femenino</button>
        <input type="hidden" id="genero" value="masculino">
        <br><br>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>RFC</p>
        <input id="rfc" maxlength="13" placeholder="{{ __('RFC') }}" type="text" class="input_underline form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" value="{{ $solicitud->cliente->rfc }}">
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>CURP</p>
        <input id="curp" maxlength="18" placeholder="{{ __('CURP') }}" type="text" class="input_underline form-control{{ $errors->has('curp') ? ' is-invalid' : '' }}" value="{{ $solicitud->cliente->curp }}">
    </div>
</div>

<script>
    $(function(){
        revisaTipoSolicitante();
        
        setSexo();
        $('.btnGenero').click(function(e){
            e.preventDefault();
            $('.btnGenero').removeClass('btn-success').addClass('btn-default').addClass('btn-outline');
            $(this).addClass('btn-success').removeClass('btn-outline');
            $('#genero').val( $(this).data('value') );
        })
    })

    function setSexo(){
        var sexo = '{{ (!empty($solicitud->cliente->sexo))?$solicitud->cliente->sexo:'' }}';
        if(sexo != ''){
            $('.btnGenero').removeClass('btn-success').addClass('btn-default').addClass('btn-outline');
            $('.btnGenero[data-value="'+ sexo +'"]').addClass('btn-success').removeClass('btn-outline');
            $('#genero').val( sexo);
        }
    }

    function validateStep2(){
        var errors = '';

        if( $('#f_dia').val() == '' || $('#f_mes').val() == '' || $('#f_anio').val() == '' ){
            errors += '* La fecha de nacimiento es necesaria.<br>';
        }

        if( $('#estado_nacimiento_id').val() == ''){
            errors += '* El estado de nacimiento es necesaria.<br>';
        }

        if( $('#rfc').val() == ''){
            errors += '* El RFC es necesario.<br>';
        }

        if( $('#curp').val() == ''){
            errors += '* El CURP es necesario.<br>';
        }

        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 2);
            formDetail.append('cliente_id' , {{ $solicitud->cliente_id }});
            formDetail.append('fecha_nacimiento' , $('#f_anio').val() +'-'+ $('#f_mes').val() +'-' + $('#f_dia').val() );
            formDetail.append('estado_nacimiento_id' , $('#estado_nacimiento_id').val() );
            formDetail.append('sexo' , $('#genero').val() );
            formDetail.append('rfc' , $('#rfc').val() );
            formDetail.append('curp' , $('#curp').val() );

            pass = "";
            $.ajax({
                url: '{{ route('integrador.postSteps') }}',
                type: 'POST',
                dataType: "json",
                data:formDetail,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    pass = true;
                },
                error:function(data){
                    console.log(data.responseJSON.errors);
                    var errors = "";
                    $.each(data.responseJSON.errors,function(k,v){
                        errors += "<b>"+ k +"</b><br>";
                        $.each(v,function(i,err){
                            errors += "*" + err + "<br>";
                        })
                    })

                    $.toast({
                        heading: 'Errores detectados',
                        text: errors,
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 9500
                    });
                    pass = false;
                }
            });
            return pass;

        }else{
            $.toast({
                heading: 'Errores detectados',
                text: errors,
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 9500
            });
            return false;
        }
    }
    
</script>
