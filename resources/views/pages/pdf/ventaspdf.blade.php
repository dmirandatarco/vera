<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.6rem;
            font-weight: normal;
            line-height: .05;
            color: #151b1e;
            writing-mode: tb-rl;
            size:landscape;
            width:100%;
            height:100%;
            TEXT-TRANSFORM:UPPERCASE;

        }

        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 0.3rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.05rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 1px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 1px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
            line-height: 1.6;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
            line-height: 1.6;
        }
        tbody {
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
            line-height: 1.6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        .resumen{
            page-break-inside: avoid;
        }
        .w-85
        {
            width: 85%;
        }
        .w-15
        {
            width: 85%;
        }
        .w-100{
            width: 100%;
        }

        .w-50{
            width: 100%;
        }
        .w-25{
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="row">
            <h3 style="text-align:center; font-size:15px"> Reporte de Ventas</h3>
            <table class="w-100">
                <tr>
                    <td class="w-85">
                        <table class="w-100">
                            <tr>
                                <td class="w-25"><b>Desde:</b> </td>
                                <td class="w-25">{{date("d-m-Y ",strtotime($fechaInicio2))}} </td>
                                <td class="w-25"><b>Hasta:</b> </td>
                                <td class="w-25">{{date("d-m-Y ",strtotime($fechaFin2))}} </td>
                            </tr>
                            <tr>
                                <td class="w-25"><b>Documento:</b> </td>
                                <td class="w-25">{{$searchDocumento2}} </td>
                                <td class="w-25"><b>Estado de Pago:</b> </td>
                                <td class="w-25">{{$nume_documento2}} </td>
                            </tr>
                            <tr>
                                <td class="w-25"><b>Cliente:</b> </td>
                                <td class="w-25">{{$searchCliente2}} </td>
                                <td class="w-25"><b>Usuario:</b> </td>
                                <td class="w-25">{{$searchResponsable2}} </td>
                            </tr>
                        </table>
                    </td>
                    <td class="w-15">
                        <img class="derecha" style="padding-top:0; margin-top:0; margin-right:1rem;" src="{{ asset('img/brand/logo.png')}}"  width="205px"  alt="admin@bootstrapmaster.com">
                    </td>
                </tr>
            </table>
            <div class="card-body">
                    <div style="overflow-x:auto;">
                            <div class="table-responsive" >
                                <table id="egresos" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr style="background-color: #ffe464; color:#ffffff; font-size:12px ">
                                            <th>#</th>
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
                                    </thead>
                                    <tbody>
                                        @foreach ($ventas as $venta)
                                            <tr>
                                                <td>{{ ++$i }}</td>
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
                                            <th colspan="6" style="text-align: right;">Totales</th>
                                            <th>{{number_format($ventas->sum('total'),2)}}</th>
                                            <th>{{number_format($ventas->sum('acuenta'),2)}}</th>
                                            <th>{{number_format($ventas->sum('saldo'),2)}}</th>
                                            <th colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
