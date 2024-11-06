@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Generar Movimiento</span>
        </div>
    </div>
    @livewire('create-movimiento-masivo')
</div>
<!-- Container closed -->
@endsection




