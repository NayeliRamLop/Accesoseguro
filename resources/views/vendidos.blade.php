{{-- resources/views/boletos/vendidos.blade.php --}}
@extends('adminlte::page')

@section('title', 'Boletos vendidos')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Boletos vendidos</h1>

        <a href="{{ route('boletos.index') }}" class="btn btn-outline-secondary">Volver a Boletos</a>
    </div>
@stop

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filtro por fecha de compra</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('boletos.vendidos') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="desde" class="mr-2">Desde:</label>
                    <input type="date" name="desde" id="desde" class="form-control"
                           value="{{ $desde }}">
                </div>

                <div class="form-group mr-2">
                    <label for="hasta" class="mr-2">Hasta:</label>
                    <input type="date" name="hasta" id="hasta" class="form-control"
                           value="{{ $hasta }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>

                <a href="{{ route('boletos.vendidos') }}" class="btn btn-outline-secondary ml-2">
                    Limpiar filtros
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de boletos vendidos</h3>
        </div>
        <div class="card-body">
            @if ($boletos->isEmpty())
                <p>No se encontraron boletos vendidos con el filtro seleccionado.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Usuario</th>
                            <th>Cantidad</th>
                            <th>Precio total</th>
                            <th>Fecha de compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boletos as $boleto)
                            <tr>
                                <td>{{ $boleto->evento->titulo ?? '-' }}</td>
                                <td>
                                    @if($boleto->usuario)
                                        {{ $boleto->usuario->nombre }} {{ $boleto->usuario->apellidos }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $boleto->cantidad }}</td>
                                <td>${{ number_format($boleto->precioTotal, 2) }}</td>
                                <td>{{ $boleto->pago->fechaCompra ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- PAGINACIÓN: con Bootstrap y conservando filtros --}}
                {{ $boletos->appends([
                    'desde' => $desde,
                    'hasta' => $hasta,
                ])->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
@stop
