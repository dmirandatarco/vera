@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Mermas</span>
        </div>
        <div class="justify-content-center mt-2">
            @can('merma.create')
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                    <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Merma</b>
                </button>
            @endcan
        </div>
    </div>
    <!-- /breadcrumb -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    <!-- row -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="filtroVentas">
                            <form action="{{ route('merma.index') }}" method="GET">
                                <div class="row pb-4">
                                    <div class="col-md-3">
                                        <label for="searchFechaInicio" class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" id="searchFechaInicio"
                                            name="searchFechaInicio" value="{{ $fechaInicio2 }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="searchFechaFin" class="form-label">Fecha Fin</label>
                                        <input type="date" class="form-control" id="searchFechaFin" name="searchFechaFin"
                                            value="{{ $fechaFin2 }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button id="tuBotonEnviar" class="btn btn-primary mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-search"></i><b>
                                                &nbsp; Buscar</b>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('merma.mermas-excel', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2]) }}" target="_blank" class="btn btn-success mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Excel" class="fas fa-file"></i><b>
                                                &nbsp; Excel</b>
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('merma.mermas-pdf', ['searchFechaInicio' => $fechaInicio2, 'searchFechaFin' => $fechaFin2]) }}" target="_blank" class="btn btn-danger mt-4">
                                            <i data-bs-toggle="tooltip" data-bs-title="Crear" class="fas fa-file-pdf"></i><b>
                                                &nbsp; PDF</b>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                        <table id="mermas" class="table table-hover">
                            <thead>
                            <tr >
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Trabajo</th>
                                <th>Producto</th>
                                <th>Cliente</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mermas as $merma)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$merma->fecha}}</td>

                                <td>{{ $merma->trabajo ? "Trabajo N°" . $merma->trabajo->id : 'N/A' }}</td>
                                <td>{{$merma->producto->nombre}} {{$merma->producto->categoria->abreviatura}}</td>
                                <td>{{$merma->cliente?->nombre_comercial ?? 'SIN CLIENTE'}}</td>
                                <td>{{$merma->descripcion}}</td>
                                <td>{{$merma->estado ? 'Activo':'Inactivo'}}</td>
                                <td>
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-settings"></i>
                                </button>
                                    <ul class="dropdown-menu">
                                    @can('merma.destroy')
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Eliminartrabajo" data-id="{{$merma->id}}">Eliminar</a></li>
                                    @endcan
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /Container -->
    <div class="modal fade" id="Eliminartrabajo"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Cambiar Estado de Merma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('merma.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                        <p>¿Estás seguro de cambiar el estado?</p>
                        <div class="modal-footer">
                        <input type="hidden" name="id_merma_2" class="id_merma_2">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="crear-formulario"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="text-formulario"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="card-body">
                    <h4 id="text-formulario"></h2>
                    <form action="{{route('merma.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="mb-3 col-md-12">
                            <label for="descripcion" class="form-label">Descripcion:</label>
                            <input type="text" name="descripcion"  id="descripcion" class="form-control" value="{{old('descripcion')}}" >
                            <input type="datetime-local" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d\TH:i') }}" style="display: none;">
                            @error('descripcion')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12" >
                            <label class="form-label" for="trabajo_id">Trabajo</label>
                            <select class="js-example-basic-single form-select" id="trabajo_id" name="trabajo_id" data-width="100%">
                                <option value="" @selected(old('trabajo_id')=="")>SELECCIONE</option>
                                @foreach($trabajos as $trabajo)
                                <option value="{{$trabajo->id}}" @selected(old('trabajo_id')==$trabajo->id)>Nº {{$trabajo->numero}} / {{$trabajo->maquina->nombre}} {{$trabajo->cliente->nombre_comercial}}</option>
                                @endforeach
                            </select>
                            @error('trabajo_id')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-12" >
                            <label class="form-label" for="producto_id">Producto</label>

                            <select class="js-example-basic-single form-select" id="producto_id" name="producto_id" data-width="100%">
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" step="0.01" min='0' name="cantidad"  id="cantidad" class="form-control" value="{{old('cantidad')}}" >
                            @error('cantidad')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary me-2" id="boton-formulario"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('plugin-scripts')
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    @endpush

    @push('custom-scripts')
    @if(count($errors)>0)
    <script>
    $('#crear-formulario').modal('show');
    $(function() {
    $('#text-formulario').text('Crear Merma');
    $('#boton-formulario').text('Guardar');
    });
    </script>
    @else
    <script>
    $('#crear-formulario').modal('hide');
    </script>
    @endif

    <script>// Función que muestra el formulario y configura el modal
        function showForm() {
            $('#crear-formulario').modal('show');
            $('#text-formulario').text('Crear Merma');
            $('#id').val(null);
            $('#descripcion').val(null).focus();
            $('#cantidad').val(null);
            $('#trabajo_id').val(null).select2({
                dropdownParent: $("#crear-formulario"),
                width: '100%'
            });
            $('#producto_id').val(null).select2({
                dropdownParent: $("#crear-formulario"),
                width: '100%',
                language: "es",
                ajax: {
                    url: '{{ route("producto.buscar") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data,
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                openOnEnter: false,
            });
            $('#boton-formulario').text('Guardar');
        }
        
        // Función que se llama al hacer clic en el botón de agregar
        function agregar() {
            showForm();
        }
        
        // Ajuste del CSS para el dropdown de Select2 cuando se abre
        $(document).on('select2:open', function() {
            $('.select2-results__options').css('max-height', '400px');
        });
        
        // Prevención de eventos mouseenter en las opciones de Select2
        $(document).on('mouseenter', '.select2-results__option', function(e) {
            e.stopPropagation();
        });

    var eliminartrabajo = document.getElementById('Eliminartrabajo');
    eliminartrabajo.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var idModal = eliminartrabajo.querySelector('.id_merma_2')
        idModal.value = id;
    })
</script>
@endpush
