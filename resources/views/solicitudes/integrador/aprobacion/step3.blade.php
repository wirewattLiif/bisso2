<div class="row">
    <div class="col-md-12">
        <h2 id="titulo_step3">Cuéntanos donde vas a instalar el proyecto</h2>

    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Calle</p>
        <input id="domicilio_calle"
               placeholder="{{ __('Calle') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->calle }}"
        >
    </div>

    <div class="col-md-5">
        <p>Número exterior</p>
        <input id="domicilio_num_ext"
               placeholder="{{ __('Número exterior') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->numero_ext }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Número interior (opcional)</p>
        <input id="domicilio_numero_int"
               placeholder="{{ __('Número interior') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->numero_int }}"
        >
    </div>

    <div class="col-md-5">
        <p>Colonia</p>
        <input id="domicilio_colonia"
               placeholder="{{ __('Colonia') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->colonia }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Estado</p>
        <select id="domicilio_estado" class="form-control input_underline">
            @foreach($estados as $k => $v)
                <option value="{{ $k }}" {{ ( $solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-5">
        <p>Municipio / Delegación </p>
        <select id="domicilio_municipio" class="form-control input_underline">
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Ciudad</p>
        <input id="domicilio_ciudad"
               placeholder="{{ __('Ciudad') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->ciudad }}"
        >
    </div>

    <div class="col-md-5">
        <p>Código Postal</p>
        <input id="domicilio_cp"
               placeholder="{{ __('Código Postal') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->domicilio->cp }}"
               maxlength="6"
        >
    </div>


</div>

<div class="row">
    <div class="col-md-5">
        <p>Teléfono móvil</p>
        <input id="cliente_telefono_movil"
                placeholder="{{ __('Teléfono de movil') }}"
                type="text"
                class="input_underline form-control"
                value="{{ $solicitud->cliente->telefono_movil }}"
                data-mask="(99)9999-9999"
        >
    </div>
    
    <div class="col-md-5">
        <p>Teléfono de tu casa</p>
        <input id="cliente_telefono_casa"
               placeholder="{{ __('Teléfono de casa') }}"
               type="text"
               class="input_underline form-control"
               value="{{ $solicitud->cliente->telefono_fijo }}"
               data-mask="(99)9999-9999"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>¿Eres dueño del predio dónde se va a instalar el proyecto? <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="	¿Tu,	o	 tu	esposo(a)	es	propietario de	la	vivienda	 o	tienen	un	crédito hipotecario	a	su	nombre?">?</button></p>
        <input type="checkbox" id="dueno_casa" class="bootstrapSwitch" data-on-color="success"
            data-on-text="SI" data-off-text="NO"  {{ ($solicitud->cliente->dueno_casa)?'checked':'' }}
        >
    </div>
    
    <div class="col-md-5 div_rentero">
        <p>Nombre del rentero</p>
        <input type="text" class="input_underline form-control" id="rentero_nombre" name="rentero_nombre" value="{{ $solicitud->cliente->rentero_nombre }}" >
    </div>

    <div class="col-md-5 div_rentero">
        <p>Folio predial / Número contrato arrendamiento</p>
        <input type="text" class="input_underline form-control" id="rentero_folio_predial" name="rentero_folio_predial" value="{{ $solicitud->cliente->rentero_folio_predial }}" >
    </div>
</div>

<script>
    $(function(){
        
        showRentero();
        var municipio_id = {{ ( $solicitud->cliente->domicilio->municipio_id > 0)? $solicitud->cliente->domicilio->municipio_id:0 }};
        getMunicipios(municipio_id);

        $('#domicilio_estado').change(function(){
            getMunicipios("0");
        });

        $('#dueno_casa').on('switchChange.bootstrapSwitch', function(event, state) {
            showRentero()
        })
    })

    function showRentero(){
        if( $('#dueno_casa').is(':checked') ) {
            $('.div_rentero').hide();
        }else{
            $('.div_rentero').show();
        }
    }
    
    function validateStep3() {
        var errors = '';
        if( $('#domicilio_calle').val() == ''){
            errors += '* La calle es necesaria.<br>';
        }

        if( $('#domicilio_colonia').val() == ''){
            errors += '* La colonia necesaria.<br>';
        }

        if( $('#domicilio_cp').val() == ''){
            errors += '* El código postal es necesario.<br>';
        }

        if( $('#cliente_telefono_movil').val() == ''){
            errors += '* El campo teléfono móvil es necesario.<br>';
        }

        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 3);
            formDetail.append('cliente_id' , {{ $solicitud->cliente_id }});
            formDetail.append('calle' , $('#domicilio_calle').val());
            formDetail.append('numero_ext' , $('#domicilio_num_ext').val());
            formDetail.append('numero_int' , $('#domicilio_numero_int').val());
            formDetail.append('colonia' , $('#domicilio_colonia').val());
            formDetail.append('estado_id' , $('#domicilio_estado').val());
            formDetail.append('municipio_id' , $('#domicilio_municipio').val());
            formDetail.append('cp' , $('#domicilio_cp').val());
            formDetail.append('ciudad' , $('#domicilio_ciudad').val());

            formDetail.append('telefono_casa' , $('#cliente_telefono_casa').val());
            formDetail.append('telefono_movil' , $('#cliente_telefono_movil').val());


            var dueno_casa = '0';
            formDetail.append('rentero_nombre' , $('#rentero_nombre').val());
            formDetail.append('rentero_folio_predial' , $('#rentero_folio_predial').val());
            if( $('#dueno_casa').prop('checked') ) { 
                dueno_casa = '1';
                formDetail.append('rentero_nombre' , '');
                formDetail.append('rentero_folio_predial' , '');
            }
            formDetail.append('dueno_casa' , dueno_casa);

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

    function getMunicipios(set_selected){
        var estado_id = $('#domicilio_estado').val();
        $.get('/estados/getMunicipios/'+estado_id,function(data){
            $('#domicilio_municipio').html('');
            $.each(data,function(k,v){
                var selected = "";
                if( set_selected == k){ selected = 'selected'; }
                var option = '<option value="'+ k +'" '+ selected +'  >'+ v +'</option>';
                $('#domicilio_municipio').append(option);
            })
        })
    }
</script>