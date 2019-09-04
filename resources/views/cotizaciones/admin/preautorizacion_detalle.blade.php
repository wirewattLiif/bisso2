@extends('layouts.app')

@section('extra-css')
@endsection


@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/integrador/cotizaciones" class="btn btn-default2 btn-rounded">Cotizaciones</a>
            <h4 class="page-title d-inline ml-3">Preautorizar</h4>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-3">
            <h5>Integrador</h5>
            <p>{{ $detalle->cotizacion->integrador->user->nombre }}</p>
        </div>
        
        <div class="col-md-3">
            <h5>Precio de Lista a Facturar (con IVAs)</h5>
            <p>${{ number_format($detalle->precio_lista,2)}}</p>
        </div>

        <div class="col-md-3">
            <h5>Pago inicial</h5>
            <p>${{ number_format($detalle->pago_inicial,2)}}</p>
        </div>



        <div class="col-md-3">
            <h5>Precio del sistema (con IVA)</h5>
            <p>${{ number_format($detalle->monto_solicitado,2)}}</p>
        </div>

        <div class="col-md-3">
            <h5>Anticipo / Enganche(con IVA)</h5>
            <p>${{ number_format($detalle->enganche,2)}}</p>
        </div>        

        <div class="col-md-3">
            <h5>Monto a financiar(con IVA)</h5>
            <p>${{ number_format($detalle->monto_financiar,2)}}</p>
        </div>

        <div class="col-md-3">
            <h5>Ingreso mensual</h5>
            <p>${{ number_format($detalle->cotizacion->aplicante->salario_mensual,2) }}</p>
        </div>





        <div class="col-md-3" >
            <h5>FICO Score</h5>
            <p>
                {{ $detalle->cotizacion->aplicante->fico_score }}
            </p>
        </div>

        <div class="col-md-3" >
            <h5>Deuda mensual</h5>
            <p>
                ${{ number_format($detalle->cotizacion->aplicante->deuda_mensual,2) }}
            </p>
        </div>

        <div class="col-md-3" >
            <h5>Comisión integrador</h5>
            <p>
                ${{ number_format(( 1.16*($detalle->monto_financiar * ($detalle->plan->merchant_fee / 100))    ),2) }}
            </p>
        </div>

        <div class="col-md-3" >
            <h5>Comisión por apertura</h5>
            <p>
                ${{ number_format(( 1.16*($detalle->monto_financiar * ($detalle->plan->comision_por_apertura / 100))  ),2) }}
            </p>
        </div>


        <div class="col-md-3" >
            <h5>INE (frente)</h5>
            <p>
                @if (!empty($detalle->cotizacion->aplicante->ine_file))
                    <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'aplicante','ine']) }}">{{ $detalle->cotizacion->aplicante->ine_file  }}</a>
                @endif
            </p>
        </div>

        <div class="col-md-3" >
            <h5>INE (atras)</h5>
            <p>
                @if (!empty($detalle->cotizacion->aplicante->ine_atras_file))
                    <a  href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'aplicante','ine_atras']) }}">{{ $detalle->cotizacion->aplicante->ine_atras_file  }}</a>
                @endif                
            </p>
        </div>
    
        <div class="col-md-3" >
            <h5>Hoja buro</h5>
            <p>
                @if (!empty($detalle->cotizacion->aplicante->hoja_buro_file))
                    <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'aplicante','hoja_buro']) }}">{{ $detalle->cotizacion->aplicante->hoja_buro_file  }}</a>
                @endif
            </p>
        </div>

        <div class="col-md-3" >
            <h5>Foto cliente buro</h5>
            <p>
                @if (!empty($detalle->cotizacion->aplicante->foto_buro_file))
                    <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'aplicante','foto_buro_file']) }}">{{ $detalle->cotizacion->aplicante->foto_buro_file  }}</a>
                @endif
            </p>
        </div>


        @if ($detalle->cotizacion->requiere_coaplicante)
            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-3" >
                <h5>INE (frente) Co-aplicante</h5>
                <p>
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->ine_file))
                        <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'co_aplicante','ine']) }}">{{ $detalle->cotizacion->aplicante->obligado_solidario->ine_file  }}</a>
                    @endif
                </p>
            </div>

            <div class="col-md-3" >
                <h5>INE (atras) Co-aplicante</h5>
                <p>
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->ine_atras_file))
                        <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'co_aplicante','ine_atras_file']) }}">{{ $detalle->cotizacion->aplicante->obligado_solidario->ine_atras_file }}</a>
                    @endif
                </p>
            </div>
        
            <div class="col-md-3" >
                <h5>Hoja buro Co-aplicante</h5>
                <p>
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->hoja_buro_file))
                        <a href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'co_aplicante','hoja_buro']) }}">{{ $detalle->cotizacion->aplicante->obligado_solidario->hoja_buro_file  }}</a>
                    @endif
                </p>
            </div>

            <div class="col-md-3" >
                <h5>Foto buro Co-aplicante</h5>
                <p>
                    @if (!empty($detalle->cotizacion->aplicante->obligado_solidario->foto_buro_file))
                        <a  href="{{ route('admin.attach_file_dotizacion',[$detalle->id, 'co_aplicante','foto_buro_file']) }}">{{ $detalle->cotizacion->aplicante->obligado_solidario->foto_buro_file }}</a>
                    @endif
                </p>
            </div>
        @endif

        <div class="col-md-12">
            <hr>
        </div>

        <div class="col-md-9" >
            <h5>Motivo rechazo de la cotización</h5>
            <p>
                {{ $detalle->msj_error_ws }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>        

        
        <div class="col-md-6">
            <h5>Tasa</h5>
            <p>{{ $detalle->plan->interes_anual}}% anual</p>
        </div>
        <div class="col-md-6">
            <h5>Plazo</h5>
            <p>{{ $detalle->plan->plazo}} meses</p>
        </div>
        <div class="col-md-6">
            <h5>Pago mensual</h5>
            <p>${{ number_format($detalle->mensualidad,2)}}</p>
        </div>        
        <div class="col-md-6">
            <h5>Solicitante</h5>
            <p>
                {{ @$detalle->cotizacion->aplicante->nombre .' '. @$detalle->cotizacion->aplicante->apellido_paterno .' '. @$detalle->cotizacion->aplicante->apellido_materno  }}
            </p>
        </div>

        @if ($detalle->cotizacion->requiere_coaplicante)
            <div class="col-md-6">
                <h5>Aval</h5>
                <p>
                    {{ @$detalle->cotizacion->aplicante->obligado_solidario->nombre .' '. @$detalle->cotizacion->aplicante->obligado_solidario->apellido_paterno .' '. @$detalle->cotizacion->aplicante->obligado_solidario->apellido_materno  }}
                </p>
            </div>
        @endif

        <div class="col-md-6">
            <h5>Fecha Preautorización</h5>
            <p>{{ $detalle->fecha_preautorizacion}}</p>
        </div>        
    </div>

    

    <div class="row">        
        <div class="col-md-2">
            {!! Form::open(['method' => 'POST','url'=>route('admin.preautorizacion_autorizar',$detalle->id),'id'=>'formAutorizar']) !!}
                <button id="btnAutorizar" type="button" class="btn btn-success">Preautorizar cotización </button>
                <input type="hidden" name="detalle_id" value="{{ $detalle->id }}">
            {!! Form::close() !!}
        </div>        
    </div>
@endsection


@section('extra-js')
<script>
    $(function(){
        $('#btnAutorizar').click(function(){
            if(confirm("¿Seguro preautorizar la cotización de forma manual?")){
                $('#formAutorizar').submit();
            }
        })  
    })    
</script>
@endsection