@extends('layouts.app')


@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <h4 class="page-title d-inline">Configuraciones</h4>
        </div>
    </div>
@endsection


@section('content')

    <form action="/admin/configuraciones" method="post">
        <div class="row">
        @csrf
        <div class="col-md-4">
            <p>Porcentaje de interes anual</p>
            <div class="input-group">
                <input type="text" placeholder="" name="interes_anual" value="{{ $configs->interes_anual }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>IVA</p>
            <div class="input-group">
                <input type="text" placeholder="" name="iva" value="{{ $configs->iva }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Porcentaje de descuento con opción a compra</p>
            <div class="input-group">
                <input type="text" placeholder="" name="descuento_opcion_compra" value="{{ $configs->descuento_opcion_compra }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Porcentaje de pago valor residual</p>
            <div class="input-group">
                <input type="text" placeholder="" name="porcentaje_pago_valor_residual" value="{{ $configs->porcentaje_pago_valor_residual }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Porcentaje de escalador</p>
            <div class="input-group">
                <input type="text" placeholder="" name="escalador" value="{{ $configs->escalador }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Porcentaje de comisión por apertura</p>
            <div class="input-group">
                <input type="text" placeholder="" name="comision_por_apertura" value="{{ $configs->comision_por_apertura }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Monto mínimo a financiar</p>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">$</span>
                <input type="text" placeholder="" name="monto_min_financiar" value="{{ $configs->monto_min_financiar }}" class="input_underline form-control">
            </div>
        </div>

        <div class="col-md-4">
            <p>Interes ordinario</p>
            <div class="input-group">
                <input type="text" placeholder="" name="interes_ordinario" value="{{ $configs->interes_ordinario }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-4">
            <p>Interes moratorio</p>
            <div class="input-group">
                <input type="text" placeholder="" name="interes_moratorio" value="{{ $configs->interes_moratorio }}" class="input_underline form-control">
                <span class="input-group-addon" id="basic-addon1">%</span>
            </div>
        </div>

        <div class="col-md-12">
            <br><br>
            <button class="btn btn-success">Guardar</button>
        </div>

    </div>
    </form>
@endsection