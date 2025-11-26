@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Eventos</h1>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu de eventos</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                {{-- crear evento --}}
                <a href="{{ route('eventos.create') }}" class="btn btn-primary mr-2">
                    Crear evento
                </a>

                {{-- eventos disponibles --}}
                <a href="{{ route('eventos.disponibles') }}" class="btn btn-success mr-2">
                    Eventos disponibles
                </a>

                {{-- eventos finalizados --}}
                <a href="{{ route('eventos.finalizados') }}" class="btn btn-secondary mr-2">
                    Eventos finalizados
                </a>

                {{-- todos los eventos --}}
                <a href="{{ route('eventos.todos') }}" class="btn btn-info mr-2">
                    Todos los eventos
                </a>

                {{-- eventos sold out --}}
                <a href="{{ route('eventos.soldout') }}" class="btn btn-outline-dark">
                    Eventos sold out
                </a>
            </div>
        </div>
    </div>

@stop
