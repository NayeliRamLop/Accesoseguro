<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de boletos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h1 {
            text-align: center;
            margin-bottom: 10px;
        }
        .resumen {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #666;
            padding: 4px 6px;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h1>Reporte de boletos</h1>

    <div class="resumen">
        <strong>Fecha de generación:</strong> {{ $fechaGenerado }}<br>
        <strong>Total de boletos:</strong> {{ $totalBoletos }}<br>
        <strong>Total monto:</strong> ${{ number_format($totalMonto, 2) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Evento</th>
                <th>Usuario</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Fecha compra</th>
                <th>Escaneado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boletos as $boleto)
                <tr>
                    <td>{{ optional($boleto->evento)->titulo }}</td>
                    <td>{{ optional($boleto->usuario)->nombre }} {{ optional($boleto->usuario)->apellidos }}</td>
                    <td>{{ $boleto->cantidad }}</td>
                    <td>${{ number_format($boleto->precioTotal, 2) }}</td>
                    <td>{{ optional($boleto->pago)->fechaCompra ?? '-' }}</td>
                    <td>{{ $boleto->estaUsado ? 'Escaneado' : 'No escaneado' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
