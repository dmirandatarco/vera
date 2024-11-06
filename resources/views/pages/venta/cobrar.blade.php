@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
    @if($caja)
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Ventas por Cobrar</span>
            </div>
            {{-- <div class="justify-content-center mt-2">
                <button id="BotonFiltro" class="btn btn-primary">
                    <i class="fas fa-filter"></i><b> &nbsp; Filtros</b>
                </button>
            </div> --}}
        </div>
        <!-- /breadcrumb -->
        <!-- row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="filtroVentas">
                            <form action="{{ route('ventas.cobrar') }}" method="GET">
                                <div class="row pb-4">
                                    <div class="col-md-3">
                                        <label for="searchFechaInicio" class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" id="searchFechaInicio"
                                            name="searchFechaInicio" value="{{ $fechaInicio2 }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchFechaFin" class="form-label">Fecha Fin</label>
                                        <input type="date" class="form-control" id="searchFechaFin" name="searchFechaFin"
                                            value="{{ $fechaFin2 }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchCliente" class="form-label">Cliente</label>
                                        <div class="form-group">
                                            <select name="searchCliente" class="form-control form-select cliente"
                                                data-bs-placeholder="Select Cliente">
                                                <option value="">SELECCIONE</option>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}"
                                                        {{ $searchCliente2 == $cliente->id ? 'selected' : '' }}>
                                                        {{ $cliente->razon_social }} {{ $cliente->nombre_comercial }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchDocumento" class="form-label">Tipo de Documento</label>
                                        <div class="form-group">
                                            <select name="searchDocumento" class="form-control form-select documento"
                                                data-bs-placeholder="Select Document">
                                                <option value="">SELECCIONE</option>
                                                @foreach ($documentos as $documento)
                                                    <option value="{{ $documento->id }}"
                                                        {{ $searchDocumento2 == $documento->id ? 'selected' : '' }}>
                                                        {{ $documento->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchNroDocumento" class="form-label">Nro de Documento</label>
                                        <input type="text" class="form-control" id="searchNroDocumento"
                                            name="searchNroDocumento" placeholder="" value="{{ $nume_documento2 }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button id="tuBotonEnviar" class="btn btn-primary mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-search"></i><b>
                                                &nbsp; Buscar</b>
                                        </button>
                                    </div>
                                    @if($searchCliente2 && count($ventas) > 0 && $ventas->where('estado',1)->sum('saldo') > 0)
                                        <div class="col-md-2">
                                            <button data-bs-toggle="modal" data-bs-target="#modalCobrarGlobal" type="button" class="btn btn-primary mt-4">
                                                <i class="fas fa-money-bill-alt"></i><b>
                                                    &nbsp; Pagar</b>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="movimientos" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Saldo</th>
                                        <th>Total</th>
                                        <th>Sucursal</th>
                                        <th>Reponsable</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                    <tr class="fila-venta {{$venta->verCobro() == 1 ? 'bg-primary':''}}" data-id="{{ $venta->id }}">
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $venta->fecha }}</td>
                                            <td>{{ $venta->cliente?->razon_social }} {{ $venta->cliente?->nombre_comercial }}</td>
                                            <td>{{ $venta->documento->nombre }} {{ $venta->nume_doc }}</td>
                                            <td>{{ $venta->saldo }}</td>
                                            <td>{{ $venta->total }}</td>
                                            <td>{{ $venta->sucursal->nombre }}</td>
                                            <td>{{ $venta->user->nombre }} {{ $venta->user->apellido }}</td>
                                            <td>{{ $venta->estado ? 'Registrado' : 'Anulado' }}</td>
                                            <!-- <td>
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fe fe-settings"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" data-bs-toggle="modal">Visualizar</a>
                                                    </li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#EliminarUsuario"
                                                            data-id="{{ $venta->id }}">Anular</a></li>
                                                    <li><a class="dropdown-item"
                                                            target="_blank"href="{{ route('venta.ticketpdf', $venta) }}">Ver
                                                            Ticket</a></li>
                                                    <li><a class="dropdown-item"
                                                            target="_blank"href="{{ route('venta.ticketpedido', $venta) }}">Ver
                                                            Pedido</a></li>
                                                </ul>
                                            </td> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: right;">Totales</th>
                                        <th>{{number_format($ventas->where('estado',1)->sum('acuenta'),2)}}</th>
                                        <th>{{number_format($ventas->where('estado',1)->sum('saldo'),2)}}</th>
                                        <th>{{number_format($ventas->where('estado',1)->sum('total'),2)}}</th>
                                        <th colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Container -->

    <!-- Large Modal -->
    <div class="modal fade" id="modalCobrar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Realizar Pago</h6><button aria-label="Close" class="btn-close"  data-bs-dismiss="modal" aria-label="btn-close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" >
                    <form action="{{ route('ventas.cobrarTrabajador', 'test') }}" method="POST" autocomplete="off" id="paymentForm2">
                    {{csrf_field()}}
                    <div class="mb-3 ">
                        <label class="form-label" for="medioId">Medio de Pago</label>
                        <select class="js-example-basic-single form-select" id="medioId" name="medioId" data-width="100%" required>
                            @foreach($medios as $medio)
                                <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                            @endforeach
                        </select>
                        @error('medioId')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 ">
                        <label for="totalpago" class="form-label">Monto</label>
                        <input type="number" step="0.01" min='0' id="totalpago" class="form-control totalpago" name="totalpago" autocomplete="off" required>
                        @error('totalpago')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="id_venta_pagar" class="id_venta_pagar">
                    </div>
                    <div class="modal-footer">
                        <button aria-label="Close" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
                        <button type="submit" class="btn btn-primary me-2" id="submitButton2">Guardar</button>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Large Modal -->
    <div class="modal fade" id="modalCobrarGlobal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Realizar Pago</h6><button aria-label="Close" class="btn-close"  data-bs-dismiss="modal" aria-label="btn-close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" >
                    <form action="{{ route('ventas.pagarglobalTrabajador', 'test') }}" method="POST" autocomplete="off" id="paymentForm">
                    {{csrf_field()}}
                    <div class="mb-3 ">
                        <label class="form-label" for="medioIdGlobal">Medio de Pago</label>
                        <select class="js-example-basic-single form-select" id="medioIdGlobal" name="medioIdGlobal" data-width="100%" required>
                            @foreach($medios as $medio)
                                <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                            @endforeach
                        </select>
                        @error('medioIdGlobal')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 ">
                        <label for="totalpagoGlobal" class="form-label">Monto</label>
                        <input type="number" step="0.01" min='0' max="{{$ventas->where('estado',1)->sum('saldo')}}" id="totalpagoGlobal" class="form-control totalpagoGlobal" name="totalpagoGlobal" value="{{$ventas->where('estado',1)->sum('saldo')}}" autocomplete="off" required>
                        @error('totalpagoGlobal')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="cliente_id_global" class="cliente_id_global" value="{{$searchCliente2}}">
                        <input type="hidden" name="fecha_inicio_global" class="fecha_inicio_global" value="{{$fechaInicio2}}">
                        <input type="hidden" name="fecha_fin_global" class="fecha_fin_global" value="{{$fechaFin2}}">
                    </div>
                    <div class="modal-footer">
                        <button aria-label="Close" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
                        <button type="submit" class="btn btn-primary me-2" id="submitButton">Guardar</button>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" >
        <div class="offcanvas-body" >
            <div aria-multiselectable="true" class="accordion accordion-dark" id="accordion2" role="tablist" >

                <div class="panel-group1" id="accordion11" role="tablist">
                    <div class="card overflow-hidden">
                        <a class="accordion-toggle panel-heading1 collapsed " data-bs-toggle="collapse" data-bs-parent="#accordion11" href="#collapseOne1" aria-expanded="true"><i class="fe fe-user me-2"></i>Datos Generales</a>
                        <div id="collapseOne1" class="panel-collapse collapse show" role="tabpanel" aria-expanded="false">
                            <div class="panel-body">
                                <div class="main-contact-item p-0">
                                    <div class="main-contact-body m-0">
                                        <h6>Nombre del Asesor: <span id="nombreAsesor"></span></h6>
                                        <span class="me-2">
                                            <i class="far fa-calendar-check"></i>
                                            <span id="fechaVenta"></span>
                                        </span>
                                        <span>
                                            <i class="far fa-clock"></i>
                                            <span id="horaVenta"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-6">
                                            <div class="row border-end bd-xs-e-0">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex align-items-center p-3 gap-4">
                                                    <i class="fa fa-archive"></i>
                                                    <h6 class="mb-2 tx-12">Almacen:<br><span id="almacenVenta"></span></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-6">
                                            <div class="row border-end bd-xs-e-0">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex align-items-center p-3 gap-4">
                                                    <i class="fa fa-sitemap"></i>
                                                    <h6 class="mb-2 tx-12">Sucursal:<br><span id="sucursalVenta"></span></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 px-3">
                                            <div class="row border-end bd-xs-e-0">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex gap-4">
                                                    <i class="fa fa-user-secret"></i>
                                                    <h6 class="mb-2 tx-12">Cliente:<br><span id="clienteNombreVenta"></span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card overflow-hidden">
                        <a class="accordion-toggle mb-0 panel-heading1 collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion11" href="#collapseTwo2" aria-expanded="true"><i class="fe fe-plus-circle me-2"></i>Detalles de Venta</a>
                        <div id="collapseTwo2" class="panel-collapse collapse show" role="tabpanel" aria-expanded="false">
                            <div class="panel-body p-0 ">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-primary mg-b-0 text-md-nowrap table-side" >
                                        <thead>
                                            <tr>
                                                <th>DIP:</th>
                                                <th>ADD:</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-bordered table-hover table-primary mg-b-0 text-md-nowrap table-side">
                                        <thead>
                                            <tr>
                                                <th>Cant</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detallesVentaContainer">
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card overflow-hidden">
                        <a class="accordion-toggle mb-0 panel-heading1 collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion11" href="#collapseThree3" aria-expanded="true"><i class="fas fa-dollar-sign me-2"></i>Pagos</a>
                        <div id="collapseThree3" class="panel-collapse collapse show" role="tabpanel" aria-expanded="false">
                            <div class="panel-body p-0 ">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-primary mg-b-0 text-md-nowrap table-side">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Medio</th>
                                                <th>Monto</th>
                                                <th>Estado</th>
                                                <th>Anular</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pagosVentaContainer">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card overflow-hidden">
                        <a class="accordion-toggle mb-0 panel-heading1 collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion11" href="#collapseFour4" aria-expanded="true"><i class="fa fa-mouse-pointer me-2"></i>Ordenes</a>
                        <div id="collapseFour4" class="panel-collapse collapse show" role="tabpanel" aria-expanded="false">
                            <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-primary mg-b-0 text-md-nowrap table-side">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Maquina</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="trabajosContainer">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <div class="tabs-menu ">
                            <ul class="nav panel-tabs flex-nowrap">
                                @if($caja)
                                    <li class=""><a class="btn btn-primary mx-2 button-icon" href="#" data-bs-toggle="modal" data-bs-target="#modalCobrar" id="btnPagar" ><i class="pe-2 fas fa-dollar-sign"></i>Pagar</a></li>
                                @endif
                                <li class=""><a class="btn btn-primary mx-2 button-icon" id="btnImprimir"><i class="pe-2 fa fa-print"></i>Imprimir</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">No Hay caja Aperturada</span>
            </div>
        </div>
    </div>
    @endif

@endsection
@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush
@push('custom-scripts')
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
        $(document).ready(function() {
            $('.responsable').select2({
                placeholder: 'Seleccione',
                searchInputPlaceholder: 'Search'
            });
            $('.responsable-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Seleccione'
            });
            $('.responsable').on('click', () => {
                let selectField = document.querySelectorAll('.select2-search__field')
                selectField.forEach((element, index) => {
                    element?.focus();
                })
            });
        });
        $(document).ready(function() {
            $('.cliente').select2({
                placeholder: 'Seleccione',
                searchInputPlaceholder: 'Search'
            });
            $('.cliente-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Seleccione'
            });
            $('.cliente').on('click', () => {
                let selectField = document.querySelectorAll('.select2-search__field')
                selectField.forEach((element, index) => {
                    element?.focus();
                })
            });
        });
        $(document).ready(function() {
            $('.documento').select2({
                placeholder: 'Seleccione',
                searchInputPlaceholder: 'Search'
            });
            $('.documento-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Seleccione'
            });
            $('.documento').on('click', () => {
                let selectField = document.querySelectorAll('.select2-search__field')
                selectField.forEach((element, index) => {
                    element?.focus();
                })
            });
        });
        var agregarPago = document.getElementById('modalCobrar');
        agregarPago.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')
            var saldo = button.getAttribute('data-saldo')
            var idModal = agregarPago.querySelector('.id_venta_pagar')
            var totalModal = agregarPago.querySelector('.totalpago')
            idModal.value = id;
            totalModal.value = saldo;
        })
    </script>

    <script>
        function showSpinnerAndDownload(movimientoId, url) {
            $('#spinner-' + movimientoId).removeClass('d-none');
            setTimeout(function() {
                window.location.href = url;
            }, 100);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.fila-venta').on('click', function() {
                var ventaId = $(this).data('id');

                // Llamada a la función para cargar los datos de la venta
                cargarDatosVenta(ventaId);

                // Abrir el offcanvas
                var offcanvas = new bootstrap.Offcanvas($('#offcanvasRight'));
                offcanvas.show();
            });
        });

        function cargarDatosVenta(ventaId) {
            $.ajax({
                url: '/ventas/consulta/' + ventaId,
                type: 'GET',
                success: function(data) {

                    var dateTime = data.fecha;
                    var parts = dateTime.split(' ');
                    var fecha = parts[0];
                    var hora = parts[1];
                    $('#nombreAsesor').text(data.user.nombre +' '+ data.user.apellido);
                    $('#fechaVenta').text(fecha);
                    $('#horaVenta').text(hora);
                    $('#almacenVenta').text(data.almacen.nombre);
                    $('#sucursalVenta').text(data.sucursal.nombre);
                    $('#clienteNombreVenta').text(data.cliente.razon_social+' '+data.cliente.nombre_comercial);
                    $('#detallesVentaContainer').empty();
                    var detalles = data.detalles_venta;
                    var detallesHtml = '';
                    detalles.forEach(function(detalle) {
                        detallesHtml += '<tr>' +
                                            '<td scope="row">' + detalle.cantidad + '</td>' +
                                            '<td class="descripcion-table-side" style="font-size:0.75rem">' + detalle.producto.categoria.abreviatura+' '+detalle.producto.nombre + '</td>' +
                                            '<td>' + detalle.precio + '</td>' +
                                        '</tr>';
                    });
                    $('#detallesVentaContainer').html(detallesHtml);
                    $('#pagosVentaContainer').empty();
                    $('#pagosVentaContainer').empty();
                    var pagos = data.cobros_venta;
                    var pagosHtml = '';
                    pagos.forEach(function(pago) {
                        anularLink = '<a href="{{ url('cobraranular') }}/' + pago.id + '" class="btn btn-primary button-icon"><i class="fas fa-times"></i></a>';
                        pagosHtml += '<tr>' +
                                        '<td scope="row">' + (pago.fecha) + '</td>' +
                                        '<td>' + pago.medio.nombre + '</td>' +
                                        '<td>' + pago.total + '</td>' +
                                        '<td>' + (pago.estado == 1 ? "Registrado" : "Anulado") + '</td>' +
                                        '<td>' + anularLink + '</td>' +
                                    '</tr>';
                    });
                    $('#pagosVentaContainer').html(pagosHtml);
                    $('#trabajosContainer').empty();
                    var trabajos = data.trabajos;
                    var trabajosHtml = '';
                    trabajos.forEach(function(trabajo) {
                        
                        trabajosHtml += '<tr>' +
                                        '<td scope="row">' + (trabajo.id) + '</td>' +
                                        '<td scope="row">' + (trabajo.fecha) + '</td>' +
                                        '<td>' + trabajo.user.nombre + '</td>' +
                                        '<td>' + trabajo.maquina.nombre + '</td>' +
                                        '<td><a href="{{ url('ventas/ticketpedido') }}/' + trabajo.id + '" target="_blank" class="btn btn-primary button-icon"><i class="fas fa-file"></i></a></td>' +
                                    '</tr>';
                    });
                    $('#trabajosContainer').html(trabajosHtml);
                    $('#btnImprimir').attr("href", `{{ url('ventas/ticketpdf') }}/${data.id}`);
                    $('#btnImprimir').attr("target", "_blank");
                    $('#btnPagar').attr('data-id',data.id);
                    $('#btnPagar').attr('data-saldo',data.saldo);
                    $('#totalpago').attr('max',data.saldo);
                },
                error: function(error) {
                    console.log(error);
                    // Manejar los errores
                }
            });
        }
    </script>
@endpush
