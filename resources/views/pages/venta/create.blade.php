@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if ($message = Session::get('dark'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ $message }}
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if($caja)
        <!-- container -->
        @livewire('venta-create')
        <!-- Container closed -->
    @else
    <div class="main-container container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">No Hay caja Aperturada</span>
            </div>
        </div>
    </div>
    @endif
@endsection




