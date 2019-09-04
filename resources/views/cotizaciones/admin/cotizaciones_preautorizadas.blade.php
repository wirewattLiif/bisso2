@extends('layouts.app')

@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <br>
        </div>
    </div>
@stop

@section('content')
    
    <div class="row">
        <h2 class="col-md-6">Cotizaciones por preautorizar</h2>
    </div>
    

    <div class="row">
        <div class="col-md-12">
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Prestamo Solicitado</th>
                        <th>Plan</th>
                        <th>Plazo</th>
                        <th>FICO</th>
                        <th>Deuda mensual</th>
                        <th>Estatus</th>
                        <th>Fecha Cotización</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizaciones as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->cotizacion->titulo }}</td>
                            <td>${{ number_format($c->monto_solicitado,2) }}</td>
                            <td>{{ $c->plan->nombre }}</td>
                            <td>{{ $c->plazo_financiar }} meses</td>
                            <td>{{ @$c->cotizacion->aplicante->fico_score }}</td>
                            <td>${{ number_format(@$c->cotizacion->aplicante->deuda_mensual,2) }}</td>
                            <td>{{ $c->estatus->nombre }}</td>
                            <td>{{ $c->cotizacion->created_at }}</td>
                            <td>
                                @if ($c->estatus_id == 1)
                                    <a href="{{ route("admin.preautorizacion_detalle",$c->id) }}">Ver</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop
