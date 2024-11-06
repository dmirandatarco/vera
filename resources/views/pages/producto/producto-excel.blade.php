@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
    <div class="main-container container-fluid">
    <!-- row -->
    <div class="row m-4">
        <div class="col-xl-12 col-md-12">
        <form action="{{route('producto.cargamasiva')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{csrf_field()}}
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title TextoTituloFlex">Subir Archivo de Productos</h3>
                        </div>
                        @if(count($errors)>0)
                            <span class="error-message" style="color:red">{{ $errors }}</span>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <input class="form-control" type="file" id="formFile" name="archivo">
                                    @error('archivo')
                                        <span class="error-message" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-end m-3">
                                    <div class="mb-3 d-flex align-items-center">
                                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary btn-lg"><i class="fe fe-check me-1"></i>Guardar</button>
                                        <div class="spinner-border m-3" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>

    </div>
    <!-- row -->
</div>

@endsection


@push('custom-scripts')
<script>
    $(document).ready(function() {
        $('button[type="submit"]').click(function() {
            $('.spinner-border').show();
        });
    });
</script>
@endpush
