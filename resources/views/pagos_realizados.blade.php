{{-- resources/views/pagos_realizados.blade.php --}}
@extends('adminlte::page')

@section('title', 'Pagos realizados')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pagos realizados</h1>

        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Ventas
        </a>
    </div>
@stop

@section('content')
    {{-- Filtros --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filtro por fecha de compra</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pagos.realizados') }}" class="form-inline">
                <div class="form-group mr-2 mb-2">
                    <label for="desde" class="mr-2">Desde:</label>
                    <input type="date" name="desde" id="desde" class="form-control"
                           value="{{ $desde }}">
                </div>

                <div class="form-group mr-2 mb-2">
                    <label for="hasta" class="mr-2">Hasta:</label>
                    <input type="date" name="hasta" id="hasta" class="form-control"
                           value="{{ $hasta }}">
                </div>

                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fas fa-search"></i> Buscar
                </button>

                <a href="{{ route('pagos.realizados') }}" class="btn btn-outline-secondary mb-2 ml-2">
                    Limpiar filtros
                </a>
            </form>
        </div>
    </div>

    {{-- Resumen --}}
    <div class="mt-3 mb-2">
        <strong>Total monto (página actual):</strong>
        ${{ number_format($totalMonto, 2) }}
    </div>

    {{-- Tabla --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de pagos realizados</h3>
        </div>
        <div class="card-body">
            @if ($pagos->isEmpty())
                <p>No se encontraron pagos con el filtro seleccionado.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Número de tarjeta</th>
                            <th>Titular</th>
                            <th>Fecha de expiración</th>
                            <th>Monto</th>
                            <th>Fecha de compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            @php
                                $num = $pago->numeroTarjeta;
                                $masked = $num
                                    ? str_repeat('*', max(0, strlen($num) - 4)) . substr($num, -4)
                                    : '-';
                            @endphp
                            <tr>
                                {{-- NO mostramos ID, solo tarjeta enmascarada --}}
                                <td>{{ $masked }}</td>
                                <td>{{ $pago->titularTarjeta }}</td>
                                <td>{{ $pago->fechaExpiracion }}</td>
                                <td>${{ number_format($pago->monto, 2) }}</td>
                                <td>{{ $pago->fechaCompra }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Paginación con Bootstrap --}}
                {{ $pagos->appends([
                    'desde' => $desde,
                    'hasta' => $hasta,
                ])->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
@stop
