@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<!-- container -->
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Listado de Roles</span>
        </div>
        <div class="justify-content-center mt-2">
          @can('role.create')
            <a href="{{ route('roles.create')}}">
                <button type="button" class="btn btn-primary mb-2 mb-md-0">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" class="fa fa-plus-circle"></i><b> &nbsp; Crear Role</b>
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
            <table id="usuarios" class="table table-hover">
              <thead>
                <tr >
                  <th>Numero</th>
                  <th>Nombre</th>
                  <th ></th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                @foreach($roles as $role)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$role->name}}</td>
                  <td>
                    @can('role.edit')
                      <a href="{{ route('roles.edit',$role) }}">
                      <button type="submit" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-title="Editar"><i class="fa fa-edit"></i></button> </a>
                    @endcan
                  </td>
                  <td>
                    @can('role.destroy')
                    <form action="{{ route('roles.destroy',$role) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-icon" data-bs-toggle="tooltip" data-bs-title="Desactivar"><i class="fa fa-trash"></i></button>
                    </form>
                    @endcan
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

@endsection

@push('plugin-scripts')
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
<script>

$(function() {
  'use strict';

  $(function() {
    $('#usuarios').DataTable({
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
          targets: [2,3],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
