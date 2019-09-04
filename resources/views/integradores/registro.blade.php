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
                <form method="POST" id="msform" action="#">
                @csrf
                <!-- progressbar -->
                    <ul id="eliteregister">
                        <li class="active">Datos del Usuario</li>
                        <li>Datos de la empresa</li>
                        <li>Datos del socio</li>
                    </ul>
                    <!-- fieldsets -->
                    <fieldset>
                        @include('integradores.partials.step1')
                        <button type="button" name="next" id="integradoresBtnStep1" class="next action-button btn btn-outline btn-rounded btn-warning" >Siguiente</button>
                    </fieldset>
                    <fieldset>
                        @include('integradores.partials.step2')
                        <button type="button" name="previous" class="previous action-button btn btn-outline btn-rounded btn-warning" >Anterior</button>
                        <button type="button" name="next" id="integradoresBtnStep2" class="next action-button btn btn-outline btn-rounded btn-warning" >Siguiente</button>
                    </fieldset>
                    <fieldset>
                         @include('integradores.partials.step3')
                        <button type="button" name="previous"  class="previous action-button btn btn-outline btn-rounded btn-warning" >Anterior</button>
                        <button type="button" name="next" id="integradoresBtnStep3" class="next action-button btn btn-outline btn-rounded btn-warning" >Registrar</button>
                        
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