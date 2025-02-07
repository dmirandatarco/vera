<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="codigo" class="form-label">Codigo:</label>
  <input type="text" class="form-control " id="codigo" name="codigo" value="{{old('codigo')}}">
  @error('codigo')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="precio" class="form-label">Precio Venta:</label>
  <input type="text" class="form-control " id="precio" name="precio" value="{{old('precio')}}">
  @error('precio')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="precio_doc" class="form-label">Precio Docena:</label>
  <input type="text" class="form-control " id="precio_doc" name="precio_doc" value="{{old('precio_doc')}}">
  @error('precio_doc')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>  
<div class="mb-3">
  <label for="stock" class="form-label">Stock:</label>
  <input type="text" class="form-control " id="stock" name="stock" value="{{old('stock')}}">
  @error('stock')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div> 
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary" id="boton-formulario"></button>
</div>
