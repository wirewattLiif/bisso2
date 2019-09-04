<!DOCTYPE html>
<html lang="eng">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/contratos.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Pagaré</title>
</head>
<body>
<script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("helvetica", "bold");
        $pdf->page_text(300, 765, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script>


<h3 class="naranja center" style="font-size: 22px;">PAGARÉ</h3>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                    @php
                        #$div_decimales = explode('.',$periodos['suma_amortizaciones']);
                        $div_decimales = explode('.',number_format($periodos['suma_amortizaciones'],2,'.',''));

                        $total_letras = NumeroALetras::convertir($div_decimales[0]);
                        $total_centavos = (isset($div_decimales[1]))?$div_decimales[1]:'00';
                    @endphp

                <p class="center" style="text-align:center;font-size: 14px;">
                        ${{ number_format($periodos['suma_amortizaciones'],2) }}
                        <br>
                        ({{ $total_letras }} PESOS {{ $total_centavos }}/100  Moneda Nacional)
                    </p>
                </td>
            </tr>
            <tr>
            <p style="text-align: justify">
                    @php
                        $fecha = $periodos[ (count($periodos) -1 )]['fecha_pago'];
                        $fecha = \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y');
                @endphp
                <b>POR VALOR RECIBIDO</b>, el suscrito: <b class="upper">{{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</b> (el <span class="underline">“Suscriptor”</span>),
                por medio de este pagaré (el <span class="underline">“Pagaré”</span>) promete pagar incondicionalmente a la orden de <b class="underline">{{ @$solicitud->razon_social->razon_social }}</b> (el <span class="underline">“Tenedor”</span>), la
                suma principal de <b>${{ number_format($periodos['suma_amortizaciones'],2) }}</b> (

                <b>({{ $total_letras }} PESOS {{ $total_centavos }}/100  Moneda Nacional)</b>

                ya con el Impuesto al Valor Agregado correspondiente (el <span class="underline">“Principal”</span>) pagadera a más
                tardar el día <b>{{  $fecha }}</b> (la <span class="underline">“Fecha de Vencimiento”</span>), mediante
                {{ count($periodos) -1 }} ({{ NumeroALetras::convertir((count($periodos) -1))}}) amortizaciones
                mensuales y consecutivas (cada una, un <span class="underline">“Monto de Amortización en Pesos”</span>) en cada fecha de pago indicada en la
                tabla de amortizaciones a continuación (cada una, una <span class="underline">“Fecha de Pago”</span>) en el domicilio del Tenedor ubicado en

                {{ @$solicitud->razon_social->calle }} #{{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Col. {{ @$solicitud->razon_social->colonia }} , {{ @$solicitud->razon_social->municipio->nombre }},
                {{ @$solicitud->razon_social->estado->nombre }}, C.P. {{ @$solicitud->razon_social->cp }},
                por los Montos de Amortización en Pesos y en cada Fecha de Pago que se indican a
                continuación (las <span class="underline">“Amortizaciones”</span>):
                <br>
            </p>
        </tr>
    </table>

    @php
        unset( $periodos['suma_amortizaciones']);
    @endphp
    <table width="100%" class="periodos">
        <tr>
            <th>Número de Amortización</th>
            <th>Monto de Amortización en Pesos</th>
            <th>Fecha de Pago</th>
        </tr>
        @foreach($periodos as $k => $periodo)
            <tr>
                <td>{{ $k }}</td>
                <td style="text-align: center">${{ number_format($periodo['subtotal'],2) }}</td>
                <td style="text-align: right;text-transform: capitalize">{{ \Carbon\Carbon::parse($periodo['fecha_pago'])->formatLocalized('%d de %B de %Y')  }}</td>
            </tr>
        @endforeach
    </table>

    <p style="text-align: justify">
        El Suscriptor se obliga a pagar intereses moratorios sobre el Principal vencido y no pagado, mismos que se
        generarán desde el día siguiente de cada Fecha de Pago, hasta el día en que dicho Principal vencido y no pagado
        quede totalmente pagado, a razón de una tasa anual del {{ @$solicitud->razon_social->interes_moratorio }}% ({{ NumeroALetras::convertir(@$solicitud->razon_social->interes_moratorio) }} por ciento) (los <span class="underline">“Intereses Moratorios”</span>).
        Los Intereses Moratorios se calcularán en base a un año de 360 (trescientos sesenta) días y deberán ser pagados en
        cada Fecha de Pago correspondiente a cada Monto de Amortización en Pesos y sus accesorios.
        <br><br>
        Cada Monto de Amortización en Pesos que deba hacerse conforme a este Pagaré será efectuado sin necesidad de
        requerimiento previo, antes de las 14:00 horas (hora de la Ciudad de Monterrey, Nuevo León, México) de la
        Fecha de Pago, en Pesos, moneda en curso legal en los Estados Unidos Mexicanos (<span class="underline">“Pesos”</span>), en fondos
        inmediatamente disponibles, en el domicilio ubicado en
        {{ @$solicitud->razon_social->calle }} número {{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Colonia {{ @$solicitud->razon_social->colonia }}, {{ @$solicitud->razon_social->municipio->nombre }}, {{ @$solicitud->razon_social->estado->nombre }}, Código Postal {{ @$solicitud->razon_social->estado->nombre }},
        libre de cualquier impuesto, carga, gravamen,
        imposición, derecho, deducción o retención impuesta por cualquier autoridad de la jurisdicción a través de la cual
        el Suscriptor deba hacer un pago de Principal o cubrir un Monto de Amortización en Pesos conforme a este
        Pagaré.
        <br><br>
        En cualquier caso en que el pago de Principal conforme al presente sea debido en un día distinto a un Día Hábil,
        dicho pago será exigible y pagadero en el Día Hábil siguiente.
        <br><br>
        Según se utiliza en este Pagaré, el término <span class="underline">“Día Hábil”</span> significa cualquier día que no sea (a) un sábado o domingo,
        o (b) un día en que las instituciones de crédito estén autorizadas u obligadas a cerrar en la Ciudad de México, de
        conformidad con las disposiciones aplicables emitidas por la Comisión Nacional Bancaria y de Valores.
        <br><br>
        El importe Principal de este Pagaré y los intereses sobre el mismo serán pagados por el Suscriptor libres y sin
        deducción alguna por concepto de cualesquiera impuestos, tributos, contribuciones, deducciones, cargos,
        retenciones, cualesquiera intereses, recargos, multas, sanciones y otros gravámenes fiscales presentes o futuros de
        cualquier clase respecto de los mismos.
        <br><br>
        Este Pagaré se considerará suscrito conforme y de acuerdo a las disposiciones establecidas en la Ley General de
        Títulos y Operaciones de Crédito vigente en los Estados Unidos Mexicanos, y para todos los efectos se
        interpretará de conformidad con dicha Ley.
        <br><br>
        La aceptación por parte del Tenedor para recibir pagos subsecuentes a la Fecha de Pago correspondiente de
        conformidad con el presente Pagaré, así como la aceptación del Tenedor de recibir pagos parciales del importe e
        intereses acumulados, no implica novación de las obligaciones a cargo del Suscriptor especificadas en el presente
        Pagaré, ni renuncia por parte del Tenedor de los derechos a su favor que derivan del mismo, ni de las acciones
        judiciales que procedan y a que tenga derecho por la falta de pago oportuno del importe de este Pagaré y de sus
        intereses, y por lo tanto, el Suscriptor está consciente y acepta que el Tenedor pueda en cualquier momento iniciar
        en su contra las acciones, mediante los procedimientos o juicios que sean necesarios para obtener el pago del
        importe del presente Pagaré y sus intereses.
        <br><br>
        El Suscriptor, en forma expresa, desde ahora autoriza al Tenedor o a cualquier tenedor subsecuente para que: (i)
        endose, transmita, descuente, transfiera, ceda, negocie, afecte y grave este Pagaré y los derechos de crédito que en
        el mismo se amparan, en cualquier tiempo y lugar, sirviendo el presente como la más amplia y necesaria
        autorización del Suscriptor al respecto, y (ii) en caso de que el Suscriptor omita pagar cualquiera de los Montos de
        Amortización en Pesos, en la Fecha de Pago de que se trate, pueda dar válidamente por vencido anticipadamente
        el plazo establecido en el presente Pagaré y, por lo tanto, el Suscriptor estará obligado a pagar al Tenedor, el saldo
        insoluto de Principal pendiente de pago.
        <br><br>
        El presente Pagaré ha sido celebrado bajo y será interpretado y ejercitado de acuerdo con las leyes de los Estados
        Unidos Mexicanos, sin importar los conflictos de leyes que pudiesen surgir debido a la nacionalidad o domicilios
        de las partes. Para cualquier acción o procedimiento derivado de o relativo al presente Pagaré, el Suscriptor, se
        somete expresamente a la jurisdicción de los tribunales competentes de la Ciudad de Monterrey, Nuevo León, y
        renuncia expresamente por lo tanto, a cualquier otra jurisdicción a la que pudiera tener derecho, incluyendo pero
        no limitado a, jurisdicción por razón de su domicilio presente o futuro o por razón del lugar de pago de este
        Pagaré o por cualquier otra razón.
        <br><br>
        Por el presente Pagaré, el Suscriptor renuncia a cualquier diligencia de presentación, requerimiento, protesto y a
        toda notificación en relación con este Pagaré.
        <br><br>
        La omisión en el ejercicio por el Tenedor del presente de cualquiera de sus derechos conforme al mismo en
        cualquier instancia, no constituirá una renuncia a tales derechos en dicha o en cualquier otra instancia.
        <br><br>
        El Suscriptor por medio del presente Pagaré, promete incondicionalmente pagar los gastos que implique el cobro
        de este Pagaré y los honorarios de los abogados que intervengan en el mismo cobro en caso de que haya
        incumplimiento de pago de este Pagaré.

        <br><br>
        Este Pagaré se suscribe en la Ciudad de Monterrey, Estado de Nuevo León, Estados Unidos Mexicanos, el día {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
    </p>



    <h3 class="upper" style="text-align: center">El suscriptor</h3>
    <hr style="width: 300px;margin-top: 120px">
    <p style="text-align: center;width: 350px;margin: 0 auto;font-weight: bold" class="upper">
        {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}
        <br>
        Domicilio: {{ $solicitud->cliente->domicilio->calle  }} Ext:{{ $solicitud->cliente->domicilio->numero_ext  }} Int:{{ $solicitud->cliente->domicilio->numero_int  }}
        Col. {{ $solicitud->cliente->domicilio->colonia }}, {{ $solicitud->cliente->domicilio->municipio->nombre }}, {{ $solicitud->cliente->domicilio->estado->nombre }}, 
        C.P: {{ $solicitud->cliente->domicilio->cp }}
    </p>

    </body>
</html>