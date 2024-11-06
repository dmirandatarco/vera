@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Cajas para Cobrar</span>
        </div>
        <div class="justify-content-center mt-2">
            @if( Gate::check('caja.create') && !$cajaactiva)
            <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar('{{$ultimacaja ? $ultimacaja?->totalCierre : 0}}')">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Aperturar Caja</b>
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
                        <div class="table-responsive">
                        <table id="clientes" class="table table-hover">
                            <thead>
                                <tr >
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Monto Inicial</th>
                                    <th>Monto Final</th>
                                    <th>Total Efectivo</th>
                                    <th>Total Transferencia</th>
                                    <th>Estado</th>
                                    <th>Responsable</th>
                                    <th>Sucursal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cajas as $caja)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$caja->fechaApertura}}</td>
                                        <td>{{number_format($caja->totalApertura,2)}}</td>
                                        <td>{{number_format($caja->totalCierre,2)}}</td>
                                        <td>{{number_format($caja->calcularBalanceEfectivo(),2)}}</td>
                                        <td>{{number_format($caja->calcularBalanceTransferencia(),2)}}</td>
                                        <td>{{$caja->estado ? 'Aperturado':'Cerrado'}}</td>
                                        <td>{{$caja->user->nombre}} {{$caja->user->apellido}}</td>
                                        <td>{{$caja->sucursal->nombre}}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-settings"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{route('cajacobrar.show',$caja->id)}}" >Ver Detalles</a></li>
                                                <li><a class="dropdown-item" onclick="editar('{{$caja->id}}','{{$caja->user_id}}','{{$caja->totalApertura}}','{{$caja->observacion}}')">Editar</a></li>
                                                <li><a class="dropdown-item" onclick="cerrar('{{$caja->id}}','0','{{$caja->calcularBalanceEfectivo()+$caja->calcularBalanceTransferencia()}}')" >Cerrar Caja</a></li>
                                            </ul>
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
<div class="modal fade" id="crear-egreso"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cerrar Caja </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('cajacobrar.cerrar')}}" method="POST" autocomplete="off" id="paymentForm2">
                    {{csrf_field()}}
                    <div class="mb-3" >
                        <input type="hidden" name="id_caja" id="id_caja" value="{{old('id_caja')}}">
                        <label for="totalCierre" class="form-label">Total Cierre:</label>
                        <input type="number" step="0.01" min='0' class="form-control total" id="totalCierre" name="totalCierre" value="{{old('totalCierre')}}">
                        @error('totalCierre')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="totalGlobal" class="form-label">Total Caja:</label>
                        <input type="number" step="0.01" min='0' class="form-control total" id="totalGlobal" name="totalGlobal" value="{{old('totalGlobal')}}">
                        @error('totalGlobal')
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
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary" id="submitButton2">Guardar</button>
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
                <h5 class="modal-title">Aperturar Caja </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('cajacobrar.store')}}" method="POST" autocomplete="off" id="paymentForm">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="totalApertura" class="form-label">Total Apertura:</label>
                        <input type="number" step="0.01" min='0' class="form-control total" id="totalApertura" name="totalApertura" value="{{old('totalApertura')}}">
                        @error('totalApertura')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3" >
                        <input type="hidden" name="id" id="id" value="{{old('id')}}">
                        <label class="form-label" for="user_id">Responsable</label>
                        <select class="form-select" id="user_id" name="user_id" data-width="100%">
                            <option value="">SELECCIONE</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->nombre}} {{$user->apellido}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
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
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary" id="submitButton">Guardar</button>
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
    
    if('{{old("totalApertura")}}'){
        $(function() {
            $('#crear-formulario').modal('show');
        });
    }else{
        $(function() {
            $('#crear-egreso').modal('show');
        });
    }
    </script>
    @else
    @endif

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const submitButton = document.getElementById('submitButton');
        const paymentForm = document.getElementById('paymentForm');

        paymentForm.addEventListener('submit', function() {
            submitButton.disabled = true; // Deshabilitar el botón de enviar una vez que se envía el formulario
        });

        const submitButton2 = document.getElementById('submitButton2');
        const paymentForm2 = document.getElementById('paymentForm2');

        paymentForm2.addEventListener('submit', function() {
            submitButton2.disabled = true; // Deshabilitar el botón de enviar una vez que se envía el formulario
        });
    });
    function agregar(cierre) {
        $('#crear-formulario').modal('show').on('shown.bs.modal', function () {
            $('#totalApertura').focus();
        });
        $('#id').val(null);
        $('#user_id').val(null).select2({
            dropdownParent: $("#crear-formulario"),
            width: '100%'
        });
        $('#totalApertura').val(cierre);
        $('#observacion').val(null);
    }

    function editar(id,user_id,totalApertura,observacion) {
        $('#crear-formulario').modal('show').on('shown.bs.modal', function () {
            $('#totalApertura').focus();
        });
        $('#id').val(id);
        $('#user_id').val(user_id).select2({
            dropdownParent: $("#crear-formulario"),
            width: '100%'
        });
        $('#totalApertura').val(totalApertura);
        $('#observacion').val(observacion);
    }
    
    function cerrar(id,totalCierre,totalGlobal) {
        $('#crear-egreso').modal('show').on('shown.bs.modal', function () {
            $('#totalCierre').focus();
        });
        $('#id_caja').val(id);
        $('#totalCierre').val(totalCierre);
        $('#totalGlobal').val(totalGlobal);
        $('#observacion').val(null);
    }

    $(function() {
    'use strict';

    $(function() {
        $('#clientes').DataTable({
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "language": {
            "lengthMenu": "Mostrar  _MENU_  registros por paginas",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate":{
            "next": "Siguiente",
            "previous": "Anterior",
            }
        },
        "columnDefs": [
            {
            targets: [7],
            orderable: false
            }
        ]
        });
    });

});
</script>
@endpush
