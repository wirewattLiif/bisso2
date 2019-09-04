<!DOCTYPE html>
<html lang="eng">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/contratos.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/fav.ico') }}">
    <title>Contrato</title>
</head>
<body id="contrato">

<script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("helvetica", "bold");
        $pdf->page_text(300, 765, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script>
<style>
    .page-break {
        page-break-after: always;
    }
</style>

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
<header style="text-align: right;">
    <img src="{{ $logo }}" class="img-responsive" style="max-width:220px;">
    <p style="margin-right: 20px;margin-top: -2px;text-align: right">Contrato No. Folio: {{ $solicitud->folio }}</p>
</header>

    <table class="tbl_contrato" style="margin-top: 25px;">
        <tr>
            <td width="100%" colspan="4">
                <b>Nombre comercial del Producto:</b>
                ARRENDAMIENTO FINANCIERO PF-R
            </td>

        </tr>
        <tr>
            <td colspan="4">
                <b>Tipo de Crédito:</b>
                ARRENDAMIENTO FINANCIERO
            </td>
        </tr>
        <tr >
            <td width="33%" style="border-top:1px solid black ;" class="center"> <b>CAT (Costo Anual Total) </b></td>
            <td width="33%"> <b> TASA DE INTERÉS ANUAL ORDINARIA <br>Y MORATORIA</b> </td>
            <td width="33%"> <b>MONTO O LINEA DE CREDITO</b> </td>
            <td width="33%"> <b>MONTO TOTAL A PAGAR (IVA INCLUIDO)</b> </td>
        </tr>
        <tr>
            <td width="33%">
                NO APLICA
                Sin IVA Para fines informativos y de comparación
            </td>
            <td width="33%">
                Tasa Ordinaria: {{ $interes_anual }}%<br>
                Tasa Moratoria: {{ @$solicitud->razon_social->interes_moratorio }}%
            </td>
            <td width="33%">
                ${{ number_format($solicitud->monto_financiar,2) }} PESOS 00/100 MN
            </td>
            <td width="33%">
                ${{ number_format($periodos['suma_amortizaciones'],2) }} PESOS 00/100 MN
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center">
                <b>Plazo:</b>

                {{ count($periodos) - 1 }} meses
            </td>
            <td>
                <b>Fecha de Corte:</b>
                El día {{ date('d',strtotime($periodos[1]['fecha_pago'])) }} de cada mes estipulado en la Tabla de Pagos Parciales
            </td>
            <td>
                <b>Fecha límite de pago:</b>
                Es la misma que la Fecha de Corte
            </td>
        </tr>
        <tr>
            <td colspan="4" class="center">
                <b>COMISIONES RELEVANTES</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <ul style="margin-left: 20px">
                    <li>Comisión por Apertura: ${{ number_format($comision_por_apertura,2) }} + IVA MXN ({{ $solicitud->porcentaje_comision_por_apertura }}% del monto a financiar). De acuerdo a la Cláusula Quinta y  <span class="underline">Anexo “A”</span> del Contrato.</li>
                    <li>Prima Anual de Seguro: ${{ number_format($costo_anual_seguro,2) }}+ IVA MXN</li>
                    <li>Pago Inicial: ${{ number_format($pago_inicial,2) }} + IVA MXN. Incluye Comisión por Apertura y Gastos de Seguros.</li>
                </ul>
            </td>
            <td colspan="2">
                Gastos Administrativos: ${{ number_format(@$solicitud->razon_social->gastos_administrativos,2) }} + IVA MXN. De acuerdo a la Cláusula Quinta y <span> <span class="underline">Anexo “A”</span></span> del Contrato.

            </td>
        </tr>
        <tr>
            <td colspan="4" >
                <b>LEYENDAS</b><br>
                <ol type="a">
                    <li>"Incumplir tus obligaciones te puede generar comisiones e intereses moratorios".</li>
                    <li>"Contratar créditos por arriba de tu capacidad de pago puede afectar tu historial crediticio".</li>
                    <li>"El Obligado solidario, Avalista o Coacreditado responderá como obligado principal frente a la Arrendadora".</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="center">
                <b>SEGUROS</b>
            </td>
        </tr>
    </table>

    <table class="tbl_contrato" width="100%">
        <tr>
            <td>
                Seguro: OBLIGATORIO
            </td>
            <td>
                Aseguradora: PRIMERO SEGUROS
            </td>
            <td>
                Cláusula: DÉCIMA SEGUNDA
            </td>
        </tr>
        <tr>
            <td>
                <b>PERIODICIDAD</b>
            </td>
            <td>
                <b>NUMERO DE PARCIALIDADES</b>
            </td>
            <td>
                <b>MONTO PROMEDIO DE LA PARCIALIDAD</b>
            </td>
        </tr>
        <tr>
            <td class="center">
                Mensual
            </td>
            <td class="center">
                {{ count($periodos) - 1 }}
            </td>
            <td class="center">
                ${{ number_format($periodos[1]['subtotal'],2) }}
            </td>
        </tr>
        <tr>
            <td colspan="3" class="center">
                <b>ESTADO DE CUENTA</b>
            </td>
        </tr>
        <tr>
            <td>
                Envío a domicilio: No
            </td>
            <td>
                Consulta: via internet: Sí
            </td>
            <td>
                Envío por correo electrónico: Sí
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Aclaraciones y reclamaciones:</b><br>
                Unidad Especializada de Atención a Usuarios: <br>
                Domicilio: <b>{{ @$solicitud->razon_social->calle }} #{{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Colonia {{ @$solicitud->razon_social->colonia }}, {{ @$solicitud->razon_social->municipio->nombre }}, {{ @$solicitud->razon_social->estado->nombre }}, C.P, {{ @$solicitud->razon_social->cp }}</b><br>
                Teléfono: <b>{{ @$solicitud->razon_social->telefono }}</b>, Correo electrónico: <b>{{ @$solicitud->razon_social->correo }}</b>, Página web: <b>{{ @$solicitud->razon_social->web }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Lugar y Fecha:</b> Monterrey, Nuevo León; {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="3" class="center">
                <b>"LA ARRENDATARIA"</b>

                <hr style="border-top:1px solid black;width:300px;text-align:center;margin-top:90px">
                <p>{{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</p>

            </td>
        </tr>
    </table>

<div class="page-break"></div>

<p>
    <b>Contrato de Arrendamiento Financiero</b>
    de fecha {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }} que celebran {{ @$solicitud->razon_social->razon_social }}, en su carácter de arrendadora (la "Arrendadora")
    representada en este acto por {{ @$solicitud->razon_social->representante_legal }}, {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}, en su carácter de arrendataria,
    (la "Arrendataria"), y conjuntamente la Arrendadora y la Arrendataria (las “Partes”), de conformidad con las siguientes
    Declaraciones y Cláusulas:
</p>
<br>
<h1 class="center">DECLARACIONES</h1>

<p>
    I.- Declara la Arrendadora a través de su representante legal, que:
</p>
<ol type="a">
    <li>Es una persona moral, constituida de conformidad con las leyes mexicanas, con la capacidad suficiente para asumir las obligaciones establecidas en este Contrato.</li>
    <li>Su apoderado cuenta con las facultades suficientes para la celebración del Contrato, mismas que a la fecha no le han sido revocadas, modificadas o limitadas en forma alguna.</li>
    <li>Su domicilio es {{ @$solicitud->razon_social->calle }} No. {{ @$solicitud->razon_social->numero_ext }}, Colonia {{ @$solicitud->razon_social->colonia }}, {{ @$solicitud->razon_social->municipio->nombre }}, {{ @$solicitud->razon_social->estado->nombre }}, Código Postal {{ @$solicitud->razon_social->cp }}.</li>
    <li>Está dispuesta a adquirir del Proveedor que le señale la Arrendataria los Bienes, con objeto de concederle el uso y goce temporal a plazo forzoso a la Arrendataria, en términos del artículo 408 de la Ley General de Títulos y Operaciones de Crédito.</li>
</ol>

<p>II.- Declara la Arrendataria bajo protesta de decir verdad que:</p>
<ol type="a">
    <li>Es una persona física de nacionalidad mexicana, mayor de edad y con plena capacidad legal para obligarse y cumplir los términos del Contrato.</li>
    <li>Cuenta con la capacidad financiera suficiente para asumir las obligaciones a las que se obliga en los términos de este Contrato.</li>
    <li>Tiene el uso y goce del inmueble ubicado en el Lugar de Ubicación de los Bienes en calidad de arrendatario y cuenta con la autorización expresa de su arrendador para celebrar este Contrato y colocar los Bienes en el Lugar de Ubicación de los Bienes, según consta en el <span class="underline">Apéndice I</span> de este Contrato.</li>
    <li>Es su deseo recibir los Bienes en arrendamiento financiero y pagar a la Arrendadora la contraprestación consistente en la Renta Global, la que cubrirá el Valor de los Bienes, las cargas financieras y los demás accesorios estipulados en este Contrato.</li>
    <li>Cuenta con los recursos financieros y materiales necesarios y suficientes para cumplir con sus obligaciones de pago y demás obligaciones establecidas en este Contrato.</li>
    <li>Se obliga a seleccionar los Bienes que sean adquiridos por la Arrendadora con objeto de que esta última le conceda el uso y goce temporal de los mismos, en términos de este Contrato.</li>
    <li>Su Registro Federal de Contribuyentes es {{ $solicitud->cliente->rfc }}, su Clave Única de Registro de Población es {{ $solicitud->cliente->curp }} y su domicilio se encuentra ubicado en calle {{ @$solicitud->cliente->domicilio->calle  }} Ext:{{ @$solicitud->cliente->domicilio->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio->numero_int  }}
            Col. {{ @$solicitud->cliente->domicilio->colonia }}, {{ @$solicitud->cliente->domicilio->municipio->nombre }}, {{ @$solicitud->cliente->domicilio->estado->nombre }}, 
            C.P: {{ @$solicitud->cliente->domicilio->cp }}.</li>
    <li>En la fecha de firma de este Contrato, no tiene pendiente, ni existe intención o riesgo de que vaya a iniciarse alguna acción o procedimiento, ya sea judicial o extrajudicial, que afecte o pudiere afectar la legalidad, validez o exigibilidad de este Contrato ni su capacidad de cumplir con sus obligaciones contenidas en este Contrato y que sus recursos provienen de fuentes lícitas. Manifestando asimismo, que las cantidades recibidas de su parte, son destinadas a fines permitidos por la Ley, sin incurrir en alguno de los delitos señalados en los artículos 139 quáter y 400 Bis del Código Penal Federal, mismos que conozco a la letra.</li>
</ol>



<h1 class="center">DEFINICIONES</h1>
<p>
    Para efectos de este Contrato, los siguientes términos tendrán el significado que a continuación se señala, a menos que expresamente se indique lo contrario:
</p>
<p>
    <b class="underline">“Arrendadora”</b> tiene el significado que se le atribuye a dicho término en el proemio de este Contrato.
</p>
<p>
    <b class="underline">“Arrendamiento Financiero”</b> significa el arrendamiento financiero sobre los Bienes otorgado de conformidad con los términos y condiciones de este Contrato.
</p>
<p>
    <b class="underline">“Arrendataria”</b> tiene el significado que se le atribuye a dicho término en el proemio de este Contrato.
</p>
<p>
    <b class="underline">“Autoridad Gubernamental”</b> significa cualquiera de los poderes ejecutivo, legislativo o judicial, independientemente de la forma en que actúen, sean federales o estatales, así como cualquier órgano de gobierno municipal, cualquier agencia de gobierno, dependencia, secretaría, departamento administrativo, autoridad regulatoria, registro, entidad o tribunal gubernamental (incluyendo, sin limitación, autoridades bancarias y fiscales), organismo descentralizado o entidad equivalente o cualquier estado, departamento u otra subdivisión política de los mismos, o cualquier organismo gubernamental, autoridad (incluyendo cualquier banco central o autoridad fiscal) o cualquier entidad que ejerza funciones de gobierno, ejecutivas, legislativas o judiciales, ya sean nacionales o extranjeros.
</p>
<p>
    <b class="underline">“Bienes”</b> significan los sistemas solares fotovoltaicos y sus accesorios que adquiera la Arrendadora y que se describen bajo dicho rubro dentro del <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Carátula”</b> significa el documento anexo a este Contrato en el que, de manera complementaria a este Contrato, se especifican las Condiciones y Términos Generales del Arrendamiento, que regirán durante la vigencia del mismo.
</p>
<p>
    <b class="underline">“Descripción de los Bienes”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Día Hábil”</b> significa cualquier día que no sea (a) un sábado o domingo, o (b) un día en que las instituciones de crédito estén autorizadas u obligadas a cerrar en la Ciudad de México, de conformidad con las disposiciones aplicables emitidas por la Comisión Nacional Bancaria y de Valores.
</p>
<p>
    <b class="underline">“Fecha de Firma”</b> significa la fecha de firma señalada en el proemio de este Contrato.
</p>
<p>
    <b class="underline">“Forma de Pago”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Gastos Administrativos”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Inicio de Vigencia”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“IVA”</b>  significa el Impuesto al Valor Agregado.
</p>
<p>
    <b class="underline">“LGTOC”</b> significa la Ley General de Títulos y Operaciones de Crédito.
</p>
<p>
    <b class="underline">“Lugar de Ubicación de los Bienes”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“México”</b> significa los Estados Unidos Mexicanos.
</p>
<p>
    <b class="underline">“Opción de Compra”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Pago Inicial”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Partes”</b> tiene el significado que se le atribuye a dicho término en el proemio de este Contrato.
</p>
<p>
    <b class="underline">“Plazo Forzoso”</b> significa el periodo de tiempo en el que estará vigente este Contrato y, en consecuencia, las obligaciones a cargo de la Arrendataria, de conformidad con el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Pagos Parciales”</b> significa las cantidades que por concepto de rentas pagará la Arrendataria a la Arrendadora en la forma periódica acordada en este Contrato, los cuales se encuentran descritos en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Pago Adelantado”</b> significa la o las cantidades que la Arrendataria pagará a la Arrendadora en los términos de la Cláusula Octava de este Contrato.
</p>
<p>
    <b class="underline">“Pago Anticipado”</b> significa las cantidades que la Arrendataria pagará a la Arrendadora en los términos de la Cláusula Octava de este Contrato.
</p>
<p>
    <b class="underline">“Periodo Anual”</b> significa cada periodo de 12 (doce) meses transcurridos a partir de la Fecha de Firma de este Contrato.
</p>
<p>
    <b class="underline">“Periodo de Cálculo”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Pesos”</b> significa la moneda en curso legal en México.
</p>
<p>
    <b class="underline">“Proveedor”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Proveedor Autorizado”</b> tiene el significado que se le atribuye a dicho término en el Anexo “B” de este Contrato.
</p>
<p>
    <b class="underline">“Renta Global”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Tabla de Pagos Parciales”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Tasa de Interés Ordinario Anual”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Tasa de Interés Moratorio”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Unidad Especializada”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>
<p>
    <b class="underline">“Valor de los Bienes”</b> tiene el significado que se le atribuye a dicho término en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>

<p>
    Conformes las Partes en el proemio y las declaraciones que anteceden, celebran este Contrato de Arrendamiento
    Financiero de conformidad con las siguientes:
</p>



<h1 class="center">CLÁUSULAS</h1>

<p>
    <b>PRIMERA. OBJETO.</b> De conformidad con los términos y condiciones establecidos en este Contrato, la Arrendadora otorgará en
    arrendamiento financiero a la Arrendataria, quien en tal concepto recibirá los Bienes descritos de conformidad con la
    Descripción de los Bienes. La Arrendadora se obliga a adquirir del Proveedor, la propiedad de los Bienes y a conceder su uso y goce
    temporal a la Arrendataria, en el Plazo Forzoso, obligándose la Arrendataria a pagar a la Arrendadora la contraprestación que
    cubra el Valor de los Bienes, las cargas financieras y los demás accesorios estipulados en este Contrato y en el <span class="underline">Anexo “A”</span>.
    <br>
    Este Contrato, incluyendo sus anexos, será aplicable a cualquier mecanismo, refacción, pieza o elemento que se use accesoriamente o que
    posteriormente se agregue a los Bienes, los cuales quedarán en beneficio de la Arrendadora.
</p>

<p>
    <b>SEGUNDA. ELECCIÓN DE BIENES, ADQUISICIÓN Y ENTREGA DE LOS BIENES.</b> Las Partes convienen en que la Arrendataria elegirá en todo
    tiempo, en forma unilateral y de conformidad con sus propios intereses, tanto los Bienes en cuanto a su marca, capacidad, tipo,
    modelo, calidad y demás especificaciones, como al Proveedor siempre y cuando sea un Proveedor Autorizado, por lo que dicha elección
    correrá por su exclusivo riesgo, liberando expresamente a la Arrendadora de cualesquier responsabilidad surgida de daños de cualquier
    naturaleza ocasionados a la Arrendataria o a terceros, defectos o diferencias de especificaciones originales en los Bienes o de
    incumplimiento por parte del Proveedor en la entrega de los mismos. <br><br>
    La Arrendadora adquirirá en propiedad los Bienes y en consecuencia, pagará al Proveedor correspondiente, en la forma convenida
    con dicho Proveedor, una vez que (i) reciba este Contrato debidamente firmado por todas las Partes, (ii) reciba todas las cantidades
    iniciales a las que se hubiere obligado a pagar la Arrendataria de conformidad con este Contrato, y (iii) reciba cualquier otro documento
    que sea necesario para acreditar que la Arrendataria ha recibido a su entera satisfacción los Bienes. <br><br>
    La entrega material de los Bienes será hecha directamente por el Proveedor a la Arrendataria, quien por medio de este
    Contrato se obliga a recibirlos en las condiciones en las que se encuentren. La totalidad de los gastos que se originen con
    motivo de la transportación, entrega e instalación de los Bienes, serán por cuenta de la Arrendataria. La Arrendataria se obliga a
    recibir materialmente los Bienes directamente del Proveedor, así como a extender la constancia escrita de recepción que corresponda,
    misma que constituirá prueba suficiente de su entrega. Al recibir los Bienes del Proveedor, la Arrendataria será responsable de revisar
    que cumplan con las especificaciones acordadas y se encuentren en buenas condiciones mecánicas para su funcionamiento.
    <br><br>
    La Arrendadora no tendrá responsabilidad alguna, en relación con:
</p>

<ol type="a">
    <li>Cualquier perdida, daño, retraso, defecto, error o falta en la entrega, ensamble o instalación de los Bienes, error o incumplimiento del Proveedor en relación con los Bienes, o bien en relación con las garantías otorgadas por el  Proveedor.</li>
    <li>
        Vicios o defectos ocultos, errores, o deficiencias en los Bienes o cualquier otra deficiencia que impida su uso parcial o total.
    </li>
    <li>
        La falta de refacciones, partes, herramientas o servicios que se requieran a efecto de mantener y operar los Bienes de conformidad con las especificaciones del Proveedor o con lo establecido en este Contrato.
    </li>
    <li>
        La inexigibilidad de la garantía expedida por el Proveedor de los  Bienes.
    </li>
</ol>

<p>
    La Arrendataria no podrá hacer mejoras a los Bienes, ni variar la forma de los mismos, sin previo consentimiento por escrito de la Arrendadora.
    Las mejoras que hiciere la Arrendataria en los Bienes serán por su cuenta y quedarán en beneficio de los Bienes.
    Las mejoras, mantenimiento, refacciones o cualquier tipo de modificaciones en los Bienes únicamente podrán ser realizadas por algún
    Proveedor Autorizado. En caso de que la Arrendataria hiciere mejoras o varíe su forma sin consentimiento por escrito de la Arrendadora,
    ésta ejercitará cualquier derecho que le concede este Contrato y tratándose de variaciones de forma: (i) recibirá los Bienes con la
    variación efectuada sin costo alguno, o (ii) requerirá a la Arrendataria que a su costo restablezca los Bienes al estado que éstos
    tenían cuando se le entregaron.
    <br><br>

    La Arrendadora legitima en este acto a la Arrendataria para que esta última reclame al Proveedor respectivo cualquier defecto, error,
    omisión o imprecisión en los Bienes o en la descripción de los mismos o el incumplimiento en su entrega, teniendo la Arrendataria
    el derecho expedito para hacerlo valer a su exclusivo cargo y costo en contra del Proveedor, derivado de lo anterior la
    Arrendataria se obliga a sacarla en paz y a salvo a la Arrendadora, liberándola de cualquier responsabilidad que por lo anterior se
    origine.
    <br><br>
</p>

<p>
    <b>TERCERA. PLAZO.</b> El plazo del Arrendamiento celebrado al amparo de este Contrato será el Plazo Forzoso. Este Contrato iniciará
    su vigencia en el Inicio de Vigencia y permanecerá en vigor hasta en tanto las obligaciones a cargo de la Arrendataria
    hayan sido totalmente satisfechas. A la terminación del Plazo Forzoso, deberá sujetarse a lo pactado en la <span class="underline">Cláusula Décima Séptima</span>
    de este Contrato.
</p>

<p>
    <b>CUARTA. GASTOS, DERECHOS E IMPUESTOS.</b> Serán a cargo de la Arrendataria: (i) los Gastos Administrativos, (ii) todos los
    gastos que se originen por el otorgamiento, la ratificación, el registro y cualesquier trámites que fundados en la Ley que ocasione
    este Contrato o su incumplimiento, y (iii) los gastos por seguros que se requieran de conformidad con este Contrato.
    <br><br>
    La Arrendadora podrá solicitar a la Arrendataria el pago de Gastos Administrativos a los que pueda incurrir por concepto de gastos
    que erogue, con motivo de la cobranza que realice en caso de atraso o incumplimiento puntual de los Pagos Parciales en que incurra la
    Arrendataria ya sea por gestiones de carácter extrajudicial que realice a través de sus áreas de cobranza interna o por la contratación
    de empresas o despachos externos de cobranza por los servicios profesionales que efectúen. La Arrendadora informará a la Arrendataria
    en el estado de cuenta, los Gastos Administrativos en los que incurrió y que la Arrendataria deberá pagar. Dicha comisión será por el
    monto que se indique en la Carátula. Lo anterior sin perjuicio de los gastos y costas que pudieren generarse por cualquier procedimiento
    judicial o cobranza judicial que pudiere derivarse de este Contrato, los cuales podrán ser reclamados por la Arrendadora en cualquier
    momento.
    <br><br>
    La Arrendataria pagará la totalidad de derechos e impuestos en vigor, así como los que en el futuro se establezcan por cualquier autoridad,
    respecto a la adquisición, posesión, tenencia, propiedad y uso de los Bienes arrendados, o cualquier otra erogación que cause este
    Contrato, sea cual fuere su naturaleza, entendiéndose que la Arrendadora no deberá efectuar erogación alguna por ningún concepto,
    salvo tratándose del Impuesto Sobre la Renta a cargo de la misma, cuando los Bienes sean enajenados a la Arrendataria.
    <br>
    Si la Arrendadora paga alguna cantidad de las referidas en ésta Cláusula, la Arrendataria deberá reintegrársela en cuanto se lo solicite
    la Arrendadora. En caso de que la Arrendataria no reintegre a la Arrendadora las cantidades antes señaladas dentro de los 2 (dos) Días
    Hábiles siguientes a la fecha en que así se lo solicite, a dicha cantidad le será aplicable la Tasa de Interés Moratorio, computados
    desde la fecha en que la Arrendadora hubiere desembolsado las cantidades respectivas, hasta la fecha de pago efectivo, sin perjuicio
    del derecho que tiene la Arrendadora de dar por vencido anticipadamente este Contrato o exigir el cumplimiento forzoso de los mismos.
</p>

<p>
    <b>QUINTA. COMISIONES.</b> La Arrendataria pagará a la Arrendadora una comisión única por concepto de apertura, por el monto señalado
    en el <span class="underline">Anexo “A”</span>, bajo el rubro "Comisión por Apertura" más el IVA, la cual se pagará en la fecha que se indique en el <span class="underline">Anexo “A”</span> bajo
    el rubro Fecha de Comisión de Apertura.
</p>

<p>
    <b>SEXTA. RENTA.</b> La Arrendataria pagará a la Arrendadora la Renta Global más los intereses aplicables mediante los Pagos Parciales
    correspondientes indicados en el <span class="underline">Anexo “A”</span>, mismos que se pactan como plazos para el pago de la Renta Global, en los términos de
    lo dispuesto por el artículo 408 de la LGTOC, los cuales serán exigibles y deberán efectuarse precisamente en las fechas y por las
    cantidades que se especifiquen en la Tabla de Pagos Parciales, más los intereses ordinarios que se generen de acuerdo a la periodicidad
    que se establezca en el <span class="underline">Anexo “A”</span>. Los Pagos Parciales se cubrirán de conformidad con el Periodo de Cálculo y Forma de Pago establecidos
    en el <span class="underline">Anexo “A”</span> de este Contrato, precisamente en las fechas previstas en la Tabla de Pagos Parciales.
    <br><br>
    Las Partes acuerdan que a los Pagos Parciales y la Renta Global se les aplicará la Tasa de Interés Ordinario Anual correspondiente a cada Pago Parcial, de conformidad con lo establecido en el <span class="underline">Anexo “A”</span> de este Contrato.
    <br><br>
    Los Pagos Parciales que la Arrendataria pague a la Arrendadora por concepto de renta se efectuarán con su respectivo IVA, estableciéndose en el <span class="underline">Anexo “A”</span> el monto de cada Pago Parcial y la Tasa de Interés Ordinario Anual aplicable a cada periodo. En caso de que la fecha establecida para algún Pago Parcial no sea un Día Hábil, la Arrendataria podrá realizar el Pago Parcial a más tardar el Día Hábil inmediato posterior, debiéndose efectuar cada Pago Parcial con su respectivo IVA, por períodos completos, sin que la Arrendataria esté facultada para efectuar deducción alguna.
</p>

<p>
    <b>SÉPTIMA. INTERESES ORDINARIOS.</b> Las Partes convienen en que la tasa de interés aplicable para determinar cada Pago Parcial
    de renta, a cargo de la Arrendataria en términos de este Contrato y su <span class="underline">Anexo “A”</span>, se obtendrá del resultado de aplicar la Tasa de Interés
    Ordinario Anual al periodo de Pago Parcial correspondiente.
    <br><br>
    Las Partes convienen que la determinación de los Pagos Parciales de las rentas con su respectivo IVA, se calculará con base al saldo insoluto
    de la Renta Global establecido en el <span class="underline">Anexo “A”</span> de este Contrato.
</p>

<h1>OCTAVA. PAGOS ADELANTADOS Y ANTICIPADOS.</h1>
<p>
    <b>Pagos Adelantados:</b> La Arrendadora podrá recibir pagos que aún no sean exigibles, con el fin de aplicarlos a cubrir, hasta donde alcance, los Pagos Parciales inmediatos siguientes, siempre y cuando así lo solicite la Arrendataria previamente y por escrito.
    <br><br>
    Cuando el importe del Pago Parcial de acuerdo a la Tabla de Pagos Parciales del <span class="underline">Anexo “A”</span> sea superior al monto que deba cubrirse en el Periodo Anual, la Arrendataria deberá presentar un escrito con firma autógrafa solicitando que los recursos que entregó en exceso de sus obligaciones exigibles se utilicen para cubrir por adelantado y hasta donde alcance el o los Pagos Anticipados de conformidad con el inciso siguiente. El escrito no será necesario cuando los recursos en exceso sean inferiores al importe de un Pago Parcial.
    <br><br>
    La Arrendataria no tendrá derecho a ningún premio o bonificación por los pagos adelantados que realice.
    <br><br>
    La Arrendadora entregará un comprobante de pago a la Arrendataria una vez efectuado el Pago Adelantado.
    <br><br>

    <b>b) Pagos Anticipados:</b> La Arrendataria podrá realizar Pagos Anticipados en cualquier momento durante la vigencia de este Contrato
    mediante solicitud por escrito a la Arrendadora, siempre y cuando se hayan cubierto los Pagos Parciales correspondientes fa dicho Periodo
    Anual en cuyo caso, cualquier pago en exceso de los Pagos Parciales del Periodo Anual correspondiente será aplicado a la Renta Global.
    Para tal efecto, durante cada Periodo Anual la Arrendadora hará un cálculo de todos los Pagos Anticipados recibidos durante dicho Periodo
    Anual de que se trate, siempre que se hayan aplicado en exceso a los Pagos Parciales adeudados durante dicho periodo, y se aplicará la suma
    de dichas cantidades hacia la Renta Global , ajustándose los Pagos Parciales descritos en el <span class="underline">Anexo “A”</span> para reflejar dichos Pagos Anticipados.
    <br><br>
    Estas actualizaciones comenzarán a partir de la Fecha de Firma de este Contrato y tendrán aplicación automática al concluir cada Periodo
    Anual de conformidad con lo establecido en este Contrato.
    <br><br>
    En caso de que la Arrendataria tenga la intención de pagar anticipadamente la totalidad del monto por concepto de arrendamiento
    de conformidad con este Contrato, la Arrendataria deberá notificarlo a la Arrendadora por escrito y realizar el pago de los Pagos
    Parciales del Periodo Anual en curso así como pagar el precio de la Opción de Compra correspondiente. La Arrendadora informará el saldo
    insoluto del arrendamiento.
</p>

<p>
    <b>NOVENA. LUGAR DE PAGO.</b> La Arrendataria se obliga a efectuar todos los pagos que se deriven de este Contrato sin necesidad de
    previo requerimiento, judicial o extrajudicial, precisamente en el lugar de pago señalado el <span class="underline">Anexo “A”</span> de este Contrato o bien, en el
    lugar en el que libremente señale la Arrendadora por escrito con 15 (quince) días naturales de anticipación.
</p>

<p>
    <b>DÉCIMA. APLICACIÓN Y ACREDITAMIENTO DE PAGOS.</b> La Arrendataria faculta expresamente a la Arrendadora para que aplique sus pagos al
    Pago Parcial más antiguo, hasta donde alcance y en la proporción que corresponda dicho pago, en el orden siguiente: (i) Intereses Moratorios
    con su respectivo IVA, (ii) Pagos Parciales vencidos con su respectivo IVA, (iii) Accesorios con su respectivo IVA y (iv) Pagos Parciales por
    vencerse con su respectivo IVA. Ambas Partes convienen en que lo pactado en esta cláusula, será aplicable aún y cuando por cualquier causa
    no se exprese la aplicación exacta del pago de que se trate en el recibo que por él extienda la Arrendadora y cuando la Arrendadora llegue
    a recibir de la Arrendataria pagos extemporáneos y respecto de los cuales aún no hubiesen liquidado los intereses moratorios y su
    respectivo IVA.
    <br><br>
    Las Partes en este Contrato convienen que los pagos que por cualquier concepto la Arrendataria deba realizar a la Arrendadora,
    quedarán acreditados de acuerdo al medio de pago que utilice la Arrendataria, de la manera siguiente:
</p>

<div class="page-break"></div>
<table class="tbl_contrato" style="" width="100%">
    <tr>
        <td>
            <b>MEDIOS DE PAGO</b>
        </td>
        <td>
            <b>FECHAS DE ACREDITAMIENTO DEL PAGO</b>
        </td>
    </tr>
    <tr>
        <td>
            Cheque del mismo banco donde la ARRENDADORA tiene abierta su cuenta
        </td>
        <td>Se acreditará el mismo día.</td>
    </tr>
    <tr>
        <td>
            Cheque de otro banco
        </td>
        <td>
            El día en que la institución de crédito en que se haya hecho el pago lo acredite en la cuenta bancaria correspondiente de la Arrendadora.
        </td>
    </tr>
    <tr>
        <td>
            Domiciliación
        </td>
        <td>
            Se acreditará: <br>
            a) En la fecha que la Arrendadora acuerde con el Arrendatario, o
            <br>
            b) En la fecha límite de pago del Pago Parcial de que se trate
        </td>
    </tr>
    <tr>
        <td>Transferencias electrónicas de fondos</td>
        <td>
            A través del Sistema de Pagos Electrónicos Interbancarios (SPEI), se acreditará el mismo día hábil en que se ordene la transferencia.
            <br>
            A través del Sistema de Pagos Electrónicos, se acreditará a más tardar el día hábil siguiente al que se ordene la transferencia.
        </td>
    </tr>
</table>

<p>
    <b>DÉCIMA PRIMERA. INTERESES MORATORIOS.</b> Ante la falta de pago oportuno de cualquier cantidad que la Arrendataria deba pagar a la Arrendadora al amparo de este Contrato, esta última pagará a la Arrendadora, intereses moratorios con su respectivo IVA, desde el momento del incumplimiento hasta su pago total, aplicando la Tasa de Interés Moratorio a la cantidad adeudada.
    <br><br>
    La Tasa de Interés Moratorio será computable por días calendario, hasta que la Arrendataria no tenga cantidades adeudadas por cualquier concepto bajo este Contrato y cumpla con el pago puntualmente, como se indica en el <span class="underline">Anexo “A”</span> al amparo de este Contrato.
</p>

<p>
    <b>DÉCIMA SEGUNDA. SEGUROS.</b> Con el fin de tener los Bienes protegidos durante la vigencia de este Contrato ante eventualidades, en la fecha de firma de este Contrato será obligación de la Arrendataria la contratación de seguros conforme a lo que a continuación se establece, lo cual podrá realizar por sí o por conducto de la Arrendadora, en el entendido de que, en todo momento, serán por cuenta y orden de la Arrendataria, considerando lo siguiente:
    <br><br>
    <b>a)</b>Contratar un seguro que, de acuerdo con la naturaleza de los Bienes, los proteja contra pérdida, robo, destrucción y daños en
    general, así como de los daños y perjuicios que se ocasionen o pudieran ocasionarse a terceros en su persona o propiedades, designando
    como único beneficiario en primer lugar y grado con carácter irrevocable a la Arrendadora, debiendo ser los términos de dicha contratación
    a satisfacción de ésta. El seguro en cuestión no deberá ser menor del total de la inversión, de tal manera que en todo momento se
    encuentren garantizados el capital, intereses y demás prestaciones y accesorios legales; el seguro de los Bienes será renovable en forma anual,
    mientras exista adeudo en favor de la Arrendadora, debiendo ser los términos de dicha contratación a satisfacción de ésta última y quedando la póliza
    respectiva en su poder, designándolo como beneficiario preferente con carácter irrevocable;
