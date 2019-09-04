@extends('layouts.app')
@section('breadcrumb')
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <div class=""> <img class="img-responsive" alt="user" src="{{ asset('app_layout/img/avatar-default.png') }}"> </div>
                <div class="user-btm-box">
                    <!-- .row -->
                    <div class="row text-center m-t-10">
                        <div class="col-md-6 b-r"><strong>Nombre</strong>
                            <p>{{ auth()->user()->nombre }}</p>
                        </div>
                        <div class="col-md-6"><strong>Correo</strong>
                            <p>{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="white-box">
                <!-- .tabs -->
                <ul class="nav nav-tabs tabs customtab">

                    <li role="presentation" class="nav-item"><a href="#update" class="nav-link active" aria-controls="update" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs"> Informacion personal</span></a></li>

                    <li role="presentation" class="nav-item"><a href="#password" class="nav-link" aria-controls="password" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">Contraseña</span></a></li>

                </ul>
                <!-- /.tabs -->
                <div class="tab-content">

                    <div class="tab-pane active" id="update">
                        {!! Form::open(['method' => 'POST','url'=>'/mi_perfil']) !!}
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="hidden" name="caso" value="1" >
                                    {!! Form::label('nombre', 'Nombre', ['class' => 'col-md-6']) !!}
                                    {!! Form::text('nombre', auth()->user()->nombre, ['placeholder' => 'Ingresa el nombre', 'class' => 'form-control']) !!}

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    {!! Form::label('email', 'Correo electrónico', ['class' => 'col-md-6']) !!}
                                    {!! Form::text('email', auth()->user()->email, ['placeholder' => 'Ingresa el nombre', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Actualizar</button>
                        {!! Form::close() !!}
                    </div>


                    <div class="tab-pane" id="password">
                        {!! Form::open(['method' => 'POST','url'=>'/mi_perfil']) !!}
                            <div class="form-group row">
                                <input type="hidden" name="caso" value="2" >
                                {!! Form::label('password', 'Contraseña', ['class' => 'col-md-12']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('password', null, ['data-toggle' => 'validator', 'data-minlength' => '6', 'class' => 'form-control', 'id' => 'inputPassword','placeholder' => "Contraseña", 'required' => true, 'type' => 'password']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    {!! Form::text('password_confirmation', null, ['data-match' => "#inputPassword", 'data-match-error' => 'Las contraseñas no coinsiden', 'placeholder' => "Confirmar contraseña", 'class' => 'form-control', 'required' => true]) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Actualizar</button>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop