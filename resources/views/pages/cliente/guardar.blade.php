@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{$cliente ? 'Editar Cliente':'Crear Cliente'}}</span>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="card-body">
                <div class="col-md-12">
                    
                        @livewire('crear-cliente',["cliente" => $cliente])
                    
                </div>
            </div>
        </div>
    </div>
</div>
    


@endsection