</p>

<p>
    <b>b)</b>La Arrendataria podrá contratar los seguros a que se refieren los incisos a) y b) anteriores con cualquier compañía
    aseguradora de reconocida solvencia y registrada ante la Comisión Nacional de Seguros y Fianzas, sin perjuicio de que podrá contratar
    dichas pólizas con la o las aseguradoras ofrecidas o recomendadas por la Arrendadora, sin que ello condicione la suscripción de
    este Contrato u otorgue mejores condiciones a la Arrendataria en este Contrato; y
</p>

<p>
    <b>c)</b>La Arrendadora podrá quedar facultada por la Arrendataria, sin estar obligado a ello, para contratar los seguros a que se refiere
    esta cláusula con la compañía que así lo estime conveniente, en caso de que la Arrendataria: (i) así lo instruya a la Arrendadora previo
    a la firma de este Contrato; o (ii) no contrate los seguros en la fecha de firma de este Contrato, y, en consecuencia, la Arrendadora
    quedará facultada para pagar por cuenta de la Arrendataria los gastos y primas que causen dichos seguros; estos seguros deberán mantenerse
    en vigor, durante todo el tiempo que exista a cargo de la Arrendataria cualquier saldo que provenga de este Contrato, y no podrán ser
    cancelados ni modificados sin previa autorización por escrito de la Arrendadora.
    <br><br>

    La Arrendataria se responsabilizará de todos los daños y perjuicios que cause o se causen a los Bienes y a terceros incluyendo a la Arrendadora, en sus bienes o en sus personas, así como el pago del importe de todas las erogaciones originadas por lo anterior.
    <br><br>
    La Arrendataria se obliga a pagar a la Arrendadora el valor de las pólizas, los incrementos que la Arrendadora determine, con base a la información que reciba de la empresa aseguradora así como sus renovaciones anuales por todo el tiempo de vigencia del arrendamiento, cuyo valor es incluido en el arrendamiento exclusivamente como una referencia, toda vez que, el monto de las primas y demás gastos que causen los seguros contratados por la Arrendadora, así como cualquier incremento futuro del valor de las pólizas y sus renovaciones anuales, correrán por cuenta de la Arrendataria, quien además tendrá a su cargo, el pago de cualquier cantidad deducible que haya de erogarse o gastos no cubiertos por los seguros en relación con los mismos, siempre y cuando dichas cantidades hayan sido erogadas por la Arrendadora. Los seguros que contrate la Arrendadora por cuenta y orden la Arrendataria, se mantendrán vigentes por el tiempo contratado, sin que la Arrendataria, pueda solicitar su cancelación o sustitución. La obligación de la Arrendataria de mantener los seguros persistirá mientras se encuentre vigente el arrendamiento de este Contrato.
    <br><br>
    En caso de que la Arrendataria no realice el pago del valor de los seguros contratados y renovados por la Arrendadora, así como sus incrementos en su valor, en la fecha requerida por la Arrendadora, por cada día que transcurra le pagará intereses moratorios de acuerdo a lo estipulado en este Contrato.
    <br><br>
    En el caso de que la Arrendadora estime que las coberturas contratadas no son suficientes, lo comunicará por escrito a la Arrendataria, para que ésta, dentro de un plazo que no exceda de 5 (cinco) días hábiles desde la fecha en la que reciba dicha comunicación, subsane la omisión, cubriendo la Arrendataria las diferencias de prima que resulten.
    <br><br>
    En el caso de que la Arrendataria contrate directamente los seguros objeto de esta cláusula, ésta deberá entregar a la Arrendadora en la fecha de firma de este Contrato: (i) la póliza anualizada emitida por compañía autorizada de seguros, póliza que será otorgada en los mismos términos y condiciones señalada en los párrafos anteriores de esta Cláusula, esto es, en cuanto al riesgo asegurado, y endoso preferencial e irrevocable a favor de la Arrendadora, obligándose la Arrendataria a renovar la misma durante la vigencia de este Contrato; y (ii) los recibos correspondientes del pago de las primas respectivas. En el caso de que la Arrendataria no entregue la póliza del seguro contratado por él a la Arrendadora o no efectúe la renovación por vencimiento de vigencia del seguro, la Arrendadora procederá a contratar o renovar el seguro, aplicándose lo establecido en esta Cláusula, así como a ser reembolsado por cualquier erogación que realice la Arrendadora, por concepto de la contratación o renovación del seguro y demás aplicables.
    <br><br>
    La Arrendadora podrá en cualquier momento solicitar a la Arrendataria que ésta obtenga de las compañías aseguradoras con quienes se contraten dichos seguros, las pólizas, endosos, reconocimientos, certificados o cualquiera otras evidencias documentales que comprueben la aceptación de, o notificación a, dichas compañías aseguradoras.
    <br><br>
    En caso de pérdida, destrucción, daño irreparable o cualquiera otra contingencia que impida, total o parcialmente, la utilización de los Bienes, la Arrendataria se obliga a hacer del conocimiento de la autoridad competente y de la compañía de seguros en forma inmediata y a la Arrendadora dentro de las 24 (veinticuatro) horas siguientes de ocurrido el hecho, y realizar todos los trámites necesarios hasta en tanto la empresa aseguradora entregue a la Arrendadora la indemnización correspondiente, y una vez que dicha indemnización sea pagada, igualmente la Arrendataria se obliga a pagar a la Arrendadora cualquier diferencia que pudiere existir entre el monto de la indemnización y el saldo adeudado por el arrendamiento dispuesto a la fecha del pago de la indemnización.
    <br><br>
    Por su parte, la Arrendadora se obliga a devolver a la Arrendataria cualquier diferencia que pudiere resultar en su favor, en caso de que la indemnización que cubra la empresa aseguradora resulte superior al saldo adeudado del arrendamiento a la fecha de pago de la multicitada indemnización.
    <br><br>
    La Arrendataria se obliga a liberar de toda responsabilidad a la Arrendadora o a cualquier cesionaria de ésta, de cualquier gasto, costas o indemnizaciones a terceros o a la propia Arrendataria, que se reclamen o que se determinen ante y por autoridades competentes, sea cual fuere su naturaleza, derivados de la tenencia o del uso de los Bienes, mientras que el mismo se encuentre a su disposición, independientemente de la vigencia o de la terminación del arrendamiento. La Arrendataria será responsable en todo momento de los Bienes, aun cuando no cuente con la póliza de seguro, así como en el caso de que la compañía de seguros rechace la indemnización o la póliza resulte invalidada por cualquier causa; de manera enunciativa mas no limitativa: la falta de pago de la prima, exclusiones, o cualquier limitación, incumplimiento, o violación a las condiciones y obligaciones de la Arrendataria que contenga la póliza.
    <br><br>
    Sin perjuicio de lo anterior, la Arrendataria igualmente se obliga a efectuar con toda oportunidad la totalidad de las gestiones, avisos, reclamaciones, demandas y demás actos necesarios o convenientes para que las aseguradoras de que se trate cubran las indemnizaciones que en cada caso de pérdida, de robo, de destrucción o de cualquier otro daño que sufran los Bienes, procedan en favor de la Arrendadora, siendo responsable frente a ésta de los daños y de los perjuicios que le cause con su omisión, dolo o negligencia. Ambas Partes convienen, en que en ningún caso la Arrendadora será responsable de los daños o de los perjuicios que pudiere causar a la Arrendataria o a cualquier tercero, la empresa aseguradora de que se trate, en caso de demorarse ésta en los pagos de indemnizaciones por siniestros ocurridos al amparo de los seguros respectivos.
    <br><br>
    La Arrendadora está facultada frente a las compañías aseguradoras con quienes se contraten los seguros referidos en esta Cláusula, para ceder, transferir, pignorar o de cualquier otra manera gravar los derechos que tenga como beneficiario irrevocable y preferente, en primer lugar y grado, respecto de los seguros referidos en esta Cláusula, sin necesidad de consentimiento expreso y por escrito adicional alguno por parte de la Arrendataria.
