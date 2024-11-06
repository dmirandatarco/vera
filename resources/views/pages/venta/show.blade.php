@extends('layout.master')
@push('plugin-styles')
@endpush
@section('content')
<div class="main-container container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="row row-sm">
		<div class="col-lg-12 col-md-12">
			<div class="card custom-card">
				<div class="card-body">
					<div class="d-lg-flex">

					</div>
					<div class="row row-sm">
						<div class="col-lg-6">
							<p class="h3">Movimiento N°: {{$movimiento->id}}</p>
							<address>
								<b>Movimiento de:</b>{{ $movimiento->tipo->nombre }} <br>
								<b>Factura de:</b>{{ $movimiento->tipo_doc }} {{ $movimiento->nume_doc }} <br>
							</address>
						</div>
						<div class="col-lg-6 text-end">
							<address>
								<b>Sucursal:</b> {{ $movimiento->sucursal->nombre }}<br>
								<b>Almacen:</b> {{ $movimiento->almacen->nombre }}<br>
								<b>Usuario:</b> {{ $movimiento->user->nombre }} {{ $movimiento->user->apellido }}<br>
								<b>Proveedor:</b> {{ $movimiento->proveedor_id }}<br>
							</address>
							<div class="">
								<p class="mb-1"><span class="font-weight-bold">Fecha de Movimiento:</span></p>
									<address>
									{{ $movimiento->fecha }}
									</address>
							</div>
						</div>
					</div>
					<div class="table-responsive mg-t-40">
						<table class="table table-invoice table-bordered">
							<thead>
								<tr>
									<th class="wd-20p">N°</th>
									<th class="wd-40p">Producto</th>
									<th class="wd-20p">Cantidad</th>
									<th class="tx-right">Precio</th>
									<th class="tx-right">Estado</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($detall as $i => $d )
									<tr>
										<td>{{++$i}}</td>
										<td class="tx-12">{{$d->producto->categoria->abreviatura}} {{$d->producto->nombre}}</td>
										<td class="tx-center">{{ $d->cantidad }}</td>
										<td class="tx-right">{{$d->precio}}</td>
										<td class="tx-right">{{$d->estado ? 'Activo' : 'Anulado'}}</td>
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
@endsection
