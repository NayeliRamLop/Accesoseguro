@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Panel de control</h1>

        {{-- Boton de cerrar sesion (POST) --}}
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

    <div class="row">
        {{-- Tarjeta: Eventos --}}
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

        {{-- Tarjeta: Boletos --}}
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

        {{-- Tarjeta: Ventas (NUEVA VISTA) --}}
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

        {{-- Tarjeta: Reportes --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Reportes</h3>
                    <p>Reporte de boletos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ route('boletos.reporte') }}" class="small-box-footer">
                    Ir a reportes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@extends('adminlte::page')
@section('css')
<style>
/* --- FONDO GENERAL --- */
body,
.content-wrapper,
.main-footer {
    background-color: #e4e3e5 !important;
    color: #373737 !important;
}

/* --- NAVBAR --- */
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

/* --- SIDEBAR LATERAL --- */
.main-sidebar {
    background-color: #434485 !important;
    
      
}

.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
    background-color: #ffffff !important;
    color: #e7e5e5 !important;
     border-color: #ccc
}

.nav-sidebar .nav-link {
    color: #ccc !important;
     border-color: #ccc
}

.nav-sidebar .nav-link:hover {
    background-color: #a9a9a9 !important;
    color: #fff !important;
    border-color: #ccc
  
}

/* --- TARJETAS (SMALL-BOX) --- */
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

.small-box.bg-warning {
    background: linear-gradient(135deg, #b8860b, #e8b923) !important;
}

.small-box-footer {
    color: #fff !important;
}

/* --- TARJETAS NORMALES (CARD) --- */
.card {
    background-color: #e5c9f !important;
    color: #e6e6e6 !important;
    border: 1px solid #333 !important;
}

.card-header {
    background-color: #d6d9ff !important;
    border-bottom: 1px solid #646464 !important;
}

/* --- TABLAS --- */
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

/* --- BOTONES --- */
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

/* --- FORMULARIOS --- */
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

/* --- SCROLLBAR ESTILO OSCURO --- */
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

@section('title', 'Dashboard')

    @section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><b>Acceso seguro</h1>

        {{-- Boton de cerrar sesion (GET) --}}
        <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesion
    </button>
</form>

@stop

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <p>Bienvenido al panel de control</p>
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

<div class="card" style="height: 500px;">
    <div class="card-header">
        <h3 class="card-title" style="color: #0d0d0d">Resumen de ventas </h3>
    </div>

    <div class="card-body">
        <div style="height: 98%;">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>
</div>


@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('ventasChart').getContext('2d');

    new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: [
                'Enero','Febrero','Marzo','Abril','Mayo',
                'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
            ],
            datasets: [{
                label: 'Ventas',
                data: [120, 180, 140, 200, 260, 180, 150, 90, 110, 130, 170, 190],
                backgroundColor: [
                    'rgba(255, 80, 255, .5)',
                    'rgba(50, 22, 235, .5)',
                    'rgba(205, 10, 156, .5)',
                    'rgba(0, 0, 192, .5)',
                    'rgba(153, 30, 255, .5)',
                    'rgba(225, 19, 224, .5)',
                ],
                 borderWidth: 0, 
            }]
        },
        options: {
               maintainAspectRatio: false,
          plugins: {
        legend: {
            position: 'left',  // <--- Esto pone los datos verticales
          
            
            }
        }
    }
    });
});
</script>
@endsection



    <div class="row">
        {{-- Tarjeta: Eventos --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-dark">
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

        {{-- Tarjeta: Boletos (placeholder, aun sin ruta) --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>Boletos</h3>
                    <p>Listado de boletos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                {{-- Sin ruta definida todavia, para evitar error --}}
                <a href="#" class="small-box-footer">
                    Proximamente <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Tarjeta: Reportes (placeholder tambien) --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>Reportes</h3>
                    <p>Reporte de ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                {{-- Igual, sin ruta para no causar RouteNotFound --}}
                <a href="#" class="small-box-footer">
                    Proximamente <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection