<div id="step2">
    <div class="form-group row">
        <h3 class="col-md-12"><span class="naranja">Pre-cotizar</span> un crédito</h3>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <label for="">Plan</label><br>
            {!! Form::select('plan_id',$planes_list,'null',['class'=>'form-control','placeholder'=>'Plan personalizado','id'=>'plan_id']) !!}
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            <input id="precio_sistema" name="solicitud[precio_sistema]" placeholder="¿Cuál es el precio del sistema solar FV?" type="text" class="form-control{{ $errors->has('solicitud.precio_sistema') ? ' is-invalid' : '' }}" value="{{  $errors->has('solicitud.precio_sistema') }}" >
            @if ($errors->has('solicitud.precio_sistema'))
                <div class="invalid-feedback">
                    {{ $errors->first('solicitud.precio_sistema') }}
                </div>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-lg-center">
        <label class="text-left">Selecciona monto de enganche</label>
        <div class="col-md-8 col-lg-8">
            <input type="text" name="solicitud[enganche]" id="enganche">
        </div>

        <div class="col-md-2 col-lg-2">
            <h3><span id="porcentaje_enganche">0</span>%</h3>
        </div>
    </div>

    <div class="form-group row justify-content-lg-center">
        <label class="text-left">Selecciona el plazo a financiar del sistema</label>
        <div class="col-md-12 col-lg-10">
            <input type="hidden" name="solicitud[plazo_financiar]" id="plazo_financiar">
        </div>
    </div>
</div>


