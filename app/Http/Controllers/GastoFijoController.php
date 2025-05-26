<?php

namespace App\Http\Controllers;

use App\Models\GastoFijo;
use Illuminate\Http\Request;
use App\Models\Periodo;


class GastoFijoController extends Controller
{
    public function index()
    {
        $gastosFijos = GastoFijo::with('periodo')->get();
        return view('gastos_fijos.index', compact('gastosFijos'));
    }

    public function create()
    {
        $periodos = Periodo::all();
        return view('gastos_fijos.create', compact('periodos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion'  => 'required|string|max:255',
            'valor'        => 'required|numeric',
            'periodo_id'   => 'required|exists:periodos,idperiodo',
            'fecha_inicio' => 'required|date',
        ]);

        GastoFijo::create($validated);

        return redirect()->route('gastos-fijos.index')->with('success', 'Gasto fijo creado correctamente.');
    }

    public function show($id)
    {
        $gastoFijo = GastoFijo::with('periodo')->findOrFail($id);
        return view('gastos_fijos.show', compact('gastoFijo'));
    }

    public function edit($id)
    {
        $gastoFijo = GastoFijo::with('periodo')->findOrFail($id);
        $periodos = Periodo::all();
        return view('gastos_fijos.edit', compact('gastoFijo', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'descripcion'  => 'required|string|max:255',
            'valor'        => 'required|numeric',
            'periodo_id'   => 'required|exists:periodos,idperiodo',
            'fecha_inicio' => 'required|date',
        ]);

        GastoFijo::findOrFail($id)->update($validated);
        return redirect()->route('gastos-fijos.index')->with('success', 'Gasto fijo actualizado correctamente.');
    }

    public function destroy($id)
    {
        GastoFijo::findOrFail($id)->delete();
        return redirect()->route('gastos-fijos.index')->with('success', 'Gasto fijo eliminado correctamente.');
    }
}
