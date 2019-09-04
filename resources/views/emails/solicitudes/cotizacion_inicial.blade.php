@component('mail::message')

# ¡Hola!
<p>Este es el resultado de tu cotización</p>

<p>
    <b>Monto:</b> ${{ number_format($solicitud->monto_financiar,2) }}
</p>

<p>
    <b>Plazo:</b> {{ $solicitud->plazo_financiar }} meses
</p>

<p>
    <b>Mensualidad:</b> ${{ number_format($primer_mensualidad,2) }}
</p>

<p>
    Recuerda que es una simulación. Inicia una
    solicitud para descubrir el monto que te
    podemos prestar y obtener tu crédito para
    instalar paneles solares.
</p>


@component('mail::button', ['url' => config('app.url').'/check/'.$solicitud->cliente->id ])
    Iniciar solicitud
@endcomponent


@endcomponent
