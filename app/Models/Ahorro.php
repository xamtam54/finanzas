<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ahorro extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idahorro';
    protected $fillable = ['fechainicio', 'fechafin', 'periodo_id'];

    protected $casts = [
        'fechainicio' => 'datetime',
        'fechafin' => 'datetime',
    ];

    public function ingresos()
    {
        return $this->belongsToMany(Ingreso::class, 'ahorro_ingreso', 'ahorro_id', 'ingreso_id')
                    ->withPivot('porcentaje')
                    ->withTimestamps();
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public static function ingresarAhorro($data)
    {
        return self::create($data);
    }

    public static function total()
    {
        return self::with('ingresos')->get()->sum(function ($ahorro) {
            return $ahorro->calcularValorAhorro();
        });
    }

    public function calcularValorAhorro()
    {
        return $this->ingresos->sum(function ($ingreso) {
            $porcentaje = $ingreso->pivot->porcentaje; // valor entre 0 y 100
            return ($ingreso->valor * $porcentaje) / 100;
        });
    }

    public function porcentajeAsignado($ingresoId)
    {
        return DB::table('ahorro_ingreso')
            ->where('ingreso_id', $ingresoId)
            ->sum('porcentaje');
    }

    public function asociarIngreso($ingresoId, $nuevoPorcentaje)
    {
        $ingreso = Ingreso::findOrFail($ingresoId);

        $porcentajeExistente = $this->porcentajeAsignado($ingresoId);
        $relacionExistente = DB::table('ahorro_ingreso')
            ->where('ahorro_id', $this->idahorro)
            ->where('ingreso_id', $ingresoId)
            ->first();

        $porcentajeActual = $relacionExistente->porcentaje ?? 0;
        $porcentajeSinEste = $porcentajeExistente - $porcentajeActual;
        $nuevoTotal = $porcentajeSinEste + $porcentajeActual + $nuevoPorcentaje;

        if ($nuevoTotal > 100) {
            return [
                'error' => true,
                'message' => 'El porcentaje total asignado a este ingreso no puede exceder el 100%. Actualmente está en ' . ($porcentajeSinEste + $porcentajeActual) . '%.'
            ];
        }

        $nuevoValor = ($nuevoPorcentaje * $ingreso->valor) / 100;
        $disponible = (Ingreso::totalactual() ?? Ingreso::sum('valor'))
                    - (Egreso::totalactual() ?? Egreso::sum('valor'))
                    - Ahorro::total();

        if ($nuevoValor > $disponible) {
            return [
                'error' => true,
                'message' => 'No se puede asociar este ingreso porque supera el dinero disponible ($' . number_format($disponible, 2) . ').'
            ];
        }

        if ($relacionExistente) {
            DB::table('ahorro_ingreso')
                ->where('ahorro_id', $this->idahorro)
                ->where('ingreso_id', $ingresoId)
                ->update([
                    'porcentaje' => $porcentajeActual + $nuevoPorcentaje,
                ]);
        } else {
            $this->ingresos()->attach($ingresoId, [
                'porcentaje' => $nuevoPorcentaje,
            ]);
        }

        return ['error' => false];
    }
}
