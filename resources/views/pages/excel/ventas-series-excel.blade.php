<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas por Series</title>
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
                        <td colspan="2">
                            <h3 class="text-uppercase m0">
                                ZOLUX 
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        </td>
                    </tr>
                    <tr >
                        <th colspan="3">REPORTE DE VENTAS POR SERIE</th>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td class="w-25">Desde:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaInicio2))}} </td>
                    </tr>
                    <tr>
                        <td class="w-25">Hasta:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaFin2))}} </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Serie</th>
                        <th>Cantidad</th>
                    </tr>
                    @foreach ($ventas as $i => $venta)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{ $venta->serie}}</td>
                            <td>{{ $venta->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total:</th>
                        <th>{{$ventas->sum('cantidad')}}</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
