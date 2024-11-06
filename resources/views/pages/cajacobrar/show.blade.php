@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Detalles de Caja</span>
        </div>
        @if($caja->contabilizado == 0)
        <div class="justify-content-center mt-2">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="enviar()">
                    <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Unir Caja</b>
                </button>
            </div>
        @endif
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
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($caja->cobros()->where('tipo',1)->sum('total'),2)}}</h4>
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
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($caja->cobros()->where('tipo',0)->sum('total'),2)}}</h4>
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
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($caja->calcularBalanceEfectivo(),2)}}</h4>
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
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($caja->calcularBalanceTransferencia(),2)}}</h4>
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
                                                        <h4 class="tx-20 font-weight-semibold">{{number_format($caja->calcularBalanceEfectivo() + $caja->calcularBalanceTransferencia(),2)}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('venta.juntarcajas') }}" method="POST" id="enviarFormulario">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_caja_cobrar" value="{{$caja->id}}">
                        <div class="table-responsive">
                        <table id="clientes" class="table table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="marcarTodos"></th>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Documento</th>
                                    <th>Fecha Compra</th>
                                    <th>Fecha Pago</th>
                                    <th>Cliente / Detalle</th>
                                    <th>Medio</th>
                                    <th>Monto</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($caja->cobros as $pago)
                                <tr class="fila-venta">
                                    <td><input type="checkbox" name="ids[]" value="{{$pago->id }}"></td>
                                    <td>{{++$i}}</td>
                                    <td>{{$pago->tipo ? 'Ingreso':'Egreso'}}</td>
                                    <td>{{$pago->venta ? $pago->venta->documento->nombre.' - '.$pago->venta->nume_doc : $pago->documento}}</td>
                                    <td>{{$pago->venta ? $pago->venta->fecha : $pago->fecha}}</td>
                                    <td>{{$pago->fecha}}</td>
                                    <td>{{$pago->venta ? $pago->venta->cliente->nombre_comercial.''.$pago->venta->cliente->razon_social : $pago->observacion}}</td>
                                    <td>{{$pago->medio->nombre}}</td>
                                    <td>{{$pago->total}}</td>
                                    <td>{{$pago->user->nombre}} {{$pago->user->apellido}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom-scripts')
<script>
    $(document).ready(function() {
            // Manejar el cambio en la casilla de verificación "Marcar Todos"
            $('#marcarTodos').change(function() {
                // Obtener el estado actual de la casilla de verificación
                var isChecked = $(this).prop('checked');

                // Establecer el mismo estado en todas las casillas de verificación en la tabla
                $('.fila-venta input[type="checkbox"]').prop('checked', isChecked);
            });
        });

    function enviar() {
        // Obtener la lista de checkboxes por nombre
        var checkboxes = document.getElementsByName("ids[]");

        // Verificar si al menos uno está marcado
        var alMenosUnoMarcado = Array.from(checkboxes).some(function(checkbox) {
            return checkbox.checked;
        });

        // Si al menos uno está marcado, enviar el formulario; de lo contrario, mostrar un mensaje de alerta
        if (alMenosUnoMarcado) {
            document.getElementById("enviarFormulario").submit();
        } else {
            alert("Selecciona al menos una opción antes de enviar el formulario.");
        }
    }
</script>
@endpush