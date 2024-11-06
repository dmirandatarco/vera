@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">Crear Proveedor</span>
        </div>
    </div>
    <!-- /breadcrumb -->

    <form action="{{route('proveedor.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6" >
                            <label class="form-label" for="documento">Tipo de Documento</label>
                            <select class="js-example-basic-single form-select" id="documento" name="documento" data-width="100%">
                                <option value="DNI" @selected(old('documento')=="DNI")>DNI</option>
                                <option value="RUC" @selected(old('documento')=="RUC")>RUC</option>
                            </select>
                            @error('documento')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="num_documento" class="form-label">Numero de Documento:</label>
                            <input type="text" name="num_documento"  id="num_documento" class="form-control" value="{{old('num_documento')}}" >
                            @error('num_documento')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-8">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre')}}" >
                            @error('nombre')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" name="celular" id="celular" class="form-control" value="{{old('celular')}}" >
                            @error('celular')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" name="correo"  id="correo" class="form-control" value="{{old('correo')}}" >
                            @error('correo')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="correo" class="form-label">Direccion</label>
                            <input type="text" name="direccion"  id="direccion" class="form-control" value="{{old('direccion')}}" >
                            @error('direccion')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nrocuenta1" class="form-label">Nro cuenta1:</label>
                            <input type="text" name="nrocuenta1" class="form-control" for="nrocuenta1" value="{{old('nrocuenta1')}}">
                            @error('nrocuenta1')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nrocuenta2" class="form-label">Nro cuenta2:</label>
                            <input type="text" name="nrocuenta2" class="form-control" for="nrocuenta2" value="{{old('nrocuenta2')}}">
                            @error('nrocuenta2')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" id="submit-button" class="btn btn-primary me-2">Crear Proveedor</button>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>
<!-- /Container -->


@endsection

@push('plugin-scripts')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
@endpush

@push('custom-scripts')


@endpush
