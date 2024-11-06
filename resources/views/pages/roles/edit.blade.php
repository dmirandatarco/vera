@extends('layout.master')
@section('content')
<div class="main-container container-fluid">

  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
          <span class="main-content-title mg-b-0 mg-b-lg-1">Editar Rol</span>
      </div>
  </div>
  <!-- /breadcrumb -->

  <!-- row -->
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{route('roles.update',$role)}}" method="post" id="formulacio" class="form-horizontal" enctype="multipart/form-data">
            {{method_field('patch')}}
            {{csrf_field()}}
            <div class="col-md-12 mb-5">
              <input type="text" class="form-control" name="name" placeholder="Nombre del Rol" value="{{old('name',$role->name)}}">
              @error('name')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <h4 class="mb-3">Permisos</h4>
            <div class="col-md-12 row">
              @foreach($permissions as $permission)
                <div class="col-md-3">
                    <div class="form-check form-switch mb-2">
                      <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input"
                      {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>                  
                      <label class="form-check-label" for="formSwitch1">{{ $permission->description }}</label>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary mt-3">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection