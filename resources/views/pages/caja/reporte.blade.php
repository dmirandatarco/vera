@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Reporte de Caja</span>
        </div>
        <div class="justify-content-center mt-2">
            @if( Gate::check('caja.ingreso') && $cajaactiva)
            <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar(1)">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Agregar Ingreso</b>
            </button>
            @endif
            @if( Gate::check('caja.egreso') && $cajaactiva)
            <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar(2)">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Agregar Egreso</b>
            </button>
            @endif
        </div>
    </div>
    <!-- /breadcrumb -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    <!-- row -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-xs-2">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-2">
                                                <div class="">
                                                    <h6 class="mb-2 tx-18 ">Total Ingresos:</h6>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex">
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($pagoSolesIngreso,2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-xs-2">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-2">
                                                <div class="">
                                                    <h6 class="mb-2 tx-18 ">Total Egresos:</h6>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex">
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($pagoSolesEgreso,2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-xs-2">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-2">
                                                <div class="">
                                                    <h6 class="mb-2 tx-18 ">Total Efectivo:</h6>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex">
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($pagoSolesTotal,2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-xs-2">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-2">
                                                <div class="">
                                                    <h6 class="mb-2 tx-18 ">Total Transferencia:</h6>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex">
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($pagoTransferenciaTotal,2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-xs-4">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-2">
                                                <div class="">
                                                    <h6 class="mb-2 tx-18 ">Total:</h6>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex">
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($pagoSolesTotal + $pagoTransferenciaTotal,2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table id="ventas" class="table table-hover">
                            <thead>
                                <tr >
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Documento</th>
                                    <th>Fecha Compra</th>
                                    <th>Fecha Pago</th>
                                    <th>Cliente / Detalle</th>
                                    <th>Medio</th>
                                    <th>Monto</th>
                                    <th>Responsable</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($pagos as $pago)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$pago->tipo == 1 ? 'Ingreso':'Egreso'}}</td>
                                    <td>{{$pago->venta ? $pago->venta->documento->nombre.' - '.$pago->venta->nume_doc : ($pago->compra ? $pago->compra->documento->nombre.' - '.$pago->compra->nume_doc : $pago->documento)}}</td>
                                    <td>{{$pago->venta ? $pago->venta->fecha : ($pago->compra ? $pago->compra->fecha : $pago->fecha)}}</td>
                                    <td>{{$pago->fecha}}</td>
                                    <td>{{$pago->venta ? $pago->venta->cliente->nombre_comercial.''.$pago->venta->cliente->razon_social : ($pago->compra ? $pago->compra->proveedor?->nombre : $pago->observacion)}}</td>
                                    <td>{{$pago->medio->nombre}}</td>
                                    <td>{{$pago->total}}</td>
                                    <td>{{$pago->user->nombre}} {{$pago->user->apellido}}</td>
                                    <td>
                                        @if($cajaactiva->id == $pago->caja_id && $pago->estado == 1)
                                            <button type="button" class="btn btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$pago->id}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
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
</div>
<!-- /Container -->
<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Cambiar Estado de Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('caja.destroy','test')}}" method="POST" autocomplete="off">
            {{method_field('delete')}}
            {{csrf_field()}}
                <p>¿Estás seguro de cambiar el estado?</p>
                <div class="modal-footer">
                <input type="hidden" name="id_pago_2" class="id_pago_2">
                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- /Container -->
<div class="modal fade" id="crear-formulario"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="text-formulario"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('caja.pagos')}}" method="POST" autocomplete="off" id="paymentForm">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="total" class="form-label">Total:</label>
                        <input type="number" step="0.01" min='0' class="form-control total" id="total" name="total" value="{{old('total')}}">
                        @error('total')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3" >
                        <input type="hidden" name="id" id="id" value="{{old('id')}}">
                        <input type="hidden" name="tipo" id="tipo" value="{{old('tipo')}}">
                        <label class="form-label" for="medio_id">Medio</label>
                        <select class="form-select" id="medio_id" name="medio_id" data-width="100%">
                            <option value="">SELECCIONE</option>
                            @foreach($medios as $medio)
                                <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                            @endforeach
                        </select>
                        @error('medio_id')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento:</label>
                        <input type="text" class="form-control documento" id="documento" name="documento" value="{{old('documento')}}">
                        @error('documento')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observacion:</label>
                        <input type="text" class="form-control observacion" id="observacion" name="observacion" value="{{old('observacion')}}">
                        @error('observacion')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary" id="submitButton">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

    @push('plugin-scripts')
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    @endpush

    @push('custom-scripts')
    @if(count($errors)>0)
    <script>
    
    if('{{old("tipo")}}'){
        $(function() {
            $('#crear-formulario').modal('show');
            $('#text-formulario').text('Agregar Ingreso');
        });
    }else{
        $(function() {
            $('#crear-formulario').modal('show');
            $('#text-formulario').text('Agregar Egreso');
        });
    }
    </script>
    @else
    <script>
    </script>
    @endif

    <script>

    document.addEventListener("DOMContentLoaded", function() {
        const submitButton = document.getElementById('submitButton');
        const paymentForm = document.getElementById('paymentForm');

        paymentForm.addEventListener('submit', function() {
            submitButton.disabled = true; // Deshabilitar el botón de enviar una vez que se envía el formulario
        });
    });
    $(document).ready(function() {
        $('#ventas').DataTable({
            searching: false,  // Desactivar la opción de búsqueda
            paging: false       // Desactivar la paginación
        });
    });
    function agregar(tipo) {
        $('#crear-formulario').modal('show').on('shown.bs.modal', function () {
            $('#total').focus();
        });
        if(tipo==1){
            $('#text-formulario').text('Agregar Ingreso');
            $('#tipo').val(tipo);
        }else{
            $('#text-formulario').text('Agregar Egreso');
            $('#tipo').val(tipo);
        }
        $('#id').val(null);
        $('#medio_id').val(null).select2({
            dropdownParent: $("#crear-formulario"),
            width: '100%'
        });
        $('#total').val(null);
        $('#documento').val(null);
        $('#observacion').val(null);
    }

    var eliminarUsuario = document.getElementById('EliminarUsuario');

    eliminarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = eliminarUsuario.querySelector('.id_pago_2')

    idModal.value = id;
})
</script>
@endpush
