@extends('layouts.app')
@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/admin/productos" class="btn btn-default2 btn-rounded">Productos</a>
            <h4 class="page-title d-inline">Detalle del producto.</h4>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h2 class="d-inline">
                {{ $producto->nombre }}
            </h2>
        </div>
    </div>
        <br><br>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <h5>Descripción</h5>
                    <p>{{ $producto->descripcion}}</p>
                </div>
                <div class="col-md-4">
                    <h5>Creado por</h5>
                    <p></p>
                </div>
                <div class="col-md-4">
                    <h5>Modificado por</h5>
                    <p></p>
                </div>
                <div class="col-md-4">
                    <h5>Estatus</h5>
                    <p>
                        <span class="label label-rouded label-{{ ($producto->activo)?'success':'danger' }}" > {{ ($producto->activo)?'Activo':'Inactivo' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                    <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-item active" aria-expanded="false">
                        <a href="#productos" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            Productos
                        </a>
                    </li>  
                </ul>

                <div class="tab-content">
                    <button type="button" id="btnAdd" class="btn btn-success btn-outline pull-right" data-target="#addPlan" data-toggle="modal"  style="margin-top: 22px;margin-bottom: 10px;">(+) Agregar</button>

                    <div role="tabpanel" class="tab-pane active" id="productos" aria-expanded="false">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Producto</th> 
                                        <th>Id del producto</th>
                                        <th>Merchant fee</th>
                                        <th>Interes anual</th>
                                        <th>Plazo</th>
                                        <th>Comisión por apertura</th>
                                        <th>Activo</th>
                                        <th>Aplica costo anual seguro</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($producto->planes as $plan)
                                    <tr>
                                        <td>{{ $plan->nombre }}</td>
                
                                        <td>{{ @$plan->producto->nombre }}</td>
                                        <td>{{ $plan->id_producto }}</td>
                                        <td>{{ $plan->merchant_fee }}%</td>
                                        <td>{{ $plan->interes_anual }}%</td>
                                        <td>{{ $plan->plazo }} meses</td>
                                        <td>{{ number_format($plan->comision_por_apertura,2) }}%</td>
                                        <td>
                                            <span class="label label-rouded" style="background-color:{{ ($plan->activo)?'#08C394':'#F99478' }}">
                                                {{ ($plan->activo)?'Si':'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="label label-rouded" style="background-color:{{ ($plan->costo_anual_seguro)?'#08C394':'#F99478' }}">
                                                {{ ($plan->costo_anual_seguro)?'Si':'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="label label-rouded" style="background-color:#08C394">
                                                    <a href="#"
                                                    class="button-show-hover btnEdit label label-rouded"
                                                    data-toggle="modal"
                                                    data-target="#editPlan"
                                                    data-id="{{ $plan->id }}"
                                                    data-nombre="{{ $plan->nombre }}"
                                                    data-abreviacion="{{ $plan->abreviacion }}"
                                                    data-id_producto="{{ $plan->id_producto }}"
                                                    data-producto_id="{{ @$plan->producto_id }}"
                                                    data-merchant_fee="{{ $plan->merchant_fee }}"
                                                    data-dti_pre="{{ $plan->dti_pre }}"
                                                    data-dti_post="{{ $plan->dti_post }}"
                                                    data-interes_anual="{{ $plan->interes_anual }}"
                                                    data-plazo="{{ $plan->plazo }}"
                                                    data-ltv="{{ $plan->ltv }}"
                                                    data-activo="{{ ($plan->activo)?true:false }}"
                                                    data-personalizado="{{ ($plan->personalizado)?true:false }}"
                                                    data-costo_anual_seguro="{{ ($plan->costo_anual_seguro)?true:false }}"
                                                    data-comision_por_apertura="{{ $plan->comision_por_apertura }}"
                                                    data-url="{{ route('planes.update',$plan->id) }}"
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
                    
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade none-border" id="addPlan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Agregar Plan</h4>
                </div>
                {!! Form::open(['method' => 'POST','url'=>'/admin/planes']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        
                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'nombre','required'=>true] ) }}
                            {{ Form::hidden('producto_id',$producto->id,['id'=>'producto_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Abreviación</label>
                            {{ Form::text('abreviacion',null,['class'=>'form-control','id'=>'abreviacion','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Id del producto</label>
                            {{ Form::text('id_producto',null,['class'=>'form-control','id'=>'id_producto','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Merchant fee</label>
                            <div class="input-group">
                                {{ Form::text('merchant_fee',null,['class'=>'form-control','id'=>'merchant_fee','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Interes anual</label>
                            <div class="input-group">
                                {{ Form::text('interes_anual',null,['class'=>'form-control','id'=>'interes_anual','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Plazo</label>
                            <div class="input-group">
                                {{ Form::text('plazo',null,['class'=>'form-control','id'=>'plazo','required'=>true,'onkeypress'=>'return isNumberKey(this)','required'] ) }}
                                <span class="input-group-addon" id="basic-addon1">Meses</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">DTI Pre</label>
                            <div class="input-group">
                                {{ Form::text('dti_pre',null,['class'=>'form-control','id'=>'dti_pre','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">DTI Post</label>
                            <div class="input-group">
                                {{ Form::text('dti_post',null,['class'=>'form-control','id'=>'dti_post','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        

                        <div class="col-md-6">
                            <label for="">Porcentaje de comisión por apertura</label>
                            <div class="input-group">
                                {{ Form::text('comision_por_apertura',null,['class'=>'form-control','id'=>'comision_por_apertura','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">LTV</label>
                            <div class="input-group">
                                {{ Form::text('ltv',null,['class'=>'form-control','id'=>'ltv','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Costo anual del seguro</label>
                            <br>
                            <input type="checkbox" id="costo_anual_seguro" name="costo_anual_seguro" class="bootstrapSwitch" data-on-color="success" name="activo" data-on-text="SI" data-off-text="NO" value="1" checked>
                        </div>

                        <div class="col-md-6">
                            <label for="">Personalizado</label>
                            <br>
                            <input type="checkbox" id="personalizado" name="personalizado" class="bootstrapSwitch" data-on-color="success" name="activo" data-on-text="SI" data-off-text="NO" value="1" checked>
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


    <div class="modal fade none-border" id="editPlan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Editar Plan</h4>
                </div>
                {!! Form::open(['method' => 'PUT','url'=>'/admin/planes','id'=>'formEdit']) !!}
                <div class="modal-body">
                    <div class="row">                        

                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'edit_nombre','required'=>true] ) }}
                            {{ Form::hidden('id',null,['class'=>'form-control','id'=>'edit_id',] ) }}
                            {{ Form::hidden('producto_id',$producto->id,['id'=>'edit_producto_id','required'=>true] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Abreviación</label>
                            {{ Form::text('abreviacion',null,['class'=>'form-control','id'=>'edit_abreviacion','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Id del producto</label>
                            {{ Form::text('id_producto',null,['class'=>'form-control','id'=>'edit_id_producto','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Merchant fee</label>
                            <div class="input-group">
                                {{ Form::text('merchant_fee',null,['class'=>'form-control','id'=>'edit_merchant_fee','required'=>false,'onkeypress'=>'return isDecimalKey(this)'] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Interes anual</label>
                            <div class="input-group">
                                {{ Form::text('interes_anual',null,['class'=>'form-control','id'=>'edit_interes_anual','required'=>false,'onkeypress'=>'return isDecimalKey(this)'] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Plazo</label>
                            <div class="input-group">
                                {{ Form::text('plazo',null,['class'=>'form-control','id'=>'edit_plazo','required'=>false,'onkeypress'=>'return isNumberKey(this)'] ) }}
                                <span class="input-group-addon" id="basic-addon1">Meses</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">DTI Pre</label>
                            <div class="input-group">
                                {{ Form::text('dti_pre',null,['class'=>'form-control','id'=>'edit_dti_pre','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">DTI Post</label>
                            <div class="input-group">
                                {{ Form::text('dti_post',null,['class'=>'form-control','id'=>'edit_dti_post','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="">Porcentaje de comisión por apertura</label>
                            <div class="input-group">
                                {{ Form::text('comision_por_apertura',null,['class'=>'form-control','id'=>'edit_comision_por_apertura','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                                <label for="">LTV</label>
                                <div class="input-group">
                                    {{ Form::text('ltv',null,['class'=>'form-control','id'=>'edit_ltv','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                                    <span class="input-group-addon" id="basic-addon1">%</span>
                                </div>
                            </div>

                        <div class="col-md-6">
                            <label for="">Costo anual del seguro</label>
                            <br>
                            <input type="checkbox" id="edit_costo_anual_seguro" name="costo_anual_seguro" class="bootstrapSwitch" data-on-color="success" name="activo" data-on-text="SI" data-off-text="NO" value="1" checked>
                        </div>

                        <div class="col-md-6">
                            <label for="">Personalizado</label>
                            <br>
                            <input type="checkbox" id="edit_personalizado" name="personalizado" class="bootstrapSwitch" data-on-color="success" name="activo" data-on-text="SI" data-off-text="NO" value="1" checked>
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
@stop


@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function(){
            $(".bootstrapSwitch").bootstrapSwitch();

            $('.btnEdit').click(function(){
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var abreviacion = $(this).data('abreviacion');
                var id_producto = $(this).data('id_producto');
                var producto_id = $(this).data('producto_id');
                var merchant_fee = $(this).data('merchant_fee');
                var interes_anual = $(this).data('interes_anual');
                var plazo = $(this).data('plazo');
                var activo = $(this).data('activo');
                var personalizado = $(this).data('personalizado');
                var costo_anual_seguro = $(this).data('costo_anual_seguro');
                var comision_por_apertura = $(this).data('comision_por_apertura');

                var dti_pre = $(this).data('dti_pre');
                var dti_post = $(this).data('dti_post');
                var ltv = $(this).data('ltv');

                var url = $(this).data('url');

                $('#edit_id').val(id);
                $('#edit_nombre').val(nombre);
                $('#edit_abreviacion').val(abreviacion);
                $('#edit_id_producto').val(id_producto);
                $('#edit_producto_id').val(producto_id);
                $('#edit_merchant_fee').val(merchant_fee);
                $('#edit_dti_pre').val(dti_pre);
                $('#edit_dti_post').val(dti_post);
                $('#edit_interes_anual').val(interes_anual);
                $('#edit_plazo').val(plazo);
                $('#edit_ltv').val(ltv);

                if(activo){
                    $("#edit_activo").bootstrapSwitch('state', true);
                }else{
                    $("#edit_activo").bootstrapSwitch('state', false);
                }

                if(personalizado){
                    $("#edit_personalizado").bootstrapSwitch('state', true);
                }else{
                    $("#edit_personalizado").bootstrapSwitch('state', false);
                }

                if(costo_anual_seguro){
                    $("#edit_costo_anual_seguro").bootstrapSwitch('state', true);
                }else{
                    $("#edit_costo_anual_seguro").bootstrapSwitch('state', false);
                }
                $('#edit_comision_por_apertura').val(comision_por_apertura);

                $('#formEdit').attr('action',url);
            })
        })

        function isDecimalKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

    </script>
@endsection