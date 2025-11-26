<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // mostrar formulario de login (vista de adminlte)
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    // procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // mapeamos email -> columna correo y filtramos solo admins
        $credentials = [
            'correo'      => $request->input('email'),
            'password'    => $request->input('password'),
            'tipoUsuario' => 'Admin',   // pon aqui el valor real de tu tabla
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // manda al dashboard
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ])->onlyInput('email');
    }

    // cerrar sesion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
