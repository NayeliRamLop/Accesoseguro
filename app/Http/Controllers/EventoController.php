<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function __construct()
    {
        // protege todas las rutas de este controlador
        $this->middleware('auth');
    }

    /**
     * Pagina principal de eventos (desde el dashboard).
     */
    public function index()
    {
        // vista con botones
        $eventos = Evento::orderBy('id', 'desc')->get();

        return view('evento', compact('eventos'));
    }

    /**
     * Formulario para crear un evento nuevo.
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Guarda un nuevo evento en la base de datos.
     * Aqui ya acepta subir una imagen desde la computadora.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'             => 'required|string|max:100',
            'descripcion'        => 'required|string|max:255',
            'fecha'              => 'required|date',
            'hora'               => 'required|string|max:20',
            'ubicacion'          => 'required|string|max:150',
            'precio'             => 'required|numeric|min:0',
            'imagen'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'boletosDisponibles' => 'required|integer|min:0',
        ]);

        // guardar imagen si se envio
        $pathImagen = '';
        if ($request->hasFile('imagen')) {
            // se guarda en storage/app/public/eventos
            $pathImagen = $request->file('imagen')->store('eventos', 'public');
        }

        $evento = new Evento();
        $evento->titulo             = $request->input('titulo');
        $evento->descripcion        = $request->input('descripcion');
        $evento->fecha              = $request->input('fecha'); // tipo DATE en la BD
        $evento->hora               = $request->input('hora');
        $evento->ubicacion          = $request->input('ubicacion');
        $evento->precio             = $request->input('precio');
        $evento->urlImagen          = $pathImagen; // ruta relativa en storage
        $evento->boletosDisponibles = $request->input('boletosDisponibles');
        $evento->save();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento creado correctamente');
    }

    /**
     * Muestra el detalle de un evento.
     */
    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    /**
     * Formulario normal para editar (si lo usas aparte del modal).
     */
    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    /**
     * Actualiza un evento existente.
     * Se usa tanto desde el formulario normal como desde el modal.
     * Aqui ya se puede cambiar y/o borrar la imagen.
     */
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'titulo'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'fecha'       => 'required|date',
            'hora'        => 'required|string|max:20',
            'ubicacion'   => 'required|string|max:150',
            'precio'      => 'required|numeric|min:0',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ruta actual de la imagen en BD
        $pathImagen = $evento->urlImagen;

        // si marcaron borrar imagen
        if ($request->boolean('borrar_imagen')) {
            if ($pathImagen) {
                Storage::disk('public')->delete($pathImagen);
            }
            $pathImagen = '';
        }

        // si subieron una nueva imagen, borramos la anterior (si existe) y guardamos la nueva
        if ($request->hasFile('imagen')) {
            if ($pathImagen) {
                Storage::disk('public')->delete($pathImagen);
            }
            $pathImagen = $request->file('imagen')->store('eventos', 'public');
        }

        $evento->titulo      = $request->input('titulo');
        $evento->descripcion = $request->input('descripcion');
        $evento->fecha       = $request->input('fecha');
        $evento->hora        = $request->input('hora');
        $evento->ubicacion   = $request->input('ubicacion');
        $evento->precio      = $request->input('precio');
        $evento->urlImagen   = $pathImagen;
        $evento->save();

        $from = $request->input('from');

        // vistas a las que regresamos segun desde donde se actualizo
        if ($from === 'disponibles') {
            return redirect()
                ->route('eventos.disponibles')
                ->with('success', 'Evento actualizado correctamente');
        }

        if ($from === 'finalizados') {
            return redirect()
                ->route('eventos.finalizados')
                ->with('success', 'Evento actualizado correctamente');
        }

        if ($from === 'todos') {
            return redirect()
                ->route('eventos.todos')
                ->with('success', 'Evento actualizado correctamente');
        }

        if ($from === 'soldout') {
            return redirect()
                ->route('eventos.soldout')
                ->with('success', 'Evento actualizado correctamente');
        }

        // en cualquier otro caso regresamos a la lista general
        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento actualizado correctamente');
    }

    /**
     * Elimina un evento.
     */
    public function destroy(Request $request, Evento $evento)
    {
        // borrar imagen fisica si existe
        if ($evento->urlImagen) {
            Storage::disk('public')->delete($evento->urlImagen);
        }

        $evento->delete();

        $from = $request->input('from');

        if ($from === 'disponibles') {
            return redirect()
                ->route('eventos.disponibles')
                ->with('success', 'Evento eliminado correctamente');
        }

        if ($from === 'finalizados') {
            return redirect()
                ->route('eventos.finalizados')
                ->with('success', 'Evento eliminado correctamente');
        }

        if ($from === 'todos') {
            return redirect()
                ->route('eventos.todos')
                ->with('success', 'Evento eliminado correctamente');
        }

        if ($from === 'soldout') {
            return redirect()
                ->route('eventos.soldout')
                ->with('success', 'Evento eliminado correctamente');
        }

        // si no, volver a la lista general
        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente');
    }

    /**
     * Eventos disponibles: desde hoy en adelante y con boletos > 0.
     * Ahora con filtro opcional por rango de fechas.
     */
    public function disponibles(Request $request)
    {
        $hoy = Carbon::today()->toDateString();

        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        $query = Evento::query()
            ->whereDate('fecha', '>=', $hoy)
            ->where('boletosDisponibles', '>', 0);

        if ($fechaDesde) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        $eventos = $query->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();

        return view('eventos_disponibles', compact('eventos'));
    }

    /**
     * Eventos finalizados: todos los eventos con fecha menor o igual a ayer.
     * Con filtro opcional por rango de fechas.
     */
    public function finalizados(Request $request)
    {
        $hoy = Carbon::today();
        $ayer = $hoy->copy()->subDay()->toDateString();

        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        $query = Evento::query()
            ->whereDate('fecha', '<=', $ayer);

        if ($fechaDesde) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        $eventos = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('eventos_finalizados', compact('eventos'));
    }

    /**
     * Todos los eventos: pasados, actuales y futuros.
     * Con filtro opcional por rango de fechas.
     */
    public function todos(Request $request)
    {
        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        $query = Evento::query();

        if ($fechaDesde) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        $eventos = $query->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();

        return view('eventos_todos', compact('eventos'));
    }

    /**
     * Eventos sold out: boletosDisponibles <= 0
     * Con filtro opcional por rango de fechas.
     */
    public function soldout(Request $request)
    {
        $fechaDesde = $request->query('fecha_desde');
        $fechaHasta = $request->query('fecha_hasta');

        $query = Evento::query()
            ->where('boletosDisponibles', '<=', 0);

        if ($fechaDesde) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        $eventos = $query->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();

        return view('eventos_soldout', compact('eventos'));
    }
}
