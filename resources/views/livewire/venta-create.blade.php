<div>
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">{{$this->idTrabajoEdit!=null || $this->idVentaEdit!=null ? 'Editar':'Generar'}} Venta</span>
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
                        <h5 class="mb-1">Datos de Venta</h5>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="tipo_documento">Comprobante</label>
                                <select class="js-example-basic-single form-select" id="tipo_documento" wire:model="tipo_documento" data-width="100%" tabindex="1">
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
                                <label class="form-label" for="clienteId">Nº Documento</label>
                                <input type="text" name="nuevodocumento" id="nuevodocumento" class="form-control" wire:model.defer="nuevodocumento">
                                @error('nuevodocumento')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4 col-md-1">
                                <button type="button" class="btn btn-primary mb-2 mb-md-0 " wire:click="searchDocumento">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="clienteId">Nombre</label>
                                <input type="text" name="nuevonombrerazon" id="nuevonombrerazon" class="form-control" wire:model.defer="nuevonombrerazon">
                                @error('nuevonombrerazon')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-2">
                                <label class="form-label" for="cantidad_final">CANT.</label>
                                <input type="number" name="cantidad_final" class="form-control" wire:model.defer="cantidad_final" tabindex="3">
                                @error('cantidad_final')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-8">
                                <label class="form-label">Productos: (F8 Buscar Producto)</label    >
                                <div wire:ignore>
                                    <select id="producto-select" class="form-control" wire:model="productoId" tabindex="4">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" style="color: red;">
                                
                                <div class="flex" style="flex:row">
                                    <div>
                                    <label class="form-label" style="color: red;">Total</label>
                                    <h3 >{{number_format($total,2)}}</h3>
                                    </div>
                                    <div>
                                    @if($total > 0)

                                    <button class="btn btn-danger me-2" type="button" wire:click="registrarVenta(0)" wire:loading.attr="disabled" id="guardarCobrar">Guardar (F9)</button>
                                    @endif
                                    </div>
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
                                            <th class="text-center" style="width: 45%;">Descripcion</th>
                                            <th class="text-center" style="width: 15%;">Cant.</th>
                                            <th class="text-center" style="width: 20%;">Precio</th>
                                            <th class="text-center" style="width: 15%;">Sub-Total</th>
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
                                                    <input type="number" class="form-control" name="cantidadProducto{{$index}}" id="cantidadProducto{{$index}}" wire:model.lazy="cantidadProducto.{{$index}}">
                                                </td>
                                                <td class="text-center" >
                                                    <input type="number" class="form-control" name="precioProducto{{$index}}" id="precioProducto{{$index}}" wire:model.lazy="precioProducto.{{$index}}">
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($detalle['subtotal'],2) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="row">
                                                        {{-- <button type="button" class="btn btn-primary button-icon" wire:click="editarProducto({{ $index }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button> --}}
                                                        <button type="button" class="btn btn-danger button-icon" wire:click="eliminarProducto({{ $index }})" 
                                                        wire:loading.attr="disabled"
                                                        wire:target="eliminarProducto">
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
                            <div class="mb-3 col-md-2">
                                <label class="form-label" for="medioId">Medio de Pago</label>
                                <select class="js-example-basic-single form-select" id="medioId" wire:model.defer="medioId" data-width="100%">
                                    @foreach($medios as $medio)
                                        <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('medioId')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($tipo == 0)
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="cuotas">Cuotas</label>
                                    <input type="number" class="form-control" step="1" name="cuotas" id="cuotas" wire:model="cuotas"/>
                                    @error('cuotas')
                                        <span class="error-message" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                <div class="mb-3 col-md-3">
                                </div>
                            @endif
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Cantidad productos</label>
                                <h3 >{{$cantidadproductos}}</h3>
                            </div>
                            <div class="mb-3 col-md-4" style="text-align-last: right">
                                <label class="form-label">Total</label>
                                <h3 >{{number_format($total,2)}}</h3>
                            </div>
                        </div>
                        @if($cuotas > 0 && $tipo == 0)
                            <h5 class="mb-1">Cuotas</h5>
                            <div class="row">
                                @for($i=0;$i<$cuotas;$i++)
                                    <div class="mb-3 col-md-1">
                                        <label class="form-label" for="cuotas">Cuota</label>
                                        <input type="text" class="form-control" disabled name="cuotas" value="{{$i+1}}"/>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label" for="fechacuota">Fecha</label>
                                        <input type="date" class="form-control" name="fechacuota" wire:model.defer="fechacuota.{{$i}}"/>
                                    </div>
                                @endfor
                            </div>
                        @endif
                        @if($total > 0)
                            <div class="d-flex justify-content-end mt-3">
                            {{-- 
                                <button class="btn btn-danger me-2" type="button" wire:click="registrarVenta(0)" wire:loading.attr="disabled" id="guardarCobrar">Guardar (F9)</button>
                                @if($tipo_documento != '')
                                    <button type="button" wire:click="registrarVenta(1)" wire:loading.attr="disabled" class="btn btn-success me-2" id="efectuarDirecto">Efectuar Directo (F10)</button>
                                    <button class="btn btn-primary me-2" type="button"  wire:click="modalCobrar()" wire:loading.attr="disabled" id="cobrarVenta">Cobrar Venta (F11)</button>
                                @endif --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <label class="form-label" for="nuevo_tipo_documento">Tipo de Documento</label>
                            <select class="js-example-basic-single form-select" id="Tipodedocumento" wire:model.defer="nuevotipo_documento" data-width="100%">
                                <option value="" @selected(old('documento')=="")>SELECCIONE</option>
                                <option value="DNI" @selected(old('documento')=="DNI")>DNI</option>
                                <option value="RUC" @selected(old('documento')=="RUC")>RUC</option>
                            </select>
                            @error('nuevotipo_documento')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nuevo_documento" class="form-label">Documento</label>
                            <div class="d-flex gap-3">
                                <input type="text" id="nuevo_documento" class="form-control" wire:model.defer="nuevodocumento" autocomplete="off">
                                @error('almacen_2')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                                <button type="button" class="btn btn-primary button-icon" wire:click="searchDocumento" ><i class="fe fe-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100 justify-content-center">
                        <div class="mb-3 col-md-12">
                            <label for="nuevo_nombrerazon" class="form-label">Nombre o Razon Social</label>
                            <div class="d-flex gap-3">
                                <input type="text" id="nuevo_nombrerazon" class="form-control" wire:model="nuevonombrerazon" autocomplete="off">
                                @error('almacen_2')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
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
                            <label for="nuevodireccion" class="form-label">Direccion</label>
                            <div class="d-flex gap-3">
                                <input type="text" id="nuevo_direccion" class="form-control" wire:model.defer="nuevodireccion" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nuevotelefono" class="form-label">Telefono</label>
                            <div class="d-flex gap-3">
                                <input type="text" id="nuevo_telefono" class="form-control" wire:model.defer="nuevotelefono" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nuevocorreo" class="form-label">Correo</label>
                            <div class="d-flex gap-3">
                                <input type="text" id="nuevocorreo" class="form-control" wire:model.defer="nuevocorreo" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button aria-label="Close" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button type="button" wire:click="agregarCliente" class="btn btn-primary me-2" wire:loading.attr="disabled">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Large Modal -->
    <div class="modal fade" id="modalCobrar" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Realizar Pago</h6><button aria-label="Close" class="btn-close" wire:click="modalCobrarCerrar" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" >
                    <div class="mb-3 ">
                        <label class="form-label" for="medioId">Medio de Pago</label>
                        <select class="js-example-basic-single form-select" id="medioId" wire:model.defer="medioId" data-width="100%">
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
                        <input type="number" step="0.01" min='0' id="totalpago" class="form-control" wire:model.defer="totalpago" autocomplete="off">
                        @error('totalpago')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">

                    <button aria-label="Close" class="btn btn-danger me-2" wire:click="modalCobrarCerrar" type="button">Cancelar</button>
                    <button type="button" wire:click="cobrar()" class="btn btn-primary me-2" wire:loading.attr="disabled">Guardar</button>
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
                    <div class="mb-3 ">
                        <label for="eje" class="form-label">Eje</label>
                        <input type="text" id="eje" class="form-control" wire:model.defer="eje" autocomplete="off" tabindex="103">
                        @error('eje')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button aria-label="Close" wire:click="cancelarProducto()" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button type="button" wire:click="agregar()" class="btn btn-primary me-2" tabindex="104" id="botonGuardar">Guardar</button>
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
document.addEventListener("DOMContentLoaded", function() {
    const submitButton = document.getElementById('submitButton');
    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener('submit', function() {
        submitButton.disabled = true; // Deshabilitar el botón de enviar una vez que se envía el formulario
    });
});
document.addEventListener('livewire:load',function(){
    $('#clienteId').select2();
    $('#clienteId').on('change',function(){
        @this.set('clienteId',this.value);
    });
    $('#usermaquina').select2();
    $('#usermaquina').on('change',function(){
        @this.set('usermaquina',this.value);
    });
})
$(document).on('select2:open', () => {
    document.querySelector('.select2-container--open .select2-search__field').focus();
});

Livewire.on('close-modal', function (id) {
    $('#modalcliente').modal('hide');
    $('#clienteId').val(id).select2();
    $('#clienteId').on('change', function (e) {
        @this.set('clienteId', this.value);
    });
    $('#usermaquina').select2();
    $('#usermaquina').on('change',function(){
        @this.set('usermaquina',this.value);
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

Livewire.on('modalCobrar', function () {
    $('#modalCobrar').modal('show');
});

Livewire.on('modalCobrarCerrar', function () {
    $('#modalCobrar').modal('hide');
});

Livewire.on('cerrarModalproducto', function () {
    
    $('#producto-select').val(null).select2('open');
});

Livewire.on('modalproducto', function () {
    $('#modalProducto').modal('show').on('shown.bs.modal', function () {
        $('#cantidad').focus();
    });
});
let eventoManejado = false; // Variable para verificar si el evento ya se ha manejado

Livewire.on('abrirTrabajo', function (id) {
    // Verificar si el evento ya se ha manejado
    if (!eventoManejado) {
        var urlTicketPedido = `{{ url('ventas/ticketpedido') }}/${id}`;
        window.open(urlTicketPedido, "_blank");
        eventoManejado = true; // Marcar el evento como manejado
    }
});

Livewire.on('abrirAmbos', function (idtrabajo, idventa) {
    var urlTicketPdf = `{{ url('ventas/ticketpdf') }}/${idventa}`;
    var urlTicketPedido = `{{ url('ventas/ticketpedido') }}/${idtrabajo}`;

    // Crear enlaces ocultos
    var enlacePdf = document.createElement('a');
    enlacePdf.href = urlTicketPdf;
    enlacePdf.target = '_blank';

    var enlacePedido = document.createElement('a');
    enlacePedido.href = urlTicketPedido;
    enlacePedido.target = '_blank';

    // Simular clic en los enlaces
    if (!eventoManejado) {
        enlacePdf.click();
        enlacePedido.click();
        eventoManejado = true; // Marcar el evento como manejado
    }
    
});

Livewire.on('abrirVenta', function (id) {

    if (!eventoManejado) {
        var urlTicketPdf = `{{ url('ventas/ticketpdf') }}/${id}`;
        window.open(urlTicketPdf, "_blank");
        eventoManejado = true; // Marcar el evento como manejado
    }
});

Livewire.on('abrirmodalcliente', function () {
    $('#modalcliente').modal('show').on('shown.bs.modal', function () {
        $('#Tipodedocumento').focus();
    });
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

        if (nextIndex == 105) {
            document.getElementById('botonGuardar').click();
        } 
        if (nextIndex == 3) {
            $('#producto-select').select2('open');
        } 
        if (nextIndex == 6) {
            $('#usermaquina').select2('open');
        }else {
            let nextElement = document.querySelector('[tabindex="' + nextIndex + '"]');
            if(nextElement) {
                nextElement.focus();
            }
        }
    }
    if (event.key === 'F6') {
        event.preventDefault();
        if ($('#modalcliente').is(':visible')) {
            $('#modalcliente').modal('hide');
        } else {
            $('#modalcliente').modal('show').on('shown.bs.modal', function () {
                $('#Tipodedocumento').focus();
            });
            $('#clienteId').select2('close');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
        }
    }
    if (event.key === 'F8') {
        event.preventDefault();
        if ($('#producto-select').data('select2').isOpen()) {
            $('#producto-select').select2('close');
        } else {
            $('#producto-select').select2('open');
            $('#modalcliente').modal('hide');
            $('#clienteId').select2('close');
            $('#modalProducto').modal('hide');
        }
        
    }
    if (event.key === 'F7') {
        event.preventDefault();
        if ($('#clienteId').data('select2').isOpen()) {
            $('#clienteId').select2('close');
        } else {
            $('#clienteId').select2('open');
            $('#modalcliente').modal('hide');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
        }
    }
    if (event.key === 'F9') {
        event.preventDefault();
        var miBoton = document.getElementById('guardarCobrar');
        if (miBoton) {
            $('#modalcliente').modal('hide');
            $('#clienteId').select2('close');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
            miBoton.click();
        }
    }
    if (event.key === 'F10') {
        event.preventDefault();
        var miBoton = document.getElementById('efectuarDirecto');
        if (miBoton) {
            $('#modalcliente').modal('hide');
            $('#clienteId').select2('close');
            $('#producto-select').select2('close');
            $('#modalProducto').modal('hide');
            miBoton.click();
        }
    }
    if (event.key === 'F11') {
        event.preventDefault();
        var miBoton = document.getElementById('cobrarVenta');
        if (miBoton) {
            $('#modalcliente').modal('hide');
            $('#clienteId').select2('close');
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
