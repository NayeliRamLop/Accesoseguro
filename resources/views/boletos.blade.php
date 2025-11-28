@extends('adminlte::page')

@section('title', 'Boletos')


@section('content_header')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Boletos</h1>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Volver al menu principal
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        {{-- Boletos vendidos --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Boletos vendidos</h3>
                </div>
                <div class="card-body">
                    <p>Consulta los boletos vendidos con filtro por fecha.</p>
                    <a href="{{ route('boletos.vendidos') }}" class="btn btn-primary">
                        Ver boletos vendidos
                    </a>
                </div>
            </div>
        </div>

        {{-- Boletos escaneados --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Boletos escaneados</h3>
                </div>
                <div class="card-body">
                    <p>Listado de boletos que ya fueron escaneados.</p>
                    <a href="{{ route('boletos.escaneados') }}" class="btn btn-warning">
                        Ver boletos escaneados
                    </a>
                </div>
            </div>
        </div>

        {{-- Reporte de boletos --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reporte de boletos</h3>
                </div>
                <div class="card-body">
                    <p>Reporte general de todos los boletos registrados.</p>
                    <a href="{{ route('boletos.reporte') }}" class="btn btn-info">
                        Ver reporte de boletos
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
