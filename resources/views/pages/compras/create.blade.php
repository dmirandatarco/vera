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
    @livewire('crear-compra')
    <!-- Container closed -->
@endsection




