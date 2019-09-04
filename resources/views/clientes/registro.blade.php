@extends('layouts.public')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
@stop

@section('content')

<div class="col-md-12">

    <div class="register-box">
        <div class="row justify-content-lg-center">
            <div class="col-lg-8">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                @endif

                @if(session('danger'))
                        <div class="alert alert-success">
                            <h3>Mensaje informativo</h3>
                            {{ session('danger') }}
                        </div>
                @endif

                <!-- multistep form -->
                <form method="POST" id="msform" action="{{ route('registro_cliente') }}">
                @csrf
                <!-- progressbar -->
                    <ul id="eliteregister">
                        <li class="active">Precotizar</li>
                        <li>Datos Generales</li>
                        <li>Cotización</li>
                    </ul>
                    <!-- fieldsets -->
                    <fieldset>
                        @include('clientes.partials.step2')
                        <button type="button" name="next" id="btnStep1" class="next action-button btn btn-outline btn-rounded btn-warning" >Siguiente</button>
                    </fieldset>
                    <fieldset>
                        @include('clientes.partials.step1')
                        <button type="button" name="previous" class="previous action-button btn btn-outline btn-rounded btn-warning" >Anterior</button>
                        <button type="button" name="next" id="btnStep2" class="next action-button btn btn-outline btn-rounded btn-warning" >Siguiente</button>
                    </fieldset>
                    <fieldset>
                        @include('clientes.partials.step3')
                        <button type="button" name="previous" class="previous action-button btn btn-outline btn-rounded btn-warning" >Anterior</button>
                        {{--<button id="btnSubmit" type="button" class="submit action-button btn btn-outline btn-rounded btn-warning">Iniciar preaprobación de crédito</button>--}}
                        {{--<input type="submit" name="submit" class="submit action-button" value="Submit" />--}}
                    </fieldset>
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>


@endsection

@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>
    <script>
        $(function(){
            $('#btnSubmit').click(function(e){
                e.preventDefault();
                window.location = "/aprobacion_credito";
            })

        })
    </script>
@endsection