@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Reporte de Biselados</span>
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
                            <form action="{{ route('reportes.biselados') }}" method="GET">
                                <div class="row pb-4">
                                    <div class="col-md-4">
                                        <label for="searchFechaInicio" class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" id="searchFechaInicio"
                                            name="searchFechaInicio" value="{{ $fechaInicio2 }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="searchFechaFin" class="form-label">Fecha Fin</label>
                                        <input type="date" class="form-control" id="searchFechaFin" name="searchFechaFin"
                                            value="{{ $fechaFin2 }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="searchCliente" class="form-label">Maquina</label>
                                        <div class="form-group">
                                            <select name="searchMaquina" class="form-control form-select" id="maquina"
                                                data-bs-placeholder="Select Maquina">
                                                <option value="">SELECCIONE</option>
                                                @foreach ($maquinas as $maquina)
                                                    <option value="{{ $maquina->id }}"
                                                        {{ $maquina2 == $maquina->id ? 'selected' : '' }}>
                                                        {{ $maquina->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="searchCliente" class="form-label">Trabajador</label>
                                        <div class="form-group">
                                            <select name="searchTrabajador" class="form-control form-select" id="trabajador"
                                                data-bs-placeholder="Select Trabajador">
                                                <option value="">SELECCIONE</option>
                                                @foreach($usuarios as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $trabajador2 == $user->id ? 'selected' : '' }}>
                                                        {{ $user->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button id="tuBotonEnviar" class="btn btn-primary mt-4 mr-2">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-search"></i><b>
                                                &nbsp; Buscar</b>
                                        </button>
                                        <a href="{{ route('reportes.biselados-excel', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2,  'searchMaquina' => $maquina2,  'searchTrabajador' => $trabajador2]) }}" target="_blank" class="btn btn-success mt-4 mr-2">
                                            <i data-bs-toggle="tooltip" data-bs-title="Excel" class="fas fa-file"></i><b>
                                                &nbsp; Excel</b>
                                        </a>
                                        <a href="{{ route('reportes.biselados-pdf', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2,  'searchMaquina' => $maquina2,  'searchTrabajador' => $trabajador2]) }}" target="_blank" class="btn btn-danger mt-4 ">
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
                                        <th>Trabajo Nº</th>
                                        <th>Fecha</th>
                                        <th>Maquina</th>
                                        <th>Trabajador</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Cantidad</th>
                                        <th>Producto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trabajos as $trabajo)
                                    <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>TRABAJO Nº {{ $trabajo->numero}}</td>
                                            <td>{{ $trabajo->fecha }}</td>
                                            <td>{{ $trabajo->nombremaquina}}</td>
                                            <td>{{ $trabajo->nombreuser }}</td>
                                            <td>{{ $trabajo->nombrecliente}}</td>
                                            <td>{{ $trabajo->nombrevendedor }}</td>
                                            <td>{{ $trabajo->cantidad}}</td>
                                            <td>{{ $trabajo->producto }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">Total:</td>
                                        <td>{{$trabajos->sum('cantidad')}}</td>
                                        <td></td>
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
            $('#trabajador').select2({
                placeholder: 'Seleccione',
            });
            $('#maquina').select2({
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
