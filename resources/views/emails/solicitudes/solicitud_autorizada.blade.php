@component('mail::message')
# ¡Hola {{ $solicitud->cliente->nombre }}! Haz pasado a la última etapa!

Sigue los siguientes tres pasos y el crédito es
tuyo:
<br><br>
Paso 1: Descargar y firmar contrato
Descarga el contrato <a href="{{ config('app.url') }}/solicitudes">AQUÍ</a>, imprímelo y
fírmalo.
<br><br>
Paso 2: Escanear y subir contrato a plataforma
Escanea los documentos y súbelos desde tu
computadora <a href="{{ config('app.url') }}/carga_documentos_firmados/{{ $solicitud->id }}">AQUÍ</a>.
<br><br>
Paso 3: Recoger contrato en tu domicilio
Un analista se pondrá en contacto contigo para
coordinar la recolección de los documentos en
tu domicilio.
<br><br>
Al terminar estos pasos nos pondremos en
contacto con


@endcomponent
