<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use App\Models\Periodo;
use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;

use Illuminate\Support\Facades\DB;

class AhorroController extends Controller
{
    public function index()
    {
        $ahorros = Ahorro::with('ingresos', 'periodo')->get();
        return view('ahorros.index', compact('ahorros'));
    }

    public function create()
    {
        $periodos = Periodo::all();
        return view('ahorros.create', compact('periodos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'periodo_id' => 'required|exists:periodos,idperiodo',
        ]);

        Ahorro::ingresarAhorro($validated);

        return redirect()->route('ahorros.index')->with('success', 'Ahorro creado correctamente.');
    }

    public function show(Ahorro $ahorro)
    {
        $ahorro->load('periodo', 'ingresos');
        $valorAhorro = $ahorro->calcularValorAhorro();
        return view('ahorros.show', compact('ahorro', 'valorAhorro'));
    }

    public function edit(Ahorro $ahorro)
    {
        $periodos = Periodo::all();
        return view('ahorros.edit', compact('ahorro', 'periodos'));
    }

    public function update(Request $request, Ahorro $ahorro)
    {
        $validated = $request->validate([
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'periodo_id' => 'required|exists:periodos,idperiodo',
        ]);

        $ahorro->update($validated);
        return redirect()->route('ahorros.index')->with('success', 'Ahorro actualizado correctamente.');
    }

    public function destroy(Ahorro $ahorro)
    {
        $ahorro->delete();
        return redirect()->route('ahorros.index')->with('success', 'Ahorro eliminado correctamente.');
    }

    public function agregarIngresoForm(Ahorro $ahorro)
    {
        $ingresos = Ingreso::all();
        return view('ahorros.agregar-ingreso', compact('ahorro', 'ingresos'));
    }

    public function asociarIngreso(Request $request, Ahorro $ahorro)
    {
        $request->validate([
            'ingreso_id' => 'required|exists:ingresos,idingreso',
            'porcentaje' => 'required|numeric|min:0|max:100',
        ]);

        $resultado = $ahorro->asociarIngreso($request->ingreso_id, $request->porcentaje);

        if ($resultado['error']) {
            return back()->withErrors(['porcentaje' => $resultado['message']])->withInput();
        }

        return redirect()->route('ahorros.show', $ahorro)->with('success', 'Ingreso asociado correctamente.');
    }

    public function eliminarIngreso(Ahorro $ahorro, Ingreso $ingreso)
    {
        $ahorro->ingresos()->detach($ingreso->idingreso);
        return redirect()->route('ahorros.show', $ahorro->idahorro)
                         ->with('success', 'Ingreso eliminado del ahorro correctamente.');
    }
}
