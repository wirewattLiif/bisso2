@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <h3 class="col-md-12">Datos Generales</h3>
                                <label for="nombre" class="col-md-3 col-form-label">{{ __('Nombre') }}</label>

                                <div class="col-md-8">
                                    <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" >

                                    @if ($errors->has('nombre'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label">{{ __('Apellido Paterno') }}</label>
                                <div class="col-md-8">
                                    <input id="apellido_paterno" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{ old('apellido_paterno') }}" >

                                    @if ($errors->has('apellido_paterno'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="apellido_materno" class="col-md-3 col-form-label">{{ __('apellido_materno') }}</label>
                                <div class="col-md-8">
                                    <input id="apellido_materno" type="text" class="form-control{{ $errors->has('apellido_materno') ? ' is-invalid' : '' }}" name="apellido_materno" value="{{ old('apellido_materno') }}" >
                                    @if ($errors->has('apellido_materno'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('apellido_materno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefono_movil" class="col-md-3 col-form-label">{{ __('telefono_movil') }}</label>
                                <div class="col-md-8">
                                    <input id="telefono_movil" type="text" class="form-control{{ $errors->has('telefono_movil') ? ' is-invalid' : '' }}" name="telefono_movil" value="{{ old('telefono_movil') }}" >
                                    @if ($errors->has('telefono_movil'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telefono_movil') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="correo" class="col-md-3 col-form-label">{{ __('correo') }}</label>
                                <div class="col-md-8">
                                    <input id="correo" type="text" class="form-control{{ $errors->has('correo') ? ' is-invalid' : '' }}" name="correo" value="{{ old('correo') }}" >
                                    @if ($errors->has('correo'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('correo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="estado_nacimiento_id" class="col-md-3 col-form-label">{{ __('estado_nacimiento_id') }}</label>
                                <div class="col-md-8">
                                    <input id="estado_nacimiento_id" type="text" class="form-control{{ $errors->has('estado_nacimiento_id') ? ' is-invalid' : '' }}" name="estado_nacimiento_id" value="{{ old('estado_nacimiento_id') }}" >
                                    @if ($errors->has('estado_nacimiento_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('estado_nacimiento_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ciudad_nacimiento_id" class="col-md-3 col-form-label">{{ __('ciudad_nacimiento_id') }}</label>
                                <div class="col-md-8">
                                    <input id="ciudad_nacimiento_id" type="text" class="form-control{{ $errors->has('ciudad_nacimiento_id') ? ' is-invalid' : '' }}" name="ciudad_nacimiento_id" value="{{ old('ciudad_nacimiento_id') }}" >
                                    @if ($errors->has('ciudad_nacimiento_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('ciudad_nacimiento_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>






                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
