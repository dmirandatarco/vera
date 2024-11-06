@foreach ($categorias as $categoria)
    <li class="position-relative">{{ $categoria->abreviatura }} - {{ $categoria->nombre }}
        <div class="row position-absolute top-0 end-0 pe-3">
            <div class="justify-content-center mt-2 d-block">
                @can('categoria.create')
                    <button type="button" class="btn btn-primary mb-2 mb-md-2 px-2 py-1" onclick="agregar({{$categoria->id}})">
                        <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear
                            </b>
                    </button>
                @endcan
                @can('categoria.edit')
                    <button type="button" class="btn btn-primary mb-2 mb-md-2 px-2 py-1" onclick="editar('{{$categoria->id}}','{{$categoria->nombre}}','{{$categoria->abreviatura}}','{{$categoria->categoria_id}}')">
                        <i data-bs-toggle="tooltip" data-bs-title="Editar" class="fa fa-edit"></i><b> &nbsp; Editar
                            </b>
                    </button>
                @endcan
                @can('categoria.destroy')
                    <button type="button" class="btn btn-primary mb-2 mb-md-2 px-2 py-1 " data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$categoria->id}}">
                        <i data-bs-toggle="tooltip" data-bs-title="Eliminar" class="fa fa-trash"></i><b> &nbsp; Eliminar
                            </b>
                    </button>
                @endcan
                    <!-- <button type="button" class="btn btn-primary mb-2 mb-md-2 px-2 py-1 " data-bs-toggle="modal" data-bs-target="#editprice" data-id="{{$categoria->id}}">
                        <i data-bs-toggle="tooltip" data-bs-title="Eliminar" class="fas fa-dollar-sign"></i><b> &nbsp; Precio Lote
                            </b>
                    </button> -->
            </div>
        </div>
        @if (count($categoria->categoriashijos)>0)
            <ul>
                @include('pages.categoria.recursividad',['categorias' => $categoria->categoriashijos])
            </ul>
        @endif
    </li>
@endforeach
