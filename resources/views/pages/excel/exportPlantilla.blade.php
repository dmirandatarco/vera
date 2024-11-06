<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plantilla</title>
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
                            @foreach ($productos as $i => $producto)

                                @foreach ($producto as $j => $prod )
                                <tr>
                                    <td>{{ $prod->serie->nombre }}</td>
                                    <td>{{ $prod->nombre }}</td>
                                    <td>{{ $prod->categoria->abreviatura }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
