<div id="step1">
    <div class="form-group row">
        <h3 class="col-md-12 naranja">Información del socio</h3>
    </div>

    <div class="form-group row justify-content-lg-center">
        <div class="col-md-12 col-lg-10">
            {!! Form::text('integrador[nombre_socio]', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Nombre']) !!}
        </div>

        <div class="col-md-12 col-lg-10">
            {!! Form::text('integrador[paterno_socio]', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Apellido paterno']) !!}
        </div>

        <div class="col-md-12 col-lg-10">
            {!! Form::text('integrador[materno_socio]', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Apellido materno']) !!}
        </div>


        <div class="col-md-12">
                <h3 class="col-md-12 naranja">Dirección</h3>
            </div>
    
            <div class="col-md-6">
                {!! Form::text('direccion_socio[calle]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Calle']) !!}
            </div>
    
            <div class="col-md-6">
                {!! Form::text('direccion_socio[num_ext]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Número exterior']) !!}
            </div>
    
            <div class="col-md-12">
                {!! Form::text('direccion_socio[colonia]', null, ['class'=>"form-control",'required'=>false,'placeholder'=>'Colonia']) !!}
            </div>
    
    
    
            <div class="col-md-6">
                <label for="">Estado</label><br>
                <select name="direccion_socio[estado_id]" id="domicilio_socio_estado" class="form-control"]>
                    @foreach($estados as $k => $v)
                        <option value="{{ $k }}" {{ ( @$solicitud->cliente->domicilio->estado_id == $k)?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
    
    
            <div class="col-md-6">
                <label for="">Municipio / Delegación</label><br>
                <select name="direccion_socio[municipio_id]" id="domicilio_socio_municipio" class="form-control"]>
                </select>
            </div>
    
            <div class="col-md-6">
                {!! Form::text('direccion_socio[cp]', null, ['class'=>"input_underline form-control",'required'=>false,'maxlength'=>5,'placeholder'=>'Código Postal']) !!}
            </div>



    </div>
</div>

@section('extra-js')
    <script>
        
        
            
        

       

    </script>
@endsection

