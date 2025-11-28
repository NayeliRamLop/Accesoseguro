@extends('adminlte::page')

@section('title', 'Dashboard')

@php
    use App\Models\Pago;
    use App\Models\Boleto;

    // lista de anios disponibles en pagos
    $anios = Pago::selectRaw('DISTINCT YEAR(fechaCompra) as anio')
        ->orderBy('anio', 'desc')
        ->pluck('anio')
        ->toArray();

    // anio seleccionado (puede venir vacio = todos)
    $anioSeleccionado = request('anio');

    // query base filtrando por anio si se eligio alguno
    $statsQuery = Pago::join('boleto', 'pago.boletoId', '=', 'boleto.id');

    if (!empty($anioSeleccionado)) {
        $statsQuery->whereYear('fechaCompra', $anioSeleccionado);
    }

    // agregados por mes
    $stats = $statsQuery
        ->selectRaw('MONTH(fechaCompra) as mes, SUM(boleto.cantidad) as total_boletos, SUM(pago.monto) as total_ventas')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->keyBy('mes');

    // arreglos para los 12 meses
    $boletosPorMes = [];
    $ventasPorMes  = [];

    for ($m = 1; $m <= 12; $m++) {
        $row = $stats[$m] ?? null;
        $boletosPorMes[] = $row->total_boletos ?? 0;
        $ventasPorMes[]  = $row->total_ventas  ?? 0;
    }

    $totalBoletosAnual = array_sum($boletosPorMes);
    $totalVentasAnual  = array_sum($ventasPorMes);
    $maxVentaMes       = max($ventasPorMes ?: [0]);
@endphp

@section('css')
<style>
body,
.content-wrapper,
.main-footer {
    background-color: #e4e3e5 !important;
    color: #373737 !important;
}

.main-header.navbar {
    background-color: #575c9a !important;
    border-bottom: 1px solid #e4e4e4 !important;
}

.navbar-light .navbar-nav .nav-link,
.navbar-nav .nav-link {
    color: #ccc !important;
}

.navbar-nav .nav-link:hover {
    color: #fff !important;
}

.main-sidebar {
    background-color: #434485 !important;
}

.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
    background-color: #ffffff !important;
    color: #e7e5e5 !important;
    border-color: #ccc;
}

.nav-sidebar .nav-link {
    color: #ccc !important;
    border-color: #ccc;
}

.nav-sidebar .nav-link:hover {
    background-color: #a9a9a9 !important;
    color: #fff !important;
    border-color: #ccc;
}

.small-box {
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 0 15px rgba(142, 142, 142, 0.05);
}

