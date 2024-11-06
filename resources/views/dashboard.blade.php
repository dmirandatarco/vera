@extends('layout.master')

@section('content')

<!-- container -->
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
        </div>
        {{-- <div class="justify-content-center mt-2">
            <form action="{{ route('dashboard') }}" method="GET">
                <div class="d-flex">
                    <div class="w-100 me-2">
                        <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="{{$fechaInicio2}}">
                    </div>
                    <div class="w-100">
                        <input type="date" name="fechaFin" id="fechaFin" class="form-control" value="{{$fechaFin2}}">
                    </div>
                    <button id="BotonFiltro" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i><b> &nbsp; Buscar</b>
                    </button>
                </div>
            </form>
        </div> --}}
    </div>
    {{-- <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-xs-6">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-12">
                                <div class="ps-4 pt-4 pe-3 pb-2">
                                    <div class="">
                                        <h6 class="mb-2 tx-18 ">Total Efectivo:</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold">{{number_format($pagoSolesTotal,2)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-xs-6">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-12">
                                <div class="ps-4 pt-4 pe-3 pb-2">
                                    <div class="">
                                        <h6 class="mb-2 tx-18 ">Total Transferencia:</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold">{{number_format($pagoTransferenciaTotal,2)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-xs-6">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-12">
                                <div class="ps-4 pt-4 pe-3 pb-2">
                                    <div class="">
                                        <h6 class="mb-2 tx-18 ">Total:</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold">{{number_format($pagoTransferenciaTotal+$pagoSolesTotal,2)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header border-bottom-0">
                    <div>
                        <h3 class="card-title mb-2 ">Ventas por Categoria </h3> <span class="d-block tx-12 mb-0 text-muted"></span>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <canvas id="VentaGraph"></canvas>
                </div>
            </div>

        </div>
    </div> --}}
</div>
<!-- /Container -->
@endsection

@push('plugin-scripts')
<script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endpush

@push('custom-scripts')
    
@endpush
