<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas </title>
    <style>
    </style>
</head>
<body>
<div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="row">
            <div class="table-responsive" >
            <table  class="table table-bordered table-striped table-sm">
                <tbody>
                    <tr>
                        <td rowspan="2">

                        </td>
                        <td colspan="9">
                            <h3 class="text-uppercase m0">
                                ZOLUX 
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9">
                        </td>
                    </tr>
                    <tr >
                        <th colspan="10">REPORTE DE VENTAS</th>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td class="w-25">Desde:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaInicio2))}} </td>
                        <td class="w-25">Hasta:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaFin2))}} </td>
                        <td class="w-25">Usuario: </td>
                        <td class="w-25">{{$searchResponsable2}} </td>
                    </tr>

                    <tr>
                        <td class="w-25">Cliente:</td>
                        <td class="w-25">{{$searchCliente2}} </td>
                        <td class="w-25">Documento:</td>
                        <td class="w-25">{{$searchDocumento2}} </td>
                        <td class="w-25">Estado de Pago:</td>
                        <td class="w-25">{{$nume_documento2}} </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <th>Pago</th>
                        <th>Cliente</th>
                        <th>Comprobante</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Sucursal</th>
                        <th>Estado Pago</th>
                    </tr>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->pago == 1 ? 'CONTADO':'CREDITO' }}</td>
                            <td>{{ $venta->cliente?->nombre_comercial }}</td>
                            <td>{{ $venta->documento->nombre }} {{ $venta->nume_doc }}</td>
                            <td>{{ $venta->fecha }}</td>
                            <td>{{ $venta->estado ? 'Registrado' : 'Anulado' }}</td>
                            <td>{{ $venta->total }}</td>
                            <td>{{ $venta->acuenta }}</td>
                            <td>{{ $venta->saldo }}</td>
                            <td>{{ $venta->sucursal->nombre }}</td>
                            <td>{{ $venta->estadoPagado ? 'Cancelado' : 'Pendiente' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align: right;">Totales</th>
                        <th>{{number_format($ventas->sum('total'),2)}}</th>
                        <th>{{number_format($ventas->sum('acuenta'),2)}}</th>
                        <th>{{number_format($ventas->sum('saldo'),2)}}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
