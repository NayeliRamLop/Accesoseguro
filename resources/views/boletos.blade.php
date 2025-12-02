@extends('adminlte::page')

@section('title', 'Boletos')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('content')

<div class="mt-3 mb-4 text-center" style="padding: 20px 0;">
    <h1 style="font-size: 2.8rem; font-weight: 600;">Gestión de boletos</h1>

    <p style="
        font-size: 1.6rem;
        font-weight: 300;
        color: #464646;
        max-width: 780px;
        margin: 15px auto 0 auto;
        line-height: 1.5;
    ">
        Administra todos los boletos generados para tus eventos: ventas, escaneos,
        validaciones y control de acceso.
    </p>
</div>

<div class="container" style="max-width: 1300px;">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menú de boletos</h3>
        </div>

        <div class="card-body">
            <div class="event-menu">

                <a href="{{ route('boletos.vendidos') }}" class="event-card">
                    <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                    <span>Boletos vendidos</span>
                </a>

                <a href="{{ route('boletos.escaneados') }}" class="event-card">
                    <div class="icon"><i class="fas fa-qrcode"></i></div>
                    <span>Boletos escaneados</span>
                </a>

                <a href="{{ route('boletos.reporte') }}" class="event-card">
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <span>Reporte de boletos</span>
                </a>

            </div>
        </div>

    </div>
</div>

@stop
