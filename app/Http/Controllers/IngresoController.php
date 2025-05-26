<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;
class IngresoController extends Controller
{
    public function index(Request $request)
    {
        $inicio = $request->query('inicio');
        $fin = $request->query('fin');
        $min = $request->query('min');
        $max = $request->query('max');
        $ultimos = $request->query('ultimos');

        if ($inicio && $fin) {
            // Filtrar ingresos entre dos fechas
            $ingresos = Ingreso::buscarFechas($inicio, $fin);
        } elseif ($min !== null && $max !== null) {
            // Filtrar ingresos por rango de valor
            $ingresos = Ingreso::buscarRango($min, $max);
        } elseif ($ultimos) {
            // Traer últimos N ingresos, si ultimos no se pasa tomamos 10
            $cantidad = (int) $ultimos ?: 10;
            // Si tu método solo busca últimos 10, podrías modificar o hacer un nuevo método que acepte cantidad
            $ingresos = ($cantidad === 10) ? Ingreso::buscarUltimos10() : Ingreso::buscarUltimos($cantidad);
        } else {
            // Sin filtros: traer todos
            $ingresos = Ingreso::all();
        }

        return view('ingresos.index', compact('ingresos'));
    }


    // Mostrar formulario para crear ingreso
    public function create()
    {
        return view('ingresos.create');
    }

    // Guardar nuevo ingreso y redirigir
    public function store(Request $request)
    {
        $validated = $request->validate([
            'valor' => 'required|numeric',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        Ingreso::create($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso creado correctamente');
    }

    // Mostrar detalle ingreso
    public function show(Ingreso $ingreso)
    {
        return view('ingresos.show', compact('ingreso'));
    }

    // Mostrar formulario para editar ingreso
    public function edit(Ingreso $ingreso)
    {
        return view('ingresos.edit', compact('ingreso'));
    }

    // Actualizar ingreso y redirigir
    public function update(Request $request, Ingreso $ingreso)
    {
        $validated = $request->validate([
            'valor' => 'required|numeric',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        $ingreso->update($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente');
    }

    // Eliminar ingreso
    public function destroy(Ingreso $ingreso)
    {
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente');
    }

    // Métodos personalizados
    public function buscarFechas($inicio, $fin)
    {
        return Ingreso::buscarFechas($inicio, $fin);
    }

    public function buscarUltimos10()
    {
        return Ingreso::buscarUltimos10();
    }

    public function buscarRango($min, $max)
    {
        return Ingreso::buscarRango($min, $max);
    }

    public function totalActual()
    {
        return Ingreso::totalActual();
    }

    public function restar($valor)
    {
        return Ingreso::restar($valor);
    }
}
