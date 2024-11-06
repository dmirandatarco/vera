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
                            20602583474
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
                        <td class="w-25"> </td>
                        <td class="w-25"> </td>
                    </tr>

                    <tr>
                        <td class="w-25">Cliente:</td>
                        <td class="w-25">{{$searchCliente2}} </td>
                        <td class="w-25">Documento:</td>
                        <td class="w-25">{{$searchDocumento2}} </td>
                        <td class="w-25">Nº:</td>
                        <td class="w-25">{{$nume_documento2}} </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Tipo doc.</th>
                        <th>Numero</th>
                        <th>F. Emisión</th>
                        <th>F. Vencimiento</th>
                        <th>Doc. Afectado</th>
                        <th># Guia</th>
                        <th>Cotización</th>
                        <th>Caso</th>
                        <th>Dist.</th>
                        <th>Dpto.</th>
                        <th>Prov.</th>
                        <th>Dirección</th>
                        <th>Cliente</th>
                        <th>RUC</th>
                        <th>Estado</th>
                        <th>Moneda</th>
                        <th>Forma pago</th>
                        <th>Método de Pago</th>
                        <th>TC</th>
                        <th>Total Cargos</th>
                        <th>Total Exonerado</th>
                        <th>Total Inafecto</th>
                        <th>Total Gratuito</th>
                        <th>Total Gravado</th>
                        <th>Descuento</th>
                        <th>Total IGV</th>
                        <th>Total ISC</th>
                        <th>Total</th>
                        <th>Total Productos</th>
                    </tr>
                    @foreach ($ventas as $i => $venta)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$venta->user?->nombre}}</td>
                            <td>{{$venta->documento?->codSunat}}</td>
                            <td>{{$venta->documento?->serie}}-{{$venta->nume_doc}}</td>
                            <td>{{date("Y-m-d",strtotime($venta->fecha))}}</td>
                            <td>{{date("Y-m-d",strtotime($venta->fecha))}}</td>
                            <td>{{$venta->venta?->documento?->serie}}-{{$venta->venta?->nume_doc}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Cusco</td>
                            <td>Cusco</td>
                            <td>Cusco</td>
                            <td>{{$venta->cliente?->direccion}}</td>
                            <td>{{$venta->cliente?->razon_social}}</td>
                            <td>{{$venta->cliente?->num_documento}}</td>
                            <td>{{ $venta->sunat == 1 ? 'Aceptado' : ($venta->sunat == 2 ? 'Anulado' : 'Rechazado') }}</td>
                            <td>PEN</td>
                            <td>CONTADO</td>
                            <td>EFECTIVO</td>
                            <td>1</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>{{number_format($venta->total/1.18,2, '.', '')}}</td>
                            <td>0</td>
                            <td>{{number_format(($venta->total/1.18)*0.18,2, '.', '')}}</td>
                            <td>0</td>
                            <td>{{$venta->total}}</td>
                            <td>{{$venta->detallesVenta()->sum('cantidad')}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="21" style="text-align: right;">TOTALES</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <th>{{number_format($ventas->sum('total')/1.18,2, '.', '')}}</th>
                        <th>0</th>
                        <th>{{number_format(($ventas->sum('total')/1.18)*0.18,2, '.', '')}}</th>
                        <td>0</td>
                        <th>{{number_format($ventas->sum('total'),2, '.', '')}}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
