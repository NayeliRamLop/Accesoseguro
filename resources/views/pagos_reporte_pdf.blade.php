<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de pagos</title>
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
    <h1>Reporte de pagos</h1>

    <div class="resumen">
        <strong>Fecha de generacion:</strong> {{ $fechaGenerado }}<br>
        <strong>Total de pagos:</strong> {{ $totalPagos }}<br>
        <strong>Total monto:</strong> ${{ number_format($totalMonto, 2) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Número de tarjeta</th>
                <th>Titular</th>
                <th>Fecha de expiracion</th>
                <th>Monto</th>
                <th>Fecha de compra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                @php
                    $num = $pago->numeroTarjeta;
                    $masked = $num
                        ? str_repeat('*', max(0, strlen($num) - 4)) . substr($num, -4)
                        : '-';
                @endphp
                <tr>
                    <td>{{ $masked }}</td>
                    <td>{{ $pago->titularTarjeta }}</td>
                    <td>{{ $pago->fechaExpiracion }}</td>
                    <td>${{ number_format($pago->monto, 2) }}</td>
                    <td>{{ $pago->fechaCompra }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
