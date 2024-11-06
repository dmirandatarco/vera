@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

<!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Categorias</span>
        </div>
        <div class="justify-content-center mt-2">
            @can('categoria.create')
                <a type="button" href="{{route('categoria.ordenar')}}" class="btn btn-primary mb-2 mb-md-0 " >
                    <i data-bs-toggle="tooltip" class="fa fa-align-left"></i><b> &nbsp; Ordenar Categoria</b>
                </a>
            @endcan
            @can('categoria.create')
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar(null)">
                    <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear
                        Categoria</b>
                </button>
            @endcan
        </div>
    </div>
    <!-- /breadcrumb -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span
                    aria-hidden="true">&times;</span></button>
        </div>
    @endif
    <!-- row -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul id="treeview1">
                        @include('pages.categoria.recursividad',['categorias' => $categorias])
                    </ul>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- /Container -->
<div class="modal fade" id="EliminarUsuario" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado de Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categoria.destroy', 'test') }}" method="POST" autocomplete="off">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <p>¿Estás seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_categoria_2" class="id_categoria_2">
                        <button type="button" data-bs-toggle="tooltip" data-bs-title="Cancelar"
                            class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" data-bs-toggle="tooltip" data-bs-title="Aceptar"
                            class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Agregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="text-formulario"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('categoria.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="abreviatura" class="form-label">Abreviatura:</label>
                        <input type="text" class="form-control" id="abreviatura" name="abreviatura" value="{{old('abreviatura')}}">
                        @error('abreviatura')
                        <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
                        @error('nombre')
                        <span class="error-message" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="hidden" name="categoria_id" id="categoria_id" class="categoria_id" value="{{old('categoria_id')}}">
                    <input type="hidden" name="id" id="id" class="id" value="{{old('id')}}">
                    <div class="modal-footer">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary" id="boton-formulario"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editprice" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Precio por Lote</h5>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categoria.editprice') }}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="d-flex m-0 justify-content-between">
                        <input type="hidden" name="id_categoria_2" class="id_categoria_2">

                        <div class="section2 d-flex">
                            <button type="submit" id="incrementButton" data-bs-toggle="tooltip" data-bs-title="+ 1"
                            class="btn btn-icon  btn-warning me-1 btn-rounded"><i class="fas fa-dollar-sign"></i></button>
                        </div>
                        <div class="section1 d-flex justify-content-end">
                            <div class="col-md-6">
                                <input type="text" name="monto" id="monto" class="form-control" placeholder="0.00">
                            </div>
                            <button type="submit" data-bs-toggle="tooltip" data-bs-title="Aceptar"
                            class="btn btn-primary">Aceptar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('plugin-scripts')
    <script src="{{ asset('plugins/treeview/treeview.js') }}"></script>
@endpush

@push('custom-scripts')
@if(count($errors)>0)
<script>
    $(function() {
        $('#Agregar').modal('show');
    });
</script>
@endif

<script>

function agregar(id) {
    $('#text-formulario').text('Crear Categoria');
    $('#id').val(null);
    $('#nombre').val(null);
    $('#abreviatura').val(null);
    $('#categoria_id').val(id);
    $('#Agregar').modal('show').on('shown.bs.modal', function () {
        $('#abreviatura').focus();
    });
    $('#boton-formulario').text('Guardar');
}


function editar(id, nombre,abreviatura, categoria_id) {
    $('#text-formulario').text('Editar Categoria');
    $('#id').val(id);
    $('#nombre').val(nombre);
    $('#abreviatura').val(abreviatura);
    $('#categoria_id').val(categoria_id);
    $('#Agregar').modal('show').on('shown.bs.modal', function () {
        $('#abreviatura').focus();
    });
    $('#boton-formulario').text('Editar');
}



var eliminarUsuario = document.getElementById('EliminarUsuario');
eliminarUsuario.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = eliminarUsuario.querySelector('.id_categoria_2')

    idModal.value = id;
})


var editprice = document.getElementById('editprice');
editprice.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var idModal = editprice.querySelector('.id_categoria_2')
    idModal.value = id;
})
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("incrementButton").addEventListener("click", function() {
            document.getElementById("monto").value = "1";
        });
    });
</script>

@endpush
