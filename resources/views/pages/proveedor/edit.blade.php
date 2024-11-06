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
        <span class="main-content-title mg-b-0 mg-b-lg-1">Editar Proveedor</span>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="row inbox-wrapper">
        <div class="col-md-12">
        <form action="{{route('proveedor.update',$proveedor)}}" method="post" class="forms-sample" enctype="multipart/form-data">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="d-flex flex-column align-items-center border-bottom">
                    <div class="text-center">
                        <p class="tx-16 fw-bolder">{{$proveedor->nombre}}</p>
                    </div>
                </div>
        <div class="card">
            <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-3" >
                    <label class="form-label" for="tipo_documento">Tipo de Documento</label>
                    <select class="js-example-basic-single form-select" id="tipo_documento" name="tipo_documento" data-width="100%">
                        <option value="DNI" @selected(old('tipo_documento',$proveedor->tipo_documento)=="DNI")>DNI</option>
                        <option value="RUC" @selected(old('tipo_documento',$proveedor->tipo_documento)=="RUC")>RUC</option>
                    </select>
                    @error('tipo_documento')
                        <span class="error-message" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 col-md-3">
                <label for="num_documento" class="form-label">Numero de Documento</label>
                <input type="text" name="num_documento"  id="num_documento" class="form-control" value="{{old('num_documento',$proveedor->num_documento)}}" >
                @error('num_documento')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
                </div>
                <div class="mb-3 col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre',$proveedor->nombre)}}" >
                @error('nombre')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
                </div>
                <div class="mb-3 col-md-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" value="{{$proveedor->celular}}">
                </div>
                <div class="mb-3 col-md-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="text" name="correo" id="correo"  class="form-control" value="{{old('correo',$proveedor->correo)}}" >
                    @error('correo')
                        <span class="error-message" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" name="direccion" id="direccion"  class="form-control" value="{{old('direccion',$proveedor->direccion)}}" >
                    @error('direccion')
                        <span class="error-message" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="nrocuenta1" class="form-label">Nro cuenta1:</label>
                    <input type="text" name="nrocuenta1" class="form-control" for="nrocuenta1" value="{{old('nrocuenta1',$proveedor->nrocuenta1)}}">
                    @error('nrocuenta1')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="nrocuenta2" class="form-label">Nro cuenta2:</label>
                    <input type="text" name="nrocuenta2" class="form-control" for="nrocuenta2" value="{{old('nrocuenta2',$proveedor->nrocuenta2)}}">
                    @error('nrocuenta2')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                </form>
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

</script>
@endpush
