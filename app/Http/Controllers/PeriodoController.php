<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodos = Periodo::all();
        return view('periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('periodos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cantidaddias' => 'required|integer|min:1',
        ]);

        Periodo::create($validated);

        return redirect()->route('periodos.index')->with('success', 'Periodo creado correctamente.');
    }

    public function update(Request $request, Periodo $periodo)
    {
        $validated = $request->validate([
            'cantidaddias' => 'required|integer|min:1',
        ]);

        $periodo->update($validated);

        return redirect()->route('periodos.index')->with('success', 'Periodo actualizado correctamente.');
    }

    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return redirect()->route('periodos.index')->with('success', 'Periodo eliminado correctamente.');
    }
}
