<div id="step1">
    <div class="form-group row">
        <h3 class="col-md-12 naranja">Datos Generales</h3>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="nombre" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" required="required">
            @if ($errors->has('nombre'))
            <div class="invalid-feedback">
                {{ $errors->first('nombre') }}
            </div>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="apellido_paterno" placeholder="{{ __('Apellido Paterno') }}" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required="required">

            @if ($errors->has('apellido_paterno'))
                <div class="invalid-feedback">
                    {{ $errors->first('apellido_paterno') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="apellido_materno" placeholder="Apellido Materno" type="text" class="form-control{{ $errors->has('apellido_materno') ? ' is-invalid' : '' }}" name="apellido_materno" value="{{ old('apellido_materno') }}" >
            @if ($errors->has('apellido_materno'))
                <div class="invalid-feedback">
                    {{ $errors->first('apellido_materno') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="telefono_movil" placeholder="Telefono Movil" type="text" class="form-control{{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" name="telefono_movil" value="{{ old('telefono_movil') }}" >
            @if ($errors->has('telefono_movil'))
                <div class="invalid-feedback">
                    {{ $errors->first('telefono_movil') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="correo" type="text" placeholder="Correo" class="form-control{{ $errors->has('correo') ? ' is-invalid' : '' }}" name="correo" value="{{ old('correo') }}" >
            @if ($errors->has('correo'))
                <div class="invalid-feedback">
                    {{ $errors->first('correo') }}
                </div>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <select name="estado_nacimiento_id" id="estado_nacimiento_id" class="form-control {{ $errors->has('estado_nacimiento_id') ? ' is-invalid' : '' }}">
                <option value="">Selecciona un Estado</option>
                @foreach($estados as $k => $v)
                    <option value="{{ $k }}" {{ (old('estado_nacimiento_id') == $k)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('estado_nacimiento_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('estado_nacimiento_id') }}
                </div>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <select name="inmueble_id" id="inmueble_id" class="form-control{{ $errors->has('inmueble_id') ? ' is-invalid' : '' }}">
                <option value="">Selecciona un Inmueble</option>
                @foreach($inmuebles as $k => $v)
                    <option value="{{ $k }}" {{ (old('inmueble_id') == $k)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('inmueble_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('inmueble_id') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-lg-center">
        <div class="col-md-8">
            <p id="terminos" class="mx-auto" style="width: 65%;">
                Al registrarte estás aceptando los <span class="naranja"> <a href="/aviso_privacidad" target="_blank" class="naranja">Términos y Condiciones</a></span> y el <span class="naranja"> <a
                            href="/terminos_condiciones" target="_blank" class="naranja">Aviso de Privacidad</a> </span>
            </p>
        </div>
    </div>
</div>

