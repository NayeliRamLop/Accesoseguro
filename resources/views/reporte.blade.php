{{-- resources/views/reporte.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reporte de boletos')

{{-- CSS solo para este reporte --}}
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@section('css')
    <style>
        /* Por si alguna otra paginación mete SVG, aquí los limitamos */
        nav[aria-label="Pagination Navigation"] svg {
            width: 16px !important;
            height: 16px !important;
        }
    </style>
@endsection

@section('content_header')
    <h1>Reporte de boletos</h1>
@stop

@section('content')
    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ route('boletos.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver a boletos
        </a>
    </div>

    {{-- Filtros --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form class="form-inline" method="GET" action="{{ route('boletos.reporte') }}">
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

                <div class="form-group mr-2 mb-2">
                    <label for="estado" class="mr-1">Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="" {{ $estado === null || $estado === '' ? 'selected' : '' }}>
                            Todos
                        </option>
                        <option value="1" {{ $estado === '1' ? 'selected' : '' }}>
                            Escaneados
                        </option>
                        <option value="0" {{ $estado === '0' ? 'selected' : '' }}>
                            No escaneados
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2 mr-2">
                    Aplicar filtros
                </button>

                <a href="{{ route('boletos.reporte') }}" class="btn btn-outline-secondary mb-2 mr-2">
                    Quitar filtros
                </a>

                {{-- Botón PDF que respeta los filtros actuales --}}
                <a href="{{ route('boletos.reporte.pdf', request()->query()) }}"
                   class="btn btn-danger mb-2">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </form>
        </div>
    </div>

    {{-- Resumen --}}
    <div class="mt-3 mb-2">
        <strong>Total de boletos:</strong> {{ $totalBoletos }}<br>
        <strong>Total monto:</strong> ${{ number_format($totalMonto, 2) }}
    </div>

    {{-- Tabla de boletos --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
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
                    @forelse($boletos as $boleto)
                        <tr>
                            <td>{{ optional($boleto->evento)->titulo }}</td>
                            <td>
                                {{ optional($boleto->usuario)->nombre }}
                                {{ optional($boleto->usuario)->apellidos }}
                            </td>
                            <td>{{ $boleto->cantidad }}</td>
                            <td>${{ number_format($boleto->precioTotal, 2) }}</td>
                            <td>{{ optional($boleto->pago)->fechaCompra ?? '-' }}</td>
                            <td>
                                @if($boleto->estaUsado)
                                    <span class="badge badge-success">Escaneado</span>
                                @else
                                    <span class="badge badge-secondary">No escaneado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No hay boletos con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($boletos instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer clearfix">
               
                {{ $boletos
                    ->appends(['desde' => $desde, 'hasta' => $hasta, 'estado' => $estado])
                    ->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
