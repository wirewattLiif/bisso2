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
        <a href="{{ route('integradores.index') }}" class="btn btn-default2 btn-rounded">Integradores</a>
            <h4 class="page-title d-inline">Editar</h4>
        </div>
    </div>
@endsection


@section('content')
    {!! Form::open(['method' => 'PUT','url'=>route('integradores.update',$integrador->id),'autocomplete'=>'false']) !!}
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Datos de la cuenta</h3>
            </div>
            
            <div class="col-md-4">
                <p>Nombre del usuario</p>
                {!! Form::hidden('user[id]', $integrador->user->id) !!}
                {!! Form::text('user[nombre]', $integrador->user->nombre, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Email</p>
                {!! Form::text('user[email]', $integrador->user->email, ['class'=>"input_underline form-control",'required'=>true,'readonly'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Celular</p>
                {!! Form::text('user[phone]', $integrador->user->phone, ['class'=>"input_underline form-control",'required'=>true]) !!}
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
                {!! Form::hidden('integrador[id]', $integrador->id) !!}
                {!! Form::text('integrador[razon_social]', $integrador->razon_social, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Nombre comercial</p>                
                {!! Form::text('integrador[nombre_comercial]', $integrador->nombre_comercial, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>RFC</p>
                {!! Form::text('integrador[rfc]', $integrador->rfc, ['class'=>"input_underline form-control",'required'=>true]) !!}
            </div>
            <div class="col-md-4">
                <p>Página web</p>
                {!! Form::text('integrador[pagina_internet]', $integrador->pagina_internet, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>            
            <div class="col-md-2">
                <p>Años operando</p>
                <div class="input-group">
                    {!! Form::text('integrador[anios_operando]', $integrador->anios_operando, ['class'=>"input_underline form-control",'required'=>false]) !!}
                    <span class="input-group-addon" id="basic-addon1">Años</span>
                </div>  
            </div>

            <div class="col-md-4">
                <p>Ventas Anuales</p>
                @php
                    $ventas_anuales = ['$0 - $2,000,000' => '$0 - $2,000,000','$2,000,001 - $6,000,000'=>'$2,000,001 - $6,000,000','$6,000,000 - $12,000,000'=>'$6,000,000 - $12,000,000','+$12,000,000'=>'+$12,000,000'];
                @endphp
                {!! Form::select('integrador[ventas_anuales]', $ventas_anuales, $integrador->ventas_anuales,['class'=>"form-control input_underline"]) !!}
            </div>

            <div class="col-md-4">
                <p>Regimen</p>                
                {!! Form::select('integrador[tipo_persona]', $tipo_persona, $integrador->tipo_persona,['class'=>"form-control input_underline"]) !!}
            </div>

            <div class="col-md-4">
                <p>Financiamientos ofrecidos</p>                
                {!! Form::select('integrador[financiamientos_ofrecidos]', $financiamientos_ofrecidos, $integrador->financiamientos_ofrecidos,['class'=>"form-control input_underline"]) !!}
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
                {!! Form::select('integrador[producto_principal]', $producto_principal, $integrador->producto_principal,['class'=>"form-control input_underline"]) !!}
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
                    {!! Form::hidden('direccion[id]', $integrador->domicilio->id) !!}
                    {!! Form::text('direccion[calle]', $integrador->domicilio->calle, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                </div>
    
                <div class="col-md-4">
                    <p>Número exterior</p>
                    {!! Form::text('direccion[num_ext]', $integrador->domicilio->numero_ext, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                </div>
    
                <div class="col-md-4">
                    <p>Número interior (opcional)</p>
                    {!! Form::text('direccion[numero_int]', $integrador->domicilio->numero_int, ['class'=>"input_underline form-control",'required'=>false]) !!}                                        
                </div>
    
                <div class="clearfix"></div>
    
                <div class="col-md-4">
                    <p>Colonia</p>
                    {!! Form::text('direccion[colonia]', $integrador->domicilio->colonia, ['class'=>"input_underline form-control",'required'=>false]) !!}
                </div>
    
                <div class="col-md-4">
                    <p>Estado</p>
                    <select name="direccion[estado_id]" id="domicilio_estado" class="form-control input_underline"]>
                        @foreach($estados as $k => $v)
                            <option value="{{ $k }}" {{ ( @$integrador->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
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
                    {!! Form::text('direccion[cp]', $integrador->domicilio->cp, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5]) !!}                    
                </div>
            
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 style="color:#faab4f">Información del socio</h3>
            </div>

            <div class="col-md-4">
                <p>Nombre</p>
                {!! Form::text('integrador[nombre_socio]', $integrador->nombre_socio, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>
            <div class="col-md-4">
                <p>Apellido paterno</p>
                {!! Form::text('integrador[apellido_paterno_socio]', $integrador->apellido_paterno_socio, ['class'=>"input_underline form-control",'required'=>false]) !!}
            </div>
            <div class="col-md-4">
                <p>Apellido materno</p>
                {!! Form::text('integrador[apellido_materno_socio]', $integrador->apellido_materno_socio, ['class'=>"input_underline form-control",'required'=>false]) !!}
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
                        {!! Form::hidden('direccionSocio[id]', $integrador->domicilio_socio->id) !!}
                        {!! Form::text('direccionSocio[calle]', $integrador->domicilio_socio->calle, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                    </div>
        
                    <div class="col-md-4">
                        <p>Número exterior</p>
                        {!! Form::text('direccionSocio[num_ext]', $integrador->domicilio_socio->numero_ext, ['class'=>"input_underline form-control",'required'=>false]) !!}                    
                    </div>
        
                    <div class="col-md-4">
                        <p>Número interior (opcional)</p>
                        {!! Form::text('direccionSocio[numero_int]', $integrador->domicilio_socio->numero_int, ['class'=>"input_underline form-control",'required'=>false]) !!}                                        
                    </div>
        
                    <div class="clearfix"></div>
        
                    <div class="col-md-4">
                        <p>Colonia</p>
                        {!! Form::text('direccionSocio[colonia]', $integrador->domicilio_socio->colonia, ['class'=>"input_underline form-control",'required'=>false]) !!}
                    </div>
        
                    <div class="col-md-4">
                        <p>Estado</p>
                        <select name="direccionSocio[estado_id]" id="domicilio_socio_estado" class="form-control input_underline"]>
                            @foreach($estados as $k => $v)
                                <option value="{{ $k }}" {{ ( @$integrador->domicilio_socio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
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
                        {!! Form::text('direccionSocio[cp]', $integrador->domicilio_socio->cp, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5]) !!}                    
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
        getMunicipios($('#domicilio_estado'),{{ (isset($integrador->domicilio->municipio_id)?$integrador->domicilio->municipio_id:1 ) }},$('#domicilio_municipio'));
        $('#domicilio_estado').change(function(){
            getMunicipios($(this),0,$('#domicilio_municipio'));
        });

        getMunicipios($('#domicilio_socio_estado'),{{ (isset($integrador->domicilio_socio->municipio_id)?$integrador->domicilio_socio->municipio_id:1 ) }},$('#domicilio_socio_municipio'));
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