<script>
    var monto_financiar = 0;
    var maxEnganche = 0;
    var minFinanciar = {{ $minFinanciar }};


    var porcentaje_comision_apertura = {{ $configuracion->comision_por_apertura }};
    var planes = {!! $planes !!};


    $(function(){
        $("#enganche").ionRangeSlider({
            min: 0,
            max: 0,
            from: 0,
            prefix: "$",
            grid: true,
            step:1000,
            onFinish:function(data){

                var porcentaje_enganche = 0;
                var precio_sistema = 0;

                if (!isNaN( parseFloat($('#precio_sistema').val()) )){
                    precio_sistema = parseFloat($('#precio_sistema').val());
                }
                porcentaje_enganche = (data.from * 100) / precio_sistema;
                console.log(porcentaje_enganche);
                $('#porcentaje_enganche').html(porcentaje_enganche.formatMoney(2));
            }
        });

        setEnganche();
        $('#precio_sistema').keyup(function(e){
            e.preventDefault();
            setEnganche();
        })


        $("#plazo_financiar").ionRangeSlider({
            min: 0,
            max: 120,
            from: 0,
            grid: true,
            step:3,
            postfix:' meses',
            onFinish:function(data){
                $('#cotizacion_meses').html(data.from);
            }
        });

        $('#btnStep2').click(function(e){
            //Guardamos en variable _porcentaje_comision_apertura para no sobreescribir la general
            var _porcentaje_comision_apertura = porcentaje_comision_apertura;
            var plan_id = $('#plan_id').val();
            $('#cotizacion_precio_sistema').html( '$'+parseFloat($('#precio_sistema').val()).formatMoney(2) );
            $('#cotizacion_enganche').html('$'+ parseFloat($('#enganche').val()).formatMoney(2) );

            //enganche  precio sistema - monto a financiar
            var precio_sistema = parseFloat($('#precio_sistema').val());
            var monto_financiar = precio_sistema - parseFloat($('#enganche').val())
            var aplica_costo_anual_seguro = true;

            $('#cotizacion_total_financiar').html('$'+ parseFloat(monto_financiar).formatMoney(2));

            if(plan_id != ''){
                //calculamos porcentaje_comision_apertura
                aplica_costo_anual_seguro = planes[plan_id].aplica_costo_anual_seguro;
                _porcentaje_comision_apertura = planes[plan_id].comision_por_apertura;
            }

            var comision_por_apertura = parseFloat(monto_financiar) * (_porcentaje_comision_apertura / 100);


            $('#input_comision_apertura').val(comision_por_apertura);
            $('#comicion_apertura').html('$'+ parseFloat(comision_por_apertura).formatMoney(2));

            var costo_anual_seguro = 0;
            monto_financiar = parseFloat(monto_financiar);

            if(aplica_costo_anual_seguro){
                if (monto_financiar <= 110000){
                    costo_anual_seguro = 2085;
                }else if(monto_financiar > 110000 && monto_financiar <= 220000){
                    costo_anual_seguro = 2464;
                }else if(monto_financiar > 220000 && monto_financiar <= 310000){
                    costo_anual_seguro = 3601;
                }else if(monto_financiar > 310000){
                    costo_anual_seguro = 3980;
                }
            }
            $('#input_costo_anual_seguro').val(costo_anual_seguro);
            $('#costo_anual_seguro').html('$'+ parseFloat(costo_anual_seguro).formatMoney(2));


            var pago_inicial = costo_anual_seguro + comision_por_apertura;
            $('#input_pago_inicial').val(pago_inicial);
            $('#pago_inicial').html('$'+ parseFloat(pago_inicial).formatMoney(2));


            if(plan_id != ''){
                $('#lbl_porcentaje_comision_apertura').html(_porcentaje_comision_apertura);
            }else{
                $('#lbl_porcentaje_comision_apertura').html(porcentaje_comision_apertura);
            }


        })


        setPlan();
        $('#plan_id').change(function(){
            setPlan();
        });

})

    function setPlan(){
        var plan_id = $('#plan_id').val();

        if (plan_id != ''){
            //Obtenemos el plan
            var slider = $("#plazo_financiar").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: planes[plan_id].plazo,
                from :planes[plan_id].plazo,
                disable:true
            });

            $('#cotizacion_meses').html(planes[plan_id].plazo);
        }else{
            var slider = $("#plazo_financiar").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: 120,
                from :0,
                disable:false
            });

            $('#cotizacion_meses').html("");
        }
    }


    function setEnganche(){
        var precio_sistema = 0;

        if (!isNaN( parseFloat($('#precio_sistema').val()) )){
            precio_sistema = parseFloat($('#precio_sistema').val());
        }
        maxEnganche = precio_sistema - minFinanciar;
        medio = maxEnganche / 2;

        var slider = $("#enganche").data("ionRangeSlider");
        slider.reset();
        slider.update({
            max: maxEnganche,
            from :medio
        });

        var porcentaje_enganche = 0;
        var precio_sistema = 0;
        var enganche = $("#enganche").val();
        if (!isNaN( parseFloat($('#precio_sistema').val()) )){
            precio_sistema = parseFloat($('#precio_sistema').val());
        }
        porcentaje_enganche = (enganche * 100) / precio_sistema;

        $('#porcentaje_enganche').html(porcentaje_enganche.formatMoney(2));
        if(isNaN(porcentaje_enganche)){
            $('#porcentaje_enganche').html(0);
        }

    }

    function getPeriodos(){
        var formDetail = new FormData();
        formDetail.append('precio_sistema' , $('#precio_sistema').val());
        formDetail.append('enganche' , $('#enganche').val());
        formDetail.append('periodos' , $('#plazo_financiar').val());
        formDetail.append('plan_id' , $('#plan_id').val());

        $.ajax({
            url: '{{ route('calcula_periodos') }}',
            type: 'POST',
            dataType: "json",
            data:formDetail,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var html = "";
                $.each(data,function(k,v){


                    var pago_mensual_a_capital = formatter.format(v.pago_mensual_a_capital);
                    var pago_mensual_a_interes = formatter.format(v.pago_mensual_a_interes);
                    var pago_mensual_IVA_interes = formatter.format(v.pago_mensual_IVA_interes);
                    var subtotal = formatter.format(v.subtotal);


                    html +="<tr>\
                                <td>"+ k +"</td>\
                                <td>"+ v.fecha_pago +"</td>\
                                <td>"+ (pago_mensual_a_capital) +"</td>\
                                <td>"+ (pago_mensual_a_interes) +"</td>\
                                <td>"+ (pago_mensual_IVA_interes) +"</td>\
                                <td>"+ (subtotal) +"</td>";
                })

                $('#tablePeriodos tbody').html(html);
                //console.log(data);

                $('#cotizacion_primer_mensualidad').html(data[1]['subtotal'].formatMoney(2));
            },
            error:function(data){

            }
        });
    }

    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        // the default value for minimumFractionDigits depends on the currency
        // and is usually already 2
    });

    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
</script>