</p>

<p>
    <b>DÉCIMA TERCERA. USO, LUGAR DE USO DE LOS BIENES Y RESPONSABILIDAD.</b> La Arrendataria podrá usar los Bienes exclusivamente para el uso convenido de acuerdo a su naturaleza y únicamente en el Lugar de Ubicación de los Bienes. La Arrendataria deberá notificar a la Arrendadora por escrito con al menos 30 (treinta) Días Hábiles de anticipación su intención de cambiar los Bienes del Lugar de Ubicación de los Bienes y para ello, se deberá realizar una modificación al <span class="underline">Anexo “A”</span>. Posteriormente, la Arrendadora programará la reubicación de los Bienes, la cual deberá ser llevada a cabo por un Proveedor Autorizado. Todos los costos y gastos derivados de la reinstalación y reubicación de los Bienes serán por cuenta de la Arrendataria.
    <br><br>
    La Arrendataria conviene y reconoce expresamente que la Arrendadora no será responsable de daños causados por o con los Bienes. En tal virtud, la Arrendataria se obliga a sacar a la Arrendadora, sus subsidiarias, filiales, accionistas, directores y empleados en paz y a salvo de todo juicio o reclamación por tal concepto, así como a cubrir todos los gastos relacionados con tales juicios o reclamaciones, incluyendo los honorarios legales correspondientes.
    <br><br>
