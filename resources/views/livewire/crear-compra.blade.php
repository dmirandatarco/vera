<div>
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">{{$idTicket==null ? 'Generar':'Editar'}} Compra</span>
            </div>
        </div>
        @if ($message = Session::get('danger'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="ps-4 pe-4 pb-2 pt-4">
                        <h5 class="mb-1">Datos de Compra</h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="proveedorId">Proveedor (F7 Buscar Proveedor)</label>
                                <div wire:ignore>
                                    <select class="js-example-basic-single form-select" id="proveedorId" wire:model.defer="proveedorId" data-width="100%" tabindex="2">
                                        <option value="">SELECCIONE</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{$proveedor->id}}">{{$proveedor?->nombre}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('proveedorId')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <h5 class="mb-1">Productos: (F8 Buscar Producto)</h5>
                                <div wire:ignore>
                                    <select id="producto-select" class="form-control" wire:model="productoId" tabindex="3">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 text-center mt-3">
                        <div class="container-fluid pt-0 ht-100p">
                            <div class="table-responsive">
                                <table id="movimientos" class="table table-hover" style="width: 100%;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center" style="width: 50%;">Descripcion</th>
                                            <th class="text-center" style="width: 15%;">Cant.</th>
                                            <th class="text-center" style="width: 10%;">Precio</th>
                                            <th class="text-center" style="width: 20%;">Sub-Total</th>
                                            <th class="text-center" style="width: 5%;">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detalleProductos as $index => $detalle)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $detalle['productonombre'] }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $detalle['cantidad'] }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($detalle['precio'],2) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($detalle['subtotal'],2) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="row">
                                                        <button type="button" class="btn btn-primary button-icon" wire:click="editarProducto({{ $index }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger button-icon" wire:click="eliminarProducto({{ $index }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="ps-4 pe-4 pb-2 pt-4">
                        <div class="row ">                            
                            <div class="mb-3 col-md-6" style="text-align-last: right">
                                <label class="form-label">Cantidad Productos</label>
                                <h3 >{{number_format($totalproductos,2)}}</h3>
                            </div>
                            <div class="mb-3 col-md-6" style="text-align-last: right">
                                <label class="form-label">Total</label>
                                <h3 >{{number_format($total,2)}}</h3>
                            </div>
                        </div>
                        @if($total > 0)
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-danger me-2" type="button" wire:click="registrarVenta(0)" wire:loading.attr="disabled" id="guardarCobrar">Guardar (F9)</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Large Modal -->
    <div class="modal fade" id="modalProducto" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Producto</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 ">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="text" id="cantidad" class="form-control" wire:model.defer="cantidad" autocomplete="off" tabindex="101">
                        @error('cantidad')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 ">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="text" id="precio" class="form-control" wire:model.defer="precio" autocomplete="off" tabindex="102">
                        @error('precio')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button aria-label="Close" wire:click="cancelarProducto()" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button type="button" wire:click="agregar()" class="btn btn-primary me-2" tabindex="103" id="botonGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('plugin-scripts')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/i18n/es.js') }}"></script>

@endpush
@push('custom-scripts')
<script>
document.addEventListener('livewire:load',function(){
    $('#proveedorId').select2();
    $('#proveedorId').on('change',function(){
        @this.set('proveedorId',this.value);
    });
})
$(document).on('select2:open', () => {
    document.querySelector('.select2-container--open .select2-search__field').focus();
});

Livewire.on('close-modal', function (id) {
    $('#proveedorId').val(id).select2();
    $('#proveedorId').on('change', function (e) {
        @this.set('proveedorId', this.value);
    });
    $('#producto-select').select2({
        language: "es", // Configuración de idioma
        ajax: {
            url: '{{route("producto.buscar")}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // parámetro de búsqueda que se envía al servidor
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            cache: true
        },
        minimumInputLength: 1, // Número mínimo de caracteres para iniciar la búsqueda
        openOnEnter: false, // Evitar que se abra al presionar Enter
    });
    $('#producto-select').on('select2:open', function() {
        // Ajustar el tamaño del desplegable
        $('.select2-results__options').css('max-height', '400px'); // Ajusta este valor según tus necesidades
    })
    $('#producto-select').on('change', function (e) {
        @this.set('productoId', this.value);
    });
    $('.select2-results__option').on('mouseenter', function(e) {
        e.stopPropagation();
    });
});

Livewire.on('cerrarModalproducto', function () {
    $('#producto-select').select2({
        language: "es", // Configuración de idioma
        ajax: {
            url: '{{route("producto.buscar")}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // parámetro de búsqueda que se envía al servidor
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            cache: true
        },
        minimumInputLength: 1, // Número mínimo de caracteres para iniciar la búsqueda
        openOnEnter: false, // Evitar que se abra al presionar Enter
    });
    $('#producto-select').on('select2:open', function() {
        // Ajustar el tamaño del desplegable
        $('.select2-results__options').css('max-height', '400px'); // Ajusta este valor según tus necesidades
    })
    $('#producto-select').on('change', function (e) {
        @this.set('productoId', this.value);
    });
    $('.select2-results__option').on('mouseenter', function(e) {
        e.stopPropagation();
    });
    $('#producto-select').val(null).select2('open');
    $('#proveedorId').select2('close');
    $('#modalProducto').modal('hide');
});

Livewire.on('modalproducto', function () {
    $('#modalProducto').modal('show').on('shown.bs.modal', function () {
        $('#cantidad').focus();
    });
});
let eventoManejado = false; // Variable para verificar si el evento ya se ha manejado

Livewire.on('abrirTicket', function (id) {
    // Verificar si el evento ya se ha manejado
    if (!eventoManejado) {
        var urlTicketPedido = `{{ url('compras/ticketpdf') }}/${id}`;
        window.open(urlTicketPedido, "_blank");
        eventoManejado = true; // Marcar el evento como manejado
    }
});


$(document).ready(function() {
    $('#producto-select').select2({
        language: "es", // Configuración de idioma
        ajax: {
            url: '{{route("producto.buscar")}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // parámetro de búsqueda que se envía al servidor
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            cache: true
        },
        minimumInputLength: 1, // Número mínimo de caracteres para iniciar la búsqueda
        openOnEnter: false, // Evitar que se abra al presionar Enter
    });
    $('#producto-select').on('select2:open', function() {
        // Ajustar el tamaño del desplegable
        $('.select2-results__options').css('max-height', '400px'); // Ajusta este valor según tus necesidades
    })
    $('#producto-select').on('change', function (e) {
        @this.set('productoId', this.value);
    });
    $('.select2-results__option').on('mouseenter', function(e) {
        e.stopPropagation();
    });
});
</script>
<script>

document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Evita que se envíe el formulario
        
        let currentIndex = parseInt(document.activeElement.getAttribute('tabindex'), 10);
        let nextIndex = currentIndex;
        if (currentIndex != 0) {
            nextIndex = nextIndex + 1;
        } 

        if (nextIndex == 104) {
            document.getElementById('botonGuardar').click();
        } 
        if (nextIndex == 3) {
            $('#producto-select').select2('open');
        } 
        else {
            let nextElement = document.querySelector('[tabindex="' + nextIndex + '"]');
            if(nextElement) {
                nextElement.focus();
            }
        }
    }
    if (event.key === 'F8') {
        event.preventDefault();
        if ($('#producto-select').data('select2').isOpen()) {
            $('#producto-select').select2('close');
        } else {
            $('#producto-select').select2('open');
            $('#proveedorId').select2('close');
            $('#modalProducto').modal('hide');
        }
        
    }
    if (event.key === 'F7') {
        event.preventDefault();
        if ($('#proveedorId').data('select2').isOpen()) {
            $('#proveedorId').select2('close');
        } else {
            $('#proveedorId').select2('open');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
        }
    }
    if (event.key === 'F9') {
        event.preventDefault();
        var miBoton = document.getElementById('guardarCobrar');
        if (miBoton) {
            $('#proveedorId').select2('close');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
            miBoton.click();
        }
    }
});
</script>
@endpush
@push('style')
<style>
.dropdown-item:hover, .dropdown-item:focus {
    color: #141c2b;
    text-decoration: none;
    background-color: var(--primary02) !important;
}
.select2-results__message {
    display: none; /* Oculta el mensaje */
}
</style>
@endpush
