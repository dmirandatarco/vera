@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Sucursales</span>
      </div>
      <div class="justify-content-center mt-2">
        @can('sucursal.create')
          <button type="button" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
            <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Sucursal</b>
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
      <div class="col-lg-{{(Gate::check('sucursal.create') || Gate::check('sucursal.edit')) ? '8':'12'}} col-md-{{(Gate::check('sucursal.create') || Gate::check('sucursal.edit')) ? '8':'12'}}">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="sucursals" class="table table-hover">
                <thead>
                  <tr >
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sucursales as $sucursal)
                  <tr>
                    <td>{{++$i}}</td>
                    <td>{{$sucursal->nombre}}</td>
                    <td>{{$sucursal->estado ? 'Activo':'Inactivo'}}</td>
                    <td>
                      <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-settings"></i>
                      </button>
                        <ul class="dropdown-menu"> 
                          @can('sucursal.edit')
                            <li><a class="dropdown-item" onclick="editar('{{$sucursal->id}}','{{$sucursal->nombre}}')">Editar</a></li>
                          @endcan
                          @can('sucursal.destroy')
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$sucursal->id}}">Eliminar</a></li>
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
      @if( Gate::check('sucursal.create') || Gate::check('sucursal.edit'))
        <div class="col-lg-4 col-md-4" id="crear-formulario">
          <div class="card">
            <div class="card-body">
              <h4 id="text-formulario"></h2>
              <form action="{{route('sucursal.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3 col-md-12">
                  <input type="hidden" name="id" id="id" value="{{old('id')}}">
                  <label for="nombre" class="form-label">Nombre:</label>
                  <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre')}}" >
                  @error('nombre')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary me-2" id="boton-formulario"></button> 
              </div>
            </form>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
<!-- /Container -->
<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Cambiar Estado de Sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('sucursal.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>¿Estás seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="id_sucursal_2" class="id_sucursal_2">
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
@if(count($errors)>0)
<script>
  $('#crear-formulario').show();
  if('{{old("id")}}'){
    $(function() {
      $('#text-formulario').text('Editar Sucursal');
      $('#boton-formulario').text('Editar');
    });
  }else{
    $(function() {
      $('#text-formulario').text('Crear Sucursal');
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
function agregar() {
  $('#crear-formulario').show();
  $('#text-formulario').text('Crear Sucursal');
  $('#id').val(null);
  $('#nombre').val(null).focus();
  $('#boton-formulario').text('Guardar');
}

function editar(id, nombre) {
  $('#crear-formulario').show();
  $('#text-formulario').text('Editar Sucursal');
  $('#id').val(id);
  $('#nombre').val(nombre).focus();
  $('#boton-formulario').text('Editar');
}

var eliminarUsuario = document.getElementById('EliminarUsuario');

eliminarUsuario.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget

  var id = button.getAttribute('data-id')

  var idModal = eliminarUsuario.querySelector('.id_sucursal_2')

  idModal.value = id;
})

$(function() {
  'use strict';

  $(function() {
    $('#sucursals').DataTable({
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
          targets: [3],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
