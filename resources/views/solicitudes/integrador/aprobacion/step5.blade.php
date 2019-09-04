<div class="row">
    <div class="col-md-12">
        <h2>Referencias personales</h2>
    </div>
</div>


<div class="divFisica">
    <div class="row">
        <div class="col-md-4">
            <p>Nombre Completo</p>
            <input type="hidden" id="referencias_id_1" value="{{ @$solicitud->cliente->referencias_personales[0]->id}}">
            <input id="referencia_nombre_1"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_personales[0]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono Referencia 1</p>
            <input id="referencia_telefono_1"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_personales[0]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <p> Nombre Completo</p>
            <input type="hidden" id="referencias_id_2" value="{{ @$solicitud->cliente->referencias_personales[1]->id}}">
            <input id="referencia_nombre_2"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_personales[1]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono Referencia 2</p>
            <input id="referencia_telefono_2"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_personales[1]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>
    </div>
</div>


<div class="divMoral">
    <div class="row">

        <div class="col-md-4">
            <p>Nombre Proveedor 1</p>
            <input type="hidden" id="referencias_proveedor_id_1" value="{{ @$solicitud->cliente->referencias_proveedores[0]->id}}">
            <input id="referencias_proveedor_nombre_1"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_proveedores[0]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono </p>
            <input id="referencias_proveedor_telefono_1"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_proveedores[0]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <p>Nombre Proveedor 2</p>
            <input type="hidden" id="referencias_proveedor_id_2" value="{{ @$solicitud->cliente->referencias_proveedores[1]->id}}">
            <input id="referencias_proveedor_nombre_2"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_proveedores[1]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono </p>
            <input id="referencias_proveedor_telefono_2"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_proveedores[1]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <p>Nombre Cliente 1</p>
            <input type="hidden" id="referencias_cliente_id_1" value="{{ @$solicitud->cliente->referencias_clientes[0]->id}}">
            <input id="referencias_cliente_nombre_1"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_clientes[0]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono </p>
            <input id="referencias_cliente_telefono_1"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_clientes[0]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <p>Nombre Cliente 2</p>
            <input type="hidden" id="referencias_cliente_id_2" value="{{ @$solicitud->cliente->referencias_clientes[1]->id}}">
            <input id="referencias_cliente_nombre_2"
                   placeholder="{{ __('Nombre') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_clientes[1]->nombre}}"
            >
        </div>

        <div class="col-md-4">
            <p>Teléfono </p>
            <input id="referencias_cliente_telefono_2"
                   placeholder="{{ __('Teléfono') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ @$solicitud->cliente->referencias_clientes[1]->telefono}}"
                   data-mask="(99)9999-9999"
            >
        </div>

    </div>
</div>



<script>
    $(function(){
    })

    function validateStep5() {
        var errors = '';

        if(errors.length == 0){
            var tipo = $('#persona_tipo').val();
            

            var formDetail = new FormData();
            formDetail.append('step' , 5);
            formDetail.append('cliente_id' , {{ $solicitud->cliente_id }});
            formDetail.append('persona_tipo' , tipo);

            if(tipo == 'fisica'){                
                formDetail.append('referencias[1][id]' , $('#referencias_id_1').val());
                formDetail.append('referencias[1][nombre]' , $('#referencia_nombre_1').val());
                formDetail.append('referencias[1][telefono]' , $('#referencia_telefono_1').val());

                formDetail.append('referencias[2][id]' , $('#referencias_id_2').val());
                formDetail.append('referencias[2][nombre]' , $('#referencia_nombre_2').val());
                formDetail.append('referencias[2][telefono]' , $('#referencia_telefono_2').val());
            }else{

                formDetail.append('referencias_proveedor[1][id]' , $('#referencias_proveedor_id_1').val());
                formDetail.append('referencias_proveedor[1][nombre]' , $('#referencias_proveedor_nombre_1').val());
                formDetail.append('referencias_proveedor[1][telefono]' , $('#referencias_proveedor_telefono_1').val());

                formDetail.append('referencias_proveedor[2][id]' , $('#referencias_proveedor_id_2').val());
                formDetail.append('referencias_proveedor[2][nombre]' , $('#referencias_proveedor_nombre_2').val());
                formDetail.append('referencias_proveedor[2][telefono]' , $('#referencias_proveedor_telefono_2').val());

                formDetail.append('referencias_cliente[1][id]' , $('#referencias_cliente_id_1').val());
                formDetail.append('referencias_cliente[1][nombre]' , $('#referencias_cliente_nombre_1').val());
                formDetail.append('referencias_cliente[1][telefono]' , $('#referencias_cliente_telefono_1').val());

                formDetail.append('referencias_cliente[2][id]' , $('#referencias_cliente_id_2').val());
                formDetail.append('referencias_cliente[2][nombre]' , $('#referencias_cliente_nombre_2').val());
                formDetail.append('referencias_cliente[2][telefono]' , $('#referencias_cliente_telefono_2').val());
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
</script>