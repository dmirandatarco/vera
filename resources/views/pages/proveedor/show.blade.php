@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Ver Proveedor</span>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-3" >
                            <label class="form-label" for="tipo_documento">Tipo de Documento</label>
                            <select class="js-example-basic-single form-select" id="tipo_documento" name="tipo_documento" data-width="100%" disabled>
                                <option value="DNI" @selected(old('tipo_documento',$proveedor->tipo_documento)=="DNI")>DNI</option>
                                <option value="RUC" @selected(old('tipo_documento',$proveedor->tipo_documento)=="RUC")>RUC</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nroDocumento" class="form-label">Numero de Documento</label>
                            <input type="text" class="form-control" value="{{$proveedor->num_documento}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" value="{{$proveedor->nombre}}" disabled>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" name="celular" id="celular" class="form-control" value="{{old('celular')}}" disabled>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" name="correo" id="correo"  class="form-control" value="{{old('correo',$proveedor->correo)}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="direccion" class="form-label">Direcion</label>
                            <input type="text" class="form-control" value="{{$proveedor->direccion}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nrocuenta1" class="form-label">Nro cuenta1:</label>
                            <input type="text" name="nrocuenta1" class="form-control" for="nrocuenta1" value="{{old('nrocuenta1',$proveedor->nrocuenta1)}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nrocuenta2" class="form-label">Nro cuenta2:</label>
                            <input type="text" name="nrocuenta2" class="form-control" for="nrocuenta2" value="{{old('nrocuenta2',$proveedor->nrocuenta2)}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Container -->
@endsection
