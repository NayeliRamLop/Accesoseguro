{{-- resources/views/ventas.blade.php --}}
@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Ventas</h1>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al panel
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        {{-- Pagos realizados --}}
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Pagos realizados</h3>
                    <p>Listado de pagos con filtro por fecha</p>
                </div>
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <a href="{{ route('pagos.realizados') }}" class="small-box-footer">
                    Ir a pagos realizados <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Reporte de pagos --}}
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Reporte de pagos</h3>
                    <p>Resumen con totales y descarga en PDF</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="{{ route('pagos.reporte') }}" class="small-box-footer">
                    Ir a reporte de pagos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@stop
