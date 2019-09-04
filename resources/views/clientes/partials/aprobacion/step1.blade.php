<div class="row">
    <h2>Registro</h2>

    <div class="col-md-12">
        <p>Tipo de solicitante</p>
        <button class="btn btn-success btnTipoPersona" data-value="fisica">Persona</button>
        <button class="btn btn-default btn-outline btnTipoPersona" data-value="moral">Empresa</button>

        <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="¿El sistema solar lo vas a poner en tu casa o negocio?">?</button>



        <br><br><br><br><br>
    </div>

    <div class="col-md-6">
        <input type="hidden" id="persona_tipo" value="fisica">

        <p>Correo</p>
        <input id="correo" type="text" placeholder="Correo" class="input_underline form-control{{ $errors->has('correo') ? ' is-invalid' : '' }}" name="correo" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" >
        @if ($errors->has('correo'))
            <div class="invalid-feedback">
                {{ $errors->first('correo') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <p>Nombre(s)</p>
        <input id="nombre" type="text" placeholder="Nombre(s)" class="input_underline form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ \Illuminate\Support\Facades\Auth::user()->cliente->nombre }}" >
        @if ($errors->has('nombre'))
            <div class="invalid-feedback">
                {{ $errors->first('nombre') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <p>Apellido paterno</p>
        <input id="apellido_paterno" placeholder="{{ __('Apellido Paterno') }}" type="text" class="input_underline form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{ \Illuminate\Support\Facades\Auth::user()->cliente->apellido_paterno }}">
        @if ($errors->has('apellido_paterno'))
            <div class="invalid-feedback">
                {{ $errors->first('apellido_paterno') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <p>Apellido materno</p>
        <input id="apellido_materno" placeholder="Apellido Materno" type="text" class="input_underline form-control{{ $errors->has('apellido_materno') ? ' is-invalid' : '' }}" name="apellido_materno" value="{{ \Illuminate\Support\Facades\Auth::user()->cliente->apellido_materno }}" >
        @if ($errors->has('apellido_materno'))
            <div class="invalid-feedback">
                {{ $errors->first('apellido_materno') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <p>Teléfono Movil</p>
        <input id="telefono_movil" placeholder="Teléfono Movil" type="text" class="input_underline form-control{{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" name="telefono_movil" value="{{ \Illuminate\Support\Facades\Auth::user()->cliente->telefono_movil }}" >
        @if ($errors->has('telefono_movil'))
            <div class="invalid-feedback">
                {{ $errors->first('telefono_movil') }}
            </div>
        @endif
    </div>
</div>

<div class="row">

    @if(empty(Auth::user()->password))
    <div class="col-md-6">
        <p>Contraseña</p>
        <input id="password" placeholder="Contraseña" type="password" class="input_underline form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" autocomplete="off">
        @if ($errors->has('password'))
            <div class="invalid-feedback">
                {{ $errors->first('password') }}
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <p>Repetir contraseña</p>
        <input id="password-confirm" placeholder="Repetir contraseña" type="password" class="input_underline form-control" name="password_confirmation" required>
    </div>
    @endif




    <div class="col-md-12">
        <br><br>
        <div class="form-check">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chkTerminos">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">
                    <a href="/terminos_condiciones" target="_blank" style="color: #686876">Acepto Términos y Condiciones</a>
                </span>
            </label>
        </div>

    </div>

    <div class="col-md-12">
        <div class="form-check">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chkAviso">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">
                    <a href="/aviso_privacidad" target="_blank" style="color: #686876">Acepto Aviso de Privacidad</a>
                </span>
            </label>
        </div>
    </div>
</div>



<script>
    $(function(){

        revisaTipoSolicitante();
        $('.btnTipoPersona').click(function(e){
            e.preventDefault();
            $('.btnTipoPersona').removeClass('btn-success').addClass('btn-default').addClass('btn-outline');
            $(this).addClass('btn-success').removeClass('btn-outline');
            $('#persona_tipo').val( $(this).data('value') );

            revisaTipoSolicitante()
        })
    })

    function validateStep1(){
        var errors = '';

        if( !$('#chkTerminos').is(':checked') ){
            $.toast({
                heading: 'Info',
                text: "Debes aceptar los Términos y Condiciones.",
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 9500
            });
            return false;
        }

        if( !$('#chkAviso').is(':checked') ){
            $.toast({
                heading: 'Info',
                text: "Debes aceptar el Aviso de Privacidad.",
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 9500
            });
            return false;
        }

        if( $('#correo').val().trim().length == 0){
            errors = 'Correo es necesario<br>';
        }

//        if( $('#nombre').val().trim().length == 0){
//            errors = 'Nombre es necesario<br>';
//        }

        if( $('#apellido_paterno').val().trim().length == 0){
            errors = 'Apellido paterno es necesario<br>';
        }

        if( $('#apellido_materno').val().trim().length == 0){
            errors = 'Apellido materno es necesario<br>';
        }

        if( $('#telefono_movil').val().trim().length == 0){
            errors = 'Teléfono movil es necesario<br>';
        }

        if($('#password').length > 0){
            if( $('#password').val().trim().length == 0){
                errors = 'Password es necesario<br>';
            }

            if( $('#password').val() != $('#password-confirm').val() ){
                errors = 'Passwords no coinciden<br>';
            }
        }

        if(errors.length == 0){
            //Ajax con datos
            var formDetail = new FormData();
            formDetail.append('step' , 1);
            formDetail.append('cliente_id' , $('#cliente_id').val());
            formDetail.append('nombre' , $('#nombre').val());
            formDetail.append('correo' , $('#correo').val());
            formDetail.append('apellido_paterno' , $('#apellido_paterno').val());
            formDetail.append('apellido_materno' , $('#apellido_materno').val());
            formDetail.append('telefono_movil' , $('#telefono_movil').val());
            formDetail.append('persona_tipo' , $('#persona_tipo').val());

            if($('#password').length > 0){
                formDetail.append('password' , $('#password').val());
                formDetail.append('password_confirmation' , $('#password-confirm').val());
            }

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

                    $('#titulo_step2').html('Datos personales');
                    $('#titulo_step3').html('Cuéntanos dónde vives (tu dirección actual)');
                    if( $('#persona_tipo').val() == 'moral'){
                        $('#titulo_step2').html('Datos personales del representante legal');
                        $('#titulo_step3').html('Cuéntanos dónde vives (dirección actual del representante legal)');
                    }

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

    function revisaTipoSolicitante(){
        var tipo = $('#persona_tipo').val();

        if(tipo == 'fisica'){
            $('.divFisica').show();
            $('.divMoral').hide();
        }else{
            $('.divFisica').hide()
            $('.divMoral').show();;
        }
    }

</script>