</p>

<p>
    <b>DÉCIMA CUARTA. MANTENIMIENTO Y REPARACIÓN DE LOS BIENES.</b> La Arrendataria se obliga a mantener a su costa y sin responsabilidad alguna para la Arrendadora, en todo tiempo los Bienes en perfectas condiciones de uso, mecánicas y de operación, conforme a su naturaleza y destino, con las solas limitaciones o deterioros que en ellos se causen por el paso del tiempo y por su uso normal.
    <br><br>
    La Arrendataria pagará por su exclusiva cuenta, cualquier gasto que sea necesario o conveniente para el debido mantenimiento de los Bienes, incluyendo todo tipo de reparaciones y de servicios correctivos, sea por concepto de mano de obra o refacciones, debiéndose utilizar refacciones legítimas y debiéndose realizar las reparaciones por algún Proveedor Autorizado. Toda refacción, implemento o accesorio que se adicione a los Bienes, se considerará incorporado a ellos, y en consecuencia, quedará sujeto a los términos de este Contrato y su <span class="underline">Anexo “A”</span>, por lo que quedarán a beneficio de la Arrendadora, sin que la Arrendataria pueda retirarlos o exigir indemnización alguna por ellos.
    <br><br>
    La Arrendataria se obliga a que, en caso de despojo, extinción de dominio, confiscación, expropiación, perturbación o cualquier acto de autoridad o de cualquier tercero que afecten o pretendan afectar el uso, goce, posesión o propiedad de los Bienes con motivo de las actividades de la Arrendataria, esta última realizará las acciones que correspondan para recuperar su posesión y defender su uso, goce o propiedad. Cuando ocurra alguna de estas eventualidades, la Arrendataria notificará por escrito a la Arrendadora, a más tardar el tercer Día Hábil siguiente a que tenga lugar dicha eventualidad. La Arrendadora, podrá ejercitar directamente las acciones o defensas, sin perjuicio de las que realice la Arrendataria, debiendo ésta última reembolsar a la Arrendadora los gastos y honorarios en que incurra, en los términos de lo estipulado en este Contrato.
    <br><br>
    Durante la vigencia de este Contrato la Arrendadora cede a la Arrendataria los derechos de cualquier garantía o servicio que otorgue el Proveedor de los Bienes, corriendo por cuenta de la Arrendataria, cualquier cargo que el Proveedor realice por servicios o por materiales no incluidos en la garantía de que se trate. La Arrendataria deberá reclamar directamente del Proveedor de los Bienes, sin responsabilidad alguna para la Arrendadora, los derechos relacionados con la calidad y con el buen funcionamiento de los Bienes.
    <br><br>
    Igualmente, la Arrendataria se obliga a cuidar y a proteger los Bienes, dando cumplimiento, a su costa, a lo establecido en el artículo 415 de la LGTOC.
    <br><br>
    La Arrendataria se obliga a no reemplazar los Bienes en ninguna de sus Partes materia de este Contrato y su <span class="underline">Anexo “A”</span>, por otros distintos a los renovados tecnológicamente, toda vez que esto implicaría la celebración de un nuevo Contrato previa autorización de la Arrendadora o en su caso el derecho que tendrá la Arrendadora de rescindir este Contrato. Las Partes no reconocerán Bienes diferentes a la Descripción de los Bienes.
