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
        <h2 class="col-md-6">Cotizaciones</h2>

        <div class="col-md-6">
            <a href="{{ route('integrador.cotizador') }}" class="btn btn-success btn-outline pull-right">(+) Agregar</a>
        </div>
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
                            <td>{{ $c->monto_solicitado }}</td>
                            <td>{{ $c->plan->nombre }}</td>
                            <td>{{ $c->plazo_financiar }} meses</td>
                            <td>{{ $c->estatus->nombre }}</td>
                            <td>{{ $c->cotizacion->created_at }}</td>
                            <td>
                                @if ($c->estatus_id == 2)
                                    <a href="{{ route("integrador.preautorizacion_detalle",$c->id) }}">Ver</a>
                                @elseif( $c->estatus_id == 3 and $c->solicitud()->exists())
                                    <a href="{{ route("integrador.showSolicitudCotizacion",$c->solicitud->id) }}">Solicitud</a>
                                @else
                                    <a href="{{ route("integrador.cotizador",$c->cotizacion_id) }}">Ver</a>                                        
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop
