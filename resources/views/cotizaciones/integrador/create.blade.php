@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
@endsection

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/integrador/cotizaciones" class="btn btn-default2 btn-rounded">Cotizaciones</a>
            <h4 class="page-title d-inline ml-3">Crear cotización</h4>
        </div>
    </div>
@endsection



@section('content')


    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <input type="hidden" name="id" id="cotizacion_id" value="{{ (!is_null($cotizacion)? $cotizacion->id:'') }}">
                    <p>Título</p>
                    <input type="text" class="form-control" id="titulo" value="{{ (!is_null($cotizacion)? $cotizacion->titulo:'') }}">
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-6">
                    <p>Precio de lista a facturar (con IVA)</p>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">$</span>
                        <input type="text" class="form-control" id="precio_lista" value="0.00" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <p>Pago inicial (con IVA)</p>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">$</span>
                        <input type="text" class="form-control" value="0.00" id="pago_inicial" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p>$ Prestamo</p>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">$</span>
                        <input type="text" class="form-control" id="prestamo" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <p>$ Mensualidad (con IVA)</p>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">$</span>
                        <input type="text" class="form-control" value="0.00" id="mensualidad" readonly>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-6">
                    <label>
                        <input type="checkbox" id="check_merchant_fee" name="">
                        Merchant Fee (con IVA)
                    </label>
                    <br>
                    <p>$<span id="lbl_merchant_fee"></span></p>                    
                </div>

                <div class="col-md-6">
                    <label>
                        <input type="checkbox" name="" id="check_comision_apertura">
                        Comisión por apertura (con IVA)
                    </label>
                    <br>
                    <p>$<span id="lbl_comision_apertura"></span></p>
                </div>
            </div>


            <div class="row">
                <div class="col-md-5">
                    <br><br>
                    <p>Plan</p>                    
                    <select name="" id="plan_id" class="form-control">                        
                        @foreach ($productos as $producto)
                            <optgroup label="{{ $producto->nombre }}" data-producto_id="{{ $producto->id }}" data-producto_nombre="{{ $producto->nombre }}">
                                @foreach ($producto->planes as $p)
                                    @if ($p->activo)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-md-11">
                    <br>
                    <p>Precio del sistema (con IVA)</p>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">$</span>
                        <input type="text" id="precio_sistema" class="form-control" style="width:50% !important" value="5000" onkeypress="return isNumberKey(event)">
                    </div>
                    {{-- <input type="text" id="necesitas" > --}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-11">
                    <br>
                    <p>Selecciona un monto de enganche</p>
                    <input type="text" id="enganche">
                </div>
            </div>

            <div class="row">
                <div class="col-md-11">
                    <br>
                    <p>¿A cuántos meses?</p>
                    <input type="text" id="plazo_financiar">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <br>
                    <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>

                    <label class="ml-4">
                        <input type="checkbox" name="" id="transmitir_cliente">
                        Transmitir comisión a cliente
                    </label>
                </div>                
            </div>

        </div>


        <div class="col-md-6">

            <table class="table" id="tblPlanes">
                <tr>
                    <th></th>
                    <th>Prestamo</th>
                    <th>Pago inicial</th>
                    <th>Mensualidad</th>
                    <th></th>
                </tr>
                <tbody>
                    @foreach ($planes_agregados as $nombre_prod => $detalles)
                        <tr data-producto_id="{{ $detalles[0]['plan']['producto_id'] }}" class="tr_titulo">
                            <td colspan="4">{{ $nombre_prod }}</td>
                        </tr>
                        @foreach ($detalles as $detalle)
                            <tr class="tr_detalle" data-grupo="{{ $detalle['plan']['producto_id']}}" data-plan_id="{{ $detalle['plan_id']}}">
                                <td>{{ $detalle['plan']['nombre']}}</td>
                                <td>${{ number_format($detalle['monto_financiar'],2) }}</td>
                                <td>${{ number_format($detalle['pago_inicial'],2) }}</td>
                                <td>${{ number_format($detalle['mensualidad'],2) }}</td>
                                <td>
                                    
                                    @if ( $detalle['estatus_id'] != 3)
                                        <a href="{{ route('integrador.preautorizar', $detalle['id'])}}" class="detalle" data-detalle_id="{{ $detalle['id']}}" title="Preautorizar">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </a>

                                        <a href="#" class="delete_detalle" data-detalle_id="{{ $detalle['id']}}" title="Eliminar"
                                            data-url="{{ route('integrador.detalle_cotizacion.delete',$detalle['id'] )}}"
                                        >
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>                                        
                                    @endif
                                    
                                    <a href="#">
                                        <i class="fa fa-info show-tooltip" title="" data-placement="left" data-toggle="tooltip" data-html="true" 
                                            data-original-title="
                                                Interes anual: {{ $detalle['plan']['interes_anual'] }}% <br>
                                                Comisión por apertura: ${{ number_format(  ($detalle['monto_financiar'] * ($detalle['plan']['comision_por_apertura'] / 100)),2)   }}  ({{ $detalle['plan']['comision_por_apertura'] }}%) <br>
                                                Merchant fee: ${{ number_format(  1.16 * ($detalle['monto_financiar'] * ($detalle['plan']['merchant_fee'] / 100)),2) }} ({{ $detalle['plan']['merchant_fee'] }}%)
                                            ">
                                                
                                        </i>                                            
                                    </a>

                                </td>
                            </tr>
                        @endforeach                      
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('extra-js')
    <script src="https://underscorejs.org/underscore-min.js"></script>
    <script src="{{ asset('assets/plugins/bower_components/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>

    <script>
        var planes = @json($planes);
        /* var minFinanciar = {{ $minFinanciar }}; //Se carga desde las configuraciones */
        var minFinanciar = 5000; 

        $(function(){            
            check_comision_apertura();
            $('#check_comision_apertura').click(function(){
                check_comision_apertura();
            })
            check_merchant_fee();
            $('#check_merchant_fee').click(function(){
                check_merchant_fee();
            })


            $('#transmitir_cliente').click(function(){
                
                getMensualidad();                  
            })

            $("#necesitas").ionRangeSlider({
                min: 5000,
                max: 1500000,
                from: 5000,
                prefix: "$",
                grid: true,
                step:1000,
                onFinish:function(data){                    
                    setPrestamo();
                    getMensualidad();
                    $("#precio_sistema").val(data.from);
                },
                onChange:function(){
                    setEnganche();
                }
            });


            $("#enganche").ionRangeSlider({
                min: 0,
                max: 0,
                from: 0,
                prefix: "$",
                grid: true,
                step:1000,
                onFinish:function(data){
                    setPrestamo();
                    getMensualidad();
                }
            });

            $("#plazo_financiar").ionRangeSlider({
                min: 1,
                max: 120,
                from: 1,
                grid: true,
                step:3,
                postfix:' meses',
                onFinish:function(data){
                    getMensualidad();
                }
            });


            $('#plan_id').change(function(){
                setPlan();
                getMensualidad();
            })


            setPlan();
            setEnganche();
            setPrestamo();
            getMensualidad();

            $('#btnAgregar').click(function(){

                if($('.tr_detalle').length === 9){
                    alert("No puedes agregar más de nueve opciones a la cotización");
                    return false;
                }
                var plan_id = $('#plan_id').val();
                var plan_nombre = $('#plan_id option:selected').text();
                var producto_id = $('#plan_id option[value="'+ plan_id +'"]').parent().data('producto_id');
                var lbl_producto = $('#plan_id option[value="'+ plan_id +'"]').parent().data('producto_nombre');
                var prestamo = $("#prestamo").val();
                var enganche = $("#enganche").val();
                var monto_solicitado = $('#precio_sistema').val();
                var plazo_financiar = $('#plazo_financiar').val();
                var cotizacion_id = $('#cotizacion_id').val();
                var titulo = $('#titulo').val();

                var tblPlanes = $('#tblPlanes');


                var precio_lista = $('#precio_lista').val();
                var pago_inicial = $('#pago_inicial').val();

                //mandamos datos para crear cotizacion
                var formDetail = new FormData();
                formDetail.append('cotizacion_id' , cotizacion_id);
                formDetail.append('plan_id' , plan_id);
                formDetail.append('monto_solicitado' , monto_solicitado);
                formDetail.append('monto_financiar' , prestamo);
                formDetail.append('plazo_financiar' , plazo_financiar);
                formDetail.append('enganche' , enganche);
                formDetail.append('titulo' , titulo);
                formDetail.append('precio_lista' , precio_lista);
                formDetail.append('pago_inicial' , pago_inicial);


                
                $.ajax({
                    url: '{{ route('integrador.add_cotizacion') }}',
                    type: 'POST',
                    dataType: "json",
                    data:formDetail,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //Revisamos si ya existe apartado del plan
                        $('#cotizacion_id').val(data.cotizacion_id);

                        var count = tblPlanes.find('tbody tr.tr_titulo[data-producto_id="'+ producto_id +'"]').length;
                        var html = "";

                        var monto_comision_apertura = parseFloat(prestamo) * ( data.comision_por_apertura / 100);
                        var monto_merchant_fee = parseFloat(prestamo) * ( data.merchant_fee / 100);

                        if(count == 0){
                            //Insertamos el titulo
                            html = `<tr data-producto_id="${producto_id}" class="tr_titulo">\
                                        <td colspan="4">${lbl_producto}</td>\
                                    </tr>`;
                            
                            //Insertamos el row
                            html += `<tr class="tr_detalle" data-grupo="${producto_id}" data-plan_id="${plan_id}">
                                        <td>${plan_nombre}</td>
                                        <td>$${parseFloat(prestamo).formatMoney(2)}</td>
                                        <td>$${parseFloat(pago_inicial).formatMoney(2)}</td>
                                        <td>$${data.mensualidad }</td>
                                        <td>
                                            <a href="/integrador/cotizacion/${data.detalle_id}/preautorizar" class="detalle" data-detalle_id="${data.detalle_id}" title="Preautorizar">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>

                                            <a href="#" class="delete_detalle" data-detalle_id="${data.detalle_id}" title="Eliminar"
                                                data-url="/cotizacion_detalle/${data.detalle_id}/delete"
                                            >
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>

                                            
                                            <a href="#" >
                                                <i class="fa fa-info show-tooltip" title="" data-placement="left" data-toggle="tooltip" data-html="true" 
                                                    data-original-title="
                                                        Interes anual: ${ data.interes_anual}% <br>
                                                        Comisión por apertura: $${ parseFloat(monto_comision_apertura ).formatMoney(2) } (${ data.comision_por_apertura }%)<br>
                                                        Merchant Fee: $${ parseFloat(( 1.16 * monto_merchant_fee )).formatMoney(2) } (${ data.merchant_fee }%)
                                                    ">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>`;
                            
                            tblPlanes.append(html);
                        }else{
                            //Ya existe
                            //Insertamos el row
                            html = `<tr class="tr_detalle" data-grupo="${producto_id}" data-plan_id="${plan_id}">
                                        <td>${plan_nombre}</td>
                                        <td>$${parseFloat(prestamo).formatMoney(2)}</td>
                                        <td>$${parseFloat(pago_inicial).formatMoney(2)}</td>
                                        <td>$${data.mensualidad}</td>
                                        <td>
                                            <a href="/integrador/cotizacion/${data.detalle_id}/preautorizar" class="detalle" data-detalle_id="${data.detalle_id}" title="Preautorizar">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>

                                            <a href="#" class="delete_detalle" data-detalle_id="${data.detalle_id}" title="Eliminar"
                                                data-url="/cotizacion_detalle/${data.detalle_id}/delete"
                                            >
                                                <i class="fa fa-times" aria-hidden="true"></i>                                                
                                            </a>
                                            <a href="#" >
                                                <i class="fa fa-info show-tooltip" title="" data-placement="left" data-toggle="tooltip" data-html="true" 
                                                    data-original-title="
                                                        Interes anual: ${ data.interes_anual}% <br>
                                                        Comisión por apertura: $${ parseFloat(monto_comision_apertura ).formatMoney(2) } (${ data.comision_por_apertura }%)<br>
                                                        Merchant Fee: $${ parseFloat(( 1.16 * monto_merchant_fee )).formatMoney(2) } (${ data.merchant_fee }%)
                                                    ">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>`;
                            tblPlanes.find('tr[data-producto_id="'+ producto_id +'"]').after(html);
                        }

                        $(".fa-info").tooltip();


                    },
                    error:function(data){

                    }
                });
            })


            $(document).on('click', '.delete_detalle', function(e){
                e.stopPropagation();
                e.preventDefault();
                if(confirm("¿Seguro de eliminar el registro?")){

                    var tr = $(this).parent().parent();
                    var a = $(this);
                    let detalle_id = a.data('detalle_id');
                    var formDetail = new FormData();
                    formDetail.append('detalle_id' ,detalle_id);
    
                    var pass = "";
                    $.ajax({
                        url: "/integrador/cotizacion_detalle/"+ detalle_id +"/delete",
                        type: 'DELETE',
                        dataType: "json",
                        data:formDetail,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            tr.remove();
                        },
                        error:function(data){
                        
                        }
                    });
                }
            });

            $('#precio_sistema').keyup(function(){
                console.log($('#precio_sistema').val());
                var valor = parseFloat($(this).val());
                // var slider = $("#necesitas").data("ionRangeSlider");
                // //buscamos el plan
                
                // slider.reset();
                // slider.update({
                //     from : valor,
                // });       

                setEnganche();
                setPrestamo();
                // setEnganche();
                getMensualidad();  
                // setEnganche();       
            })
                    
    

        })

        function check_comision_apertura(){        
            $('#lbl_comision_apertura').parent().hide();
            if( $('#check_comision_apertura').is(':checked') ) {
                $('#lbl_comision_apertura').parent().show();
            }
        }

        function check_merchant_fee(){
            $('#lbl_merchant_fee').parent().hide();
            if( $('#check_merchant_fee').is(':checked') ) {
                $('#lbl_merchant_fee').parent().show();
            }
        }

        function getMensualidad(){
            var monto_solicitado = $('#precio_sistema').val();
            var plazo_financiar = $('#plazo_financiar').val();
            var enganche = parseFloat($("#enganche").val());
            var plan_id = $("#plan_id").val();

            var formDetail = new FormData();
            formDetail.append('monto_solicitado' , monto_solicitado);
            formDetail.append('enganche' , enganche);
            formDetail.append('plazo_financiar' , plazo_financiar);
            formDetail.append('plan_id' , plan_id);


            var prestamo = parseFloat($("#prestamo").val());
            var precio_sistema = parseFloat($("#precio_sistema").val());

            var transmitir_cliente = $('#transmitir_cliente').is(':checked');
            

            $.ajax({
                url: '{{ route('solicitudes.getMensualidad') }}',
                type: 'POST',
                dataType: "json",
                data:formDetail,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    $('#mensualidad').val(data.mensualidad)

                    var comision_por_apertura = ( parseFloat(data.comision_por_apertura) / 100)
                    var interes_anual =  (parseFloat(data.interes_anual) / 100) ;
                    var merchant_fee = (parseFloat(data.merchant_fee) / 100);

                    var monto_merchant_fee = (prestamo * merchant_fee) * 1.16;
                    var monto_comision_apertura = prestamo * comision_por_apertura;
                    console.log("monto_merchant_fee: " + monto_merchant_fee);
                    if(transmitir_cliente){

                        //Transfiriendo a cliente
                        var precio_lista = monto_merchant_fee + precio_sistema;
                        var pago_inicial = monto_merchant_fee + enganche + monto_comision_apertura;
                    }else{
                        //console.log('precio_sistema: ' + precio_sistema);
                        var precio_lista = precio_sistema;
                        var pago_inicial = enganche + monto_comision_apertura;
                    }

                    $('#precio_lista').val(precio_lista.toFixed(2));
                    $('#pago_inicial').val(pago_inicial.toFixed(2));

                    $('#lbl_merchant_fee').html( monto_merchant_fee.toFixed(2));
                    $('#lbl_comision_apertura').html( monto_comision_apertura.toFixed(2));

                    setPrestamo();

                },
                error:function(data){

                }
            });
        }

        function setPlan(){            
            var plan_id =  $('#plan_id').val() ;
            if (plan_id != ''){
                //Obtenemos el plan
                var slider = $("#plazo_financiar").data("ionRangeSlider");
                //buscamos el plan
                var plan = _.findWhere(planes,{"id":parseInt(plan_id)});
                slider.reset();
                slider.update({
                    max: plan.plazo,
                    from : plan.plazo,
                    disable: !plan.personalizado
                });

                /* $('#cotizacion_meses').html(planes[plan_id].plazo); */
            }else{
                var slider = $("#plazo_financiar").data("ionRangeSlider");
                slider.reset();
                slider.update({
                    max: 120,
                    from :0,
                    disable:false
                });

                /* $('#cotizacion_meses').html("");  */
            }
        }

        function setEnganche(){
            var maxEnganche = 0;

            var monto_solicitado = parseFloat($('#precio_sistema').val());
            maxEnganche = monto_solicitado - minFinanciar;
            var medio = maxEnganche / 2;

            medio = maxEnganche / 2;

            var slider = $("#enganche").data("ionRangeSlider");
            slider.reset();
            slider.update({
                max: maxEnganche,
                from :medio
            });

            getMensualidad();
        }

        function setPrestamo(){
            var monto_solicitado = parseFloat($('#precio_sistema').val());
            var enganche = parseFloat($('#enganche').val());

            var monto_prestamo = monto_solicitado - enganche;

            $('#prestamo').val(monto_prestamo);

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

        /* $(document).on('keydown', '#precio_sistema', function(e){
            var input = $(this);
            var oldVal = input.val();
            //var regex = new RegExp('^\d*(\.\d{0,2})?$', 'g');
            var regex = new RegExp('^\d+\.\d{0,2}$', 'g');

            setTimeout(function(){
                var newVal = input.val();
                if(!regex.test(newVal)){
                input.val(oldVal); 
                }
            }, 0);
        }); */

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            }
            return true;
        }


    </script>
@endsection