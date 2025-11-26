<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home: si está autenticado va al dashboard, si no al login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Mostrar formulario de login (AdminLTE)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// Procesar login
Route::post('/login', function (Request $request) {
    // Validar campos del formulario
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    // IMPORTANTE:
    // Aquí cambiamos el campo de búsqueda.
    // En lugar de 'email' => ..., usamos la columna REAL de tu tabla.
    // Si en tu tabla `usuario` la columna se llama:
    // - 'correo'  -> deja como está
    // - 'usuario' -> cambia 'correo' por 'usuario'
    // - 'mail'    -> cambia por 'mail', etc.
    $credentials = [
        'correo'   => $request->input('email'),   // <-- AJUSTA 'correo' si tu columna se llama diferente
        'password' => $request->input('password'),
    ];

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        // Redirige a la página que quería ver o al dashboard
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('email');
})->middleware('guest')->name('login.post');

// Dashboard (protegido)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Lista principal de eventos
    Route::get('/eventos', [EventoController::class, 'index'])
        ->name('eventos.index');

    // Crear evento
    Route::get('/eventos/create', [EventoController::class, 'create'])
        ->name('eventos.create');

    // Guardar evento nuevo
    Route::post('/eventos', [EventoController::class, 'store'])
        ->name('eventos.store');

    // Ver detalle de un evento
    Route::get('/eventos/{evento}', [EventoController::class, 'show'])
        ->name('eventos.show');

    // Formulario para editar evento
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])
        ->name('eventos.edit');

    // Actualizar evento
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])
        ->name('eventos.update');

    // Eliminar evento
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])
        ->name('eventos.destroy');

    // EVENTOS DISPONIBLES (desde hoy y con boletos > 0)
    Route::get('/eventos-disponibles', [EventoController::class, 'disponibles'])
        ->name('eventos.disponibles');

    // EVENTOS FINALIZADOS (anteriores a la fecha actual)
    Route::get('/eventos-finalizados', [EventoController::class, 'finalizados'])
        ->name('eventos.finalizados');

    // TODOS LOS EVENTOS
    Route::get('/eventos-todos', [EventoController::class, 'todos'])
        ->name('eventos.todos');

    // EVENTOS SOLD OUT
    Route::get('/eventos-soldout', [EventoController::class, 'soldout'])
        ->name('eventos.soldout');

    // CERRAR SESION: acepta GET y POST
    Route::match(['GET', 'POST'], '/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
