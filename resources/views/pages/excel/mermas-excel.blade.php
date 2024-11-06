<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Mermas</title>
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
                        <td colspan="5">
                            <h3 class="text-uppercase m0">
                                ZOLUX 
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        </td>
                    </tr>
                    <tr >
                        <th colspan="6">REPORTE DE MERMAS</th>
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
                        <th>Fecha</th>
                        <th>Trabajo</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                    </tr>
                    @foreach($mermas as $merma)
                        <tr>
                            <td>{{$merma->fecha}}</td>
                            <td>{{ $merma->trabajo ? "Trabajo N°" . $merma->trabajo->id : 'N/A' }}</td>
                            <td>{{$merma->producto->nombre}} {{$merma->producto->categoria->abreviatura}}</td>
                            <td>{{$merma->cliente?->nombre_comercial ?? 'SIN CLIENTE'}}</td>
                            <td>{{$merma->descripcion}}</td>
                            <td>{{$merma->estado ? 'Activo':'Inactivo'}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
