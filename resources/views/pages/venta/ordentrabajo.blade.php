@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de orden de trabajos</span>
            </div>
            <div class="justify-content-center mt-2">
                {{-- <button id="BotonFiltro" class="btn btn-primary">
                    <i class="fas fa-filter"></i><b> &nbsp; Filtros</b>
                </button> --}}
                <a href=" {{ route('venta.create') }}">
                    <button type="button" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal"
                        data-bs-target="#varyingModal">
                        <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear
                            Venta</b>
                    </button>
                </a>
                <!-- <button id="tuBotonEnviar" class="btn btn-primary">
                    <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-minus"></i><b> &nbsp; Crear Venta</b>
                </button> -->
            </div>
        </div>
        <!-- /breadcrumb -->
        <!-- row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="filtroVentas">
                            <form action="{{ route('venta.ordentrabajo') }}" method="GET">
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
                                        <button id="tuBotonEnviar" class="btn btn-primary mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-search"></i><b>
                                                &nbsp; Buscar</b>
                                        </button>
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
                        <form action="{{ route('venta.ordentrabajoguardar') }}" method="POST" id="enviarFormulario">
                            {{ csrf_field() }}
                            <input type="hidden" name="cliente_id" value="{{$searchCliente2}}">
                            <div class="table-responsive">
                                <table id="movimientos" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="marcarTodos"></th>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Maquina</th>
                                            <th>Sucursal</th>
                                            <th>Vendedor</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trabajos as $trabajo)
                                        <tr class="fila-venta" data-id="{{ $trabajo->id }}">
                                                <td><input type="checkbox" name="ids[]" value="{{$trabajo->id }}"></td>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $trabajo->fecha }}</td>
                                                <td>{{ $trabajo->cliente?->razon_social }} {{ $trabajo->cliente?->nombre_comercial }}</td>
                                                <td>{{ $trabajo->total }}</td>
                                                <td>{{ $trabajo->maquina->nombre }} {{ $trabajo->user->nombre }}</td>
                                                <td>{{ $trabajo->sucursal->nombre }}</td>
                                                <td>{{ $trabajo->vendedor->nombre }}</td>
                                                <td>{{ $trabajo->estado ? 'Registrado' : 'Anulado' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">TOTAL: </td>
                                            <td >{{ number_format($trabajos->sum('total'),2) }}</td>
                                            <td colspan="4"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if($searchCliente2 != null && count($trabajos) > 0 )
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="tipo_documento">Comprobante</label>
                                        <select class="js-example-basic-single form-select" id="tipo_documento" name="tipo_documento" data-width="100%" >
                                            <option value="">SELECCIONE</option>
                                            @foreach($documentos as $documento)
                                                <option value="{{$documento->id}}">{{$documento->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @error('tipo_documento')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label" for="tipo">Tipo</label>
                                        <select class="js-example-basic-single form-select" id="tipo" name="tipo" data-width="100%" >
                                            <option value="1">CONTADO</option>
                                            <option value="0">CREDITO</option>
                                        </select>
                                        @error('tipo')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-2 col-md-2">
                                        <button type="button" data-bs-toggle="tooltip" onclick="enviar()" class="btn btn-primary mt-4">Guardar</button>
                                    </div>
                                    
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Container -->
    <div class="modal fade" id="EliminarMovimiento" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anular Orden de Trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('venta.destroyorden', 'test') }}" method="POST" autocomplete="off">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <p>¿Estás seguro de cambiar el estado?</p>
                        <div class="modal-footer">
                            <input type="hidden" name="id_trabajo_2" class="id_trabajo_2">
                            <button type="button" data-bs-toggle="tooltip" data-bs-title="Cancelar"
                                class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" data-bs-toggle="tooltip" data-bs-title="Aceptar"
                                class="btn btn-primary">Aceptar</button>
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
                                                <th>MAQUINA: <span id="maquina"></span></th>
                                                <th>TRABAJADOR: <span id="trabajador"></span></th>
                                            </tr>
                                            <tr>
                                                <th>DIP: <span id="dip"></span></th>
                                                <th>ADD: <span id="add"></span></th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-bordered table-hover table-primary mg-b-0 text-md-nowrap table-side">
                                        <thead>
                                            <tr>
                                                <th>Cant</th>
                                                <th>Producto</th>
                                                <th>Eje</th>
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
                    <div class="panel-body ">
                        <div class="tabs-menu ">
                            <ul class="nav panel-tabs flex-nowrap">
                                <li class=""><a class="btn btn-primary mx-2 button-icon" id="btnEditar"><i class="pe-2 fa fa-edit"></i>Editar</a></li>
                                <li class="" id="imprimirText"></li>
                                <li class=""><a class="btn btn-primary mx-2 button-icon" href="#" data-bs-toggle="modal" data-bs-target="#EliminarMovimiento" id="btnAnular"><i class="pe-2 fa fa-times"></i>Anular</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>


@endpush
@push('custom-scripts')
    <script>
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
        var EliminarMovimiento = document.getElementById('EliminarMovimiento');
        EliminarMovimiento.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')
            var idModal = EliminarMovimiento.querySelector('.id_trabajo_2')
            idModal.value = id;
        })

        // $(document).ready(function() {
        //     $('#BotonFiltro').click(function() {
        //         $('#filtroVentas').toggle('fast');
        //     });
        // });
    </script>

    <script>
        $(document).ready(function() {
            $('.fila-venta').on('click', function(event) {
                // Verificar si el clic fue en el checkbox
                if ($(event.target).is('input[type="checkbox"]')) {
                    // Evitar la propagación del evento para que no se ejecute la lógica de mostrar datos de la venta
                    event.stopPropagation();
                    // Puedes agregar aquí la lógica para marcar o desmarcar el checkbox según tus necesidades
                    var checkbox = $(event.target);
                    checkbox.attr('checked', !checkbox.attr('checked'));
                } else {
                    // Si no se hizo clic en el checkbox, procede con la lógica original
                    var ventaId = $(this).data('id');
                    cargarDatosVenta(ventaId);
                    // Abrir el offcanvas
                    var offcanvas = new bootstrap.Offcanvas($('#offcanvasRight'));
                    offcanvas.show();
                }
            });
        });
        function cargarDatosVenta(ventaId) {
            $.ajax({
                url: '/ventas/consultatrabajo/' + ventaId,
                type: 'GET',
                success: function(data) {
                    var dateTime = data.fecha;
                    var parts = dateTime.split(' ');
                    var fecha = parts[0];
                    var hora = parts[1];
                    $('#nombreAsesor').text(data.vendedor.nombre +' '+ data.vendedor.apellido);
                    $('#trabajador').text(data.user.nombre );
                    $('#maquina').text(data.maquina.nombre );
                    $('#dip').text(data.detalles_trabajos[0].dip );
                    $('#add').text(data.detalles_trabajos[0].add );
                    $('#fechaVenta').text(fecha);
                    $('#horaVenta').text(hora);
                    $('#almacenVenta').text(data.almacen.nombre);
                    $('#sucursalVenta').text(data.sucursal.nombre);
                    $('#clienteNombreVenta').text(data.cliente.razon_social);
                    $('#detallesVentaContainer').empty();
                    var detalles = data.detalles_trabajos;
                    var detallesHtml = '';
                    detalles.forEach(function(detalle) {
                        detallesHtml += '<tr>' +
                                            '<td scope="row">' + detalle.cantidad + '</td>' +
                                            '<td class="descripcion-table-side" style="font-size:0.75rem">'  + detalle.producto.categoria.abreviatura+' '+ detalle.producto.nombre + '</td>' +
                                            '<td>' + detalle.eje + '</td>' +
                                            '<td>' + detalle.precio + '</td>' +
                                        '</tr>';
                    });
                    $('#detallesVentaContainer').html(detallesHtml);
                    var botonHtml = '<a href="{{ url('ventas/ticketpedido') }}/' + data.id + '" target="_blank" class="btn btn-primary mx-2 button-icon" ><i class="pe-2 fa fa-print"></i>Imprimir</a>';
                    $('#imprimirText').html(botonHtml);
                    $('#btnAnular').attr('data-id',data.id);
                    $('#btnEditar').attr("href", `{{ url('ventas/editar-trabajo/') }}/${data.id}`);
                },
                error: function(error) {
                    console.log(error);
                    // Manejar los errores
                }
            });
        }
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
