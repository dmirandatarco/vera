<div class="row">
    <div class="col-lg-12 col-xl-9 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Tipo de Movimiento:</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-control form-select select2"
                                wire:model="tipo_movimiento">
                                <option value="">SELECCIONE</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('tipo_movimiento')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Almacen:</label>
                            <select name="almacen_id" id="almacen_id" class="form-control form-select select2"
                                wire:model="almacen_id">
                                <option value="">SELECCIONE</option>
                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('almacen_id')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($condAlmacen == 1)
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Almacen Destino:</label>
                            <select name="almacen_2" id="almacen_2" class="form-control form-select select2"
                                wire:model="almacen_2">
                                <option value="">SELECCION</option>
                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('almacen_2')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @else
                    <div class="col-lg-4 col-xl-4 col-md-4">
                    </div>
                    @endif
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Fecha de Movimiento:</label>
                            <input class="form-control" type="date" wire:model.defer="fecha">
                        </div>
                        @error('fecha')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($documentoo == 1)
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Tipo Doc:</label>
                            <select name="country" id="tipo_doc" class="form-control form-select select2"
                                wire:model.defer="tipo_doc">
                                <option value="NINGUNO">NINGUNO</option>
                                <option value="BOLETA">BOLETA</option>
                                <option value="FACTURA">FACTURA</option>
                            </select>
                        </div>
                        @error('tipo_doc')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <label class="form-label">N° Doc:</label>
                        <div class="form-group" wire:ignore>
                            <input type="text" class="form-control" placeholder="numero documento"
                                wire:model.defer="nro_doc">
                        </div>
                        @error('nro_doc')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @else
                    <div class="col-md-8">
                    </div>
                    @endif
                    <div class="card-header">
                        <h4 class="card-title fw-semibold">Detalle de Movimiento</h4>
                    </div>
                    <!-- Shopping Cart-->
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-start">Producto</th>
                                    <th class="">Cantidad</th>
                                    <th>Precio U.</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control" style="border-radius: 5px;" type="text" placeholder="Buscar Producto..." name="buscarProducto" wire:model="buscarProducto" autocomplete="off">
                                        @if(count($productos))
                                        <div class="resultproducts position-absolute bg-white w-100 mt-2">

                                            @foreach($productos as $producto)
                                            <a href="#">
                                                <div class="container cursor-pointer" wire:click="asignarProducto('{{$producto->nombre}}')">
                                                    <div class="row">
                                                        <div class="col-8 col-md-10 align-self-center">
                                                            <p class="text-left m-0 p-2">{{$producto->nombre}} {{$producto->categoria->nombre}} {{$producto->categoria->abreviatura}} {{$producto->serie->nombre}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>
                                            </a>
                                            @endforeach

                                        @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="handle-counter ms-2" id="handleCounter4">
                                            <button
                                                class="counter-minus btn btn-white lh-2 shadow-none"wire:click="ReducirCantidad"><i
                                                    class="fe fe-minus"></i></button>
                                            <input type="text" value="2" class="qty"
                                                wire:model.defer="cantidaddetalle">
                                            <button
                                                class="counter-plus btn btn-white lh-2 shadow-none"wire:click="AumentarCantidad"><i
                                                    class="fe fe-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="text-center text-lg text-medium font-weight-bold  tx-15">
                                        <input type="text" class="form-control" id="preciodetalle"
                                            wire:model.defer="preciodetalle">
                                    </td>
                                    <td class="" style="text-align: -webkit-center;">
                                        <button type="button" class="btn btn-success btn-icon"
                                            wire:click="AumentarMovimiento" tabindex="90">+</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-3 col-md-12">
        <div class="card custom-card cart-details">
            <div class="card-body">
                <h5 class="mb-3 font-weight-bold tx-14">DETALLE DE MOVIMIENTOS</h5>
                <!-- Iterar sobre los detalles del movimiento -->
                @foreach ($detalleMovimiento as $detalle)
                    <dl class="dlist-align">
                        <dt class="mx-2">{{ $detalle['cantidad'] }}</dt>
                        <dt class="">{{ $detalle['categoria'] }} - {{ $detalle['producto'] }}</dt>
                        <dd class="text-end ms-auto">{{ $detalle['precio'] }}</dd>
                    </dl>
                @endforeach
                <dl class="dlist-align">
                    <dt>Total:</dt>
                    <dd class="text-end  ms-auto tx-20"><strong>{{ $total }}</strong></dd>
                </dl>
            </div>
            <div class="card-footer">
                <div class="column d-flex justify-content-end">
                    <a class="btn btn-primary text-white" wire:click.prevent="register">Enviar</a>
                    <div wire:loading wire:target="register" class="spinner-border">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- row closed -->

    @push('plugin-scripts')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    @endpush

    @push('custom-scripts')
        <script>
            $('#proveedor').select2({
                width: '100%'
            });
            $('#proveedor').on('change', function() {
                @this.set('proveedor', this.value);
            });
            $('#tipo_movimiento').select2({
                width: '100%'
            });
            $('#tipo_movimiento').on('change', function() {
                @this.set('tipo_movimiento', this.value);
            });
            $('#tipo_doc').select2({
                width: '100%'
            });
            $('#tipo_doc').on('change', function() {
                @this.set('tipo_doc', this.value);
            });
        </script>
    @endpush
