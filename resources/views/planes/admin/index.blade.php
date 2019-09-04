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
        <h2 class="col-md-12">Planes</h2>
    </div>

    <div class="row">
        <div class="col-md-12">

                <button type="button" id="btnAdd" class="btn btn-success btn-outline pull-right" data-target="#addPlan" data-toggle="modal"  style="margin-top: 22px;margin-bottom: 10px;">(+) Agregar</button>

        </div>
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
                        <th>Ltv</th>
                        <th>Activo</th>
                        <th>Aplica costo anual seguro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($planes as $plan)
                    <tr>
                        <td>{{ $plan->nombre }}</td>

                        <td>{{ @$plan->producto->nombre }}</td>
                        <td>{{ $plan->id_producto }}</td>
                        <td>{{ $plan->merchant_fee }}%</td>
                        <td>{{ $plan->interes_anual }}%</td>
                        <td>{{ $plan->plazo }} meses</td>
                        <td>{{ number_format($plan->comision_por_apertura,2) }}%</td>
                        <td>{{ $plan->ltv }}%</td>
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
                        <td style="width: 90px">
                            
                                
                                
                                    <span class="label label-rouded" style="background-color:#08C394">
                                         <a href="#"
                                            
                                            class="button-show-hover btnEdit"
                                            data-toggle="modal"
                                            data-target="#editPlan"
                                            data-id="{{ $plan->id }}"
                                            data-nombre="{{ $plan->nombre }}"
                                            data-abreviacion="{{ $plan->abreviacion }}"
                                            data-id_producto="{{ $plan->id_producto }}"
                                            data-producto_id="{{ @$plan->producto_id }}"
                                            data-merchant_fee="{{ $plan->merchant_fee }}"
                                            data-interes_anual="{{ $plan->interes_anual }}"
                                            data-plazo="{{ $plan->plazo }}"
                                            data-dti_pre="{{ $plan->dti_pre }}"
                                            data-dti_post="{{ $plan->dti_post }}"
                                            data-plazo="{{ $plan->plazo }}"
                                            data-activo="{{ ($plan->activo)?true:false }}"
                                            data-costo_anual_seguro="{{ ($plan->costo_anual_seguro)?true:false }}"
                                            data-comision_por_apertura="{{ $plan->comision_por_apertura }}"
                                            data-ltv="{{ $plan->ltv }}"
                                            data-enganche_min="{{ $plan->enganche_min }}"
                                            data-url="{{ route('planes.update',$plan->id) }}"
                                            style="font-size:12px"
                                         >
                                            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" data-original-title="" style="color:#fff !important"></i>
                                        </a>
                                    </span>
                                    
                                
                                    <span class="label label-rouded" style="background-color:#F99478;margin-top: 15px">
                                        <a  data-url="/admin/planes/{{ $plan->id }}"
                                                href="#"
                                                style="color:#fff"
                                                class="button-destroy button-show-hover "
                                                data-original-title="Eliminar"
                                                data-method="delete"
                                                data-trans-button-cancel="Cancelar"
                                                data-trans-button-confirm="Eliminar"
                                                data-trans-title="¿Está seguro de esta operación?"
                                                data-trans-subtitle="Esta operación eliminará este registro permanentemente">
                                                <i class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top" style="color:#fff !important"></i>
                                        </a>
                                    </span>
                                    
                                

                            
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
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
                            <label for="">Producto</label>
                            {{ Form::select('producto_id',$productos,null,['class'=>'form-control','id'=>'producto_id','required'=>true] ) }}
                        </div>
                        
                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'nombre','required'=>true] ) }}
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

                        {{-- <div class="col-md-6">
                            <label for="">Enganche mínimo</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">$</span>
                                {{ Form::text('enganche_min',null,['class'=>'form-control','id'=>'enganche_min','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                            </div>
                        </div> --}}

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
                            <label for="">Producto</label>
                            {{ Form::select('producto_id',$productos,null,['class'=>'form-control','id'=>'edit_producto_id','required'=>true,'placeholder'=>'Sin asignar'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'edit_nombre','required'=>true] ) }}
                            {{ Form::hidden('id',null,['class'=>'form-control','id'=>'edit_id',] ) }}
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

                        {{-- <div class="col-md-6">
                            <label for="">Enganche mínimo</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">$</span>
                                {{ Form::text('enganche_min',null,['class'=>'form-control','id'=>'edit_enganche_min','required'=>true,'onkeypress'=>'return isDecimalKey(this)','value'=>0] ) }}
                            </div>
                        </div> --}}

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
            $('.button-destroy').on('click', function(e){
            e.stopPropagation();
            e.preventDefault();
            var a = $(this);
            var _token = $('meta[name="csrf-token"]').attr('content');
            swal({
                    title: a.data('trans-title'),
                    text: a.data('trans-subtitle'),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: a.data('trans-button-confirm'),
                    cancelButtonText: a.data('trans-button-cancel'),
                    closeOnConfirm: false
                },
                function(){
                    var form =
                        $('<form>', {
                            'method': 'POST',
                            'action': a.data('url')
                        });

                    var token =
                        $('<input>', {
                            'name': '_token',
                            'type': 'hidden',
                            'value': _token
                        });

                    var hiddenInput =
                        $('<input>', {
                            'name': '_method',
                            'type': 'hidden',
                            'value': a.data('method')
                        });

                    form.append(token, hiddenInput).appendTo('body').submit();

                });
        })

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
                var dti_pre = $(this).data('dti_pre');
                var dti_post = $(this).data('dti_post');
                var activo = $(this).data('activo');
                var costo_anual_seguro = $(this).data('costo_anual_seguro');
                var comision_por_apertura = $(this).data('comision_por_apertura');

                var ltv = $(this).data('ltv');
                /* var enganche_min = $(this).data('enganche_min'); */

                var url = $(this).data('url');

                $('#edit_id').val(id);
                $('#edit_nombre').val(nombre);
                $('#edit_abreviacion').val(abreviacion);
                $('#edit_id_producto').val(id_producto);
                $('#edit_producto_id').val(producto_id);
                $('#edit_merchant_fee').val(merchant_fee);
                $('#edit_interes_anual').val(interes_anual);
                $('#edit_plazo').val(plazo);

                $('#edit_dti_pre').val(dti_pre);
                $('#edit_dti_post').val(dti_post);

                $('#edit_ltv').val(ltv);
                /* $('#edit_enganche_min').val(enganche_min); */

                if(activo){
                    $("#edit_activo").bootstrapSwitch('state', true);
                }else{
                    $("#edit_activo").bootstrapSwitch('state', false);
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