<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;
class EgresoController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->query('fecha');
        $min = $request->query('min');
        $max = $request->query('max');
        $ultimos = $request->query('ultimos');

        if ($fecha) {
            // Filtrar por fecha exacta
            $egresos = Egreso::buscarFecha($fecha);
        } elseif ($min !== null && $max !== null) {
            // Filtrar por rango valor mínimo y máximo
            $egresos = Egreso::buscarRango($min, $max);
        } elseif ($ultimos) {
            // Mostrar últimos N egresos
            $cantidad = (int) $ultimos;
            $egresos = Egreso::buscarUltimos($cantidad);
        } else {
            // Sin filtro, traer todos
            $egresos = Egreso::all();
        }

        return view('egresos.index', compact('egresos'));
    }

    public function create()
    {
        return view('egresos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Egreso::retiro($request->all());
        return redirect()->route('egresos.index')->with('success', 'Egreso creado correctamente.');
    }

    public function show(Egreso $egreso)
    {
        $egreso->load('gastosFijos');
        return view('egresos.show', compact('egreso'));
    }

    public function edit(Egreso $egreso)
    {
        return view('egresos.edit', compact('egreso'));
    }

    public function update(Request $request, Egreso $egreso)
    {
        $request->validate([
            'valor' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $egreso->editar($request->all());
        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado correctamente.');
    }

    public function destroy(Egreso $egreso)
    {
        $egreso->eliminar();
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado correctamente.');
    }

    public function buscarFecha($fecha)
    {
        return Egreso::buscarFecha($fecha);
    }

    public function buscarUltimos($cantidad = 10)
    {
        return Egreso::buscarUltimos($cantidad);
    }

    public function buscarRango($min, $max)
    {
        return Egreso::buscarRango($min, $max);
    }
}