.small-box.bg-primary {
    background: linear-gradient(135deg, #243c68, #2a5298) !important;
}

.small-box.bg-success {
    background: linear-gradient(135deg, #0f9b0f, #14cc60) !important;
}

.small-box.bg-info {
    background: linear-gradient(135deg, #0f7ea5, #14c0cc) !important;
}

.small-box.bg-warning {
    background: linear-gradient(135deg, #b8860b, #e8b923) !important;
}

.small-box-footer {
    color: #fff !important;
}

.card {
    background-color: #e5c9ff !important;
    color: #333333 !important;
    border: 1px solid #333 !important;
}

.card-header {
    background-color: #d6d9ff !important;
    border-bottom: 1px solid #646464 !important;
}

table {
    color: #e5c9ff !important;
}

.table thead {
    background-color: #888888 !important;
}

.table tbody tr {
    background-color: #8d8a8a !important;
}

.table tbody tr:hover {
    background-color: #959494 !important;
}

.btn {
    border-radius: 8px;
}

.btn-primary {
    background-color: #3d6df2 !important;
    border-color: #3d6df2 !important;
}

.btn-danger {
    background-color: #d93333 !important;
    border-color: #d93333 !important;
}

.form-control {
    background-color: #e8e8e8 !important;
    border: 1px solid #333 !important;
    color: #000000 !important;
}

.form-control:focus {
    background-color: #1c1c1c !important;
    border-color: #f4f4f4 !important;
    color: #fff !important;
}

::-webkit-scrollbar {
    width: 9px;
}
::-webkit-scrollbar-track {
    background: #111;
}
::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: #444;
}
</style>
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><b>Acceso seguro</b></h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesion
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <p>Bienvenido al panel de control.</p>
        </div>
    </div>

    <div id="assetCarousel" class="carousel slide mb-5" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/1.jpg') }}" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/2.jpg') }}" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/3.jpg') }}" class="d-block w-100" alt="Slide 3">
            </div>
        </div>

        <a class="carousel-control-prev" href="#assetCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>

        <a class="carousel-control-next" href="#assetCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

    {{-- tarjeta con grafico --}}
    <div class="card" style="height: 650px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title" style="color: #0d0d0d">
                Resumen de ventas por mes
                @if($anioSeleccionado)
                    ({{ $anioSeleccionado }})
                @endif
            </h3>
        </div>

        <div class="card-body">
            <div class="row h-100">
                {{-- columna de la gráfica --}}
                <div class="col-md-9">
                    <div style="height: 600px;">
                        <canvas id="ventasChart"></canvas>
                    </div>

                    <div class="mt-3">
                        <p><b>Total boletos vendidos:</b> {{ $totalBoletosAnual }}</p>
                        <p><b>Total ventas:</b> ${{ number_format($totalVentasAnual, 2) }}</p>
                    </div>
                </div>

                {{-- columna de filtros a la derecha --}}
                <div class="col-md-3">
                    <div class="p-3" style="background-color: #f4e6ff; border-radius: 10px;">
                        <h5 class="mb-3" style="color:#000;"><b>Filtros</b></h5>

                        <form method="GET" action="{{ route('dashboard') }}">
                            <div class="form-group">
                                <label for="anio">Periodo</label>
                                <select name="anio" id="anio" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach($anios as $anio)
                                        <option value="{{ $anio }}" {{ (string)$anioSeleccionado === (string)$anio ? 'selected' : '' }}>
                                            {{ $anio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm btn-block mb-2">
                                <i class="fas fa-search"></i> Aplicar
                            </button>

                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm btn-block">
                                Limpiar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- tarjeta eventos --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>Eventos</h3>
                    <p>Gestion de eventos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('eventos.index') }}" class="small-box-footer">
                    Ir a eventos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- tarjeta boletos --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Boletos</h3>
                    <p>Listado de boletos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('boletos.index') }}" class="small-box-footer">
                    Ir a boletos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- tarjeta ventas --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Ventas</h3>
                    <p>Resumen de ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('ventas.index') }}" class="small-box-footer">
                    Ir a ventas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- tarjeta panel de analisis --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Panel de analisis</h3>
                    <p>Analisis de ventas y boletos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ url('/analisis-ventas') }}" class="small-box-footer">
                    Ir a panel de analisis <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('ventasChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const maxVentaMes = @json($maxVentaMes);

    new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: [
                'Enero','Febrero','Marzo','Abril','Mayo',
                'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
            ],
            datasets: [{
                label: 'Ventas por mes',
                data: @json($ventasPorMes),
                backgroundColor: [
                    'rgba(255, 80, 255, .9)',
                    'rgba(50, 22, 235, .9)',
                    'rgba(205, 10, 156, .9)',
                    'rgba(0, 0, 192, .9)',
                    'rgba(153, 30, 255, .9)',
                    'rgba(225, 19, 224, .9)',
                    'rgba(80, 80, 255, .9)',
                    'rgba(80, 200, 255, .9)',
                    'rgba(80, 255, 150, .9)',
                    'rgba(255, 200, 80, .9)',
                    'rgba(255, 120, 120, .9)',
                    'rgba(180, 80, 255, .9)',
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return label + ': $' + value.toLocaleString();
                        }
                    }
                }
            },
            layout: {
                padding: 20
            },
            scales: {
                r: {
                    ticks: {
                        display: false
                    },
                    suggestedMax: maxVentaMes ? maxVentaMes * 1.1 : undefined
                }
            }
        }
    });
});
</script>
@endsection
