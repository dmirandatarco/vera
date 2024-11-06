<div class="row">
    <div class="col-lg-12 col-xl-7 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="card-header">
                        <h4 class="card-title fw-semibold">Agregar Productos</h4>
                        @if($errorMessage)
                            <span class="text-danger">{{ $errorMessage }}</span>
                        @endif
                    </div>
                    <div class="product-details table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width:50%">Categoria</th>
                                    <th>Serie</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div wire:ignore>
                                            <select class="js-example-basic-single form-control" name="categoria" id="categoria" wire:model.defer="categoria">
                                                <option value="">SELECCIONE</option>
                                                @foreach($categorias as $catItem)
                                                    <option value="{{$catItem->id}}">{{$catItem->nombre}} - {{$catItem->abreviatura}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div wire:ignore>
                                            <select class="js-example-basic-single form-control" name="serie[]" id="serie" wire:model.defer="serie" multiple>
                                                @foreach($series as $serie)
                                                    <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-success btn-icon" wire:click="AumentarDetalle" tabindex="90">+</button>
                                        <div wire:loading wire:target="AumentarDetalle" class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-5 col-md-12">
        <div class="card custom-card cart-details">
            <div class="card-body">
            <h4 class="card-title fw-semibold">Detalle de Movimiento</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Series</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($detallePlantilla as $detalle)
                        <tr>
                            <td>{{ $detalle['categoria'] }}</td>
                            <td>
                                @foreach($detalle['series'] as $serie)
                                    {{  $serie['nombre'] }},
                                @endforeach
                            </td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-danger btn-icon" wire:click="ReducirDetalle({{ $loop->index }})">-</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-primary" wire:click.prevent="register" @disabled(!$detallePlantilla)>Enviar</button>
                <div wire:loading wire:target="register" class="spinner-border">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@push('plugin-scripts')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
@endpush
@push('custom-scripts')
<script>
    $('#serie').select2({
        placeholder: "Seleccione...",
        width: '100%',
    });
    $('#serie').on('change', function() {
        @this.set('serie', $(this).val());
    });
    $('#categoria').select2({
        width: '100%',
    });
    $('#categoria').on('change',function(){
        @this.set('categoria',this.value);
    });
</script>
@endpush
