<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas por Productos</title>
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
                        <th>Serie</th>
                        <th>Talla</th>
                        <th>Categoria</th>
                        <th>Cantidad</th>
                    </tr>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->serie}}</td>
                            <td>{{ $venta->nombre }}</td>
                            <td>{{ $venta->categoria}}</td>
                            <td>{{ $venta->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total:</th>
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
