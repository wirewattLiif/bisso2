@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-10">
            <a href="" class="btn btn-default2 btn-rounded">Integradores</a>
            <h4 class="page-title d-inline">Agregar Integrador</h4>
        </div>
    </div>
@endsection


@section('content')
    {!! Form::open(['method' => 'POST','url'=>'/admin/integradores','autocomplete'=>'false']) !!}
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Datos de la cuenta</h3>
            </div>
            
            <div class="col-md-4">
                <p>Nombre del usuario</p>
                
                {!! Form::text('user[nombre]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Email</p>
                {!! Form::text('user[email]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Celular</p>
                {!! Form::text('user[phone]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Contraseña</p>
                {!! Form::password('user[password]',['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>

            <div class="col-md-4">
                <p>Confirmar contraseña</p>
                {!! Form::password('user[password_confirmation]', ['class'=>"input_underline form-control",'required'=>true]) !!}                
            </div>


            <div class="col-md-12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Información de la empresa</h3>
            </div>

            <div class="col-md-4">
                <p>Razón social</p>                
                {!! Form::text('integrador[razon_social]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Nombre comercial</p>                
                {!! Form::text('integrador[nombre_comercial]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>RFC</p>
                {!! Form::text('integrador[rfc]', null, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Página web</p>
                {!! Form::text('integrador[pagina_internet]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>            
            <div class="col-md-2">
                <p>Años operando</p>
                <div class="input-group">
                    {!! Form::text('integrador[anios_operando]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
                    <span class="input-group-addon" id="basic-addon1">Años</span>
                </div>  
            </div>

            <div class="col-md-4">
                <p>Ventas Anuales</p>
                @php
                    $ventas_anuales = ['$0 - $2,000,000' => '$0 - $2,000,000','$2,000,001 - $6,000,000'=>'$2,000,001 - $6,000,000','$6,000,000 - $12,000,000'=>'$6,000,000 - $12,000,000','+$12,000,000'=>'+$12,000,000'];
                @endphp
                {!! Form::select('integrador[ventas_anuales]', $ventas_anuales, null,['class'=>"form-control input_underline"]) !!}
            </div>

            <div class="col-md-4">
                <p>¿Cuál es tu producto principal?</p>
                @php
                    $producto_principal = [
                        'Aires acondicionados' => 'Aires acondicionados',
                        'Aislamientos' => 'Aislamientos',
                        'Eficiencia energética' => 'Eficiencia energética',
                        'Iluminación' => 'Iluminación',
                        'Impermeabilización' => 'Impermeabilización',
                        'Puertas' => 'Puertas',
                        'Solar Fotovoltaico' => 'Solar Fotovoltaico',
                        'Ventanas' => 'Ventanas',
                        'Otro' => 'Otro'
                    ];
                @endphp
                {!! Form::select('integrador[producto_principal]', $producto_principal, null,['class'=>"form-control input_underline"]) !!}
            </div>








            <div class="col-md-12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Dirección</h3>
            </div>

                <div class="col-md-4">
                    <p>Calle</p>
                    {!! Form::text('direccion[calle]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                </div>
    
                <div class="col-md-4">
                    <p>Número exterior</p>
                    {!! Form::text('direccion[num_ext]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                </div>
    
                <div class="col-md-4">
                    <p>Número interior (opcional)</p>
                    {!! Form::text('direccion[numero_int]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                                        
                </div>
    
                <div class="clearfix"></div>
    
                <div class="col-md-4">
                    <p>Colonia</p>
                    {!! Form::text('direccion[colonia]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
                </div>
    
                <div class="col-md-4">
                    <p>Estado</p>
                    <select name="direccion[estado_id]" id="domicilio_estado" class="form-control input_underline"]>
                        @foreach($estados as $k => $v)
                            <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
    
    
                <div class="col-md-4">
                    <p>Municipio / Delegación </p>
                    <select name="direccion[municipio_id]" id="domicilio_municipio" class="form-control input_underline"]>
                    </select>
                </div>
    
                <div class="col-md-4">
                    <p>Código Postal</p>
                    {!! Form::text('direccion[cp]', null, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5]) !!}                    
                </div>
            
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Información del socio</h3>
            </div>

            <div class="col-md-4">
                <p>Nombre</p>
                {!! Form::text('integrador[nombre_socio]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>
            <div class="col-md-4">
                <p>Apellido paterno</p>
                {!! Form::text('integrador[apellido_paterno_socio]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>
            <div class="col-md-4">
                <p>Apellido materno</p>
                {!! Form::text('integrador[apellido_materno_socio]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>

            <div class="col-md-12">
                <hr>
            </div>
        </div>



        <div class="row">
                <div class="col-md-12">
                    <h3 style="color:#faab4f">Dirección del socio</h3>
                </div>
    
                    <div class="col-md-4">
                        <p>Calle</p>
                        {!! Form::text('direccionSocio[calle]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                    </div>
        
                    <div class="col-md-4">
                        <p>Número exterior</p>
                        {!! Form::text('direccionSocio[num_ext]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                    </div>
        
                    <div class="col-md-4">
                        <p>Número interior (opcional)</p>
                        {!! Form::text('direccionSocio[numero_int]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}                                        
                    </div>
        
                    <div class="clearfix"></div>
        
                    <div class="col-md-4">
                        <p>Colonia</p>
                        {!! Form::text('direccionSocio[colonia]', null, ['class'=>"input_underline form-control",'required'=>false]) !!}
                    </div>
        
                    <div class="col-md-4">
                        <p>Estado</p>
                        <select name="direccionSocio[estado_id]" id="domicilio_socio_estado" class="form-control input_underline"]>
                            @foreach($estados as $k => $v)
                                <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
        
        
                    <div class="col-md-4">
                        <p>Municipio / Delegación </p>
                        <select name="direccionSocio[municipio_id]" id="domicilio_socio_municipio" class="form-control input_underline"]>
                        </select>
                    </div>
        
                    <div class="col-md-4">
                        <p>Código Postal</p>
                        {!! Form::text('direccionSocio[cp]', null, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5]) !!}                    
                    </div>
                
                
            </div>


        <div class="row">
            <div class="col-md-6">
                <br><br>
                <button type="submit" class="btn btn-success" id="">Guardar</button>
                <a href="/admin/integradores/" class="btn btn-default waves-effect">Cancelar</a>
            </div>
        </div>

    </form>
@endsection


@section('extra-js')
<script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>

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