<!DOCTYPE html>
<html lang="eng">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/contratos.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Autorización para solicitar Reportes de Crédito Personas Morales</title>
</head>
<body>



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
@endphp
<header style="text-align: right">
    <img src="{{ $logo }}" class="img-responsive" style="max-width:220px;">
</header>

<p class="upper">
    MONTERREY, NUEVO LEÓN A {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
</p>

<h2 class="naranja">
    Autorización para solicitar Reportes de Crédito
    Personas Morales
</h2>

<p>
    <br><br>
    Por este conducto autorizo expresamente a <b>{{ @$solicitud->razon_social->razon_social }}</b> para que
    por conducto de sus funcionarios facultados lleve a cabo Investigaciones, sobre comportamiento e historial
    crediticio, así como de cualquier otra información de naturaleza análoga, en las Sociedades de Información
    Crediticia que estime conveniente.
</p>

<p>
    <br><br>
    Así mismo, declaro que conozco la naturaleza y alcance de la información que se solicitará, del uso que
    {{ @$solicitud->razon_social->razon_social }} hará de tal información y de que ésta podrá realizar
    consultas periódicas de mi historial crediticio, consintiendo que esta autorización se encuentre vigente por
    un período de 3 años contados a partir de la fecha de su expedición y en todo caso durante el tiempo en que 
    mantengamos una relación jurídica.
</p>

<p>
    <br><br>
    <b>Nombre del solicitante:</b> {{ $solicitud->cliente->nombre_empresa }}<br>
    <b>Dirección:</b> {{ @$solicitud->cliente->domicilio_empresa->calle  }} Ext:{{ @$solicitud->cliente->domicilio_empresa->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio_empresa->numero_int  }}
    Col. {{ @$solicitud->cliente->domicilio_empresa->colonia }}, {{ @$solicitud->cliente->domicilio_empresa->municipio->nombre }}, {{ @$solicitud->cliente->domicilio_empresa->estado->nombre }},
    C.P: {{ @$solicitud->cliente->domicilio_empresa->cp }}<br>
    <b>Fecha Consulta:</b>  {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }} <br>
</p>

<p>
    Estoy  consciente  y  acepto  que  este  documento  quede  bajo  propiedad  de  {{ @$solicitud->razon_social->razon_social }} para efectos de control y cumplimiento del artículo 28 de la Ley para Regular 
    a Las Sociedades de Información Crediticia.
</p>

<p>
    <br>
    <b>Folio de Consulta:</b> ____________________________________
</p>

<br><br><br><br>
<h4 style="text-align: center">FIRMA DEL SOLICITANTE</h4>
<hr style="width: 300px;margin-top: 90px">
<h4 style="text-align: center">
    {{ $solicitud->cliente->nombre_empresa }}
    <br><br>
    Representada en este acto por: {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}
</h4>
</body>
</html>