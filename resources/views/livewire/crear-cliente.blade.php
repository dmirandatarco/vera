<div>
    <div class="row ">
        <div class="mb-3 col-md-6">
            <label class="form-label" for="nuevo_tipo_documento">Tipo de Documento</label>
            <select class="js-example-basic-single form-select" id="Tipo de documento" wire:model.defer="nuevotipo_documento" data-width="100%">
                <option value="">SELECCIONE</option>
                <option value="DNI">DNI</option>
                <option value="RUC">RUC</option>
            </select>
            @error('nuevotipo_documento')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="nuevo_documento" class="form-label">Documento</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevo_documento" class="form-control" wire:model.defer="nuevodocumento" autocomplete="off">
                @error('nuevodocumento')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
                <button type="button" class="btn btn-primary button-icon" wire:click="searchDocumento" ><i class="fe fe-search"></i></button>
            </div>
        </div>
        <div class="mb-3 col-md-12">
            <label for="nuevo_nombrerazon" class="form-label">Nombre o Razon Social</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevo_nombrerazon" class="form-control" wire:model="nuevonombrerazon" autocomplete="off">
                @error('nuevonombrerazon')
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
        <div class="mb-3 col-md-6">
            <label for="nuevonombrecomercial" class="form-label">Nombre Comercial</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevonombrecomercial" class="form-control" wire:model.defer="nuevonombrecomercial" autocomplete="off">
            </div>
            @error('nuevonombrecomercial')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="nuevodireccion" class="form-label">Direccion</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevo_direccion" class="form-control" wire:model.defer="nuevodireccion" autocomplete="off">
            </div>
            @error('nuevodireccion')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-3">
            <label for="nuevotelefono" class="form-label">Telefono</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevo_telefono" class="form-control" wire:model.defer="nuevotelefono" autocomplete="off">
            </div>
            @error('nuevotelefono')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-3">
            <label for="nuevocorreo" class="form-label">Correo</label>
            <div class="d-flex gap-3">
                <input type="text" id="nuevocorreo" class="form-control" wire:model.defer="nuevocorreo" autocomplete="off">
            </div>
            @error('nuevocorreo')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-3">
            <label for="nuevotipocliente" class="form-label">Tipo</label>
            <select class="js-example-basic-single form-select" id="nuevotipocliente" wire:model.defer="nuevotipocliente" data-width="100%">
                <option value="PROVINCIA">PROVINCIA</option>
                <option value="NACIONAL">NACIONAL</option>
            </select>
            @error('nuevotipocliente')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-3">
            <label for="nuevozona" class="form-label">Zona</label>
            <input type="text" id="nuevozona" class="form-control" wire:model="nuevozona" autocomplete="off">
            @error('nuevozona')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="modal-footer">
            <button aria-label="Close" class="btn btn-danger me-2" data-bs-dismiss="modal" type="button">Cancelar</button>
            <button type="button" wire:click="agregarCliente" class="btn btn-primary me-2">{{$botontext}}</button>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
    Livewire.on('abrir-modal', function (id) {
        $('#modalcliente').modal('show');
    });
</script>
@endpush