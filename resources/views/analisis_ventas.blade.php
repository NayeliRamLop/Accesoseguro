{{-- resources/views/analisis_ventas.blade.php --}}
@extends('adminlte::page')

@section('title', 'Analisis de ventas')

@php
use App\Models\Pago;
use App\Models\Boleto;
use App\Models\Evento;

// leer filtros
$desde  = request('desde');
$hasta  = request('hasta');
$fuente = request('fuente'); // '', 'pagos', 'boletos'

// helper para aplicar rango de fechas sobre pago.fechaCompra
$applyDateRange = function ($query) use ($desde, $hasta) {
    if ($desde) {
        $query->whereDate('fechaCompra', '>=', $desde);
    }
    if ($hasta) {
        $query->whereDate('fechaCompra', '<=', $hasta);
    }
};

// ===================== METRICAS DE PAGOS (VENTAS) =====================

$pagosBase = Pago::query();
$applyDateRange($pagosBase);

// ventas por dia
$pagosPorDia = (clone $pagosBase)
    ->selectRaw('DATE(fechaCompra) as dia, SUM(monto) as total')
    ->groupBy('dia')
    ->orderBy('dia')
    ->get();

$labelsVentasDia = $pagosPorDia->pluck('dia')->map(function ($d) {
    return \Carbon\Carbon::parse($d)->format('Y-m-d');
})->values();

$datosVentasDia = $pagosPorDia->pluck('total')->values();

// totales y kpi
$totalVentas      = (clone $pagosBase)->sum('monto');
$totalPagos       = (clone $pagosBase)->count();

// dia con mayor venta
$diaMayorVentaRow = $pagosPorDia->sortByDesc('total')->first();
$diaMayorVenta    = $diaMayorVentaRow ? \Carbon\Carbon::parse($diaMayorVentaRow->dia)->format('Y-m-d') : null;
$montoMayorVenta  = $diaMayorVentaRow->total ?? 0;

// promedio diario (solo dias con venta)
$promedioDiario = 0;
if ($pagosPorDia->count() > 0) {
    $promedioDiario = round($totalVentas / $pagosPorDia->count(), 2);
}

// ventas por evento (para doughnut)
$ventasPorEvento = (clone $pagosBase)
    ->join('boleto', 'pago.boletoId', '=', 'boleto.id')
    ->join('evento', 'boleto.eventoId', '=', 'evento.id')
    ->selectRaw('evento.titulo as evento, SUM(pago.monto) as total')
    ->groupBy('evento')
    ->orderByDesc('total')
    ->get();

$labelsVentasEvento = $ventasPorEvento->pluck('evento')->values();
$datosVentasEvento  = $ventasPorEvento->pluck('total')->values();

// ===================== METRICAS DE BOLETOS =====================

$boletosBase = Boleto::join('pago', 'boleto.id', '=', 'pago.boletoId')
    ->join('evento', 'boleto.eventoId', '=', 'evento.id');

$applyDateRange($boletosBase);

