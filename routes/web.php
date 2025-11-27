<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventoController;
<<<<<<< HEAD

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
=======
use App\Http\Controllers\BoletoController;

>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d

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

<<<<<<< HEAD
    // IMPORTANTE:
    // Aquí cambiamos el campo de búsqueda.
    // En lugar de 'email' => ..., usamos la columna REAL de tu tabla.
    // Si en tu tabla usuario la columna se llama:
    // - 'correo'  -> deja como está
    // - 'usuario' -> cambia 'correo' por 'usuario'
    // - 'mail'    -> cambia por 'mail', etc.
    $credentials = [
        'correo'   => $request->input('email'),   // <-- AJUSTA 'correo' si tu columna se llama diferente
=======
    $credentials = [
        'correo'   => $request->input('email'),
>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d
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
<<<<<<< HEAD
=======

    // Boletos - menú principal
    Route::get('/boletos', [BoletoController::class, 'index'])
        ->name('boletos.index');

    // Boletos vendidos (con filtro por fecha)
    Route::get('/boletos-vendidos', [BoletoController::class, 'vendidos'])
        ->name('boletos.vendidos');

    // Boletos escaneados (estaUsado = 1)
    Route::get('/boletos-escaneados', [BoletoController::class, 'escaneados'])
        ->name('boletos.escaneados');

    // Reporte de todos los boletos (vista HTML)
    Route::get('/boletos-reporte', [BoletoController::class, 'reporte'])
        ->name('boletos.reporte');

    // 🔹 NUEVO: Reporte de boletos en PDF
    Route::get('/boletos-reporte-pdf', [BoletoController::class, 'reportePdf'])
        ->name('boletos.reporte.pdf');
               // VENTAS - menú
    Route::get('/ventas', [BoletoController::class, 'ventas'])
        ->name('ventas.index');

    // PAGOS REALIZADOS
    Route::get('/pagos-realizados', [BoletoController::class, 'pagosRealizados'])
        ->name('pagos.realizados');

    // REPORTE DE PAGOS (HTML)
    Route::get('/pagos-reporte', [BoletoController::class, 'pagosReporte'])
        ->name('pagos.reporte');

    // REPORTE DE PAGOS (PDF)
    Route::get('/pagos-reporte-pdf', [BoletoController::class, 'pagosReportePdf'])
        ->name('pagos.reporte.pdf');

>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d
});
