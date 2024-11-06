<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Balance por Cliente</title>
    <style>
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="row">
                <div class="table-responsive">



                    <table class="table table-bordered table-striped table-sm">
                        <thead>

                            <tr>
                                <th>Serie</th>
                                <th>Talla</th>
                                <th>Categoria</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($movimiento->detalles as $detalle )
                                    <tr>
                                        <td>{{$detalle->producto->serie->nombre}}</td>
                                        <td>{{$detalle->producto->nombre}}</td>
                                        <td>{{$detalle->producto->categoria->nombre}}</td>
                                        <td>{{$detalle->cantidad}}</td>
                                        <td>{{$detalle->precio}}</td>
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
