<div id="step1">
        <div class="form-group row">
            <h3 class="col-md-12 naranja">Datos del Usuario</h3>
        </div>
    
        <div class="form-group row justify-content-lg-center">
            <div class="col-md-12 col-lg-10">
                {!! Form::text('user_nombre', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Nombre']) !!}
            </div>

            <div class="col-md-12 col-lg-10">
                {!! Form::text('user_apellidos', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Apellidos']) !!}
            </div>

            <div class="col-md-12 col-lg-10">
                {!! Form::text('user_email', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Email']) !!}
            </div>

            <div class="col-md-12 col-lg-10">
                {!! Form::text('user_phone', null, ['class'=>"form-control",'required'=>true,'placeholder'=>'Celular']) !!}
            </div>

            <div class="col-md-12 col-lg-10">
                {!! Form::password('user_password', ['class'=>"form-control",'required'=>true,'placeholder'=>'Contraseña']) !!}
            </div>

            <div class="col-md-12 col-lg-10">
                {!! Form::password('user_password_confirmation', ['class'=>"form-control",'required'=>true,'placeholder'=>'Confirmar contraseña']) !!}
            </div>
        </div>
</div>
    
    