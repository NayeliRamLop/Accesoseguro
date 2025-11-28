@extends('adminlte::page')

@section('title', 'Crear evento')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Crear evento</h1>
    </div>
@stop

@section('content')

    {{-- errores de validacion --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <p><strong>Revisa la informacion:</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     <div class="mb-3">
   
     </div>

     <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuevo evento</h3>
        </div>

        <div class="card-body">
            {{-- importante: enctype para subir archivos --}}
            <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- NO pedimos id, se genera en automatico en la base de datos --}}

                {{-- Titulo --}}
                <div class="form-group mb-3">
                    <label for="titulo">Titulo</label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        class="form-control"
                        value="{{ old('titulo') }}"
                        required
                    >
                </div>

                {{-- Descripcion --}}
                <div class="form-group mb-3">
                    <label for="descripcion">Descripcion</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        rows="3"
                        required
                    >{{ old('descripcion') }}</textarea>
                </div>

                {{-- Fecha --}}
                <div class="form-group mb-3">
                    <label for="fecha">Fecha</label>
                    <input
                        type="date"
                        id="fecha"
                        name="fecha"
                        class="form-control"
                        value="{{ old('fecha') }}"
                        required
                    >
                </div>

                {{-- Hora --}}
                <div class="form-group mb-3">
                    <label for="hora">Hora</label>
                    <input
                        type="time"
                        id="hora"
                        name="hora"
                        class="form-control"
                        value="{{ old('hora') }}"
                        required
                    >
                </div>

                {{-- Ubicacion --}}
                <div class="form-group mb-3">
                    <label for="ubicacion">Ubicacion</label>
                    <input
                        type="text"
                        id="ubicacion"
                        name="ubicacion"
                        class="form-control"
                        value="{{ old('ubicacion') }}"
                        required
                    >
                </div>

                {{-- Precio --}}
                <div class="form-group mb-3">
                    <label for="precio">Precio</label>
                    <input
                        type="number"
                        step="0.01"
                        id="precio"
                        name="precio"
                        class="form-control"
                        value="{{ old('precio') }}"
                        required
                    >
                </div>

                {{-- Imagen --}}
                <div class="form-group mb-3">
                    <label for="imagen">Imagen (opcional)</label>
                    <input
                        type="file"
                        id="imagen"
                        name="imagen"
                        class="form-control-file"
                    >
                </div>

                {{-- Boletos disponibles --}}
                <div class="form-group mb-3">
                    <label for="boletosDisponibles">Boletos disponibles</label>
                    <input
                        type="number"
                        id="boletosDisponibles"
                        name="boletosDisponibles"
                        class="form-control"
                        min="0"
                        value="{{ old('boletosDisponibles') }}"
                        required
                    >
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Guardar evento
                    </button>
                </div>
            </form>
            
        </div>
    </div>
@stop
