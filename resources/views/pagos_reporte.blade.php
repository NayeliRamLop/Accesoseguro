{{-- resources/views/pagos_reporte.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reporte de pagos')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

{{-- CSS para que las flechas de paginación no salgan gigantes --}}
@section('css')
    <style>
        nav[aria-label="Pagination Navigation"] svg {
            width: 16px !important;
            height: 16px !important;
        }
    </style>
@endsection

@section('content_header')
    <h1>Reporte de pagos</h1>
@stop

@section('content')
    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver a Ventas
        </a>
    </div>

    {{-- Filtros --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form class="form-inline" method="GET" action="{{ route('pagos.reporte') }}">
                <div class="form-group mr-2 mb-2">
                    <label for="desde" class="mr-1">Desde:</label>
                    <input type="date" name="desde" id="desde" class="form-control"
                           value="{{ $desde }}">
                </div>

                <div class="form-group mr-2 mb-2">
                    <label for="hasta" class="mr-1">Hasta:</label>
                    <input type="date" name="hasta" id="hasta" class="form-control"
                           value="{{ $hasta }}">
                </div>

                <button type="submit" class="btn btn-primary mb-2 mr-2">
                    Aplicar filtros
                </button>

                <a href="{{ route('pagos.reporte') }}" class="btn btn-outline-secondary mb-2 mr-2">
                    Quitar filtros
                </a>

                {{-- Botón PDF respetando filtros --}}
                <a href="{{ route('pagos.reporte.pdf', request()->query()) }}"
                   class="btn btn-danger mb-2">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </form>
        </div>
    </div>

    {{-- Resumen --}}
    <div class="mt-3 mb-2">
        <strong>Total de pagos:</strong> {{ $totalPagos }}<br>
        <strong>Total monto:</strong> ${{ number_format($totalMonto, 2) }}
    </div>

    {{-- Tabla de pagos --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
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
                    @forelse($pagos as $pago)
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
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No hay pagos con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pagos instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer clearfix">
                {{ $pagos
                    ->appends(['desde' => $desde, 'hasta' => $hasta])
                    ->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
