@extends('layouts.app')
@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop


@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <br>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <h2 class="col-md-12">Razones Sociales</h2>
    </div>

    <div class="row">
        <div class="col-md-12">

            <button type="button" id="btnAdd" class="btn btn-success btn-outline pull-right" data-target="#addModal" data-toggle="modal"  style="margin-top: 22px;margin-bottom: 10px;">(+) Agregar</button>

        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Razón social</th>
                    <th>Nombre comercial</th>
                    <th>RFC</th>
                    <th>Dirección</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($razones as $razon)
                        <tr>
                            <td>{{ $razon->razon_social }}</td>
                            <td>{{ $razon->nombre_comercial }}</td>
                            <td>{{ $razon->rfc }}</td>
                            <td>
                                {{ $razon->calle }} Ext:{{ $razon->numero_ext }} Int: {{ $razon->numero_int }}, Colonia {{ $razon->colonia }}, {{ $razon->municipio->nombre }}, {{ $razon->estado->nombre }},  CP: {{ $razon->cp }}
                            </td>
                            <td>
                                <span class="label label-rouded" style="background-color:#08C394">
                                 <a href="#"
                                    class="button-show-hover btnEdit label label-rouded"
                                    data-toggle="modal"
                                    data-target="#editRazon"
                                    data-id="{{ $razon->id }}"
                                    data-razon_social="{{ $razon->razon_social }}"
                                    data-representante_legal="{{ $razon->representante_legal }}"
                                    data-rfc="{{ $razon->rfc }}"
                                    data-nombre_comercial="{{ $razon->nombre_comercial }}"
                                    data-calle="{{ $razon->calle }}"
                                    data-numero_ext="{{ $razon->numero_ext }}"
                                    data-numero_int="{{ $razon->numero_int }}"
                                    data-colonia="{{ $razon->colonia }}"
                                    data-estado_id="{{ $razon->estado_id }}"
                                    data-municipio_id="{{ $razon->municipio_id }}"
                                    data-cp="{{ $razon->cp }}"
                                    data-activo="{{ ($razon->activo)?true:false }}"

                                    data-telefono="{{ $razon->telefono }}"
                                    data-correo="{{ $razon->correo }}"
                                    data-web="{{ $razon->web }}"
                                    data-banco="{{ $razon->banco }}"
                                    data-beneficiario="{{ $razon->beneficiario }}"
                                    data-cuenta="{{ $razon->cuenta }}"
                                    data-clabe="{{ $razon->clabe }}"
                                    data-rfc_beneficiario="{{ $razon->rfc_beneficiario }}"
                                    data-interes_moratorio="{{ $razon->interes_moratorio }}"
                                    data-gastos_administrativos="{{ $razon->gastos_administrativos }}"

                                    data-url="{{ route('razones_sociales.update',$razon->id) }}"
                                    style="font-size:12px"
                                 >
                                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" data-original-title="" title=""></i>
                                </a>
                            </span>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



    <div class="modal fade none-border" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Agregar Razón Social</h4>
                </div>
                {!! Form::open(['method' => 'POST','url'=>route('razones_sociales.store')]) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <label for="">Razón Social</label>
                            {{ Form::text('razon_social',null,['class'=>'form-control','id'=>'razon_social','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">RFC</label>
                            {{ Form::text('rfc',null,['class'=>'form-control','id'=>'rfc','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Nombre comercial</label>
                            {{ Form::text('nombre_comercial',null,['class'=>'form-control','id'=>'nombre_comercial'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Nombre representante legal</label>
                            {{ Form::text('representante_legal',null,['class'=>'form-control','id'=>'representante_legal'] ) }}
                        </div>



                        <div class="col-md-6">
                            <label for="">Teléfono</label>
                            {{ Form::text('telefono',null,['class'=>'form-control','id'=>'telefono'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Correo</label>
                            {{ Form::text('correo',null,['class'=>'form-control','id'=>'correo'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Web </label>
                            {{ Form::text('web',null,['class'=>'form-control','id'=>'web'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Interes moratorio </label>
                            {{ Form::text('interes_moratorio',null,['class'=>'form-control','id'=>'interes_moratorio'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Gastos administrativos </label>
                            {{ Form::text('gastos_administrativos',null,['class'=>'form-control','id'=>'gastos_administrativos'] ) }}
                        </div>



                        <div class="col-md-12">
                            <hr>
                            <h2>Datos bancarios</h2>
                        </div>
                        <div class="col-md-6">
                            <label for="">Banco</label>
                            {{ Form::text('banco',null,['class'=>'form-control','id'=>'banco'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Beneficiario</label>
                            {{ Form::text('beneficiario',null,['class'=>'form-control','id'=>'beneficiario'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Cuenta</label>
                            {{ Form::text('cuenta',null,['class'=>'form-control','id'=>'cuenta'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">CLABE</label>
                            {{ Form::text('clabe',null,['class'=>'form-control','id'=>'clabe'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">RFC beneficiario </label>
                            {{ Form::text('rfc_beneficiario',null,['class'=>'form-control','id'=>'rfc_beneficiario'] ) }}
                        </div>




                        <div class="col-md-12">
                            <hr>
                            <h2>Dirección</h2>
                        </div>
                        <div class="col-md-6">
                            <label for="">Calle</label>
                            {{ Form::text('calle',null,['class'=>'form-control','id'=>'calle','required'=>true] ) }}
                        </div>

                        <div class="col-md-3">
                            <label for="">Número exterior</label>
                            {{ Form::text('numero_ext',null,['class'=>'form-control','id'=>'numero_ext'] ) }}
                        </div>

                        <div class="col-md-3">
                            <label for="">Número interior</label>
                            {{ Form::text('numero_int',null,['class'=>'form-control','id'=>'numero_int'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Colonia</label>
                            {{ Form::text('colonia',null,['class'=>'form-control','id'=>'colonia','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Estado</label>
                            {{ Form::select('estado_id',$estados,null,['class'=>'form-control','id'=>'estado_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Municipio</label>
                            {{ Form::select('municipio_id',[],null,['class'=>'form-control','id'=>'municipio_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">CP</label>
                            {{ Form::text('cp',null,['class'=>'form-control','id'=>'cp'] ) }}
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light save-category" >Agregar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="modal fade none-border" id="editRazon">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Editar Razón Social</h4>
                </div>
                {!! Form::open(['method' => 'PUT','url'=>'','id'=>'formEdit']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <label for="">Razón Social</label>
                            {{ Form::hidden('id',null,['class'=>'form-control','id'=>'edit_id'] ) }}
                            {{ Form::text('razon_social',null,['class'=>'form-control','id'=>'edit_razon_social','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">RFC</label>
                            {{ Form::text('rfc',null,['class'=>'form-control','id'=>'edit_rfc','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Nombre comercial</label>
                            {{ Form::text('nombre_comercial',null,['class'=>'form-control','id'=>'edit_nombre_comercial'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Nombre representante legal</label>
                            {{ Form::text('representante_legal',null,['class'=>'form-control','id'=>'edit_representante_legal'] ) }}
                        </div>



                        <div class="col-md-6">
                            <label for="">Teléfono</label>
                            {{ Form::text('telefono',null,['class'=>'form-control','id'=>'edit_telefono'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Correo</label>
                            {{ Form::text('correo',null,['class'=>'form-control','id'=>'edit_correo'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Web </label>
                            {{ Form::text('web',null,['class'=>'form-control','id'=>'edit_web'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Interes moratorio </label>
                            {{ Form::text('interes_moratorio',null,['class'=>'form-control','id'=>'edit_interes_moratorio'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Gastos administrativos </label>
                            {{ Form::text('gastos_administrativos',null,['class'=>'form-control','id'=>'edit_gastos_administrativos'] ) }}
                        </div>


                        <div class="col-md-12">
                            <hr>
                            <h2>Datos bancarios</h2>
                        </div>

                        <div class="col-md-6">
                            <label for="">Banco</label>
                            {{ Form::text('banco',null,['class'=>'form-control','id'=>'edit_banco'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Beneficiario</label>
                            {{ Form::text('beneficiario',null,['class'=>'form-control','id'=>'edit_beneficiario'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Cuenta</label>
                            {{ Form::text('cuenta',null,['class'=>'form-control','id'=>'edit_cuenta'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">CLABE</label>
                            {{ Form::text('clabe',null,['class'=>'form-control','id'=>'edit_clabe'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">RFC beneficiario </label>
                            {{ Form::text('rfc_beneficiario',null,['class'=>'form-control','id'=>'edit_rfc_beneficiario'] ) }}
                        </div>





                        <div class="col-md-12">
                            <hr>
                            <h2>Dirección</h2>
                        </div>
                        <div class="col-md-6">
                            <label for="">Calle</label>
                            {{ Form::text('calle',null,['class'=>'form-control','id'=>'edit_calle','required'=>true] ) }}
                        </div>

                        <div class="col-md-3">
                            <label for="">Número exterior</label>
                            {{ Form::text('numero_ext',null,['class'=>'form-control','id'=>'edit_numero_ext'] ) }}
                        </div>

                        <div class="col-md-3">
                            <label for="">Número interior</label>
                            {{ Form::text('numero_int',null,['class'=>'form-control','id'=>'edit_numero_int'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Colonia</label>
                            {{ Form::text('colonia',null,['class'=>'form-control','id'=>'edit_colonia','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Estado</label>
                            {{ Form::select('estado_id',$estados,null,['class'=>'form-control','id'=>'edit_estado_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Municipio</label>
                            {{ Form::select('municipio_id',[],null,['class'=>'form-control','id'=>'edit_municipio_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">CP</label>
                            {{ Form::text('cp',null,['class'=>'form-control','id'=>'edit_cp'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Activo</label>
                            <br>
                            <input type="checkbox" id="edit_activo" class="bootstrapSwitch" data-on-color="success" name="activo"
                                   data-on-text="SI" data-off-text="NO" value="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light save-category" >Editar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection


@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function(){

            $(".bootstrapSwitch").bootstrapSwitch();

            getMunicipios($('#estado_id'), $('#municipio_id'), 0);

            $('.btnEdit').click(function(){
                var id = $(this).data('id');
                var razon_social = $(this).data('razon_social');
                var rfc = $(this).data('rfc');
                var nombre_comercial = $(this).data('nombre_comercial');
                var representante_legal = $(this).data('representante_legal');
                var calle = $(this).data('calle');
                var numero_ext = $(this).data('numero_ext');
                var numero_int = $(this).data('numero_int');
                var colonia = $(this).data('colonia');
                var estado_id = $(this).data('estado_id');
                var municipio_id = $(this).data('municipio_id');
                var cp = $(this).data('cp');
                var activo = $(this).data('activo');

                var telefono = $(this).data("telefono")
                var correo = $(this).data("correo")
                var web = $(this).data("web")
                var banco = $(this).data("banco")
                var beneficiario = $(this).data("beneficiario")
                var cuenta = $(this).data("cuenta")
                var clabe = $(this).data("clabe")
                var rfc_beneficiario = $(this).data("rfc_beneficiario")
                var interes_moratorio = $(this).data("interes_moratorio")
                var gastos_administrativos = $(this).data("gastos_administrativos")

                var url = $(this).data('url');



                $('#edit_id').val(id);
                $('#edit_razon_social').val(razon_social);
                $('#edit_rfc').val(rfc);
                $('#edit_nombre_comercial').val(nombre_comercial);
                $('#edit_representante_legal').val(representante_legal);
                $('#edit_calle').val(calle);
                $('#edit_numero_ext').val(numero_ext);
                $('#edit_numero_int').val(numero_int);
                $('#edit_colonia').val(colonia);
                $('#edit_estado_id').val(estado_id);
                $('#edit_municipio_id').val(municipio_id);
                $('#edit_cp').val(cp);

                if(activo){
                    $("#edit_activo").bootstrapSwitch('state', true);
                }else{
                    $("#edit_activo").bootstrapSwitch('state', false);
                }

                $('#edit_telefono').val(telefono);
                $('#edit_correo').val(correo);
                $('#edit_web').val(web);
                $('#edit_banco').val(banco);
                $('#edit_beneficiario').val(beneficiario);
                $('#edit_cuenta').val(cuenta);
                $('#edit_clabe').val(clabe);
                $('#edit_rfc_beneficiario').val(rfc_beneficiario);
                $('#edit_interes_moratorio').val(interes_moratorio);
                $('#edit_gastos_administrativos').val(gastos_administrativos);

                getMunicipios($('#edit_estado_id'), $('#edit_municipio_id'), municipio_id);

                $('#formEdit').attr('action',url);
            })

            $('#estado_id').change(function(){
                getMunicipios($('#estado_id'), $('#municipio_id'), 0);
            })

            $('#edit_estado_id').change(function(){
                getMunicipios($('#edit_estado_id'), $('#edit_municipio_id'), 0);
            })
        })



        function getMunicipios(element_estado,element_municipio,set_municipio){
            var state_id = element_estado.val();

            if(state_id > 0){
                $.get('/estados/getMunicipios/' + state_id, function(data) {
                    var html = "";
                    element_municipio.html("");
                    $.each(data, function(key, value) {
                        html += "<option value='"+ key+"'>"+ value+"</option>";
                    });
                    console.log(html);
                    element_municipio.append(html);

                    if(set_municipio > 0){
                        element_municipio.val(set_municipio);
                    }
                });
            }
        }
    </script>
@endsection
