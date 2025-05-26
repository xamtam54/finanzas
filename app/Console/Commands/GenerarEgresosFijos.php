<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GastoFijo;
use App\Models\Egreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerarEgresosFijos extends Command
{
    // Nombre del comando para usar en consola
    protected $signature = 'egresos:generar-fijos';

    // Descripción del comando
    protected $description = 'Generar egresos automáticos periódicos desde gastos fijos';

    public function handle()
    {
        $hoy = Carbon::today();

        $gastosFijos = GastoFijo::with('periodo')->get();

        foreach ($gastosFijos as $gasto) {
            if (!$gasto->periodo || !$gasto->fecha_inicio) {
                $this->warn("Gasto fijo ID {$gasto->idgastofijo} sin periodo o fecha de inicio, omitiendo.");
                continue;
            }

            $fechaInicio = Carbon::parse($gasto->fecha_inicio);
            $periodoDias = $gasto->periodo->cantidaddias;

            if ($periodoDias <= 0) {
                $this->warn("Periodo inválido para gasto fijo ID {$gasto->idgastofijo}, omitiendo.");
                continue;
            }

            if ($fechaInicio->greaterThan($hoy)) {
                $this->warn("Fecha inicio en futuro para gasto fijo ID {$gasto->idgastofijo}, omitiendo.");
                continue;
            }

            $diferenciaDias = $fechaInicio->diffInDays($hoy);
            $periodosPasados = intdiv($diferenciaDias, $periodoDias);

            for ($i = 0; $i <= $periodosPasados; $i++) {
                $fechaEgreso = $fechaInicio->copy()->addDays($i * $periodoDias);

                $existe = Egreso::where('descripcion', $gasto->descripcion)
                    ->whereDate('fecha', $fechaEgreso)
                    ->exists();

                if (!$existe) {
                    $egreso = Egreso::create([
                        'valor' => $gasto->valor,
                        'fecha' => $fechaEgreso,
                        'descripcion' => $gasto->descripcion,
                    ]);

                    // Relacionar con gasto fijo en tabla intermedia
                    DB::table('gasto_egreso')->insert([
                        'gastofijo_id' => $gasto->idgastofijo,
                        'egreso_id' => $egreso->idegreso,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $this->info("Egreso creado para {$fechaEgreso->toDateString()} y relacionado con gasto fijo ID {$gasto->idgastofijo}");
                }
            }
        }

        $this->info('Proceso de generación de egresos finalizado.');
    }

}
