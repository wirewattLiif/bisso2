<div class="row">
    <div class="col-md-12">
        <h2>Historial crediticio</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <p>¿Eres titular de alguna tarjeta de crédito?</p>
        <input type="checkbox" id="cliente_titular_tc" class="bootstrapSwitch" data-on-color="success"
               data-on-text="SI" data-off-text="NO" value="1" {{ ( @$solicitud->cliente->tarjeta_credito_titular)?'checked':'' }}
        >
    </div>

    <div class="col-md-4">
        <p>Últimos 4 dígitos de la cuenta</p>
        <input id="cliente_ultimos_digitos"
               placeholder="{{ __('Últimos 4 dígitos de la cuenta') }}"
               type="text"
               class="input_underline form-control"
               maxlength="4"
               minlength="4"
               value="{{ @$solicitud->cliente->ultimos_digitos }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>¿Actualmente eres titular y estás pagando algún crédito hipotecario con algún banco, financiera o INFONAVIT?</p>
        <input type="checkbox" id="cliente_credito_hipotecario" class="bootstrapSwitch" data-on-color="success"
               data-on-text="SI" data-off-text="NO" value="1" {{ ( @$solicitud->cliente->credito_hipotecario)?'checked':'' }}
        >
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>¿Has sido titular de un crédito automotriz en los últimos 24 meses?</p>
        <input type="checkbox" id="cliente_credito_automotriz" class="bootstrapSwitch" data-on-color="success"
               data-on-text="SI" data-off-text="NO"  value="1" {{ ( @$solicitud->cliente->credito_automotriz)?'checked':'' }}
        >
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>¿Cómo calificarías tu historial crediticio?</p>
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="form-check">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input historial_credito" value="No tengo historial" {{ (@$solicitud->cliente->historial_credito == "No tengo historial")?"checked":"" }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">No tengo historial</span>
            </label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-check">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input historial_credito" value="No se" {{ (@$solicitud->cliente->historial_credito == "No se")?"checked":"" }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">No se</span>
            </label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-check">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input historial_credito" value="Malo" {{ (@$solicitud->cliente->historial_credito == "Malo")?"checked":"" }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Malo</span>
            </label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-check">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input historial_credito" value="Regular" {{ (@$solicitud->cliente->historial_credito == "Regular")?"checked":"" }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Regular</span>
            </label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-check">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input historial_credito" value="Bueno" {{ (@$solicitud->cliente->historial_credito == "Bueno")?"checked":"" }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Bueno</span>
            </label>
        </div>
    </div>
</div>






<script>
    $(function(){
        revisa_tc();        
        $('.bootstrapSwitch').on('switchChange.bootstrapSwitch', function(event, state) {
            revisa_tc();
        })
    })

    function revisa_tc(){
        var tc = false;
        if( $('#cliente_titular_tc').prop('checked') ) {
            tc = true;
        }

        if(tc){
            $('#cliente_ultimos_digitos').parent().show();
        }else{
            $('#cliente_ultimos_digitos').parent().hide();
            $('#cliente_ultimos_digitos').val('');
        }
    }

    function validateStep8() {
        var errors = '';



        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 8);
            formDetail.append('solicitud_id' ,  {{ $solicitud->id }});
            formDetail.append('cliente_id' ,  {{ $solicitud->cliente_id }});
            formDetail.append('ultimos_digitos' , $('#cliente_ultimos_digitos').val());

            var historial_credito = '';
            if( $('.historial_credito:checked').val() != undefined ){
                historial_credito = $('.historial_credito:checked').val();
            }
            formDetail.append('historial_credito' , historial_credito );

            var tarjeta_credito_titular = '0';
            if( $('#cliente_titular_tc').prop('checked') ) { tarjeta_credito_titular = '1'; }
            formDetail.append('tarjeta_credito_titular' , tarjeta_credito_titular);

            var credito_hipotecario = '0';
            if( $('#cliente_credito_hipotecario').prop('checked') ) { credito_hipotecario = '1'; }
            formDetail.append('credito_hipotecario' , credito_hipotecario);

            var credito_automotriz = '0';
            if( $('#cliente_credito_automotriz').prop('checked') ) { credito_automotriz = '1'; }
            formDetail.append('credito_automotriz' , credito_automotriz);

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