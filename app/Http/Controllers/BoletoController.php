<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use App\Models\Boleto;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d

class BoletoController extends Controller
{
    /**
<<<<<<< HEAD
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
=======
     * Menú principal de boletos.
     */
    public function index()
    {
        return view('boletos');
    }

    /**
     * Menú principal de ventas (solo muestra las dos opciones).
     */
    public function ventas()
    {
        return view('ventas');
    }

    /**
     * Pagos realizados con filtro por fecha.
     */
    public function pagosRealizados(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $query = Pago::query();

        if ($desde) {
            $query->whereDate('fechaCompra', '>=', $desde);
        }

        if ($hasta) {
            $query->whereDate('fechaCompra', '<=', $hasta);
        }

        $pagos = $query->orderBy('fechaCompra', 'desc')->paginate(20);

        // Total del monto SOLO de la página actual (igual que en boletos)
        $totalMonto = $pagos->sum('monto');

        return view('pagos_realizados', [
            'pagos'      => $pagos,
            'desde'      => $desde,
            'hasta'      => $hasta,
            'totalMonto' => $totalMonto,
        ]);
    }

    /**
     * Reporte de pagos en pantalla (con filtros y PDF).
     */
    public function pagosReporte(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $query = Pago::query();

        if ($desde) {
            $query->whereDate('fechaCompra', '>=', $desde);
        }

        if ($hasta) {
            $query->whereDate('fechaCompra', '<=', $hasta);
        }

        $pagos = $query->orderBy('fechaCompra', 'desc')->paginate(20);

        $totalPagos = $pagos->count();
        $totalMonto = $pagos->sum('monto');

        return view('pagos_reporte', [
            'pagos'      => $pagos,
            'totalPagos' => $totalPagos,
            'totalMonto' => $totalMonto,
            'desde'      => $desde,
            'hasta'      => $hasta,
        ]);
    }

    /**
     * Generar PDF del reporte de pagos (respeta los filtros).
     */
    public function pagosReportePdf(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $query = Pago::query();

        if ($desde) {
            $query->whereDate('fechaCompra', '>=', $desde);
        }

        if ($hasta) {
            $query->whereDate('fechaCompra', '<=', $hasta);
        }

        $pagos = $query->orderBy('fechaCompra', 'asc')->get();

        $totalPagos = $pagos->count();
        $totalMonto = $pagos->sum('monto');

        $pdf = Pdf::loadView('pagos_reporte_pdf', [
            'pagos'        => $pagos,
            'totalPagos'   => $totalPagos,
            'totalMonto'   => $totalMonto,
            'fechaGenerado'=> now(),
        ])->setPaper('letter', 'portrait');

        return $pdf->download('reporte_pagos.pdf');
    }

    /**
     * Boletos vendidos (con filtro por fecha y estado escaneado/no escaneado).
     */
    public function vendidos(Request $request)
    {
        $desde  = $request->query('desde');
        $hasta  = $request->query('hasta');
        $estado = $request->query('estado'); // 1 escaneado, 0 no, vacío todos

        $query = Boleto::with(['evento', 'usuario', 'pago']);

        if ($desde) {
            $query->whereHas('pago', function ($q) use ($desde) {
                $q->where('fechaCompra', '>=', $desde);
            });
        }

        if ($hasta) {
            $query->whereHas('pago', function ($q) use ($hasta) {
                $q->where('fechaCompra', '<=', $hasta);
            });
        }

        if ($estado !== null && $estado !== '') {
            $query->where('estaUsado', $estado);
        }

        $boletos = $query->orderBy('id', 'desc')->paginate(20);

        return view('vendidos', [
            'boletos' => $boletos,
            'desde'   => $desde,
            'hasta'   => $hasta,
            'estado'  => $estado,
        ]);
    }

    /**
     * Boletos escaneados (estaUsado = 1).
     */
    public function escaneados()
    {
        $boletos = Boleto::with(['evento', 'usuario', 'pago'])
            ->where('estaUsado', 1)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('escaneados', compact('boletos'));
    }

    /**
     * Reporte en pantalla (boletos).
     */
    public function reporte(Request $request)
    {
        $desde  = $request->query('desde');
        $hasta  = $request->query('hasta');
        $estado = $request->query('estado');

        $query = Boleto::with(['evento', 'usuario', 'pago']);

        if ($desde) {
            $query->whereHas('pago', function ($q) use ($desde) {
                $q->where('fechaCompra', '>=', $desde);
            });
        }

        if ($hasta) {
            $query->whereHas('pago', function ($q) use ($hasta) {
                $q->where('fechaCompra', '<=', $hasta);
            });
        }

        if ($estado !== null && $estado !== '') {
            $query->where('estaUsado', $estado);
        }

        $boletos = $query->orderBy('id', 'desc')->paginate(20);

        $totalBoletos = $boletos->sum('cantidad');
        $totalMonto   = $boletos->sum('precioTotal');

        return view('reporte', [
            'boletos'      => $boletos,
            'totalBoletos' => $totalBoletos,
            'totalMonto'   => $totalMonto,
            'desde'        => $desde,
            'hasta'        => $hasta,
            'estado'       => $estado,
        ]);
    }

    /**
     * Generar PDF del reporte de boletos (respeta los mismos filtros).
     */
    public function reportePdf(Request $request)
    {
        $desde  = $request->query('desde');
        $hasta  = $request->query('hasta');
        $estado = $request->query('estado');

        $query = Boleto::with(['evento', 'usuario', 'pago']);

        if ($desde) {
            $query->whereHas('pago', function ($q) use ($desde) {
                $q->where('fechaCompra', '>=', $desde);
            });
        }

        if ($hasta) {
            $query->whereHas('pago', function ($q) use ($hasta) {
                $q->where('fechaCompra', '<=', $hasta);
            });
        }

        if ($estado !== null && $estado !== '') {
            $query->where('estaUsado', $estado);
        }

        $boletos = $query->orderBy('id', 'asc')->get();

        $totalBoletos = $boletos->sum('cantidad');
        $totalMonto   = $boletos->sum('precioTotal');

        $pdf = Pdf::loadView('reporte_pdf', [
            'boletos'       => $boletos,
            'totalBoletos'  => $totalBoletos,
            'totalMonto'    => $totalMonto,
            'fechaGenerado' => now(),
        ])->setPaper('letter', 'portrait');

        return $pdf->download('reporte_boletos.pdf');
>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d
    }
}
