@component('mail::message')
# ¡Felicidades {{ $solicitud->cliente->nombre }}, tu solicitud ha sido preautorizada!


Haz sido pre-aprobado para un crédito de:
<br><br>

<b>Monto:</b> ${{ number_format($solicitud->monto_financiar,2) }}<br>
<b>Plazo:</b> {{ $solicitud->plazo_financiar }} meses<br>
<b>Mensualidad:</b> ${{ number_format($periodos[1]['subtotal'],2) }}<br>
<b>Inicio:</b>  {{ date('d-m-Y',strtotime($solicitud->created_at))  }} <br>

<br><br>
Una de nuestras analistas se pondrá en
contacto contigo para explicarte las
condiciones de tu préstamo y completar tu
información. Ten a la mano:
<br><br>
<b>Documentos personales:</b> Identificación oficial,
comprobante de domicilio, comprobante de
ingresos, predial
<br><br>
<b>Documentos técnicos:</b> Cotización del
instalador y análisis técnico del instalador
<br><br>
<b>Documentos obligado solidario:</b> Identificación
oficial, autorización para revisar en buró,
comprobante de domicilio
<br><br>
<b>Documentos rentero:</b> Identificación oficial,
predial o contrato de arrendamiento

@component('mail::button', ['url' => config('app.url').'/carga_documentos/'.$solicitud->id])
    Cargar Documentos
@endcomponent

@endcomponent
