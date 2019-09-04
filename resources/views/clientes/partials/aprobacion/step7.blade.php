<div class="row">
    <div class="col-md-12">
        <h2>Datos sistema solar</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label for="">Plan</label><br>
        {!! Form::select('plan_id',$planes_list,Auth::user()->cliente->solicitudes[0]->plan_id,['class'=>'input_underline form-control','placeholder'=>'Plan perzonalizado','id'=>'plan_id']) !!}
    </div>
</div>


<div class="row">
    <div class="col-md-4">
        <p>¿Cuál es el precio del sistema solar FV?</p>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">$</span>
            <input id="solicitud_precio_sistema"
                   placeholder="{{ __('$') }}"
                   type="text"
                   class="input_underline form-control"
                   value="{{ Auth::user()->cliente->solicitudes[0]->precio_sistema }}"
            >
        </div>
    </div>

    <div class="col-md-2">
        <br><br>
        <button class="btn btn-default" id="btnGetPerdiodos">Actualizar</button>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <p >Selecciona el monto del enganche</p>
        <input id="enganche">
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <p >Selecciona el plazo a financiar del sistema</p>
        <input  id="rango_meses">
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <br>
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


<script>
    var planes = {!! $planes !!};
    var plazo_original = {{ (Auth::user()->cliente->solicitudes[0]->plazo_financiar > 0)?Auth::user()->cliente->solicitudes[0]->plazo_financiar:0 }};
    $(function(){
        $("#enganche").ionRangeSlider({
            min: 0,
            max: {{ $maxEnganche }},
            from: {{ (Auth::user()->cliente->solicitudes[0]->enganche > 0)?Auth::user()->cliente->solicitudes[0]->enganche:0 }},
            prefix: "$",
            grid: true,
            step:1000,
            onFinish:function(data){
                getPeriodos();
            }
        });

        $("#rango_meses").ionRangeSlider({
            min: 0,
            max: 120,
            from: {{ (Auth::user()->cliente->solicitudes[0]->plazo_financiar > 0)?Auth::user()->cliente->solicitudes[0]->plazo_financiar:0 }},
            grid: true,
            step:3,
            postfix:' meses',
            onFinish:function(data){
                getPeriodos();
            }
        });

        setPlan()
        $('#solicitud_precio_sistema').keyup(function(e){
            e.preventDefault();
            setEnganche();
        })


        $('#btnGetPerdiodos').click(function(){
            getPeriodos();
        })

        $('#plan_id').change(function(){
            setPlan();
        })
    })

    function setPlan(){
        var plan_id = $('#plan_id').val();

        if (plan_id != ''){
            //Obtenemos el plan
            var slider = $("#rango_meses").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: planes[plan_id].plazo,
                from :planes[plan_id].plazo,
                disable:true
            });

            $('#cotizacion_meses').html(planes[plan_id].plazo);
        }else{
            var slider = $("#rango_meses").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: 120,
                from :plazo_original,
                disable:false
            });
        }

        getPeriodos();
    }

    function validateStep7() {
        var errors = '';

        if( $('#solicitud_precio_sistema').val() == ''){
            errors += '* El precio del sistema es necesario.' + '.<br>';
        }




        if( $('#rango_meses').val() == 0){
            errors += "*No se seleccionó el plazo a financiar.<br>";
        }



        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('step' , 7);
            formDetail.append('cliente_id' , $('#cliente_id').val());
            formDetail.append('solicitud_id' , $('#solicitud_id').val());

            formDetail.append('precio_sistema' , $('#solicitud_precio_sistema').val());
            formDetail.append('enganche' , $('#enganche').val());
            formDetail.append('plazo_financiar' , $('#rango_meses').val());
            formDetail.append('plan_id' , $('#plan_id').val());

            pass = "";
            $.ajax({
                url: '{{ route('postSteps') }}',
                type: 'POST',
                dataType: "json",
                data:formDetail,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    pass = true;
                },
                error:function(data){
                    console.log(data.responseJSON.errors);
                    var errors = "";
                    $.each(data.responseJSON.errors,function(k,v){
                        errors += "<b>"+ k +"</b><br>";
                        $.each(v,function(i,err){
                            errors += "*" + err + "<br>";
                        })
                    })

                    $.toast({
                        heading: 'Errores detectados',
                        text: errors,
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 9500
                    });
                    pass = false;
                }
            });
            return pass;

        }else{
            $.toast({
                heading: 'Errores detectados',
                text: errors,
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 9500
            });
            return false;
        }


    }



    var minFinanciar = {{ $minFinanciar }};
    function setEnganche(){
        var precio_sistema = 0;

        if (!isNaN( parseFloat($('#solicitud_precio_sistema').val()) )){
            precio_sistema = parseFloat($('#solicitud_precio_sistema').val());
        }
        maxEnganche = precio_sistema - minFinanciar;
        medio = {{ Auth::user()->cliente->solicitudes[0]->enganche }}

        var slider = $("#enganche").data("ionRangeSlider");
        slider.reset();
        slider.update({
            max: maxEnganche,
            from :medio
        });
    }

    function getPeriodos(){
        var errors = '';

        if( $('#solicitud_precio_sistema').val() == ''){
            errors += '* El precio del sistema es necesario.' + '.<br>';
        }


        if(errors.length == 0){
            var formDetail = new FormData();
            formDetail.append('precio_sistema' , $('#solicitud_precio_sistema').val());
            formDetail.append('enganche' , $('#enganche').val());
            formDetail.append('periodos' , $('#rango_meses').val());
            formDetail.append('solicitud_id' , {{ Auth::user()->cliente->solicitudes[0]->id }});
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
                        html +="<tr>\
                                <td>"+ k +"</td>\
                                <td>"+ v.fecha_pago +"</td>\
                                <td>$"+ (v.pago_mensual_a_capital).formatMoney(2) +"</td>\
                                <td>$"+ (v.pago_mensual_a_interes).formatMoney(2) +"</td>\
                                <td>$"+ (v.pago_mensual_IVA_interes).formatMoney(2) +"</td>\
                                <td>$"+ (v.subtotal).formatMoney(2) +"</td>\
                            </tr>";
                    })

                    $('#tablePeriodos tbody').html(html);
                    console.log(data);
                },
                error:function(data){

                }
            });
        }else{
            $.toast({
                heading: 'Errores detectados',
                text: errors,
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 9500
            });
        }


    }

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