</p>

<p>
    <b>DÉCIMA SEXTA. IDENTIFICACIÓN E INSPECCIÓN DE LOS BIENES.</b> La Arrendataria se obliga a colocar en algún lugar visible de los Bienes una etiqueta o una placa en la que exprese que es propiedad de la Arrendadora. La Arrendataria faculta expresamente a la Arrendadora para que por conducto de las personas que ésta designe, se inspeccionen en cualquier tiempo los Bienes, verificando su adecuada instalación, operación, identificación y mantenimiento, obligándose a proporcionarle todas las facilidades para ello.
</p>

<p>
    <b>DÉCIMA SÉPTIMA. OPCIONES TERMINALES DEL CONTRATO.</b> Al concluir el plazo del vencimiento de este Contrato de conformidad con lo establecido en el <span class="underline">Anexo “A”</span>, cuando se acuerde su vencimiento anticipado y una vez que se hayan cumplido todas las obligaciones, la Arrendataria ejercerá la opción terminal entre las opciones siguientes:
</p>
<ol type="a">
    <li>
        La compra de los Bienes a un precio inferior al Valor de los Bienes, de conformidad con el precio de Opción de Compra que corresponda.
    </li>
    <li>
        La de prorrogarle el Contrato por el plazo establecido en el <span class="underline">Anexo “A”</span> bajo el rubro "Plazo de Prórroga", durante el cual los pagos por concepto de renta serán inferiores a los Pagos Parciales que venía haciendo, conforme a aquellos establecidos en el <span class="underline">Anexo “A”</span> bajo el rubro "Renta por Prórroga".
    </li>
    <li>
        La de participarle del producto de la venta de los Bienes a un tercero, en cuyo caso su participación será la establecida en el <span class="underline">Anexo “A”</span> bajo el rubro "Participación por Venta".
    </li>
</ol>

<p>
    La Arrendataria podrá cambiar la opción terminal a la Arrendadora, por escrito y con un plazo mínimo de 90 (noventa) días naturales de anticipación al vencimiento del Plazo Forzoso este Contrato.
    <br><br>
    La totalidad de impuestos, derechos, contribuciones o gastos de cualquier naturaleza que se ocasionen con motivo del ejercicio de cualquiera de las opciones indicadas en esta Cláusula, serán exclusivamente a cargo de la Arrendataria.
    <br><br>
    Si al vencimiento del Plazo Forzoso de este Contrato, la Arrendataria incumple con la adopción de la opción terminal previamente elegida en el <span class="underline">Anexo “A”</span>, pagará a la Arrendadora los daños y perjuicios que le ocasione por dicho incumplimiento, de acuerdo con lo establecido en el artículo 410 de la LGTOC.
</p>

<p>
    <b>DÉCIMA OCTAVA. OBLIGADO SOLIDARIO.</b> Las personas que en carácter de Obligado Solidario suscriben este Contrato, se constituyen en Obligados Solidarios de la Arrendataria y comparecen a la firma de este Contrato, para constituirse como Obligado Solidario de la Arrendataria, frente a la Arrendadora, en términos de los artículos 1987, 1989 y demás aplicables del Código Civil Federal, respondiendo absoluta e incondicionalmente del pago total y puntual de las obligaciones de pago de la Arrendataria derivadas de este Contrato. Para tal efecto, se considera que las obligaciones derivadas de este Contrato son indivisibles.
    <br><br>
    El Obligado Solidario por este medio y durante la vigencia de este Contrato renuncia a cualquier diligencia, presentación, requerimiento, protesto, aviso de aceptación, notificación de incumplimiento o cualquier otro aviso respecto de cualesquiera de las obligaciones de la Arrendataria de conformidad con este Contrato, y a todo requisito que la Arrendadora o cualquiera de sus respectivos cesionarios o causahabientes ejerza cualquier derecho, o tome cualquier medida en contra de la Arrendataria o cualquier subsidiaria o de cualquier otra Persona, o exija el cumplimiento de cualquier otra fianza o documento.  El Obligado Solidario acepta que si la Arrendataria dejare de pagar en su totalidad o en parte al vencimiento (ya sea al vencimiento programado, anticipado o en cualquier otro momento) cualesquiera de las obligaciones contenidas en este Contrato, el Obligado Solidario procederá al pago puntual de las mismas, previo requerimiento de la Arrendadora. El Obligado Solidario renuncia a los beneficios de orden, excusión y división a que hacen referencia los Artículos 2814, 2815, 2816, 2817, 2818, 2819, 2820, 2821, 2822, 2823, 2,837, 2,838, 2,839, 2,840 2,841 y demás artículos respectivos del Código Civil Federal y sus correlativos de los Códigos Civiles de los Estados de la República Mexicana y a que en caso de que la Arrendataria obtenga una prórroga en el plazo para el pago o renovación de las obligaciones contenidas en este Contrato,, éstas serán pagadas en su totalidad a su vencimiento (ya sea la fecha a la que éste se hubiere prorrogado, al vencimiento anticipado, o en cualquier otro momento) por el Obligado Solidario siempre y cuando dicha prórroga haya sido previamente y por escrito aceptada por el Obligado Solidario.
    <br><br>
    El Obligado Solidario se obliga a cumplir con todos y cada uno de los términos y obligaciones contempladas en este Contrato.
</p>

<p>
    <b>DÉCIMA NOVENA. CESIÓN DE DERECHOS.</b> La Arrendataria autoriza expresamente a la Arrendadora para ceder, endosar, dar en garantía, traspasar o en cualesquier forma, negociar los derechos que en su favor se deriven de este Contrato, para lo cual bastará una notificación del Arrendador a la Arrendataria en tal sentido.
    <br>
    Por su parte, la Arrendataria no podrá ceder, dar en garantía, traspasar o en cualesquier forma, negociar ni disponer de los bienes ni de los derechos que en su favor se deriven de este Contrato, ni en especial, subarrendar o transmitir en forma alguna la posesión de los Bienes, total o parcialmente, si no cuenta con la autorización previa y por escrito por parte de la Arrendadora.
</p>

<p>
    <b>VIGÉSIMA. OBLIGACIONES ADICIONALES DE LA ARRENDATARIA.</b> La Arrendataria se obliga a cumplir con las siguientes obligaciones, en adición a las establecidas en este Contrato:
</p>
<ol type="I">
    <li>
        Realizar todas las acciones para recuperar los Bienes o defender el uso y goce del mismo, en caso de despojo, perturbación o de cualquier acto de terceros que afecte el uso o goce de los Bienes, así como notificar por escrito y a más tardar el día hábil siguiente al hecho de que se trate a la Arrendadora de dicha circunstancia.
    </li>
    <li>
        Reembolsar a la Arrendadora, en cuanto ésta se lo solicite, cualesquier cantidad que dicha Arrendadora hubiere erogado por cuenta de la Arrendataria, por obligaciones de pago a cargo de la Arrendataria derivadas de este Contrato.
    </li>
</ol>

<p>
    <b>VIGÉSIMA PRIMERA. CAUSAS DE VENCIMIENTO ANTICIPADO Y TERMINACIÓN DEL CONTRATO.</b> Serán causas de vencimiento anticipado de este Contrato, cualquier incumplimiento en que las Partes incurran respecto de las obligaciones que en sus términos cada uno asume en favor de la otra, y en especial las siguientes:
</p>
<ol type="a">
    <li>Que la Arrendataria se abstenga de pagar uno o más de los Pagos Parciales con su respectivo IVA, en la forma y en los términos pactados en este Contrato; </li>
    <li>Que la Arrendataria se abstenga de pagar oportunamente a la Arrendadora el importe de las primas de los seguros que ésta última contrate directamente respecto de los Bienes; </li>
    <li>Que la Arrendataria se abstenga de informar o de mantener informada a la Arrendadora de la localización exacta de los Bienes, o que los traslade fuera de México, sin la previa autorización de la Arrendadora por escrito; </li>
    <li>Que la Arrendataria, en cualquier tiempo, se abstenga de dar a los Bienes el uso y destino que corresponda conforme a su naturaleza, o que permita que los usen u operen personas no capacitadas para ello; </li>
    <li>Que la Arrendataria se abstenga de realizar con toda oportunidad, a su cargo cualquier reparación y servicio de mantenimiento que sea necesario para que los Bienes se encuentren en perfectas condiciones; </li>
    <li>Que la Arrendataria se abstenga de permitir a la Arrendadora la inspección de los Bienes;</li>
    <li>Que la Arrendataria permita el embargo total o parcial de los Bienes, permita la extracción material de los mismos del lugar de su instalación o se abstenga de dar aviso inmediato y escrito a la Arrendadora de cualquier situación que pudiere afectar física o jurídicamente a los Bienes;</li>
    <li>Cualquier incumplimiento a las obligaciones de carácter crediticio bajo otro(s) Contratos(s) que la Arrendataria tenga celebrado(s) con la Arrendadora, y que convierta a aquel (aquellos) Contrato(s) pagadero(s) antes del vencimiento establecido en el (los) Contrato(s) respectivo(s).</li>
