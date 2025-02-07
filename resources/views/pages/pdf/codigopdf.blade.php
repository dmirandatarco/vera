<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Barra</title>
    <style>
        @page {
            size: 108mm 34.3mm; /* Tamaño de la página para 3 etiquetas horizontales */
            margin: 0;
            margin-left: 3.5mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 0;
            margin: 0;
            width: 34.5mm;
            height: 21.4mm;
            text-align: center;
            padding-left: 2px;
        }
        .codigo-barra img {
            max-width: 34.4mm;
            max-height: 21.4mm;
        }
        .codigo-barra-salto {
            page-break-before: always; /* Salto de página después de cada 3 etiquetas */
        }
    </style>
</head>
<body>
    @for ($i = 0; $i < $cantidad; $i++)
        @if ($i % 3 == 0 && $i > 0)
            <!-- Agregar salto de página después de cada 3 etiquetas -->
            <div class="codigo-barra-salto"></div>
        @endif
        <table>
            <tr>
                <td>
                    <div class="codigo-barra">
                        <h2>{{ $producto->nombre }}</h2>
                        <div>
                            <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Código de barras" style="width: 87px;height:35px;">
                        </div>
                        <h1 style="font-size: 8px;">C: {{ $producto->codigo }} / {{ $producto->precio }}</h1>
                    </div>
                </td>
                <td>
                    <div class="codigo-barra">
                        <h2>{{ $producto->nombre }}</h2>
                        <div>
                            <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Código de barras" style="width: 87px;height:35px;">
                        </div>
                        <h1 style="font-size: 8px;">C: {{ $producto->codigo }} / {{ $producto->precio }}</h1>
                    </div>
                </td>
                <td>
                    <div class="codigo-barra">
                        <h2>{{ $producto->nombre }}</h2>
                        <div>
                            <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Código de barras" style="width: 87px;height:35px;">
                        </div>
                        <h1 style="font-size: 8px;">C: {{ $producto->codigo }} / {{ $producto->precio }}</h1>
                    </div>
                </td>
            </tr>
        </table>
    @endfor
</body>
</html>