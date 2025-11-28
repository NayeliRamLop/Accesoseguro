@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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
           <div class="event-menu">

    <a href="{{ route('eventos.create') }}" class="event-card create">
        <div class="icon"><i class="fas fa-plus"></i></div>
        <span>Crear evento</span>
    </a>

    <a href="{{ route('eventos.disponibles') }}" class="event-card disponibles">
        <div class="icon"><i class="fas fa-calendar-check"></i></div>
        <span>Eventos disponibles</span>
    </a>

    <a href="{{ route('eventos.finalizados') }}" class="event-card finalizados">
        <div class="icon"><i class="fas fa-flag-checkered"></i></div>
        <span>Eventos finalizados</span>
    </a>

    <a href="{{ route('eventos.todos') }}" class="event-card todos">
        <div class="icon"><i class="fas fa-list-ul"></i></div>
        <span>Todos los eventos</span>
    </a>

    <a href="{{ route('eventos.soldout') }}" class="event-card soldout">
        <div class="icon"><i class="fas fa-ban"></i></div>
        <span>Eventos sold out</span>
    </a>

</div>

        </div>
    </div>

@stop
