<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>AccesoSeguro - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- AdminLTE 3 desde CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>


<style>
    body.login-page {
        background: url("{{ asset('images/fondo2.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    /* Capa semitransparente encima del fondo */
    body.login-page::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0); /* Ajusta transparencia aquí */
        z-index: -1;
    }

    /* Asegura que el contenido se mantenga arriba */
    .login-box, .card {
        position: relative;
        z-index: 10;
    }
</style>


<body class="hold-transition login-page">


{{-- LOGO ARRIBA DEL LOGIN BOX --}}
<div class="login-logo" style="margin-bottom: 5px;">
    <img src="{{ asset('images/logo-login.png') }}"
         alt="Logo"
         style="width:150px; margin-bottom:15px;">
</div>

<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><span style="color:#7719D6;"><b>Acceso</b>Seguro</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicia sesión para entrar al panel</p>

            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mensaje de estado opcional --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Correo"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Contraseña"
                        required
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Entrar
                        </button>
                    </div>
                </div>
            </form>

            {{-- Aqui podrias poner enlaces de "olvide mi contraseña" o "registrarme" si los necesitas --}}
            <!--
            <p class="mb-1">
                <a href="#">Olvidé mi contraseña</a>
            </p>
            -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
