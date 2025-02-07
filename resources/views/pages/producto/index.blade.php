@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Productos</span>
            <div class="col-sm-6 col-lg-3">

            </div><!-- col-3 -->
        </div>
        <div class="justify-content-center mt-2 mr-3">
            {{-- @can('producto.stock')
            <a href=" {{route('movimiento.create')}}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 ">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Agregar Stock</b>
                </button>
            </a>
            @endcan

            @can('producto.subirarchivo')
            <a href="{{ route('productoexcel') }}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 " >
                    <i  data-bs-toggle="tooltip" data-bs-title="Subir Productos Excel" class="fa fa-file"></i><b> &nbsp; Subir Archivo</b>
                </button>
            </a>
            @endcan
            @can('producto.editarmasivo')
            <a href="{{ route('producto.editpricemassive') }}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0 mr-3" >
                    <i  data-bs-toggle="tooltip" data-bs-title="Editar" class="fa fa-edit"></i><b> &nbsp; Editar Masivo</b>
                </button>
            </a>
            @endcan --}}
            @can('producto.create')
            <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Producto</b>
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
                <div class="table-responsive">
                <table id="productos" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Precio V.</th>
                            <th>Precio C.</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
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
<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Cambiar Estado de Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('producto.destroy','test')}}" method="POST" autocomplete="off">
            {{method_field('delete')}}
            {{csrf_field()}}
                <p>¿Estás seguro de cambiar el estado?</p>
                <div class="modal-footer">
                <input type="hidden" name="id_producto_2" class="id_producto_2">
                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
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
                <form action="{{route('producto.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.producto.form')
                    <input type="hidden" name="id" id="id" class="id" value="{{old('id')}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Barras" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="text-formulariobarras" style="text-align: center"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body" id="modal-content-to-print">
                <h1 id="nombre-producto" style="text-align: center">Nombre del producto</h1>
                <div id="codigo-barra" style="text-align: center"></div>
                {{-- <h2 id="codigo-producto" style="text-align: center">Código del producto</h2> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="printModalContent()">Imprimir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cantidadModal" tabindex="-1" aria-labelledby="cantidadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cantidadModalLabel">Editar Cantidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cantidadForm" method="POST" action="{{ route('producto.barTicketPDF') }}"  target="_blank">
                    @csrf
                    <input type="hidden" name="producto_id" id="productoId">
                    <div class="mb-3">
                        <label for="productoNombre" class="form-label">Producto</label>
                        <input type="text" class="form-control" id="productoNombre" name="productoNombre" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="productoCodigo" class="form-label">Código del Producto</label>
                        <input type="text" class="form-control" id="productoCodigo" name="productoCodigo" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
    <script src="{{ asset('plugins/select2/js/jsbarcode.all.min.js') }}"></script>
@endpush

@push('custom-scripts')
@if(count($errors)>0)
<script>
    $(function() {
        $('#Agregar').modal('show');
    });
    if('{{old("id")}}'){
        $(function() {
            $('#text-formulario').text('Editar Producto');
            $('#boton-formulario').text('Editar');
        });
    }else{
            $(function() {
            $('#text-formulario').text('Crear Producto');
            $('#boton-formulario').text('Guardar');
        });
    }
</script>
@endif
<script>
    function abrirModalCantidad(productoId, productoNombre, codigo) {
        
        document.getElementById('productoId').value = productoId;
        document.getElementById('productoNombre').value = productoNombre;
        document.getElementById('productoCodigo').value = codigo;
        document.getElementById('cantidad').value = 1; 

        
        var myModal = new bootstrap.Modal(document.getElementById('cantidadModal'));
        myModal.show();
    }
    function barras(id, nombre, codigo, precio) {
        $('#text-formulariobarras').text('Información del Producto');
        $('#nombre-producto').text(nombre);
        // $('#codigo-producto').text('Código de producto: ' + (codigo || 'Código no detectado'));

        if (codigo) {
            $('#codigo-barra').html('<svg id="barcode"></svg>');
            try {
                JsBarcode("#barcode", codigo, {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 2,
                    height: 50,
                    displayValue: true
                });
            } catch (error) {
                console.error("Error generando el código de barras", error);
                $('#codigo-barra').html('<p style="color: red;">Error generando el código de barras</p>');
            }
        } else {
            $('#codigo-barra').html('<p style="color: red;">Código no detectado</p>');
        }

        $('#Barras').modal('show').on('shown.bs.modal', function() {
            $('#nombre').focus();
        });
    }
    function printModalContent() {
        const content = document.getElementById('modal-content-to-print').innerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
        <html>
            <head>
                <title>Imprimir</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 20px; }
                    h1, h2 { margin: 10px 0; }
                </style>
            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
        printWindow.document.close();
        printWindow.print();
    }
</script>
<script>
$(document).ready(function() {
    $("#categoria_id").select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
})

$(document).ready(function() {
    $("#serie_id").select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
})

function agregar() {
    $('#text-formulario').text('Crear Producto');
    $('#id').val(null);
    $('#categoria_id').select2('destroy');
    $('#categoria_id').val(null).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
    $('#nombre').val(null)
    $('#serie_id').select2('destroy');
    $('#serie_id').val(null).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
    $('#codigo').val(null);
    $('#stock').val(null);
    $('#precio').val(null);
    $('#Agregar').modal('show').on('shown.bs.modal', function () {
        $('#nombre').focus();
    });
    $('#boton-formulario').text('Guardar');
}



function editar(id,nombre,codigo,precio,precio_doc,stock) {
    $('#text-formulario').text('Editar Producto');
    $('#id').val(id);
    $('#nombre').val(nombre).focus();
    $('#codigo').val(codigo);
    $('#precio').val(precio);
    $('#stock').val(stock);
    $('#precio_doc').val(precio_doc);
    $('#Agregar').modal('show').on('shown.bs.modal', function () {
        $('#nombre').focus();
    });
    $('#boton-formulario').text('Editar');
}

    var eliminarUsuario = document.getElementById('EliminarUsuario');

    eliminarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = eliminarUsuario.querySelector('.id_producto_2')

    idModal.value = id;
})

$(function() {
    'use strict';

    var table = $('#productos').DataTable({
        processing: true,
        serverSide: true,
        "aLengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        ajax: '/consultatableproductos',
        "language": {
            "lengthMenu": "Mostrar  _MENU_  registros por paginas",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles.",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            }
        },
        "columnDefs": [
            {
                targets: [1],
                orderable: false
            }
        ]
    });

    table.on('draw.dt', function() {
        $('[data-bs-toggle="popover"]').popover();
    });

});

</script>
@endpush
