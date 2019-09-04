<!DOCTYPE html>
<html lang="eng">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/contratos.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Cotización de Financiamiento</title>
</head>
<style>

    @page {
        margin: 70px 25px 60px;
    }

</style>
<body>
    <div>


    </div>


    @php
        $logo_path = public_path('img/logo_gris.png');
        $type = pathinfo($logo_path , PATHINFO_EXTENSION);
        $context = [
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    ];
        $data = file_get_contents($logo_path);
        $encode_data = base64_encode($data);
        $logo = 'data:image/'.$type.";base64,".$encode_data;

        unset($periodos['suma_amortizaciones']);
    @endphp
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img src="{{ $logo }}" class="img-responsive" style="max-width:220px;">
            </td>
            <td>
                <p style="text-align: right">Fecha de Cotización: {{ date('d-m-Y') }}</p>
                <p style="text-align: right">Folio: {{   ($solicitud->cliente->registro_completo)?$solicitud->folio:$solicitud->id     }}</p>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td width="65%">
                <h3>Plan de Luz Wirewatt</h3>
                <h5>Cliente: {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</h5>
                @if($solicitud->cliente->registro_completo)
                    <h5>Tipo de Cliente: Persona {{ $solicitud->cliente->persona_tipo }}</h5>
                @endif

                <h5>Plan: {{ (!is_null($solicitud->plan_id))?$solicitud->plan->nombre:'Custom' }}</h5>
            </td>
        </tr>
        <tr>
            <td></td>
            <td width="65%">
                <h5 class="naranja">Descripción del Financiamiento</h5>
                <table width="100%">
                    <tr>
                        <td width="50%"><h5>Comisión por apertura <span>${{ number_format(@$comision_por_apertura,2) }}</span></h5></td>
                        <td><h5>Costo anual del seguro <span>$ {{ number_format(@$costo_anual_seguro,2) }}</span></h5></td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="50%"><h5>Pago Inicial ${{ number_format(@$pago_inicial,2) }}</h5></td>
                        <td><h5>Plazo {{ $solicitud->plazo_financiar }} meses</h5></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td width="65%">
                <h5 class="naranja">Detalle de Cotización</h5>
                <h5>(+) Precio del Sistema FV. <span>${{ number_format($solicitud->precio_sistema,2) }}</span></h5>
                <h5>(-) Enganche <span>${{ number_format($solicitud->enganche,2) }}</span></h5>

                <table width="100%">
                    <tr>
                        <td width="50%"><h5>Total a financiar<span>${{ number_format($solicitud->monto_financiar,2) }}</span></h5></td>
                        <td><h5>Primer Mensualidad<span> ${{ number_format($periodos[1]['subtotal'],2) }}</span></h5></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>


    <table width="100%" style="margin-top:50px" class="periodos">
        <tr >
            <th style="padding-bottom:10px;">Pago No.</th>
            <th style="padding-bottom:10px;">Fecha de Pago</th>
            <th style="padding-bottom:10px;">Pago Mensual a <br>Capital</th>
            <th style="padding-bottom:10px;">Pago Mensual <br> Interés</th>
            <th style="padding-bottom:10px;">Pago Mensual <br> IVA interés</th>
            <th style="padding-bottom:10px;">Pago Total  <br>Mensual</th>
        </tr>
        @foreach($periodos as $k => $periodo)
            <tr>
                <td>{{ $k }}</td>
                <td>{{ $periodo['fecha_pago'] }}</td>
                <td>${{ number_format($periodo['pago_mensual_a_capital'],2) }}</td>
                <td>${{ number_format($periodo['pago_mensual_a_interes'],2) }}</td>
                <td>${{ number_format($periodo['pago_mensual_IVA_interes'],2) }}</td>
                <td>${{ number_format($periodo['subtotal'],2) }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>