// agregados por evento
$boletosAgg = (clone $boletosBase)
    ->selectRaw("
        evento.titulo as evento,
        SUM(boleto.cantidad) as vendidos,
        SUM(CASE WHEN boleto.estaUsado = 1 THEN boleto.cantidad ELSE 0 END) as escaneados
    ")
    ->groupBy('evento.titulo')
    ->orderByDesc('vendidos')
    ->get();

$labelsBoletosEvento      = $boletosAgg->pluck('evento')->values();
$datosBoletosVendidos     = $boletosAgg->pluck('vendidos')->values();
$datosBoletosEscaneados   = $boletosAgg->pluck('escaneados')->values();

$totalBoletosVendidos   = $boletosAgg->sum('vendidos');
$totalBoletosEscaneados = $boletosAgg->sum('escaneados');

$tasaUsoBoletos = 0;
if ($totalBoletosVendidos > 0) {
    $tasaUsoBoletos = round(($totalBoletosEscaneados / $totalBoletosVendidos) * 100, 1);
}

// evento con mas boletos vendidos
$eventoMasVendidos          = $boletosAgg->first();
$nombreEventoMasVendidos    = $eventoMasVendidos->evento ?? null;
$cantidadEventoMasVendidos  = $eventoMasVendidos->vendidos ?? 0;

// evento con menor porcentaje de uso
$eventoMenorUso = null;
$menorRatio     = null;

foreach ($boletosAgg as $row) {
    if ($row->vendidos <= 0) {
        continue;
    }
    $ratio = $row->escaneados / $row->vendidos;
    if ($menorRatio === null || $ratio < $menorRatio) {
        $menorRatio = $ratio;
        $eventoMenorUso = $row;
    }
}

$nombreEventoMenorUso  = $eventoMenorUso->evento ?? null;
$porcentajeEventoMenorUso = $eventoMenorUso && $eventoMenorUso->vendidos > 0
    ? round(($eventoMenorUso->escaneados / $eventoMenorUso->vendidos) * 100, 1)
    : null;

@endphp

@section('css')
<style>
body,
.content-wrapper,
.main-footer {
    background-color: #e4e3e5 !important;
    color: #373737 !important;
}

.card {
    background-color: #ffffff !important;
    border: 1px solid #ddd !important;
}

.card-header {
    background-color: #f4f4f4 !important;
    border-bottom: 1px solid #ddd !important;
}

.badge-metric {
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 999px;
}
</style>
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><b>Analisis de ventas</b></h1>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al dashboard
        </a>
    </div>
@endsection

@section('content')

    {{-- FILTROS --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('/analisis-ventas') }}" class="form-inline">
                <div class="form-group mr-3 mb-2">
                    <label for="desde" class="mr-2">Fecha desde</label>
                    <input type="date"
                           name="desde"
                           id="desde"
                           class="form-control"
                           value="{{ $desde }}">
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="hasta" class="mr-2">Fecha hasta</label>
                    <input type="date"
                           name="hasta"
                           id="hasta"
                           class="form-control"
                           value="{{ $hasta }}">
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="fuente" class="mr-2">Fuente de datos</label>
                    <select name="fuente" id="fuente" class="form-control">
                        <option value="" {{ $fuente == '' ? 'selected' : '' }}>Boletos y pagos</option>
                        <option value="pagos" {{ $fuente == 'pagos' ? 'selected' : '' }}>Pagos (ventas)</option>
                        <option value="boletos" {{ $fuente == 'boletos' ? 'selected' : '' }}>Boletos</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fas fa-search"></i> Aplicar filtros
                </button>

                <a href="{{ url('/analisis-ventas') }}" class="btn btn-outline-secondary mb-2 ml-2">
                    Limpiar
                </a>
            </form>
        </div>
    </div>

    {{-- KPI DE VENTAS (PAGOS) --}}
    @if ($fuente === '' || $fuente === null || $fuente === 'pagos')
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-primary text-white">Total ventas</span>
                        <h3 class="mt-2 mb-1">${{ number_format($totalVentas, 2) }}</h3>
                        <small>Monto total en el periodo seleccionado</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-success text-white">Pagos</span>
                        <h3 class="mt-2 mb-1">{{ $totalPagos }}</h3>
                        <small>Pagos registrados en el periodo</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-info text-white">Dia con mayor venta</span>
                        <h3 class="mt-2 mb-1">
                            @if ($diaMayorVenta)
                                {{ $diaMayorVenta }}
                            @else
                                Sin datos
                            @endif
                        </h3>
                        <small>Monto: ${{ number_format($montoMayorVenta, 2) }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-warning text-white">Promedio diario</span>
                        <h3 class="mt-2 mb-1">${{ number_format($promedioDiario, 2) }}</h3>
                        <small>Promedio de ventas por dia con movimiento</small>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- KPI DE BOLETOS --}}
    @if ($fuente === '' || $fuente === null || $fuente === 'boletos')
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-primary text-white">Boletos vendidos</span>
                        <h3 class="mt-2 mb-1">{{ $totalBoletosVendidos }}</h3>
                        <small>Total de boletos vendidos en el periodo</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-success text-white">Boletos escaneados</span>
                        <h3 class="mt-2 mb-1">{{ $totalBoletosEscaneados }}</h3>
                        <small>Boletos marcados como usados</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-info text-white">Uso de boletos</span>
                        <h3 class="mt-2 mb-1">{{ $tasaUsoBoletos }} %</h3>
                        <small>Porcentaje de boletos usados vs vendidos</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-metric bg-warning text-white">Evento destacado</span>
                        <h3 class="mt-2 mb-1">
                            @if ($nombreEventoMasVendidos)
                                {{ $nombreEventoMasVendidos }}
                            @else
                                Sin datos
                            @endif
                        </h3>
                        <small>Boletos vendidos: {{ $cantidadEventoMasVendidos }}</small>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- GRAFICAS DE VENTAS --}}
    @if ($fuente === '' || $fuente === null || $fuente === 'pagos')
        <div class="card mb-4" style="height: 420px;">
            <div class="card-header">
                <h3 class="card-title">Ventas por dia</h3>
            </div>
            <div class="card-body">
                <div style="height: 360px;">
                    <canvas id="chartVentasDia"></canvas>
                </div>
            </div>
        </div>

        <div class="card mb-4" style="height: 360px;">
            <div class="card-header">
                <h3 class="card-title">Distribucion de ventas por evento</h3>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="chartVentasEvento"></canvas>
                </div>
            </div>
        </div>
    @endif

    {{-- GRAFICAS DE BOLETOS --}}
    @if ($fuente === '' || $fuente === null || $fuente === 'boletos')
        <div class="card mb-4" style="height: 420px;">
            <div class="card-header">
                <h3 class="card-title">Boletos vendidos por evento</h3>
            </div>
            <div class="card-body">
                <div style="height: 360px;">
                    <canvas id="chartBoletosEvento"></canvas>
                </div>
            </div>
        </div>

        <div class="card mb-4" style="height: 420px;">
            <div class="card-header">
                <h3 class="card-title">Vendidos vs escaneados por evento</h3>
            </div>
            <div class="card-body">
                <div style="height: 360px;">
                    <canvas id="chartBoletosVendidosEscaneados"></canvas>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fuente = @json($fuente ?? '');

    // ventas por dia
    if (fuente === '' || fuente === null || fuente === 'pagos') {
        const ctxVentasDia = document.getElementById('chartVentasDia');
        if (ctxVentasDia) {
            new Chart(ctxVentasDia.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($labelsVentasDia),
                    datasets: [{
                        label: 'Ventas por dia',
                        data: @json($datosVentasDia),
                        borderWidth: 2,
                        fill: false,
                        tension: 0.25
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const ctxVentasEvento = document.getElementById('chartVentasEvento');
        if (ctxVentasEvento) {
            new Chart(ctxVentasEvento.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json($labelsVentasEvento),
                    datasets: [{
                        data: @json($datosVentasEvento),
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    }

    // boletos por evento
    if (fuente === '' || fuente === null || fuente === 'boletos') {
        const ctxBoletosEvento = document.getElementById('chartBoletosEvento');
        if (ctxBoletosEvento) {
            new Chart(ctxBoletosEvento.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($labelsBoletosEvento),
                    datasets: [{
                        label: 'Boletos vendidos',
                        data: @json($datosBoletosVendidos),
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const ctxBoletosVE = document.getElementById('chartBoletosVendidosEscaneados');
        if (ctxBoletosVE) {
            new Chart(ctxBoletosVE.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($labelsBoletosEvento),
                    datasets: [
                        {
                            label: 'Vendidos',
                            data: @json($datosBoletosVendidos),
                            borderWidth: 1
                        },
                        {
                            label: 'Escaneados',
                            data: @json($datosBoletosEscaneados),
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
});
</script>
@endsection
