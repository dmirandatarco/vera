<div class="row" >
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-xl-4 col-md-4">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Tipo de Movimiento:</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-control form-select select2" wire:model="tipo_movimiento" >
                                <option value="">SELECCIONE</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
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
                            <select name="almacen_id" id="almacen_id" class="form-control form-select select2" wire:model="almacen_id" >
                                <option value="">SELECCIONE</option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('almacen_id')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($condAlmacen == 1)
                        <div class="col-lg-4 col-xl-4 col-md-4">
                            <div class="form-group" wire:ignore>
                                <label class="form-label">Almacen Destino:</label>
                                <select name="almacen_2" id="almacen_2" class="form-control form-select select2" wire:model="almacen_2" >
                                    <option value="">SELECCION</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
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
                            <input class="form-control"  type="date" wire:model.defer="fecha">
                        </div>
                        @error('fecha')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($documentoo == 1)
                        <div class="col-lg-4 col-xl-4 col-md-4">
                            <div class="form-group" wire:ignore>
                                <label class="form-label">Tipo Doc:</label>
                                <select name="country" id ="tipo_doc" class="form-control form-select select2" wire:model.defer="tipo_doc">
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
                                <input type="text" class="form-control" placeholder="numero documento" wire:model.defer="nro_doc">
                            </div>
                            @error('nro_doc')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="col-md-8">

                        </div>
                    @endif

                    <div class="col-lg-12 col-xl-12 col-md-12">
                        <input class="form-control" type="file" id="formFile" name="archivo" wire:model.defer="archivo">
                        @error('archivo')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-primary m-3" id="boton-formulario" @disabled(!$archivo) wire:click="register">Guardar</button>
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>


@endpush

@push('custom-scripts')
<script>
    $('#almacen_id').select2({
        width: '100%'
    });
    $('#almacen_id').on('change',function(){
        @this.set('almacen_id',this.value);
    });
    $('#tipo_movimiento').select2({
        width: '100%'
    });
    $('#tipo_movimiento').on('change',function(){
        @this.set('tipo_movimiento',this.value);
    });
    $('#tipo_doc').select2({
        width: '100%'
    });
    $('#tipo_doc').on('change',function(){
        @this.set('tipo_doc',this.value);
    });

    Livewire.on('Encontrar', function (id) {
        $('#almacen_id').val(id).select2();
        $('#almacen_id').on('change', function (e) {
            @this.set('almacen_id', this.value);
        });
        $("#almacen_id").prop("disabled", true);
    });

    Livewire.on('sinEncontrar', function (id) {
        $("#almacen_id").prop("disabled", false);
        $('#almacen_id').select2({
            width: '100%'
        });
        $('#almacen_id').on('change',function(){
            @this.set('almacen_id',this.value);
        });
        $('#almacen_2').select2({
            width: '100%'
        });
        $('#almacen_2').on('change',function(){
            @this.set('almacen_2',this.value);
        });
    });
</script>
@endpush
