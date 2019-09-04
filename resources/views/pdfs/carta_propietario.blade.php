<!DOCTYPE html>
<html lang="eng">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/contratos.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Carta Propietario</title>
</head>
<body>




    <header style="">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    MONTERREY, NUEVO LEÓN
                </td>
                <td style="text-align: right">
                    {{ \Carbon\Carbon::parse( date('Y-m-d') )->formatLocalized('%d de %B de %Y') }}
                </td>
            </tr>
        </table>

    </header>

    <h3 class="naranja center" style="font-size: 22px;">APÉNDICE I</h3>

    <p style="text-align: justify">
        <b>{{ @$solicitud->razon_social->razon_social }}</b><br>
        {{ @$solicitud->razon_social->calle }} #{{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Col. {{ @$solicitud->razon_social->colonia }} , {{ @$solicitud->razon_social->municipio->nombre }},
        {{ @$solicitud->razon_social->estado->nombre }}, C.P. {{ @$solicitud->razon_social->cp }}.
    </p>

    <p style="text-align: justify">
        El que suscribe <span class="upper">{{ $solicitud->cliente->rentero_nombre }}</span> en mi calidad de propietario
        del inmueble ubicado en

        @if( $solicitud->cliente->persona_tipo == 'moral')
            <span class="upper">{{ @$solicitud->cliente->domicilio_empresa->calle  }} Ext:{{ @$solicitud->cliente->domicilio_empresa->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio_empresa->numero_int  }}
            Col. {{ @$solicitud->cliente->domicilio_empresa->colonia }}, {{ @$solicitud->cliente->domicilio_empresa->municipio->nombre }}, {{ @$solicitud->cliente->domicilio_empresa->estado->nombre }}, 
            C.P: {{ @$solicitud->cliente->domicilio_empresa->cp }}</span>
        @else
            <span class="upper">{{ @$solicitud->cliente->domicilio->calle  }} Ext:{{ @$solicitud->cliente->domicilio->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio->numero_int  }}
                Col. {{ @$solicitud->cliente->domicilio->colonia }}, {{ @$solicitud->cliente->domicilio->municipio->nombre }}, {{ @$solicitud->cliente->domicilio->estado->nombre }}, 
                C.P: {{ @$solicitud->cliente->domicilio->cp }}</span>
        @endif

        , propiedad que acredito con copia de la boleta
        predial Folio No. ({{ $solicitud->cliente->rentero_folio_predial }}), por la presente autorizo a {{ @$solicitud->razon_social->razon_social }} a que lleve a cabo en este predio la
        instalación del sistema fotovoltaico descrito en, el Contrato de Arrendamiento Financiero Numero de
        Folio: {{ $solicitud->folio }} , documento anexo a este comunicado y manifiesto que estoy de acuerdo en que
        dicho sistema no podrá ser considerado como accesión de este inmueble por lo que renuncio a los
        beneficios de los artículos 892 y 898 del código civil del estado de Nuevo León, de igual forma para
        el caso en que {{ @$solicitud->razon_social->razon_social }}, requiera retirar el sistema fotovoltaico instalado en mi propiedad otorgo desde este
        momento mi autorización al respecto.
    </p>

    <br><br><br>
    <h3 style="text-align: center">Atentamente</h3>
    <hr style="width: 300px;margin-top: 100px">
    <p style="text-align: center;width: 350px;margin: 0 auto;font-weight: bold" class="upper">
        {{ $solicitud->cliente->rentero_nombre }}.
    </p>
</body>
</html>