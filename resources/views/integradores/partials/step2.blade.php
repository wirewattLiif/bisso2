<div id="step1">
    <div class="form-group row">
        <h3 class="col-md-12 naranja">Datos de la empresa</h3>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-6 col-lg-6">
            <input type="hidden" id="usuario_id" name="usuario_id" value="">
            {!! Form::text('integrador[razon_social]', null, ['id'=>'integrador_razon_social','class'=>"form-control",'required'=>true,'placeholder'=>'Razón social']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            {!! Form::text('integrador[nombre_comercial]', null, ['id'=>'integrador_nombre_comercial','class'=>"form-control",'required'=>true,'placeholder'=>'Nombre comercial']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            {!! Form::text('integrador[rfc]', null, ['id'=>'integrador_rfc','class'=>"form-control",'required'=>true,'placeholder'=>'RFC']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            {!! Form::text('integrador[pagina_internet]',null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Página web']) !!}
        </div>



        <div class="col-md-6 col-lg-6">
            <label for="">Ventas anuales</label><br>
            {!! Form::select('integrador[ventas_anuales]',$ventas_anuales,'null',['class'=>'form-control','id'=>'ventas_anuales']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            <label for="">¿Cuál es tu producto principal?</label><br>
            {!! Form::select('integrador[producto_principal]',$producto_principal,'null',['class'=>'form-control','id'=>'producto_principal']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            <label for="">Regimen</label><br>
            {!! Form::select('integrador[tipo_persona]',$tipo_persona,'null',['class'=>'form-control','id'=>'tipo_persona']) !!}
        </div>

        <div class="col-md-6 col-lg-6">
            <label for="">Financiamientos ofrecidos</label><br>
            {!! Form::select('integrador[financiamientos_ofrecidos]',$financiamientos_ofrecidos,'null',['class'=>'form-control','id'=>'financiamientos_ofrecidos']) !!}
        </div>
        

        <div class="col-md-6 col-lg-6">
            {!! Form::text('integrador[anios_operando]', null,['class'=>"form-control",'required'=>true,'placeholder'=>'Años operando','style'=>'margin-top:27px']) !!}
        </div>




        <div class="col-md-12">
            <h3 class="col-md-12 naranja">Dirección</h3>
        </div>

        <div class="col-md-6">
            {!! Form::text('direccion[calle]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Calle']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::text('direccion[num_ext]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Número exterior']) !!}
        </div>

        <div class="col-md-12">
            {!! Form::text('direccion[colonia]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Colonia']) !!}
        </div>



        <div class="col-md-6">
            <label for="">Estado</label><br>
            <select name="direccion[estado_id]" id="domicilio_estado" class="form-control"]>
                @foreach($estados as $k => $v)
                    <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-6">
            <label for="">Municipio / Delegación</label><br>
            <select name="direccion[municipio_id]" id="domicilio_municipio" class="form-control"]>
            </select>
        </div>

        <div class="col-md-6">
            {!! Form::text('direccion[cp]', null, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5,'placeholder'=>'Código Postal']) !!}
        </div>


    </div>
</div>

@section('extra-js')
    <script>
        $(function(){
            getMunicipios($('#domicilio_estado'),1,$('#domicilio_municipio'));
            $('#domicilio_estado').change(function(){
                getMunicipios($(this),0,$('#domicilio_municipio'));
            });

            getMunicipios($('#domicilio_socio_estado'),1,$('#domicilio_socio_municipio'));
            $('#domicilio_socio_estado').change(function(){
                getMunicipios($(this),0,$('#domicilio_socio_municipio'));
            });
        })

        function getMunicipios(_this,set_selected,elemento){
            var estado_id = _this.val();
            $.get('/estados/getMunicipios/'+estado_id,function(data){
                elemento.html('');
                $.each(data,function(k,v){
                    var selected = "";
                    if( set_selected == k){ selected = 'selected'; }
                    var option = '<option value="'+ k +'" '+ selected +'  >'+ v +'</option>';
                    elemento.append(option);
                })
            })
        }

    </script>
@endsection

