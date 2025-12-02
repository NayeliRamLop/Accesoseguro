@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

@stop


@section('content')


<div class="mt-3 mb-4 text-center" style="padding: 20px 0;">
    <h1 style="font-size: 2.8rem; font-weight: 600;">Gestión de eventos</h1>

    <p style="
        font-size: 1.6rem;
        font-weight: 300;
        color: #464646;
        max-width: 780px;
        margin: 15px auto 0 auto;
        line-height: 1.5;
    ">
         Bienvenido al panel de gestión de eventos. Aquí podrás crear nuevos eventos, 
    actualizar los existentes, consultar los finalizados, revisar estadísticas 
    y tener una visión completa del estado de tus actividades.
    </p>
</div>


  <div class="container" style="max-width: 1300px;">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menú de eventos</h3>
        </div>

        <div class="card-body">
           <div class="event-menu">

    <a href="{{ route('eventos.create') }}" class="event-card">
        <div class="icon"><i class="fas fa-plus"></i></div>
        <span>Crear evento</span>
    </a>

    <a href="{{ route('eventos.disponibles') }}" class="event-card">
        <div class="icon"><i class="fas fa-calendar-check"></i></div>
        <span>Eventos disponibles</span>
    </a>

    <a href="{{ route('eventos.finalizados') }}" class="event-card">
        <div class="icon"><i class="fas fa-flag-checkered"></i></div>
        <span>Eventos finalizados</span>
    </a>

    <a href="{{ route('eventos.todos') }}" class="event-card">
        <div class="icon"><i class="fas fa-list-ul"></i></div>
        <span>Todos los eventos</span>
    </a>

    <a href="{{ route('eventos.soldout') }}" class="event-card">
        <div class="icon"><i class="fas fa-ban"></i></div>
        <span>Eventos sold out</span>
    </a>

</div>
</div>

        </div>
    </div>

@stop
