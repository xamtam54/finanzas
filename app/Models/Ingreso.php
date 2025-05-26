<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Ingreso extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idingreso';
    protected $fillable = ['valor', 'fecha', 'descripcion'];
    protected $casts = [
        'fecha' => 'date',
    ];
    public function ahorros()
    {
        return $this->belongsToMany(Ahorro::class, 'ahorro_ingreso', 'ingreso_id', 'ahorro_id');
    }

    // Métodos personalizados
    public static function ingresar($data)
    {
        return self::create($data);
    }

    public function editar($data)
    {
        return $this->update($data);
    }

    public function eliminar()
    {
        return $this->delete();
    }

    public static function buscarFechas($inicio, $fin)
    {
        return self::whereBetween('fecha', [$inicio, $fin])->get();
    }

    public static function buscarUltimos10()
    {
        return self::orderBy('fecha', 'desc')->limit(10)->get();
    }

    public static function buscarRango($min, $max)
    {
        return self::whereBetween('valor', [$min, $max])->get();
    }

    public static function totalActual()
    {
        return self::sum('valor');
    }

    public static function restar($valor)
    {
        return self::totalActual() - $valor;
    }
}
