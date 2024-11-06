@extends('layout.master')
@section('content')
<div class="main-container container-fluid">

  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
          <span class="main-content-title mg-b-0 mg-b-lg-1">Crear Rol</span>
      </div>
  </div>
  <!-- /breadcrumb -->

  <!-- row -->
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{route('roles.store')}}" method="post" id="formulacio" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 mb-5">
              <input type="text" class="form-control" name="name" placeholder="Nombre del Rol" value="{{old('name')}}">
              @error('name')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <h4 class="mb-3">Permisos</h4>
            <div class="col-md-12 row">
              @foreach($permissions as $permission)
                <div class="col-md-3">
                  <div class="form-check form-switch mb-2">
                    <input type="checkbox"  class="form-check-input chekes" id="formSwitch.{{$permission->id}}" name="permissions[]" value="{{$permission->id}}" {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? ' checked' : '' }}>
                    <label class="form-check-label" for="formSwitch.{{$permission->id}}">{{$permission->description}}</label>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="col-md-12">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Marcar" onclick="marcar(this);" class="btn btn-success mt-3">Marcar Todo</button>
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Desmarcar" onclick="marcar2(this);" class="btn btn-danger mt-3">DesMarcar Todo</button>
      
              <button type="submit" class="btn btn-primary mt-3">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@push('custom-scripts')

<script>

function marcar(source)
	{
		$('.chekes').attr("checked", "checked");
	}

  function marcar2(source)
	{
		$('.chekes').removeAttr("checked");
	}
</script>

@endpush
