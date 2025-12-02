{{-- resources/views/ventas.blade.php --}}
@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('content')

<div class="mt-3 mb-4 text-center" style="padding: 20px 0;">
    <h1 style="font-size: 2.8rem; font-weight: 600;">Gestión de ventas</h1>

    <p style="
        font-size: 1.6rem;
        font-weight: 300;
        color: #464646;
        max-width: 780px;
        margin: 15px auto 0 auto;
        line-height: 1.5;
    ">
        Consulta, administra y reporta todos los pagos realizados en tu sistema:
        ventas, reportes financieros y totales por fecha.
    </p>
</div>

<div class="container" style="max-width: 1300px;">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Menú de ventas</h3>
        </div>

        <div class="card-body">
            <div class="event-menu">

                <a href="{{ route('pagos.realizados') }}" class="event-card">
                    <div class="icon"><i class="fas fa-credit-card"></i></div>
                    <span>Pagos realizados</span>
                </a>

                <a href="{{ route('pagos.reporte') }}" class="event-card">
                    <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <span>Reporte de pagos</span>
                </a>

            </div>
        </div>

    </div>
</div>

@stop
