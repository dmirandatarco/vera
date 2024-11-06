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
    <!-- container -->
    @if($trabajo)
      @livewire('venta-create',["trabajo" => $trabajo,"venta" => $venta])
    @else
      @livewire('venta-create',["trabajo" => null,"venta" => $venta])
    @endif
    <!-- Container closed -->
@endsection