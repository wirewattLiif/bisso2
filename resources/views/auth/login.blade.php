@extends('layouts.login')

@section('content')
<div class="vertical-center" >
    <div class="container">
        @if (session('status'))
            <div class="alert alert-dismissible fade show" role="alert" style="color: #856404;background-color: #fff3cd;border-color: #ffeeba;">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row justify-content-center">


            <div class="col-md-4">
                <form id="form-login" class="align-middle" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md">
                            <div style="text-align:center">
                                <img src="{{ asset('img/logo_gris.png') }}" alt="" style="width:300px;padding:10px">
                                <br><br>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="email" type="email" placeholder="Correo" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-4">
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #686876">
                                No recuerdo mi contraseña
                            </a>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block btn-rounded">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md">
                            <br>
                            <p style="text-align:center">¿Eres nuevo en Wirewatt? <a href="/" class="naranja">Registrate</a>   </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('.alert').alert()
</script>

@endsection
