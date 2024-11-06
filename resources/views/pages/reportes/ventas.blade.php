@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Reporte de Ventas</span>
            </div>
            <div class="justify-content-center mt-2">
            </div>
        </div>
        <!-- /breadcrumb -->
        <!-- row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="filtroVentas">
                            <form action="{{ route('reportes.ventas') }}" method="GET">
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
                                        <label for="searchResponsable" class="form-label">Responsable</label>
                                        <div class="form-group">
                                            <select name="searchResponsable" class="form-control form-select" id="responsable"
                                                data-bs-placeholder="Select Responsable">
                                                <option value="">SELECCIONE</option>
                                                @foreach ($responsables as $responsable)
                                                    <option value="{{ $responsable->id }}"
                                                        {{ $searchResponsable2 == $responsable->id ? 'selected' : '' }}>
                                                        {{ $responsable->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchCliente" class="form-label">Cliente</label>
                                        <div class="form-group">
                                            <select name="searchCliente" class="form-control form-select" id="cliente"
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
                                            <select name="searchDocumento" class="form-control form-select " id="documento"
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
                                        <label for="searchNroDocumento" class="form-label">Estado de Pago</label>
                                        <select name="searchNroDocumento" class="form-control form-select " id="searchNroDocumento" data-bs-placeholder="Select Estado">
                                            <option value="" {{ is_null($nume_documento2) ? 'selected' : '' }}>SELECCIONE</option>
                                            <option value="0" {{ $nume_documento2 === 0 && !is_null($nume_documento2) ? 'selected' : '' }}>PENDIENTE</option>
                                            <option value="1" {{ $nume_documento2 === 1 && !is_null($nume_documento2) ? 'selected' : '' }}>CANCELADO</option>
                                        </select>                                        
                                    </div>
                                    <div class="col-md-2">
                                        <button id="tuBotonEnviar" class="btn btn-primary mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-search"></i><b>
                                                &nbsp; Buscar</b>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('reportes.ventas-excel', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2, 'searchNroDocumento' => $nume_documento2, 'searchResponsable' => $searchResponsable2, 'searchCliente' => $searchCliente2, 'searchDocumento' => $searchDocumento2]) }}" target="_blank" class="btn btn-success mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Excel" class="fas fa-file"></i><b>
                                                &nbsp; Excel</b>
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('reportes.ventas-pdf', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2, 'searchNroDocumento' => $nume_documento2, 'searchResponsable' => $searchResponsable2, 'searchCliente' => $searchCliente2, 'searchDocumento' => $searchDocumento2]) }}" target="_blank" class="btn btn-danger mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-file-pdf"></i><b>
                                                &nbsp; PDF</b>
                                        </a>
                                    </div>
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
                            <table id="ventas" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pago</th>
                                        <th>Cliente</th>
                                        <th>Comprobante</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Pagado</th>
                                        <th>Saldo</th>
                                        <th>Sucursal</th>
                                        <th>Estado Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                    <tr class="fila-venta" data-id="{{ $venta->id }}">
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $venta->pago == 1 ? 'CONTADO':'CREDITO' }}</td>
                                            <td>{{ $venta->cliente?->nombre_comercial }}</td>
                                            <td>{{ $venta->documento->nombre }} {{ $venta->nume_doc }}</td>
                                            <td>{{ $venta->fecha }}</td>
                                            <td>{{ $venta->estado ? 'Registrado' : 'Anulado' }}</td>
                                            <td>{{ $venta->total }}</td>
                                            <td>{{ $venta->acuenta }}</td>
                                            <td>{{ $venta->saldo }}</td>
                                            <td>{{ $venta->sucursal->nombre }}</td>
                                            <td>{{ $venta->estadoPagado ? 'Cancelado' : 'Pendiente' }}</td>
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
                                        <th colspan="6" style="text-align: right;">Totales</th>
                                        <th>{{number_format($ventas->sum('total'),2)}}</th>
                                        <th>{{number_format($ventas->sum('acuenta'),2)}}</th>
                                        <th>{{number_format($ventas->sum('saldo'),2)}}</th>
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#ventas').DataTable({
                searching: false,  // Desactivar la opción de búsqueda
                paging: false ,
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
                },      // Desactivar la paginación
            });
        });
        $(document).ready(function() {
            $('#responsable').select2({
                placeholder: 'Seleccione',
            });
            $('#cliente').select2({
                placeholder: 'Seleccione',
            });
            $('#documento').select2({
                placeholder: 'Seleccione',
            });
            $(document).on('select2:open', () => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            });
        });
    </script>

    <script>
        function showSpinnerAndDownload(movimientoId, url) {
            $('#spinner-' + movimientoId).removeClass('d-none');
            setTimeout(function() {
                window.location.href = url;
            }, 100);
        }
    </script>

@endpush
