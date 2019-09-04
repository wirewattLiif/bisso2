<div class="row">
    <div class="col-md-12">
        <h2>Datos sistema solar</h2>
    </div>
</div>


<div class="row">
    <div class="col-md-4">
        <p>
            Número de páneles
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Escribe	el	número	de	paneles	que tiene tu sistema solar FV">?</button>
        </p>
        <input type="hidden" id="solicitud_id" value="{{ Auth::user()->cliente->solicitudes[0]->id }}">
        <input id="solicitud_total_paneles"
               placeholder="{{ __('Número de páneles') }}"
               type="text"
               class="input_underline form-control"
               value="{{ Auth::user()->cliente->solicitudes[0]->total_paneles }}"
        >
    </div>

    <div class="col-md-4">
        <p>
            Capacidad por panel
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Escribe	la	capacidad	de	panel	de	tu	sistema	solar	FV(i.e 260,	270,	330)">?</button>
        </p>
        <div class="input-group">
            <input id="solicitud_capacidad_paneles"
                   placeholder="{{ __('Capacidad por panel') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ Auth::user()->cliente->solicitudes[0]->capacidad_paneles }}"
            >
            <span class="input-group-addon" id="basic-addon1">Watts</span>
        </div>


    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <p>
            Capacidad del sistema
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Esta	es	la	capacidad	de	tu	sistema	solar	FV">?</button>
        </p>
        <div class="input-group">
            <input id="solicitud_capacidad_sistema"
                   placeholder="{{ __('Capacidad del sistema') }}"
                   type="text"
                   readonly="readonly"
                   class="input_underline form-control"
                   value="{{ Auth::user()->cliente->solicitudes[0]->capacidad_sistema }}"
            >
            <span class="input-group-addon" id="basic-addon1">Watts</span>
        </div>
    </div>

    <div class="col-md-4">
        <p>
            Recibo de luz promedio (bimestral)
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Escribe en Pesos ($	MXN) el	monto de tu	recibo de luz promedio por bimestre. En	caso de	ser	mensual, multiplica	por	2 tu recibo	de luz promedio">?</button>
        </p>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">$</span>
            <input id="solicitud_cfe_promedio"
                   placeholder="{{ __('Recibo de luz promedio (bimestral)') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ Auth::user()->cliente->solicitudes[0]->cfe_promedio }}"
            >
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <p>
            Ahorro bimesral proyectado
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Escribe	los	ahorros	bimestrales	proyectados	 por	la	empresa	instaladora	solar">?</button>
        </p>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">$</span>
            <input id="solicitud_ahorrados_proyectados_mes"
                   placeholder="{{ __('Ahorro bimesral proyectado') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ Auth::user()->cliente->solicitudes[0]->ahorros_proyectados_mes }}"
            >
        </div>
    </div>

    <div class="col-md-4">
        <p>Empresa instaladora solar</p>
        <input id="solicitud_empresa_instaladora_solar"
               placeholder="{{ __('Empresa instaladora solar') }}"
               type="text"
               class="input_underline form-control"
               value="{{ Auth::user()->cliente->solicitudes[0]->empresa_instaladora_solar }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <p>
            Fecha tentativa de inicio de instalación
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Fecha en	la que estimas estar haciendo tu proyecto solar FV">?</button>
        </p>
        <input id="solicitud_fecha_instalacion_tentativa"
               placeholder="{{ __('Fecha tentativa de inicio de instalación') }}"
               type="text"
               readonly="readonly"
               class="input_underline form-control"
               value="{{ Auth::user()->cliente->solicitudes[0]->fecha_instalacion_tentativa }}"
        >
    </div>

    <div class="col-md-4">
        <p>Telefono de contacto de empresa instaladora solar</p>
        <input id="solicitud_contacto_instaladora"
               placeholder="{{ __('Telefono de contacto de empresa instaladora solar') }}"
               type="text"
               class="input_underline form-control"
               value="{{ Auth::user()->cliente->solicitudes[0]->contacto_instaladora }}"
               data-mask="(99)9999-9999"
        >
    </div>
</div>



<script>
    $(function(){
        $('#solicitud_fecha_instalacion_tentativa').datepicker({
            format:'yyyy-mm-dd',
            startDate: new Date(),

        });

        capacidadSistema();
        $('#solicitud_total_paneles,#solicitud_capacidad_paneles').keyup(function(e){
            e.preventDefault();
            capacidadSistema();
        })
    })


    function validateStep6() {
        var errors = '';

        if( $('#solicitud_total_paneles').val() == ''){
            errors += '* El número de páneles es necesario.' + '<br>';
        }

        if( $('#solicitud_capacidad_paneles').val() == ''){
            errors += '* La capacidad de páneles es necesaria .' + '<br>';
        }

        if( $('#solicitud_cfe_promedio').val() == ''){
            errors += '* Recibo de luz promedio es necesario.' + '<br>';
        }

        if( $('#solicitud_ahorrados_proyectados_mes').val() == ''){
            errors += '* Ahorros mensuales proyectados es necesario.' + '<br>';
        }


        if( $('#solicitud_fecha_instalacion_tentativa').val() == ''){
            errors += '* La Fecha tentativa de inicio de instalación es necesaria.' + '<br>';
        }


        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 6);
            formDetail.append('cliente_id' , $('#cliente_id').val());
            formDetail.append('solicitud_id' , $('#solicitud_id').val());
            formDetail.append('total_paneles' , $('#solicitud_total_paneles').val());
            formDetail.append('capacidad_paneles' , $('#solicitud_capacidad_paneles').val());
            formDetail.append('cfe_promedio' , $('#solicitud_cfe_promedio').val());
            formDetail.append('ahorros_proyectados_mes' , $('#solicitud_ahorrados_proyectados_mes').val());
            formDetail.append('empresa_instaladora_solar' , $('#solicitud_empresa_instaladora_solar').val());
            formDetail.append('fecha_instalacion_tentativa' , $('#solicitud_fecha_instalacion_tentativa').val());

            formDetail.append('capacidad_sistema' , $('#solicitud_capacidad_sistema').val());
            formDetail.append('contacto_instaladora' , $('#solicitud_contacto_instaladora').val());

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

    function capacidadSistema(){
        var total_paneles = 0;
        var capacidad_paneles = 0;
        var capacidad_sistema = 0;

        if (!isNaN( parseFloat($('#solicitud_total_paneles').val()) )){
            total_paneles = parseFloat($('#solicitud_total_paneles').val());
        }

        if (!isNaN( parseFloat($('#solicitud_capacidad_paneles').val()) )){
            capacidad_paneles = parseFloat($('#solicitud_capacidad_paneles').val());
        }

        capacidad_sistema = total_paneles * capacidad_paneles;
        $('#solicitud_capacidad_sistema').val(capacidad_sistema);
    }
</script>