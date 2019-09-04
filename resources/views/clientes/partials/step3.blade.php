<div id="step3">


    <div class="form-group row">
        <h3 class="col-md-12 naranja"> Cotización</h3>
    </div>

    <div class="row justify-content-lg-center">
        <h3 class="col-md-12 col-lg-10 text-left">Descripción del Financiamiento</h3>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(+) Comisión por apertura
            <input type="hidden" value="" id="input_comision_apertura">
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="Comisión	por	aperturar del crédito">?</button>
        </label>
        <label class="desc_der col-lg-7 text-left"><span id="comicion_apertura"></span> (<span id="lbl_porcentaje_comision_apertura"></span>)%</label>
    </div>


    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(+) Costo anual del seguro
            <input type="hidden" value="" id="input_costo_anual_seguro">
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="El crédito requiere de un seguro	de daños para el sistema solar FV.">?</button>
        </label>
        <label class="desc_der col-lg-7 text-left"><span id="costo_anual_seguro"></span></label>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(=) Pago Inicial
            <input type="hidden" value="" id="input_pago_inicial">
            <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="El pago inicial es requerido	para otorgar el crédito	solar">?</button>
        </label>
        <label class="desc_der col-lg-7 text-left"><span id="pago_inicial"> $</span></label>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">Plazo</label>
        <label class="desc_der col-lg-7 text-left"><span id="cotizacion_meses"></span> meses</label>
    </div>

    <div class="form-group row justify-content-lg-center">
        <h3 class="col-md-12 col-lg-10 text-left">Descripción del Cotización</h3>
    </div>
    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(+) Precio del sistema FV</label>
        <label class="desc_der col-lg-7 text-left"><span id="cotizacion_precio_sistema"> </span></label>
    </div>


    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(-) Enganche</label>
        <label class="desc_der col-lg-7 text-left"><span id="cotizacion_enganche"> </span></label>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">(=) Total a financiar</label>
        <label class="desc_der col-lg-7 text-left"><span id="cotizacion_total_financiar"> </span></label>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="desc_izq col-lg-3 text-left">Primer mensualidad</label>
        <label class="desc_der col-lg-7 text-left">$<span id="cotizacion_primer_mensualidad"></span></label>
    </div>


    <div class="form-group row justify-content-lg-center">
        <div class="col-lg-12">
            <button id="btnSubmit" type="button" class="submit action-button btn btn-outline btn-rounded btn-warning pull-right">Iniciar preaprobación de crédito</button>
            <a href="#" id="btnPdf" target="_blank" class="btn btn-outline btn-rounded btn-warning pull-right">
                <i class="fa fa-file-pdf-o m-r-5"></i>
                Descargar PDF
            </a>
            <br><br><br><br>
            <table class="table" id="tablePeriodos">
                <thead>
                <tr>
                    <th>Pago No.</th>
                    <th>Fecha de vencimiento</th>
                    <th>Pago mensual a capital</th>
                    <th>Pago mensual interés</th>
                    <th>Pago mensual IVA interés</th>
                    <th>Pago total mensual</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>