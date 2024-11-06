<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Biselados</title>
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
                        <td colspan="7">
                            <h3 class="text-uppercase m0">
                                ZOLUX 
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                        </td>
                    </tr>
                    <tr >
                        <th colspan="8">REPORTE DE BISELADOS</th>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td class="w-25">Desde:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaInicio2))}} </td>
                        <td class="w-25">Hasta:</td>
                        <td class="w-25">{{date("d-m-Y ",strtotime($fechaFin2))}} </td>
                    </tr>
                    <tr>
                        <td class="w-25">Maquina:</td>
                        <td class="w-25">{{$maquina2?->nombre}} </td>
                        <td class="w-25">Trabajador:</td>
                        <td class="w-25">{{$trabajador2?->nombre}} </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <th>Trabajo Nº</th>
                        <th>Fecha</th>
                        <th>Maquina</th>
                        <th>Trabajador</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                    </tr>
                    @foreach ($trabajos as $trabajo)
                        <tr>
                            <td>TRABAJO Nº {{ $trabajo->numero}}</td>
                            <td>{{ $trabajo->fecha }}</td>
                            <td>{{ $trabajo->nombremaquina}}</td>
                            <td>{{ $trabajo->nombreuser }}</td>
                            <td>{{ $trabajo->nombrecliente}}</td>
                            <td>{{ $trabajo->nombrevendedor }}</td>
                            <td>{{ $trabajo->cantidad}}</td>
                            <td>{{ $trabajo->producto }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">Total:</td>
                        <td>{{$trabajos->sum('cantidad')}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
