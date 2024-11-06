@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Clientes</span>
        </div>
        <div class="justify-content-center mt-2">
            @can('cliente.create')
                <a href="{{ route('cliente.edit',0)}}">
                    <button type="button" class="btn btn-primary mb-2 mb-md-0 ">
                        <i class="fa fa-plus-circle"></i><b> &nbsp; Crear Cliente</b>
                    </button>
                </a>
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
                <div class="table-responsive">
                <table id="clientes" class="table table-hover">
                    <thead>
                        <tr >
                            <th>#</th>
                            <th>Documento </th>
                            <th>Razon Social</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$cliente->documento}} {{$cliente->num_documento}}</td>
                        <td>{{$cliente->razon_social}}</td>
                        <td>{{$cliente->telefono}}</td>
                        <td>{{$cliente->direccion}}</td>
                        <td>{{$cliente->correo}}</td>
                        <td>{{$cliente->estado ? 'Activo':'Inactivo'}}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-settings"></i>
                            </button>
                            <ul class="dropdown-menu">
                            @can('cliente.edit')
                                <a class="dropdown-item" href="{{ route('cliente.edit',$cliente)}}">
                                    <li>Editar</li>
                                </a>
                            @endcan
                            @can('cliente.destroy')
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EliminarCliente" data-id="{{$cliente->id}}">Eliminar</a></li>
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
    <div class="modal fade" id="EliminarCliente"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Cambiar Estado de Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('cliente.destroy','test')}}" method="POST" autocomplete="off">
            {{method_field('delete')}}
            {{csrf_field()}}
                <p>¿Estás seguro de cambiar el estado?</p>
                <div class="modal-footer">
                <input type="hidden" name="id_cliente_2" class="id_cliente_2">
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    @endpush

    @push('custom-scripts')
    @if(count($errors)>0)
    <script>
    $('#crear-formulario').show();
    if('{{old("id")}}'){
        $(function() {
        $('#text-formulario').text('Editar Cliente');
        $('#boton-formulario').text('Editar');
        });
    }else{
        $(function() {
        $('#text-formulario').text('Crear Cliente');
        $('#boton-formulario').text('Guardar');
        });
    }
    </script>
    @else
    <script>
    $('#crear-formulario').hide();
    </script>
    @endif

    <script>

    $(document).ready(function() {
        $('#categoria_id').select2();
    });

    function agregar() {
    $('#crear-formulario').show();
    $('#text-formulario').text('Crear Cliente');
    $('#id').val(null);
    $('#razon_social').val(null);
    $('#documento').val(null);
    $('#num_documento').val(null);
    $('#nombre_comercial').val(null);
    $('#telefono').val(null);
    $('#direccion').val(null);
    $('#correo').val(null);
    $('#zona').val(null);
    $('#boton-formulario').text('Guardar');
    }


    function editar(id,documento,num_documento,razon_social,nombre_comercial,telefono,direccion,correo) {
    $('#crear-formulario').show();
    $('#text-formulario').text('Editar Cliente');
    $('#id').val(id);
    $('#razon_social').val(razon_social);
    $('#documento').val(documento);
    $('#num_documento').val(num_documento);
    $('#nombre_comercial').val(nombre_comercial);
    $('#telefono').val(telefono);
    $('#direccion').val(direccion);
    $('#correo').val(correo);
    $('#zona').val(zona);
    $('#boton-formulario').text('Editar');
    }

    var eliminarCliente = document.getElementById('EliminarCliente');

    eliminarCliente.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = eliminarCliente.querySelector('.id_cliente_2')

    idModal.value = id;
    })

    $(function() {
    'use strict';

    $(function() {
        $('#clientes').DataTable({
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
            targets: [10],
            orderable: false
            }
        ]
        });
    });

});
</script>
@endpush
