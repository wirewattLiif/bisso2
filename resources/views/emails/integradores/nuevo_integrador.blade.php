@component('mail::message')

<h1>Nuevo integrador registrado: {{ $integrador->user->nombre }}</h1>

@component('mail::button', ['url' => config('app.url').'/admin/integradores/'.$integrador->id])
Detalle
@endcomponent

@endcomponent