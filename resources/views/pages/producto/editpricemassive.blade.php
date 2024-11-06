@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">
<!-- row -->
<div class="row row-sm m-4">
    <div class="col-xl-12">
    <form action="{{route('producto.editpricemassivestore')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
    {{csrf_field()}}
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title TextoTituloFlex">Editar Precios Masivo</h3>
                        <div class="form-group d-flex align-items-center">
                            <label class="custom-switch-label tx-20 me-2">Cambiar</label>
                            <label class="custom-switch ps-0 mb-0">
                                <input type="checkbox" name="changeorup" id="changeorup" class="custom-switch-input">
                                <span class="custom-switch-indicator custom-switch-indicator-xl custom-radius"></span>
                            </label>
                            <label class="custom-switch-label tx-20 ms-2">Aumentar</label>
                        </div>

                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    @if ($message = Session::get('danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    <div class="card-body pt-0">


                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <div class="mb-3">
                                        <label for="serie_id" class="form-label">Serie:</label>
                                        <div >
                                            <select class="js-example-basic-single form-control" name="serie_id" id="serie_id" data-live-search="true">
                                            <option value="" >SELECCIONE</option>
                                            @foreach($series as $serie)
                                                <option value="{{$serie->id}}" @selected(old('serie_id')==$serie->id)>{{$serie->nombre}}</option>
                                            @endforeach
                                            </select>
                                            @error('serie_id')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="mb-3">
                                        <label for="categoria_id" class="form-label">Categoria:</label>
                                        <div >
                                            <select class="js-example-basic-single form-control" name="categoria_id" id="categoria_id" data-live-search="true">
                                            <option value="" >SELECCIONE</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{$categoria->id}}" @selected(old('categoria_id')==$categoria->id)>{{$categoria->nombre}}</option>
                                            @endforeach
                                            </select>
                                            @error('categoria_id')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="mb-3">
                                        <label for="precio" class="form-label">Precio:</label>
                                        <input type="text" class="form-control precio" id="precio" name="precio" placeholder="0.00" value="{{old('precio')}}">
                                        @error('precio')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3  d-flex align-items-end">
                                    <div class="mb-3">
                                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary btn-lg"><i class="fe fe-check me-1"></i>Guardar</button>
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

@push('plugin-scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>


@endpush

@push('custom-scripts')
<script>
$(document).ready(function() {
    $("#categoria_id").select2({
        width: '100%'
    });
})

$(document).ready(function() {
    $("#serie_id").select2({
        width: '100%'
    });
})
</script>
@endpush
