@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

@stop

@section('content')

  <div class="container" style="max-width: 900px;">
        <h1>Perfil de Usuario</h1>
<p>
<div class="card card-primary card-outline">
    <div class="card-body box-profile" style="padding: 40px">

        {{-- Avatar --}}
    <div class="text-center mb-3">
    <img class="profile-user-img img-fluid img-circle"
         src="{{ asset('images/user.png') }}"
         alt="User profile picture">
</div>

        <h3 class="profile-username text-center">{{ $user->name }}</h3>
        <p class="text-muted text-center">{{ $user->email }}</p>

        <hr>

        <strong><i class="fas fa-user mr-1"></i> Nombre</strong>
        <p class="text-muted">{{ $user->name }}</p>

        <hr>

        <strong><i class="fas fa-envelope mr-1"></i> Correo</strong>
        <p class="text-muted">{{ $user->email }}</p>

        <hr>


        <div style="display: flex; justify-content: center;">
    <a href="#" class="btn btn-primary btn-block" style="max-width: 200px;">
        <b>Editar Perfil</b>
    </a>
</div>

    </div>
    </div>
</div>

@stop
