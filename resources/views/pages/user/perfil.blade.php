@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
    <div class="left-content">
      <span class="main-content-title mg-b-0 mg-b-lg-1">Editar Usuario</span>
    </div>
  </div>
  <!-- /breadcrumb -->

  <div class="row inbox-wrapper">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <form action="{{route('perfilguardar',$user)}}" method="post" class="forms-sample" enctype="multipart/form-data">
            {{method_field('patch')}}
              {{csrf_field()}}
            <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
              <div class="mb-3">              
                <img src="{{asset($user->imagen)}}" alt="{{$user->nombre}}" class="wd-250 ht-250 rounded-circle" style="height: 250px;object-fit: cover;">
                <input class="form-control" type="file" id="formFile" accept="image/*" name="imagen">
                @error('imagen')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror 
              </div>
              <div class="text-center">
                <p class="tx-16 fw-bolder">{{$user->nombre}} {{$user->apellido}}</p>
                <p class="tx-12 text-muted">@foreach($user->roles as $role)
                    {{$role->name}}
                  @endforeach
                </p>
              </div>
              @error('imagen')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ $message }}
              <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
          @endif
          <div class="row">     
            <div class="mb-3 col-md-6" >
              <label class="form-label" for="tipo_documento">Tipo de Documento</label>
              <select class="js-example-basic-single form-select" id="tipo_documento" name="tipo_documento" data-width="100%">
                <option value="DNI" @selected(old('tipo_documento',$user->tipo_documento)=="DNI")>DNI</option>
                <option value="RUC" @selected(old('tipo_documento',$user->tipo_documento)=="RUC")>RUC</option>                  
              </select>    
              @error('tipo_documento')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror        
            </div>
            <div class="mb-3 col-md-6">
              <label for="num_documento" class="form-label">Numero de Documento</label>
              <input type="text" name="num_documento"  id="num_documento" class="form-control" value="{{old('num_documento',$user->num_documento)}}" >
              @error('num_documento')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-4">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre',$user->nombre)}}" >
              @error('nombre')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-4">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" name="apellido" id="apellido" class="form-control" value="{{old('apellido',$user->apellido)}}" >
              @error('apellido')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-4">
              <label for="celular" class="form-label">Celular</label>
              <input type="text" name="celular" id="celular"  class="form-control" value="{{old('celular',$user->celular)}}" >
              @error('celular')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-6">
              <label for="usuario" class="form-label">Usuario</label>
              <input type="text" name="usuario"  id="usuario" class="form-control" value="{{old('usuario',$user->usuario)}}" >
              @error('usuario')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control"  >
              @error('password')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-6" >
              <label class="form-label">Rol</label>
              <select class="js-example-basic-single form-select" id="idrol" name="idrol" data-width="100%">
                <option value="">SELECCIONE</option>
                @foreach($roles as $role)
                    <option value="{{$role->id}}" @selected(old('idrol',$user->roles->contains($role))==$role->id) >{{$role->name}}</option>
                @endforeach                  
              </select>    
              @error('idrol')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror        
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">E-mail:</label>
              <input type="text" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}">
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Sucursal:</label>
              <select class="js-example-basic-single form-control" name="sucursal_id" id="sucursal_id" data-live-search="true">
                  <option value="" >SELECCIONE</option>
                  @foreach($sucursales as $sucursal)
                  <option value="{{$sucursal->id}}" {{ old('sucursal_id', $user->sucursal_id) == $sucursal->id ? 'selected' : '' }}>{{$sucursal->nombre}}</option>
                  @endforeach
              </select>
              @error('sucursal_id')
              <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3 col-md-6">
              <label for="maquina_id" class="form-label">Estacion de Trabajo:</label>
              <select class="js-example-basic-single form-control" name="maquina_id" id="maquina_id" data-live-search="true">
                  <option value="" >SELECCIONE</option>
                  @foreach($maquinas as $maquina)
                  <option value="{{$maquina->id}}" {{ old('maquina_id', $user->maquina_id) == $maquina->id ? 'selected' : '' }}>{{$maquina->nombre}}</option>
                  @endforeach
              </select>
              @error('maquina_id')
              <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Container -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
$(document).ready(function() {
    $('#maquina_id').select2();
});
</script>
@endpush