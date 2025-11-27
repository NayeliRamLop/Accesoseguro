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
