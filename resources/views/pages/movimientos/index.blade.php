@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Movimientos</span>
        </div>
        <div class="justify-content-center mt-2">
            @can('movimiento.plantilla')
            <a href=" {{route('movimiento.plantillaexcelcrear')}}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Plantilla</b>
                </button>
            </a>
            @endcan
            @can('movimiento.create')
            <a href=" {{route('movimiento.createmovimientomasivo')}}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Movimiento</b>
                </button>
            </a>
            @endcan
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            <div class="table-responsive">
                <table id="movimientos" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Reponsable</th>
                        <th>Tipo de Movimiento</th>
                        <th>Almacen</th>
                        <th>Nº Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{date("d-m-Y",strtotime($movimiento->fecha))}}</td>
                            <td>{{$movimiento->user->nombre}}</td>
                            <td>{{$movimiento->tipo->nombre}}</td>
                            <td>{{$movimiento->almacen->nombre}}</td>
                            <td>{{$movimiento->tipo_doc}} {{$movimiento->nume_doc}}</td>
                            <td>{{$movimiento->estado ? 'Activo':'Anulado'}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-settings"></i>
                                </button>
                                <div class="spinner-border d-none" id="spinner-{{ $movimiento->id }}">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <ul class="dropdown-menu">
                                    {{-- @can('movimiento.show')
                                        <li><a class="dropdown-item" href="{{ route('movimiento.show',$movimiento->id) }}">Ver información</a></li>
                                    @endcan --}}
                                    @if(Gate::check('movimiento.destroy') && $movimiento->estado == 1)
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EliminarMovimiento" data-id="{{$movimiento->id}}">Anular</a></li>
                                    @endif
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="showSpinnerAndDownload({{ $movimiento->id }}, '{{ route('movimiento.informesexcel', $movimiento->id) }}')">Excel</a>
                                        </li>

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
    <!-- /Container -->
    <div class="modal fade" id="EliminarMovimiento"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar Estado de Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('movimiento.destroy','test')}}" method="POST" autocomplete="off">

                {{method_field('delete')}}
                {{csrf_field()}}
                    <p>¿Estás seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                    <input type="hidden" name="id_movimiento_2" class="id_movimiento_2">
                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    @endsection

    @push('plugin-scripts')
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    @endpush

    @push('custom-scripts')
    <script>

    var EliminarMovimiento = document.getElementById('EliminarMovimiento');

    EliminarMovimiento.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = EliminarMovimiento.querySelector('.id_movimiento_2')

    idModal.value = id;
    })

    $(function() {
    'use strict';

    $(function() {
        $('#movimientos').DataTable({
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "language": {
            "lengthMenu": "Mostrar  _MENU_  registros por paginas",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate":{
            "next": "Siguiente",
            "previous": "Anterior",
            }
        },
        "columnDefs": [
            {
            targets: [7],
            orderable: false
            }
        ]
        });
    });

});
</script>

<script>
    function showSpinnerAndDownload(movimientoId, url) {
        $('#spinner-' + movimientoId).removeClass('d-none');
        setTimeout(function() {
            window.location.href = url;
        }, 100);
    }
</script>
@endpush
