@extends('layouts.app')

@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="col-md-12">
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Tipo Persona</th>
                        <th>Prestamo Solicitado</th>
                        <th>Valor del bien</th>
                        <th>Plazo</th>
                        <th>Fecha Solicitud</th>
                        <th>Estatus</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $solicitud)
                        <tr data-show="{{  route('integrador.solicitud.show',$solicitud->id) }}">
                            <td>{{ $solicitud->id }}</td>
                            <td>{{ @$solicitud->cliente->nombre }} {{ @$solicitud->cliente->apellido_paterno }} {{ @$solicitud->cliente->apellido_materno }}</td>
                            <td>
                                @if($solicitud->cliente->persona_tipo == 'fisica')
                                    <i class="fa fa-user" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ $solicitud->cliente->persona_tipo }}"></i>
                                @else
                                    <i class="fa fa-building-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ $solicitud->cliente->persona_tipo }}"></i>
                                @endif
                            </td>
                            <td style="text-align: center">${{ number_format($solicitud->monto_financiar,2) }}</td>
                            <td style="text-align: center">${{ number_format($solicitud->precio_sistema,2) }}</td>
                            <td>{{ $solicitud->plazo_financiar }} meses</td>

                            <td>{{ date('d/m/Y',strtotime($solicitud->created_at)) }}</td>
                            <td><span class="label label-rouded" style="background-color:{{ $solicitud->estatus->color }}"> {{ $solicitud->estatus->nombre }}</span></td>
                            <td>
                                <a  data-url="/admin/solicitudes/{{ $solicitud->id }}"
                                    href="#"
                                    class="button-destroy button-show-hover"
                                    data-original-title="Eliminar"
                                    data-method="delete"
                                    data-trans-button-cancel="Cancelar"
                                    data-trans-button-confirm="Eliminar"
                                    data-trans-title="¿Está seguro de esta operación?"
                                    data-trans-subtitle="Esta operación eliminará este registro permanentemente">
                                    <i class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@stop


@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>

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

        $('#fecha').datepicker({
            format:'yyyy-mm-dd',
        });

        bindClickTabla();
        function bindClickTabla(){
            $('tbody td').bind('click',function(e){
                if (!$(this).hasClass('actions')) {
                    window.location.href = $(this).parent().data('show');
                }
            })
        }
    </script>
@stop
