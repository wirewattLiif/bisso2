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
                    <form method="POST" action="{{ route('password.email') }}">
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


                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-12">

                                <button type="submit" class="btn btn-success btn-block btn-rounded">
                                    {{ __('Reestablecer contraseña.') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
