<div class="row">
    <div class="col-md-12">
        <h2>Cotización</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <h5>Precio del sistema (con IVA)</h5>
        <p>${{ number_format($solicitud->precio_sistema,2)}}</p>
    </div>

    <div class="col-md-4">
        <h5>Anticipo / Enganche(con IVA)</h5>
        <p>${{ number_format($solicitud->enganche,2)}}</p>
    </div>        

    <div class="col-md-4">
        <h5>Monto a financiar(con IVA)</h5>
        <p>${{ number_format($solicitud->monto_financiar,2)}}</p>
    </div>
    
    <div class="col-md-4">
        <h5>Plazo</h5>
        <p>{{ $solicitud->plazo_financiar}} meses</p>
    </div>
    
    <div class="col-md-4">
        <h5>Mensualidad</h5>
        <p>${{ number_format($periodos[1]['subtotal'],2)}}</p>
    </div>

    <div class="col-md-4">
        <a href="{{ route('pdf_solicitud', $solicitud->id )}}" id="btnPdf" target="_blank" class="btn btn-outline btn-rounded btn-warning ">
            <i class="fa fa-file-pdf-o m-r-5"></i> 
            Descargar PDF
        </a>
    </div>
</div>