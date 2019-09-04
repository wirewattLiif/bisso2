@extends('layouts.app')

@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/jquery-wizard-master/dist/css/wizard.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Pre-aprobación del crédito</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="#" class="active">Home</a></li>--}}
            {{--</ol>--}}
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <input type="hidden" id="cliente_id" value="{{ \Illuminate\Support\Facades\Auth::user()->cliente->id }}" >
                <div class="example">
                        <ul class="row wizard-steps line-steps justify-content-md-center" role="tablist">
                            <li class="col-md start column-step" role="tab">
                                <div class="step-number">1</div>
                                <div class="step-title"></div>
                                <div class="step-info">Registro</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">2</div>
                                <div class="step-title"></div>
                                <div class="step-info">Datos personales</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">3</div>
                                <div class="step-title"></div>
                                <div class="step-info">Donde vives</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">4</div>
                                <div class="step-title"></div>
                                <div class="step-info">Donde trabajas</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">5</div>
                                <div class="step-title"></div>
                                <div class="step-info">Referencias</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">6</div>
                                <div class="step-title"></div>
                                <div class="step-info">Sistema Solar</div>
                            </li>
                            <li class="col-md column-step" role="tab">
                                <div class="step-number">7</div>
                                <div class="step-title"></div>
                                <div class="step-info">Pre-cotizar</div>
                            </li>
                            <li class="col-md column-step finish" role="tab">
                                <div class="step-number">8</div>
                                <div class="step-title"></div>
                                <div class="step-info">Historial crediticio</div>
                            </li>
                        </ul>

                        <div class="wizard-content">
                            <div class="wizard-pane active" role="tabpanel" id="step1" data-validator="validateStep1">@include('clientes.partials.aprobacion.step1')</div>
                            <div class="wizard-pane" role="tabpanel" id="step2" data-validator="validateStep2">@include('clientes.partials.aprobacion.step2')</div>
                            <div class="wizard-pane" role="tabpanel" id="step3" data-validator="validateStep3">@include('clientes.partials.aprobacion.step3')</div>
                            <div class="wizard-pane" role="tabpanel" id="step4" data-validator="validateStep4">@include('clientes.partials.aprobacion.step4')</div>
                            <div class="wizard-pane" role="tabpanel" id="step5" data-validator="validateStep5">@include('clientes.partials.aprobacion.step5')</div>
                            <div class="wizard-pane" role="tabpanel" id="step6" data-validator="validateStep6">@include('clientes.partials.aprobacion.step6')</div>
                            <div class="wizard-pane" role="tabpanel" id="step7" data-validator="validateStep7">@include('clientes.partials.aprobacion.step7')</div>
                            <div class="wizard-pane" role="tabpanel" id="step8" data-validator="validateStep8">@include('clientes.partials.aprobacion.step8')</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>

    <script src="{{ asset('app_layout/js/mask.js') }}"></script>
    <script>
        $(function(){
            var wizard = $('.example').wizard({
                step: '.wizard-steps > li',
                getPane: function(index, step) {
                    return this.$element.find('.wizard-content').children().eq(index);
                },
                theme:'simple',
                onNext:function (arg) {

                },
                onFinish:function(e){
                    console.log(e);
                    alert('fin');
                },
                buttonsAppendTo: 'this',
                templates: {
                    buttons: function() {
                        const options = this.options;
                        return `<div class="text-center">
                        <a class="btn btn-outline btn-rounded btn-warning" href="#${this.id}" data-wizard="back" role="button">${options.buttonLabels.back}</a>
                        <a class="btn btn-outline btn-rounded btn-warning" href="#${this.id}" data-wizard="next" role="button">${options.buttonLabels.next}</a>
                        <a class="btn btn-outline btn-rounded btn-warning" href="#${this.id}" data-wizard="finish" role="button">${options.buttonLabels.finish}</a>
                        </div>`;
                    }
                },
                classes: {
                    step: {
                        done: 'upcoming',
                        error: 'warning',
                        active: 'active',
                        disabled: 'disabled',
                        activing: 'activing',
                        loading: 'loading'
                    },
                    pane: {
                        active: 'active',
                        activing: 'activing'
                    }
                },
                buttonLabels: {
                    next: 'Siguiente >',
                    back: '< Anterior',
                    finish: 'Guardar'
                },
            });
        })

    </script>
@stop

