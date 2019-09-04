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
        <h2 class="col-md-12">Productos</h2>
    </div>

    <div class="row">
        <div class="col-md-12">

                <button type="button" id="btnAdd" class="btn btn-success btn-outline pull-right" data-target="#addProducto" data-toggle="modal"  style="margin-top: 22px;margin-bottom: 10px;">(+) Agregar</button>

        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr data-show="/admin/productos/{{ $producto->id }}">
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td><span class="label label-rouded label-{{ ($producto->activo)?'success':'danger' }}" > {{ ($producto->activo)?'Activo':'Inactivo' }}</span></td>
                            <td class="actions">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                            <span class="label label-rouded" style="background-color:#08C394">
                                                <a href="#"
                                                    class="button-show-hover btnEdit label label-rouded"
                                                    data-toggle="modal"
                                                    data-target="#editProducto"
                                                    data-id="{{ $producto->id }}"
                                                    data-nombre="{{ $producto->nombre }}"                                                    
                                                    data-descripcion="{{ $producto->descripcion }}"                                                    
                                                    data-activo="{{ ($producto->activo)?true:false }}"
                                                    data-url="{{ route('productos.update',$producto->id) }}"
                                                    style="font-size:12px"
                                                >
                                                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" data-original-title="" title=""></i>
                                                </a>
                                            </span>
                                    
                                        <span class="label label-rouded" style="background-color:#F89478;color:#fff">
                                            <a  data-url="/admin/productos/{{ $producto->id }}" 
                                                href="#"
                                                class="button-destroy button-show-hover"
                                                data-original-title="Eliminar"
                                                data-method="delete"
                                                data-trans-button-cancel="Cancelar"
                                                data-trans-button-confirm="Eliminar"
                                                data-trans-title="¿Está seguro de esta operación?"
                                                data-trans-subtitle="Esta operación eliminará este registro permanentemente">
                                                <i class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top" style="color:#fff !important"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade none-border" id="addProducto">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Agregar Producto</h4>
                </div>
                {!! Form::open(['method' => 'POST','url'=>'/admin/productos']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-12">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','required'=>true] ) }}
                        </div>

                        <div class="col-md-12">
                            <label for="">Descripción</label>
                            {{ Form::textarea('descripcion',null,['class'=>'form-control','required'=>false] ) }}
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


    <div class="modal fade none-border" id="editProducto">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Editar Producto</h4>
                </div>
                {!! Form::open(['method' => 'PUT','url'=>'/admin/productos/1', 'id'=>'formEdit']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-12">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','required'=>true,'id'=>'nombre'] ) }}
                        </div>

                        <div class="col-md-12">
                            <label for="">Descripción</label>
                            {{ Form::textarea('descripcion',null,['class'=>'form-control','required'=>false,'id'=>'descripcion'] ) }}
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
        bindClickTabla();
        $(".bootstrapSwitch").bootstrapSwitch();

        $('.btnEdit').click(function(){
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var descripcion = $(this).data('descripcion');
                var activo = $(this).data('activo');                

                var url = $(this).data('url');

                $('#edit_id').val(id);
                $('#nombre').val(nombre);
                $('#descripcion').val(descripcion);                                

                if(activo){
                    $("#edit_activo").bootstrapSwitch('state', true);
                }else{
                    $("#edit_activo").bootstrapSwitch('state', false);
                }                

                $('#formEdit').attr('action',url);
            })
     })

     
        function bindClickTabla(){
            $('tbody td').bind('click',function(e){
                if (!$(this).hasClass('actions')) {
                    window.location.href = $(this).parent().data('show');
                }
            })
        }
 </script>
@endsection