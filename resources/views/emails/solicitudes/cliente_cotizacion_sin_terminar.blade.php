@component('mail::message')
    # ¡Hola {{ $cliente->nombre  }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }} !

<p>
    Al parecer haz abandonado tu aplicación sin
    completarla. Sólo necesitamos tu información
    para poder continuar. Completar la aplicación
    es muy importante para poder personalizar tu
    préstamo. Termina tu solicitud ahora y recibe
    una respuesta inmediata.
</p>

@component('mail::button', ['url' => '#'])
Completa la aplicación
@endcomponent


@endcomponent
