<div>
    <!-- breadcrumb -->
    <div class="main-container container-fluid" style="height: calc(100vh - 160px);">

        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Generar Venta</span>
            </div>
        </div>
        <div class="row row-xs w-full btn-list flex justify-content-center mb-2">
            <button type="button" class="btn btn-primary-light mx-2 button-icon d-flex align-items-center gap-2" data-bs-target="#modalcliente" data-bs-toggle="modal"> Agregar Cliente <i class="fa fa-user-plus"></i></button>
            <button type="button" class="btn btn-primary-light mx-2 button-icon d-flex align-items-center gap-2"  data-bs-target="#modalproducto" data-bs-toggle="modal">Agregar Producto <i class="fa fa-cart-plus"></i></button>
            <button type="button" class="btn btn-primary-light mx-2 button-icon d-flex align-items-center gap-2">Deshacer Venta <i class="fa fa-undo"></i></button>
            <button type="button" class="btn btn-primary-light mx-2 button-icon d-flex align-items-center gap-2">Cobrar<i class="fas fa-dollar-sign"></i></button>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="movimientos" class="table table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 15%;">Cant.</th>
                                        <th class="text-center" style="width: 70%;">Descripcion</th>
                                        <th class="text-center" style="width: 10%;">Precio</th>
                                        <th class="text-center" style="width: 5%;">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detalleProductos as $index => $detalle)
                                        <tr>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-md" wire:model="detalleProductos.{{$index}}.cantidad" placeholder="Cantidad">
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-md" value="{{ $detalle['productonombre'] }}" placeholder="Producto" readonly>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-md" wire:model="detalleProductos.{{$index}}.precio" value="{{ $detalle['precio'] }}" placeholder="Precio">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger button-icon" wire:click="eliminarProducto({{ $index }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row flex justify-content-end">
                    <div class="col-md-1  flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2" wire:click="registrarVenta" >Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Large Modal -->
        <div class="modal fade" id="modalproducto" wire:ignore.self>
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Agregar Producto</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" >
                        <div class="mb-3 col-md-12">
                            <label for="producto_id" class="form-label">Producto</label>
                            <input type="text" id="producto_id" class="form-control" wire:model="search" autocomplete="off">
                            @if(count($productos))
                                @foreach($productos as $i => $producto)
                                    <label class="dropdown-item cursor-pointer" wire:click="agregar({{$producto->id}})" > {{$producto->nombre}} - {{ $producto->categoria->nombre}} - {{ $producto->categoria->abreviatura}} - {{ $producto->serie->nombre}}</label>
                                @endforeach
                                <div class="dropdown-divider"></div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <span class="text-success font-weight-semibold"> (F9) Buscar Producto </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Large Modal -->

        <!-- Large Modal -->
        <div class="modal fade" id="modalcliente" wire:ignore.self>
            <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Agregar Cliente</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body d-grid justify-items-center" >
                        <div class="row w-100 justify-content-center">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="tipo_documento">Tipo de Documento</label>
                                <select class="js-example-basic-single form-select" id="Tipo de documento" wire:model="tipo_documento" data-width="100%">
                                    <option value="" @selected(old('documento')=="")>SELECCIONE</option>
                                    <option value="DNI" @selected(old('documento')=="DNI")>DNI</option>
                                    <option value="RUC" @selected(old('documento')=="RUC")>RUC</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="documento" class="form-label">Documento</label>
                                <div class="d-flex gap-3">
                                <input type="text" id="documento" class="form-control" wire:model="documento" autocomplete="off">
                                <button type="button" class="btn btn-primary button-icon" wire:click="searchDocumento" ><i class="fe fe-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100 justify-content-center">
                            <div class="mb-3 col-md-12">
                                <label for="nombrerazon" class="form-label">Nombre o Razon Social</label>
                                <div class="d-flex gap-3">
                                    <input type="text" id="nombrerazon" class="form-control" wire:model="nombrerazon" autocomplete="off">
                                </div>
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $message }}
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                @if ($mensaje != "")

                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $mensaje }}
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="row w-100 justify-content-center">
                            <div class="mb-3 col-md-6">
                                <label for="telefono" class="form-label">Telefono</label>
                                <div class="d-flex gap-3">
                                    <input type="text" id="telefono" class="form-control" wire:model="telefono" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="direccion" class="form-label">Direccion</label>
                                <div class="d-flex gap-3">
                                    <input type="text" id="direccion" class="form-control" wire:model="direccion" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <span class="text-success font-weight-semibold"></span>
                        </div>
                        <button type="submit" id="submit-button" class="btn btn-primary me-2">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    <!--End Large Modal -->
    </div>
    <div>
        <span class="text-success font-weight-semibold"> (F7) Agregar Cliente </span>
        <span class="text-success font-weight-semibold"> (F9) Agregar Producto </span>
    </div>
</div>





@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('style')
    <style>
        .dropdown-item:hover, .dropdown-item:focus {
            color: #141c2b;
            text-decoration: none;
            background-color: var(--primary06);
        }
    </style>
@endpush

@push('custom-scripts')
<script>
$(document).ready(function() {
		$('.select2-show-search').select2({
            minimumResultsForSearch: '',
            placeholder: "Search",
            width: '100%'
        });
	});
</script>


<script type="text/javascript">
    document.addEventListener('keydown', function(event) {
        if (event.keyCode == 117) {
            event.preventDefault();
            var input = document.getElementById('producto_id');
            if (input) {
                input.focus();
            }
        }
    });
</script>
<script type="text/javascript">
    var isClientModalShown = false;
    var isProductModalShown = false;

    document.addEventListener('keydown', function(event) {
        var clientModalElement = document.getElementById('modalcliente');
        var clientModal = new bootstrap.Modal(clientModalElement);

        var productModalElement = document.getElementById('modalproducto');
        var productModal = new bootstrap.Modal(productModalElement);

        if (event.keyCode == 118) {  // F7
            event.preventDefault();
            if (isClientModalShown) {
                clientModal.hide();
            } else {
                clientModal.show();
            }
        }

        if (event.keyCode == 120) {  // F9
            event.preventDefault();
            if (isProductModalShown) {
                productModal.hide();
            } else {
                productModal.show();
            }
        }
    });

    $('#modalcliente').on('shown.bs.modal', function (e) {
        isClientModalShown = true;
    })
    $('#modalcliente').on('hidden.bs.modal', function (e) {
        isClientModalShown = false;
    })

    $('#modalproducto').on('shown.bs.modal', function (e) {
        isProductModalShown = true;
    })
    $('#modalproducto').on('hidden.bs.modal', function (e) {
        isProductModalShown = false;
    })
</script>




<script type="text/javascript">
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey) {
            let numberKey = event.keyCode - 48;
            if (numberKey >= 1 && numberKey <= 9) {
                event.preventDefault();
                console.log('Emitiendo evento agregarPorNumero con índice:', numberKey - 1);
                window.livewire.emit('agregarPorNumero', numberKey - 1);
            }
        }
    });
</script>

<script type="text/javascript">
    window.livewire.on('cerrarModalProducto', function () {
        $('#modalproducto').modal('hide');
    });
</script>


@endpush
