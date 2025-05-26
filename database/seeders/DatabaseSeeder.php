<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 periodos
        DB::table('periodos')->insert(
            collect(range(1, 5))->map(function () {
                return [
                    'cantidaddias' => rand(15, 90),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

        // 20 ingresos, valor en COP (sin dividir entre 100)
        DB::table('ingresos')->insert(
            collect(range(1, 20))->map(function () {
                return [
                    'valor' => rand(50000, 300000), // COP directo
                    'fecha' => Carbon::now()->subDays(rand(1, 60)),
                    'descripcion' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

        // 20 egresos, valor en COP (sin dividir entre 100)
        DB::table('egresos')->insert(
            collect(range(1, 20))->map(function () {
                return [
                    'valor' => rand(10000, 150000), // COP directo
                    'fecha' => Carbon::now()->subDays(rand(1, 60)),
                    'descripcion' => Str::random(12),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

        // 20 ahorros
        DB::table('ahorros')->insert(
            collect(range(1, 20))->map(function () {
                $inicio = Carbon::now()->subDays(rand(60, 120));
                $fin = (clone $inicio)->addDays(rand(15, 90));
                return [
                    'fechainicio' => $inicio,
                    'fechafin' => $fin,
                    'periodo_id' => rand(1, 5),  // solo 5 periodos
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

        // Relación ahorro_ingreso
        DB::table('ahorro_ingreso')->insert(
            collect(range(1, 20))->map(function () {
                return [
                    'ahorro_id' => rand(1, 20),
                    'ingreso_id' => rand(1, 20),
                    'porcentaje' => rand(1, 50),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

        // 3 gastos fijos, valores en COP (sin dividir)
        DB::table('gastos_fijos')->insert(
            collect(range(1, 3))->map(function () {
                return [
                    'descripcion' => 'Gasto Fijo ' . Str::random(5),
                    'periodo_id' => rand(1, 5),
                    'valor' => rand(20000, 120000), // COP directo
                    'fecha_inicio' => Carbon::now()->subMonths(rand(0, 6))->startOfMonth(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray()
        );

    }
}
