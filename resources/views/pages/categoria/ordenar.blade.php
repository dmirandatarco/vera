@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

<!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Ordenar Categorias</span>
        </div>
    </div>
    <!-- row -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('categoria.guardarordenar')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <ul id="treeview1" class="sortable">
                            @foreach ($categorias as $categoria)
                                <li class="card-draggable">{{ $categoria->abreviatura }} - {{ $categoria->nombre }}
                                    <input type="hidden" name="detalle[]" value="{{$categoria->id}}">
                                </li>
                            @endforeach
                        </ul>
                        <button type="submit" data-bs-toggle="tooltip" data-bs-title="Guardar"
                            class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('plugin-scripts')
    <script src="{{ asset('plugins/treeview/treeview.js') }}"></script>
    <script src="{{ asset('plugins/darggable/jquery-ui-darggable.min.js') }}"></script>
    <script src="{{ asset('plugins/darggable/darggable.js') }}"></script>
@endpush