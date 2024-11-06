@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Ver Usuario</span>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="mb-3">
                                <img class="wd-250 ht-250 rounded-circle" src="{{asset($user->imagen)}}" alt="" style="height: 250px;">
                            </div>
                            <div class="text-center">
                                <p class="tx-16 fw-bolder">{{$user->nombre}} {{$user->apellido}}</p>
                                <p class="tx-12 text-muted">
                                    @foreach($user->roles as $role)
                                    {{$role->name}}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                            <input type="text" class="form-control" value="{{$user->tipo_documento}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nroDocumento" class="form-label">Numero de Documento</label>
                            <input type="text" class="form-control" value="{{$user->num_documento}}" disabled>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="nombres" class="form-label">Nombre</label>
                            <input type="text" class="form-control" value="{{$user->nombre}}" disabled>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" value="{{$user->apellido}}" disabled>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" value="{{$user->celular}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" value="{{$user->usuario}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" value="{{$user->password}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            @foreach($user->roles as $role)
                            @endforeach
                            <label for="fc" class="form-label">Rol</label>
                            <input type="text" class="form-control" value="{{$role->name}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">E-mail:</label>
                            <input type="text" class="form-control" value="{{$user->email}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Sucursal:</label>
                            <input type="text" class="form-control" value="{{$user->sucursal?->nombre}}" disabled>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Estacion de Trabajo:</label>
                            <input type="text" class="form-control" value="{{$user->estacion?->nombre}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Container -->
@endsection
