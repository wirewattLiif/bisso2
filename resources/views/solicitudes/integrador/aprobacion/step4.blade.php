<div class="divFisica">
    <div class="row">
        <div class="col-md-12">
            <h2>¿Dónde trabajas?</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <p>¿Trabajas actualmente?</p>
            <input type="checkbox" id="cliente_trabaja" class="bootstrapSwitch" data-on-color="success"
                   data-on-text="SI" data-off-text="NO"  {{ ($solicitud->cliente->trabaja)?'checked':'' }}
            >
        </div>

        <div class="col-md-4">
            <p>Nombre de la empresa</p>
            <input id="cliente_nombre_empresa"
                   placeholder="{{ __('Nombre de la empresa') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->nombre_empresa }}"
            >
        </div>

        <div class="col-md-4">
            <p>Puesto</p>
            <input id="cliente_puesto"
                   placeholder="{{ __('Puesto') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->puesto }}"
            >
        </div>
    </div>


    <br>
    <div class="row">

        <div class="col-md-4">
            <p>Industria</p>
            <select id="cliente_giro_comercial_id" class="form-control input_underline">
                @foreach($giros as $i => $v)
                    <option value="{{ $i }}" {{ ( $solicitud->cliente->giro_comercial_id == $i)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <p>Número de tu trabajo</p>
            <input id="cliente_telefono_oficina"
                   placeholder="{{ __('Número de trabajo') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->telefono_oficina }}"
                   data-mask="(99)9999-9999"
            >
        </div>

        <div class="col-md-4">
            <p>Salario Mensual</p>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">$</span>
                <input id="cliente_salario_mensual"                        
                       placeholder="{{ __('Salario Mensual') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ (!empty($solicitud->cliente->salario_mensual))?$solicitud->cliente->salario_mensual:"" }}"
                >
            </div>
        </div>
    </div>


    <br>
    <div class="row">
        <div class="col-md-4">
            <p>¿Te pagan a través de un banco?</p>
            <input type="checkbox" id="cliente_pago_banco" class="bootstrapSwitch" data-on-color="success"
                   data-on-text="SI" data-off-text="NO"  {{ ($solicitud->cliente->pago_banco)?'checked':'' }}
            >
        </div>

        <div class="col-md-4">
            <p>Salario familiar total del mes</p>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">$</span>
                <input id="cliente_salario_familiar"
                       placeholder="{{ __('Salario familiar total del mes') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ (!empty($solicitud->cliente->salario_familiar))?$solicitud->cliente->salario_familiar:"0" }}"
                >
            </div>
        </div>

        <div class="col-md-4">
            <p>Número de dependientes</p>
            <select name="" id="cliente_dependientes" class="form-control input_underline">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ ( $solicitud->cliente->dependientes == $i)?'selected':'' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>



<div class="divMoral">
    <div class="row">
        <div class="col-md-12">
            <h2>Datos del Negocio</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <p>RFC que usas para facturar</p>
            <input id="cliente_moral_rfc_facturar"
                   placeholder="{{ __('RFC que usas para facturar') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->rfc_facturar }}"
            >
        </div>

        <div class="col-md-4">
            <p>Contraseña SAT (CIEC)
                <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="No es obligatorio, pero ahorrará tiempo e información adicional como: estados financieros y estados bancarios de la empresa.">?</button>
            </p>
            <input id="cliente_moral_contrasenia_sat"
                   placeholder="{{ __('Contraseña SAT (CIEC)') }}"
                   type="password"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->contrasenia_sat}}"
            >
        </div>

        <div class="col-md-4">
            <p>Ingresos anuales</p>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input id="cliente_ingreso_anual"
                       placeholder="{{ __('Ingresos anuales') }}"
                       type="text"
                       class="input_underline form-control"
                       value="{{ $solicitud->cliente->ingresos_anuales}}"
                >
            </div>
        </div>


    </div>


    <div class="row">

        <div class="col-md-4">
            <p>Razón Social de la Empresa</p>
            <input id="cliente_moral_nombre_empresa"
                   placeholder="{{ __('Razón Social de la Empresa') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->nombre_empresa }}"
            >
        </div>

        <div class="col-md-4">
            <p>Industria</p>
            <select id="cliente_moral_giro_comercial_id" class="form-control input_underline">
                @foreach($giros as $i => $v)
                    <option value="{{ $i }}" {{ ( $solicitud->cliente->giro_comercial_id == $i)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <p>Número de empleados</p>
            <input id="cliente_moral_dependientes"
                   placeholder="{{ __('Número de empleados') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->dependientes }}"
            >
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <hr>
            <p><b>Ingresa la dirección de donde esta operando actualmente:</b></p>
        </div>

        <div class="col-md-4">
            <p>Calle</p>
            <input id="domicilio_moral_calle"
                   placeholder="{{ __('Calle') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->domicilio_empresa->calle }}"
            >
        </div>

        <div class="col-md-4">
            <p>Número exterior</p>
            <input id="domicilio_moral_num_ext"
                   placeholder="{{ __('Número exterior') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->domicilio_empresa->numero_ext }}"
            >
        </div>

        <div class="col-md-4">
            <p>Número interior</p>
            <input id="domicilio_moral_numero_int"
                   placeholder="{{ __('Número interior') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->domicilio_empresa->numero_int }}"
            >
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <p>Estado</p>
            <select id="domicilio_moral_estado" class="form-control input_underline">
                @foreach($estados as $k => $v)
                    <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio_empresa->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <p>Municipio</p>
            <select id="domicilio_moral_municipio" class="form-control input_underline">
            </select>
        </div>

        <div class="col-md-4">
            <p>Colonia</p>
            <input id="domicilio_moral_colonia"
                   placeholder="{{ __('Colonia') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->domicilio_empresa->colonia }}"
            >
        </div>

    </div>

    <div class="row">



        <div class="col-md-4">
            <p>Teléfono de tu negocio</p>
            <input id="cliente_moral_telefono_oficina"
                   placeholder="{{ __('Teléfono de tu negocio') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ $solicitud->cliente->telefono_oficina }}"
                   data-mask="(99)9999-9999"
            >
        </div>

    </div>
</div>






<script>
    $(function(){
        var municipio_id = {{ ( @$solicitud->cliente->domicilio_empresa->municipio_id > 0)?$solicitud->cliente->domicilio_empresa->municipio_id:0 }};
        getMunicipiosStep4(municipio_id);
        $('#domicilio_moral_estado').change(function(){
            getMunicipiosStep4("0");
        })
    })

    function validateStep4() {
        var errors = '';
        var tipo = $('#persona_tipo').val();

        if(tipo == 'fisica'){
            if( $('#cliente_puesto').val() == ''){
                errors += '* El campo puesto es necesario' + '.<br>';
            }

            if( $('#cliente_salario_mensual').val() == ''){
                errors += '* El campo Salario mensual es necesario' + '.<br>';
            }

            if( $('#cliente_salario_familiar').val() == ''){
                errors += '* El campo Salario familiar es necesario' + '.<br>';
            }

        }
        else{
            if( $('#cliente_moral_rfc_facturar').val() == ''){
                errors += '* El campo RFC es necesario' + '.<br>';
            }

            if( $('#cliente_moral_nombre_empresa').val() == ''){
                errors += '* El nombre de la empresa es necesario' + '.<br>';
            }

            if( $('#domicilio_moral_calle').val() == ''){
                errors += '* El campo calle es necesario' + '.<br>';
            }

            if( $('#cliente_moral_telefono_oficina').val() == ''){
                errors += '* El teléfono del negocio es necesario' + '.<br>';
            }

            if( $('#cliente_moral_contrasenia_sat').val() == ''){
                errors += '* La contraseña SAT es necesaria' + '.<br>';
            }
        }



        if(errors.length == 0){
            var tipo = $('#persona_tipo').val();

            var formDetail = new FormData();
            formDetail.append('step' , 4);
            formDetail.append('cliente_id' , {{ $solicitud->cliente_id }});
            formDetail.append('persona_tipo' , tipo);

            if(tipo == 'fisica'){
                var trabaja = '0';
                if( $('#cliente_trabaja').prop('checked') ) { trabaja = '1'; }
                formDetail.append('trabaja' , trabaja);
                formDetail.append('nombre_empresa' , $('#cliente_nombre_empresa').val());
                formDetail.append('puesto' , $('#cliente_puesto').val());

                formDetail.append('telefono_oficina' , $('#cliente_telefono_oficina').val());
                formDetail.append('salario_mensual' , $('#cliente_salario_mensual').val());

                var pago_banco = '0';
                if( $('#cliente_pago_banco').prop('checked') ) { pago_banco = '1'; }
                formDetail.append('pago_banco' , pago_banco);
                formDetail.append('salario_familiar' , $('#cliente_salario_familiar').val());
                formDetail.append('dependientes' , $('#cliente_dependientes').val());

                formDetail.append('giro_comercial_id' , $('#cliente_giro_comercial_id').val());
            }
            else{
                formDetail.append('rfc_facturar' , $('#cliente_moral_rfc_facturar').val());
                formDetail.append('contrasenia_sat' , $('#cliente_moral_contrasenia_sat').val());
                formDetail.append('ingresos_anuales' , $('#cliente_ingreso_anual').val());
                formDetail.append('telefono_oficina' , $('#cliente_moral_telefono_oficina').val());

                formDetail.append('nombre_empresa' , $('#cliente_moral_nombre_empresa').val());
                formDetail.append('giro_comercial_id' , $('#cliente_moral_giro_comercial_id').val());
                formDetail.append('dependientes' , $('#cliente_moral_dependientes').val());

                formDetail.append('domicilio_calle' , $('#domicilio_moral_calle').val());
                formDetail.append('domicilio_numero_ext' , $('#domicilio_moral_num_ext').val());
                formDetail.append('domicilio_numero_int' , $('#domicilio_moral_numero_int').val());
                formDetail.append('domicilio_estado_id' , $('#domicilio_moral_estado').val());
                formDetail.append('domicilio_municipio_id' , $('#domicilio_moral_municipio').val());
                formDetail.append('domicilio_colonia' , $('#domicilio_moral_colonia').val());
            }




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

    function getMunicipiosStep4(set_selected){

        var estado_id = $('#domicilio_moral_estado').val();
        $.get('/estados/getMunicipios/'+estado_id,function(data){
            $('#domicilio_moral_municipio').html('');
            $.each(data,function(k,v){
                var selected = "";
                if( set_selected == k){ selected = 'selected'; }
                var option = '<option value="'+ k +'" '+ selected +'  >'+ v +'</option>';
                console.log(option);
                $('#domicilio_moral_municipio').append(option);
            })
        })
    }
</script>