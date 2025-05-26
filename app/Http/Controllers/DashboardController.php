<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Ahorro;
use App\Models\GastoFijo;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    // Totales actuales (adaptar según métodos en tus modelos)
    $totalIngresos = Ingreso::totalactual() ?? Ingreso::sum('valor');
    $totalEgresos = method_exists(Egreso::class, 'totalactual') ? Egreso::totalactual() : Egreso::sum('valor');
    $totalAhorros = Ahorro::total();

    $totalIngresosMenosAhorro = $totalIngresos - $totalAhorros;
    $totalIngresosMenosEgresos = $totalIngresosMenosAhorro - $totalEgresos;

    // 💡 Lógica de alerta financiera
    $alertaFinanciera = null;

    if ($totalIngresosMenosEgresos < 0) {
        if ($totalAhorros > abs($totalIngresosMenosEgresos)) {
            $alertaFinanciera = [
                'tipo' => 'warning',
                'mensaje' => 'Tienes un déficit de $' . number_format(abs($totalIngresosMenosEgresos), 2) .
                             '. Puedes usar tus ahorros para cubrir esta deuda.',
            ];
        } elseif ($totalAhorros > 0) {
            $alertaFinanciera = [
                'tipo' => 'danger',
                'mensaje' => 'Tus ingresos no cubren tus egresos y tus ahorros son insuficientes. Revisa tus gastos o busca aumentar tus ingresos.',
            ];
        } else {
            $alertaFinanciera = [
                'tipo' => 'danger',
                'mensaje' => 'Estás en deuda y no tienes ahorros disponibles. Es urgente reducir egresos o generar ingresos.',
            ];
        }
    }

    // Gastos fijos con alerta
    $limiteAlerta = 500000; // ajustar según necesidad
    $gastosAlerta = GastoFijo::alerta($limiteAlerta);

    // Últimos 10 ingresos y egresos
    $ultimosIngresos = Ingreso::buscarultimos10() ?? Ingreso::orderBy('fecha', 'desc')->limit(10)->get();
    $ultimosEgresos = method_exists(Egreso::class, 'buscarultimos') ? Egreso::buscarultimos(10) : Egreso::orderBy('fecha', 'desc')->limit(10)->get();

    // Últimos 6 meses para etiquetas de gráficas
    $mesesUltimos6 = collect(range(5, 0))->map(function($i) {
        return now()->subMonths($i)->format('M Y');
    })->toArray();

    // Datos para gráficas
    $ingresosPorMes = [];
    $egresosPorMes = [];
    $ahorrosPorMes = [];

    foreach ($mesesUltimos6 as $mes) {
        $anioMes = \Carbon\Carbon::createFromFormat('M Y', $mes);

        $ingresosPorMes[] = Ingreso::whereYear('fecha', $anioMes->year)
                                   ->whereMonth('fecha', $anioMes->month)
                                   ->sum('valor');

        $egresosPorMes[] = Egreso::whereYear('fecha', $anioMes->year)
                                 ->whereMonth('fecha', $anioMes->month)
                                 ->sum('valor');

        $ahorrosPorMes[] = Ahorro::with('ingresos')->get()->sum(function ($ahorro) use ($anioMes) {
            return $ahorro->ingresos->filter(function ($ingreso) use ($anioMes) {
                return $ingreso->fecha->year === $anioMes->year && $ingreso->fecha->month === $anioMes->month;
            })->sum(function ($ingreso) use ($ahorro) {
                return ($ingreso->valor * $ingreso->pivot->porcentaje) / 100;
            });
        });
    }

    return view('dashboard', compact(
        'totalIngresos',
        'totalEgresos',
        'totalAhorros',
        'gastosAlerta',
        'ultimosIngresos',
        'ultimosEgresos',
        'limiteAlerta',
        'mesesUltimos6',
        'ingresosPorMes',
        'egresosPorMes',
        'ahorrosPorMes',
        'totalIngresosMenosEgresos',
        'totalIngresosMenosAhorro',
        'alertaFinanciera' // <- importante
    ));
}



}
