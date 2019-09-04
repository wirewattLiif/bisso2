@component('mail::message')
# Bienvenido {{ $cliente->nombre  }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}


<p>
    Gracias por confiar en nosotros. Estamos muy
    felices por trabajar contigo y apoyarte con el
    dinero que necesitas para adquirir paneles
    solares y ahorrar dinero.
    <br><br>
    En Wirewatt olvídate del proceso tradicional de
    crédito.
    <br><br>
    <b>Ahorra tiempo:</b> Completar tu solicitud con
    nosotros te tomará minutos, con el proceso
    tradicional te puede tomar meses.
    <br><br>
    <b>Arma tu crédito:</b> Elige hasta $500,000 a plazos
    de 3 a 60 meses. La tasa y los beneficios
    dependen de tus ingresos y tu historial de
    crédito.
    <br><br>
    Para continuar con la aplicación es necesario
    validar tu email dándole clic al siguiente link.
</p>

@component('mail::button', ['url' => '#'])
Validar Email
@endcomponent


@endcomponent
