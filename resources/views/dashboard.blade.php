@extends('adminlte::page')

@section('title', 'Dashboard')

    @section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Panel de control</h1>

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
            <p>Bienvenido al panel de control.</p>
        </div>
    </div>

    <div class="row">
        {{-- Tarjeta: Eventos --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
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

        {{-- Tarjeta: Boletos (placeholder, aun sin ruta) --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-success">
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
            <div class="small-box bg-warning">
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