</ol>

<p>
    Sin perjuicio de lo anterior, en caso de incumplimiento de la Arrendataria a sus obligaciones, la Arrendadora estará facultada para optar entre:
</p>

<ol type="a">
    <li>Continuar con el Contrato en todos sus términos, mediante el pago de todas las cantidades pendientes de pago a esa fecha, más el pago de una penalización por parte de la Arrendataria, equivalente al 5% (cinco por ciento) del monto total de los Pagos Parciales pendientes de pagarse al momento del incumplimiento; o</li>
    <li>
        Exigir de la Arrendataria el cumplimiento inmediato de los pagos parciales vencidos, más el saldo de los pagos parciales por vencer, ambos con su respectivo IVA y demás accesorios generados en términos de este contrato; así como la devolución inmediata de los Bienes en el lugar que la Arrendadora le indique, con lo cual la Arrendadora se encuentra facultada  para conceder los Bienes en arrendamiento financiero a un tercero o disponer de los mismos como más le convenga. Asimismo, la Arrendadora se reserva las acciones civiles y penales, en contra de la Arrendataria en caso de que, no se alcance a cubrir los adeudos antes mencionados.
    </li>
</ol>

<p>
    La Arrendadora y la Arrendataria, están de acuerdo en que este último podrá solicitar la cancelación de este Contrato, siempre y cuando sea dentro del periodo de 10 (diez) días hábiles posteriores a la firma de este instrumento, sin responsabilidad alguna para el mismo, siempre que aún no se hubiesen adquirido los Bienes del Proveedor, en cuyo caso, la Arrendataria cubrirá los gastos en los que la Arrendadora haya incurrido respecto a la ratificación, seguros, y cualesquier otros gastos en que se hubieren incurrido en virtud a la celebración de este Contrato.
    <br><br>
    Asimismo, las Partes convienen en que la Arrendataria podrá solicitar la cancelación del Contrato dentro del plazo establecido en el párrafo anterior, de conformidad con el siguiente procedimiento: (i) presentar un escrito en la Unidad Especializada de la Arrendadora, mediante el cual solicite la cancelación del Contrato dentro del plazo permitido; (ii) la Arrendadora deberá proporcionar a la Arrendataria una clave de cancelación; y (iii) previo a la cancelación del Contrato, la Arrendadora deberá confirmar vía telefónica o por cualquier otro medio que pacten las Partes los datos de la Arrendataria; (iv) la Arrendadora a más tardar a las 24 (veinticuatro) horas siguientes en que reciba la solicitud de cancelación comunicará a la Arrendataria el importe de su adeudo y, dentro de los 5 (cinco) días hábiles siguientes también a la solicitud, deberá poner a disposición de la Arrendataria dicho dato en el domicilio de la Arrendadora.
    <br><br>
    Hecho lo anterior y una vez realizado el pago de todas y cada una de las obligaciones a cargo de la Arrendataria, se dará por terminada la relación jurídica y la Arrendadora pondrá a disposición de la Arrendataria, dentro de los 10 (diez) días hábiles siguientes al pago de dichas obligaciones, la constancia de la terminación de la relación contractual e inexistencia de adeudos derivados de la misma.
</p>

<p>
    <b>VIGÉSIMA SEGUNDA. ESTADOS DE CUENTA.</b> Durante la vigencia de este Contrato, la Arrendadora pondrá a disposición de la Arrendataria de
    forma mensual su estado de cuenta, en: (i) el domicilio de la propia Arrendadora; o (ii) enviado a través del correo electrónico proporcionado
    por la Arrendataria; o (iii) a través de la consulta en la página de internet <a href="#">{{ @$solicitud->razon_social->web }}</a>; según lo acuerden las Partes,
    independientemente de que ésta última lo pueda solicitar vía telefónica en el número 81-2139-6070. La información contenida en el estado
    de cuenta, permitirá a la Arrendataria conocer la situación de la operación, así como las transacciones registradas por la Arrendadora en
    el periodo inmediato anterior
    <br><br>
    La Arrendataria también podrá consultar la información de su estado de cuenta así como solicitarlo en la Unidad Especializada de la Arrendadora, señalada en el <span class="underline">Anexo “A”</span>.
</p>

<p>
    <b>VIGÉSIMA TERCERA. DOMICILIOS Y AVISOS.</b> Para los efectos de este Contrato, las Partes señalan como sus domicilios los que se indican en el capítulo de Declaraciones de este Contrato.
    <br><br>
    Los avisos y notificaciones que deban hacerse las Partes de conformidad con este Contrato, se harán por escrito y entregarán o enviarán a cada una de las Partes a su dirección o a cualquier otra dirección que designen mediante aviso escrito dado a su contraparte. Los avisos y comunicaciones surtirán efecto, si se dan por escrito, al ser entregadas, y si se envían por correo electrónico, al ser recibida la confirmación por ese medio.
    <br><br>
    Para cualquier solicitud, consulta, inconformidad y/o queja relacionada con este Contrato se pone a disposición el teléfono 81-2139-6070.
</p>

<p>
    <b>VIGÉSIMA CUARTA. SOLICITUDES, CONSULTAS Y ACLARACIONES.</b> La <b>ARRENDATARIA</b> tendrá un plazo de 30 (treinta) días naturales siguientes a la fecha de corte de cada pago parcial para presentar solicitudes, aclaraciones, inconformidades y quejas, relacionados con la operación o servicio contratado, misma que deberá ser presentada por escrito debidamente firmado por la Arrendataria, en el cual se indique el nombre del titular del Arrendamiento, el No. de referencia del mismo, una breve narración de los hechos, así como lo que solicite de la Arrendadora, dicho escrito deberá acompañar copia de su credencial de elector o identificación oficial, así como una copia de los documentos que se relacionen con la solicitud, consulta, aclaración, reclamación, inconformidad o queja correspondiente; el escrito deberá ser presentado ante la Unidad Especializada de la Arrendadora, en días y horas hábiles, en un horario de 9:00 a.m. a 2:00 p.m., horario en el cual la Arrendataria podrá dar seguimiento a los trámites referidos.
    <br><br>
    La Arrendadora emitirá una respuesta a la Arrendataria, ya sea por escrito, vía telefónica, fax, vía electrónica, o cualquier otro medio, dentro de un plazo de 5 (cinco) días hábiles, contado a partir de la fecha de recepción de solicitud, consulta, aclaración, inconformidad o queja, así como un informe detallado en el que se respondan todos los hechos contenidos en el escrito correspondiente.
    <br><br>
    El domicilio de la Unidad Especializada se encuentra en:
    {{ @$solicitud->razon_social->calle }} #{{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Colonia {{ @$solicitud->razon_social->colonia }}, {{ @$solicitud->razon_social->municipio->nombre }}, {{ @$solicitud->razon_social->estado->nombre }}, Código Postal {{ @$solicitud->razon_social->cp }}
    <br><br>
    El teléfono de atención a usuarios es: {{ @$solicitud->razon_social->telefono }} Correo electrónico: {{ @$solicitud->razon_social->correo }} y página web: {{ @$solicitud->razon_social->web }}
</p>

<p>
    <b>VIGÉSIMA QUINTA. MODIFICACIONES.</b> Las Partes podrán en cualquier momento modificar los términos y condiciones de este Contrato, previo acuerdo por escrito entre ellas.
    <br><br>
    Asimismo, las Partes que suscriben este Contrato convienen expresamente que, en caso de que la Arrendataria quisiera realizar alguna modificación a este Contrato, deberá presentar un escrito en el domicilio de la Arrendadora o la oficina de este donde se aperturó la operación, la Arrendataria deberá especificar en dicho escrito los cambios que desee realizar al Contrato o documentos anexos respectivos; la Arrendadora a su vez tendrá un plazo de 30 (treinta) días naturales para contestar si acepta las modificaciones solicitadas por la Arrendataria, y en su caso, si se requiere adecuarlas al <span class="underline">Anexo “A”</span> y/o en sus documentos anexos respectivos. La Arrendataria pagará a la Arrendadora una comisión señalada en el <span class="underline">Anexo “A”</span> bajo el rubro denominado como "Comisión por Modificaciones a las fechas de Pago", dicha comisión será aplicable en los casos en que la Arrendataria solicite cambios en sus fechas de pago, lo cual generará una nueva tabla de pagos parciales. Si la Arrendadora no diera contestación en el plazo señalado se entenderá por no aceptada la modificación solicitada.
    <br><br>
    En caso de que la Arrendadora solicite la modificación del Contrato, la Arrendadora tendrá un plazo de 30 (treinta) días naturales de anticipación a la entrada en vigor, para notificar a la Arrendataria las modificaciones propuestas, mediante aviso ya sea por vía telefónica, fax, vía electrónica o cualquier otro medio que las Partes acuerden. El aviso deberá especificar de forma notoria la fecha en que las modificaciones surtirán efecto.
    <br><br>
    En el evento de que la Arrendataria no esté de acuerdo con las modificaciones propuestas por la Arrendadora, podrá solicitar la terminación anticipada del Contrato hasta 30 (treinta) días naturales después de la entrada en vigor de dichas modificaciones, sin responsabilidad ni comisión alguna a su cargo, debiendo cubrir en su caso los adeudos que ya se hubieren generado a la fecha en que solicite dar por terminada la operación o servicio de que se trate.
    <br><br>
    Una vez transcurrido el plazo conforme a lo señalado en el párrafo anterior, sin que la Arrendadora haya recibido comunicación alguna por parte de la Arrendataria, se tendrán por aceptadas las modificaciones al Contrato.
    <br><br>
    Asimismo, las Partes convienen que las comisiones o la tasa de interés pactadas podrán ser modificadas siempre que se trate de una reestructura y la Arrendadora cuente con el previo consentimiento de la Arrendataria.
</p>

<p>
    <b>VIGÉSIMA SEXTA. TÍTULOS DE LAS CLÁUSULAS.</b> Los títulos que se han incluido en cada Cláusula de este Contrato, son tan sólo para referencia y fácil manejo, por lo que no deberán tener ninguna trascendencia en la interpretación legal de las mismas.
</p>

<p>
    <b>VIGÉSIMA SÉPTIMA. LEYES APLICABLES Y TRIBUNALES COMPETENTES.</b> Para todo lo relativo a la interpretación y cumplimiento de este Contrato y su  <span class="underline">Anexo “A”</span>, las Partes que en ellos intervienen declaran aplicables las leyes federales, y se someten expresamente a la jurisdicción de los tribunales competentes en Monterrey, Nuevo León, renunciando expresamente al fuero que por domicilio o por cualquier otra causa, en el presente o en lo futuro, les pudiere corresponder.
    <br><br>
    Las hojas de firmas anexas a este instrumento, forman parte integrante del <b>CONTRATO DE ARRENDAMIENTO FINANCIERO</b>
    identificado administrativamente con el No. De Folio que aparece en el ángulo superior derecho de la hoja de este Contrato, el
    cual se otorga y firma por <b>cuadruplicado</b>, en Monterrey, Nuevo León a los {{ date('d') }} días del mes de {{ \Carbon\Carbon::now()->formatLocalized('%B') }} de {{ date('Y') }}.
</p>


<br><br><br>
<p class="center"> [ Continua hoja de firmas ]</p>

<div class="page-break"></div>

<h1 class="center">LA ARRENDATARIA:</h1>
<hr style="width:300px;margin-top:100px" class="center">
<h1 class="center">Por:{{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</h1>


<h1 class="center" style="margin-top:100px">LA ARRENDADORA:</h1>
<hr style="width:300px;margin-top:100px" class="center">
<h1 class="center">
    {{ @$solicitud->razon_social->razon_social }}<br>
    Por: {{ @$solicitud->razon_social->representante_legal }}<br>
    Cargo: Representante Legal
</h1>


<h1 class="center" style="margin-top:410px">
    HOJA DE FIRMAS DEL CONTRATO DE ARRENDAMIENTO FINANCIERO CELEBRADO POR Y ENTRE LA ARRENDADORA Y LA ARRENDATARIA.
</h1>




<div class="page-break"></div>

<h1 class="center">
    LISTADO DE APÉNDICES Y ANEXOS
</h1>
<br><br><br>
<h1 class="center">
    APÉNDICES
</h1>

<p>
    <b>APÉNDICE I –</b>Carta de Arrendado del Lugar de Ubicación de los Bienes.
</p>
<h1 class="center">
    ANEXOS
</h1>
<p>
    <b>ANEXO “A” -</b> Términos y Condiciones del Arrendamiento
    <br>
    <b>ANEXO “B” –</b> Listado de Proveedores Autorizados
</p>




<div class="page-break"></div>




<h1 class="center">ANEXO "A"</h1>
<p class="upper">
    <b>ANEXO “A” DEL CONTRATO DE ARRENDAMIENTO FINANCIERO</b> No. Folio {{ $solicitud->folio }} , DE FECHA {{ date('d')}} DÍAS DEL MES DE {{ \Carbon\Carbon::now()->formatLocalized('%B') }} DE {{ date('Y')}} CELEBRADO
    ENTRE {{ @$solicitud->razon_social->razon_social }}, A QUIEN SE LE DENOMINÓ LA <b>“ARRENDADORA"</b>; <b style="text-transform:uppercase">{{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</b> , A QUIEN SE LE
    DENOMINÓ LA <b>"ARRENDATARIA"</b>.
</p>

<table class="tbl_contrato" style="margin-top: 30px;font-weight: bold" width="100%">
    <tr>
        <td colspan="2">
            <b class="center">CONDICIONES GENERALES</b>
        </td>
    </tr>
    <tr>
        <td class="center">
            CONCEPTO
        </td>
        <td class="center">VALOR</td>
    </tr>
    <tr>
        <td><b>1. VALOR DE LOS BIENES:</b></td>
        <td>${{ number_format($solicitud->precio_sistema,2) }} MXN</td>
    </tr>
    <tr>
        <td><b>2. ENGANCHE:</b></td>
        <td>${{ number_format($solicitud->enganche,2) }} MXN</td>
    </tr>
    <tr>
        <td><b>3. IMPORTE FINANCIADO DE LOS BIENES:</b></td>
        <td>${{ number_format($solicitud->monto_financiar,2) }} MXN</td>
    </tr>
    <tr>
        <td><b>4. MONTO DEL ARRENDAMIENTO (IMPORTE FINANCIADO MÁS INTERESES ORDINARIOS)</b>:</td>
        <td>${{ number_format($periodos['suma_amortizaciones'],2) }} MXN</td>
    </tr>
    <tr>
        <td><b>5. PAGO INICIAL (COMISIÓN POR APERTURA, PRIMA ANUAL DE SEGURO)</b>:</td>
        <td>${{ number_format($pago_inicial,2) }} MXN + IVA</td>
    </tr>
    <tr>
        <td><b>6. INICIO DE VIGENCIA:</b></td>
        <td>{{ \Carbon\Carbon::now()->formatLocalized('%d/%B/%Y') }}</td>
    </tr>
    <tr>
        <td><b>7. TASA DE INTERES ORDINARIO ANUAL:</b></td>
        <td>{{ $interes_anual }}% anual</td>
    </tr>
    <tr>
        <td><b>8. TASA DE INTERÉS MORATORIO:</b></td>
        <td>{{ @$solicitud->razon_social->interes_moratorio }}% anual</td>
    </tr>
    <tr>
        <td><b>9. PERIODO DE CÁLCULO Y FORMA DE PAGO:</b></td>
        <td>MENSUAL</td>
    </tr>
    <tr>
        <td><b>10. PLAZO FORZOSO:</b></td>
        <td>{{ $solicitud->plazo_financiar }} MESES</td>
    </tr>
    <tr>
        <td><b>11. NÚMERO DE PAGOS PARCIALES:</b></td>
        <td>{{ $solicitud->plazo_financiar }}</td>
    </tr>
    <tr>
        <td><b>12. FECHA DE VENCIMIENTO:</b></td>
        <td>{{ \Carbon\Carbon::parse( $periodos[count($periodos)-1]['fecha_pago'] )->formatLocalized('%d/%B/%Y')  }}</td>
    </tr>
    <tr>
        <td><b>13. COMISIÓN POR MODIFICACIONES A FECHAS DE PAGO:</b></td>
        <td>Hasta $10,000.00 MXN + IVA</td>
    </tr>
    <tr>
        <td><b>14. OPCION DE COMPRA:</b></td>
        <td>El monto en la Tabla de Pagos Parciales en el  <span class="underline">Anexo “A”</span></td>
    </tr>
    <tr>
        <td><b>15. PARTICIPACIÓN POR VENTA:</b></td>
        <td>[N/A]</td>
    </tr>
    <tr>
        <td><b>16. RENTA GLOBAL:</b></td>
        <td>${{ number_format($periodos['suma_amortizaciones'],2) }} MXN</td>
    </tr>
    <tr>
        <td><b>17. LUGAR DE PAGO EN MONEDA NACIONAL:</b></td>
        <td>
            Pago en ventanillas o transferencia electrónica a la siguiente cuenta: <br><br>

            Banco: {{ @$solicitud->razon_social->banco }} <br>
            Beneficiario: {{ @$solicitud->razon_social->beneficiario }} <br>
            Cuenta No.: {{ @$solicitud->razon_social->cuenta }} <br>
            CLABE: {{ @$solicitud->razon_social->clabe }} <br>
            RFC: {{ @$solicitud->razon_social->rfc_beneficiario }} <br>
            Referencia bancaria: [No. Folio] <br>
            
        </td>
    </tr>
    <tr>
        <td><b>18. COMISIÓN POR APERTURA:</b></td>
        <td>${{ number_format($comision_por_apertura)}} MXN + IVA</td>
    </tr>
    <tr>
        <td><b>19. PRIMA ANUAL DE SEGURO:</b></td>
        <td>${{ number_format($costo_anual_seguro,2) }} MXN + IVA </td>
    </tr>
    <tr>
        <td><b>20. GASTOS ADMINISTRATIVOS:</b></td>
        <td>$1,500 MXN + IVA</td>
    </tr>
    <tr>
        <td><b>21. FECHA DE PAGO DE COMISIÓN POR APERTURA:</b></td>
        <td>{{ \Carbon\Carbon::now()->formatLocalized('%d/%B/%Y') }}</td>
    </tr>
    <tr>
        <td><b>22. PLAZO DE PRÓRROGA:</b></td>
        <td>N/A</td>
    </tr>
    <tr>
        <td><b>23. RENTA POR PRÓRROGA:</b></td>
        <td>N/A</td>
    </tr>
    <tr>
        <td><b>24. PAGOS PARCIALES:</b></td>
        <td>El monto en la Tabla de Pagos Parciales en el  <span class="underline">Anexo “A”</span></td>
    </tr>
    <tr>
        <td><b>25. LUGAR DE UBICACIÓN DE LOS BIENES:</b></td>
        <td>
            Domicilio: {{ @$solicitud->cliente->domicilio->calle  }} Ext:{{ @$solicitud->cliente->domicilio->numero_ext  }} Int:{{ @$solicitud->cliente->domicilio->numero_int  }}
            Col. {{ @$solicitud->cliente->domicilio->colonia }}, {{ @$solicitud->cliente->domicilio->municipio->nombre }}, {{ @$solicitud->cliente->domicilio->estado->nombre }}, 
            C.P: {{ @$solicitud->cliente->domicilio->cp }}
        </td>
    </tr>
    <tr>
        <td><b>26. CONDICIONES ESPECIALES:</b></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <b>"27. ESTADO DE CUENTA:</b> <br>
            (i) Envío a través del correo electrónico proporcionado por la Arrendataria, o <br>
            (ii) Consulta vía internet a la página {{ @$solicitud->razon_social->web }}; o <br>
            (iii) Solicitar vía telefónica sin costo en el número 81-2139-6070 <br>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <b>28. UNIDAD ESPECIALIZADA</b><br>
            Domicilio: {{ @$solicitud->razon_social->calle }} #{{ @$solicitud->razon_social->numero_ext }}, interior {{ @$solicitud->razon_social->numero_int }}, Col. {{ @$solicitud->razon_social->colonia }}, {{ @$solicitud->razon_social->municipio->nombre }}, {{ @$solicitud->razon_social->estado->nombre }}, Código Postal {{ @$solicitud->razon_social->cp }}
            Teléfono: {{ @$solicitud->razon_social->telefono }}
            Correo electrónico: {{ @$solicitud->razon_social->correo }} y página web: {{ @$solicitud->razon_social->web }}
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <b>
                29. ADVERTENCIAS: <br>
                <ol type="a">
                    <li>"Incumplir tus obligaciones te puede generar comisiones e intereses moratorios". <br></li>
                    <li>"Contratar financiamientos por arriba de tu capacidad de pago puede afectar tu historial crediticio". <br></li>
                    <li>"El Obligado Solidario responderá como obligado principal frente a la Entidad Financiera ".</li>
                </ol>
            </b>
        </td>
    </tr>
</table>


<br><br><br><br>
<h1>30. TABLA DE PAGOS PARCIALES</h1>
<table class="tbl_contrato" style="margin-top: 10px;" width="100%">
    <tr>
        <td style="background-color:rgb(217, 217, 217);"><b>FECHA DE PAGO</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>CAPITAL</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>INTERÉS</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>IVA INTERES</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>PAGO PARCIAL (TOTAL)</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>OPCION DE COMPRA</b></td>
    </tr>
    @foreach($periodos as $k => $periodo)
        @if($k != 'suma_amortizaciones')
            <tr>
                <td>{{ \Carbon\Carbon::parse( $periodo['fecha_pago'] )->formatLocalized('%d/%B/%Y')  }}</td>
                <td>${{ number_format($periodo['pago_mensual_a_capital'],2) }}</td>
                <td>${{ number_format($periodo['pago_mensual_a_interes'],2) }}</td>
                <td>${{ number_format($periodo['pago_mensual_IVA_interes'],2) }}</td>
                <td>${{ number_format($periodo['subtotal'],2) }}</td>
                <td>
                    @if( $k == (count($periodos) - 1))
                        $1
                    @else
                        ${{ number_format($periodo['precio_opcion_compra'],2) }}
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
</table>

    <div class="page-break"></div>
    <h1>31. DESCRIPCIÓN DE LOS BIENES:</h1>
    <table class="tbl_contrato" style="margin-top: 20px;" width="100%">
    <tr>
        <td style="background-color:rgb(217, 217, 217);"><b>DESCRIPCIÓN / TIPO</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>MARCA / MODELO</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>NUMERO DE SERIE</b></td>
    </tr>
    <tr>
        <td colspan="2" style="height: 480px;vertical-align: top">
            {!! nl2br($solicitud->descripcion_de_bienes) !!}
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            Proveedor Solar
        </td>
        <td>Valor Factura con IVA</td>
    </tr>
    <tr>
        <td colspan="2">
            {{ $solicitud->empresa_instaladora_solar }}
        </td>
        <td>${{ number_format($solicitud->precio_sistema,2) }} MXN </td>
    </tr>
</table>
<p>
    <b>NOTA:</b> De acuerdo al artículo 15 de la Ley del Impuesto al Valor Agregado, el cobro del IVA de los intereses
    ordinarios y moratorios dependerán de la situación fiscal de la Arrendataria. Los montos del IVA expresados en la
    tabla de pagos parciales son únicamente de carácter informativo y podrán variar de acuerdo a lo establecido en el
    artículo 18-A de la Ley del IVA.
</p>

<p>
    LOS TÉRMINOS Y CONDICIONES DEL CONTRATO DE ARRENDAMIENTO FINANCIERO SON, EN ESTE ACTO, INCORPORADOS Y FORMAN PARTE
    DE ESTE ANEXO, COMO SÍ DICHOS TÉRMINOS Y CONDICIONES ESTUVIESEN TOTALMENTE PREVISTOS EN ESTE DOCUMENTO.
    <br><br>
    LEÍDO QUE FUE ESTE ANEXO, LAS PARTES LO FIRMAN, POR <b>CUADRUPLICADO</b> EN Monterrey, Nuevo León, A LOS <b>{{ date('d') }} DÍAS DEL MES DE {{ \Carbon\Carbon::now()->formatLocalized('%B') }} DE {{ date('Y') }}.</b>
</p>

<br><br><br>
<p class="center"> [ Continua hoja de firmas ]</p>


<div class="page-break"></div>


<h1 class="center">LA ARRENDATARIA:</h1>
<hr style="width:300px;margin-top:100px" class="center">
<h1 class="center">Por: {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</h1>


<h1 class="center" style="margin-top:100px">LA ARRENDADORA:</h1>
<hr style="width:300px;margin-top:100px" class="center">
<h1 class="center">
    {{ @$solicitud->razon_social->razon_social }} <br>
    Por: {{ @$solicitud->razon_social->representante_legal }}<br>
    Cargo: Representante Legal
</h1>


<h1 class="center" style="margin-top:410px">
    HOJA DE FIRMAS DEL <span class="underline">ANEXO “A”</span> DEL CONTRATO DE ARRENDAMIENTO FINANCIERO CELEBRADO POR Y ENTRE LA ARRENDADORA Y LA ARRENDATARIA.
</h1>



<div class="page-break"></div>

<h1 class="center">ANEXO "B"</h1>
<h1 class="center">Listado de Proveedores Autorizados</h1>
<p class="center">
    Le informamos que este listado podrá ser modificado de tiempo en tiempo por lo que lo invitamos a revisar el
    listado de proveedores autorizados actualizado en tiempo real en wirewatt.com/proveedoresautorizados
</p>

<div class="page-break"></div>


<h1 class="upper">
    CONSTANCIA DE RECEPCIÓN DE LOS BIENES DEL  <span class="underline">ANEXO “A”</span> DEL CONTRATO DE ARRENDAMIENTO FINANCIERO IDENTIFICADO CON EL
    NÚMERO No. Folio {{ $solicitud->folio }}, DE FECHA {{ date('d') }} DÍAS DEL MES DE {{ \Carbon\Carbon::now()->formatLocalized('%B') }} DE {{ date('Y') }} (EL "CONTRATO DE ARRENDAMIENTO"), CELEBRADO
    ENTRE [{{ @$solicitud->razon_social->razon_social }}], COMO ARRENDADORA, A QUIEN SE LE DENOMINÓ "LA ARRENDADORA", Y {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}, COMO ARRENDATARIA, A QUIEN SE LE DENOMINÓ "LA ARRENDATARIA".
</h1>

<p>
    De acuerdo con el <span class="underline">Anexo “A”</span> y el <b>CONTRATO DE ARRENDAMIENTO</b> arriba mencionados, <b>LA ARRENDATARIA</b> en este acto,
    certifica que los bienes arrendados descritos en dicho <span class="underline">Anexo “A”</span> y que se describen a continuación (los <b>"BIENES"</b>),
    han sido entregados material y jurídicamente e instalados en el "Lugar de Ubicación de los Bienes" especificado en
    el <span class="underline">Anexo “A”</span>, a su entera satisfacción para su uso y goce; declarando asimismo que los mismos han sido debidamente
    inspeccionados <b>LA ARRENDATARIA</b>, manifestando ésta última que cumplen con la descripción, especificaciones y
    condiciones particulares acordadas en el <span class="underline">Anexo “A”</span> y el <b>CONTRATO DE ARRENDAMIENTO</b>, así como en buen estado y en
    condiciones de trabajo y mecánicas para su uso, por lo que, son aceptados incondicionalmente por <b>LA ARRENDATARIA</b> a
    plena conformidad, como <b>BIENES</b> materia del arrendamiento, en la fecha indicada como "Fecha de Aceptación",
    extendiendo por virtud de la misma, el recibo más amplio y eficaz que conforme a derecho corresponde.
</p>

<table class="tbl_contrato" width="100%">
    <tr>
        <td style="background-color:rgb(217, 217, 217);"><b>DESCRIPCIÓN / TIPO</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>MARCA / MODELO</b></td>
        <td style="background-color:rgb(217, 217, 217);"><b>NUMERO DE SERIE</b></td>
    </tr>
    <tr>
        <td colspan="2" style="height: 350px;vertical-align: top">
            {!! nl2br($solicitud->descripcion_de_bienes) !!}
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            Otros
            <br><br><br>
        </td>
        <td></td>
    </tr>
</table>

<p>El presente certificado de aceptación es válido y exigible, de conformidad con los términos en que el mismo se
    encuentra redactado, surtiendo plenamente sus efectos a partir de la fecha de su firma.
</p>

<p>
    Por lo anterior, <b>LA ARRENDATARIA</b> libera a la Arrendadora de cualquier responsabilidad de conformidad con lo
    establecido en el <b>CONTRATO DE ARRENDAMIENTO</b>, renunciando en consecuencia a ejercer a cualquier derecho o acción
    alguna en contra de la Arrendadora, en términos de los artículos 6 y 7 del Código Civil Federal.
</p>

<p>
    Fecha de Recepción y Aceptación de los Bienes: <b>{{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}</b>
</p>

<h1 class="center">LA ARRENDATARIA:</h1>
<hr style="width:300px;margin-top:100px" class="center">
<h1 class="center">Por:{{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}</h1>


<div class="page-break"></div>

<p style="text-align: right">
    Monterrey, Nuevo León, a {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
</p>

<p>
    Domicilio: {{ $solicitud->cliente->domicilio->calle  }} Ext:{{ $solicitud->cliente->domicilio->numero_ext  }} Int:{{ $solicitud->cliente->domicilio->numero_int  }}
            Col. {{ $solicitud->cliente->domicilio->colonia }}, {{ $solicitud->cliente->domicilio->municipio->nombre }}, {{ $solicitud->cliente->domicilio->estado->nombre }}, 
            C.P: {{ $solicitud->cliente->domicilio->cp }}
</p>

    <h1 class="center">Aviso de Cargos Iniciales</h1>
    <p>
        @php
            $total = ($comision_por_apertura * 1.16) + ($costo_anual_seguro * 1.16) + ($solicitud->enganche);
        @endphp
        @php
            $div_decimales = explode('.',number_format($total,2,'.',''));

            $total_letras = NumeroALetras::convertir($div_decimales[0]);
            $total_centavos = (isset($div_decimales[1]))?$div_decimales[1]:'00';
        @endphp

        Por medio del presente le desglosamos los conceptos e importes de los cargos iniciales por la cantidad de
        ${{ number_format($total,2) }} ( {{ $total_letras }}  {{ $total_centavos }}/100 MXN), por los conceptos abajo detallados, de
        conformidad con el  <span class="underline">Anexo “A”</span> del contrato No. Folio {{ $solicitud->folio }}, de Arrendamiento Financiero, celebrado en
        fecha {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}.
        <br><br>
        Dicha cantidad será aplicada de conformidad con lo establecido por el  <span class="underline">Anexo “A”</span> de dicho contrato.
    </p>

    <table class="tbl_contrato" style="margin-top: 20px;" width="100%">
        <tr>
            <td style="background-color:rgb(217, 217, 217);"><b>Concepto</b></td>
            <td style="background-color:rgb(217, 217, 217);"><b>Importe</b></td>
            <td style="background-color:rgb(217, 217, 217);"><b>IVA</b></td>
            <td style="background-color:rgb(217, 217, 217);"><b>Subtotal</b></td>
        </tr>
        <tr>
            <td>Comisión por Apertura</td>
            <td>$ {{ number_format($comision_por_apertura,2) }}</td>
            <td>$ {{ number_format( ($comision_por_apertura * .16),2) }}</td>
            <td>$ {{ number_format( ($comision_por_apertura * 1.16),2) }}</td>
        </tr>
        <tr>
            <td>Prima Anual de Seguro</td>
            <td>$ {{ number_format($costo_anual_seguro,2) }}</td>
            <td>$ {{ number_format( ($costo_anual_seguro * .16) ,2) }}</td>
            <td>$ {{ number_format( ($costo_anual_seguro * 1.16) ,2) }}</td>
        </tr>
        <tr>
            <td>Enganche</td>
            <td>$ {{ number_format(($solicitud->enganche / 1.16),2) }}</td>
            <td>$ {{ number_format( ( $solicitud->enganche -  ($solicitud->enganche / 1.16) ),2) }}</td>
            <td>$ {{ number_format($solicitud->enganche,2) }}</td>
        </tr>

        <tr>
            <td colspan="2"></td>
            <td><b>Total</b></td>
            <td>$ {{ number_format( $total,2) }}</td>
        </tr>
    </table>

    <br><br><br><br><br>

    <p class="center">{{ @$solicitud->razon_social->razon_social }}</p>
</body>
</html>