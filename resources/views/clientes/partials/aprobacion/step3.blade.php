<div class="row">
    <div class="col-md-12">
        <h2 id="titulo_step3">Cuéntanos dónde vives (tu dirección actual)</h2>

    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Calle</p>
        <input id="domicilio_calle"
               placeholder="{{ __('Calle') }}"
               type="text"
               class="input_underline form-control"
               value="{{ @Auth::user()->cliente->domicilio->calle }}"
        >
    </div>

    <div class="col-md-5">
        <p>Número exterior</p>
        <input id="domicilio_num_ext"
               placeholder="{{ __('Número exterior') }}"
               type="text"
               class="input_underline form-control"
               value="{{ @Auth::user()->cliente->domicilio->numero_ext }}"
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
               value="{{ @Auth::user()->cliente->domicilio->numero_int }}"
        >
    </div>

    <div class="col-md-5">
        <p>Colonia</p>
        <input id="domicilio_colonia"
               placeholder="{{ __('Colonia') }}"
               type="text"
               class="input_underline form-control"
               value="{{ @Auth::user()->cliente->domicilio->colonia }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <p>Estado</p>
        <select id="domicilio_estado" class="form-control input_underline">
            @foreach($estados as $k => $v)
                <option value="{{ $k }}" {{ ( @Auth::user()->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
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
               value="{{ @Auth::user()->cliente->domicilio->ciudad }}"
        >
    </div>

    <div class="col-md-5">
        <p>Código Postal</p>
        <input id="domicilio_cp"
               placeholder="{{ __('Código Postal') }}"
               type="text"
               class="input_underline form-control"
               value="{{ @Auth::user()->cliente->domicilio->cp }}"
               maxlength="6"
        >
    </div>


</div>

<div class="row">
    <div class="col-md-5">
        <p>Teléfono de tu casa</p>
        <input id="cliente_telefono_casa"
               placeholder="{{ __('Teléfono de casa') }}"
               type="text"
               class="input_underline form-control"
               value="{{ Auth::user()->cliente->telefono_fijo }}"
               data-mask="(99)9999-9999"
        >
    </div>
    <div class="col-md-5">
        <p>¿Eres dueño de la casa?  <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="	¿Tu,	o	 tu	esposo(a)	es	propietario
de	la	vivienda	 o	tienen	un	crédito
hipotecario	a	su	nombre?">?</button></p>
        <input type="checkbox" id="dueno_casa" class="bootstrapSwitch" data-on-color="success"
            data-on-text="SI" data-off-text="NO"  {{ (Auth::user()->cliente->dueno_casa)?'checked':'' }}
        >
    </div>
</div>

<script>
    $(function(){
        $(".bootstrapSwitch").bootstrapSwitch();

        var municipio_id = {{ ( @Auth::user()->cliente->domicilio->municipio_id > 0)?Auth::user()->cliente->domicilio->municipio_id:0 }};
        getMunicipios(municipio_id);

        $('#domicilio_estado').change(function(){
            getMunicipios("0");
        });
    })
    
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

        if( $('#cliente_telefono_casa').val() == ''){
            errors += '* El campo teléfono es necesario.<br>';
        }

        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 3);
            formDetail.append('cliente_id' , $('#cliente_id').val());
            formDetail.append('calle' , $('#domicilio_calle').val());
            formDetail.append('numero_ext' , $('#domicilio_num_ext').val());
            formDetail.append('numero_int' , $('#domicilio_numero_int').val());
            formDetail.append('colonia' , $('#domicilio_colonia').val());
            formDetail.append('estado_id' , $('#domicilio_estado').val());
            formDetail.append('municipio_id' , $('#domicilio_municipio').val());
            formDetail.append('cp' , $('#domicilio_cp').val());
            formDetail.append('ciudad' , $('#domicilio_ciudad').val());




            formDetail.append('telefono_casa' , $('#cliente_telefono_casa').val());
            var dueno_casa = '0';
            if( $('#dueno_casa').prop('checked') ) { dueno_casa = '1'; }
            formDetail.append('dueno_casa' , dueno_casa);

            pass = "";
            $.ajax({
                url: '{{ route('postSteps') }}',
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