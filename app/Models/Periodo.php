<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Periodo extends Model
{
    use SoftDeletes;

    protected $table = 'periodos';

    protected $primaryKey = 'idperiodo';
    protected $fillable = ['cantidaddias'];

    public function ahorros()
    {
        return $this->hasMany(Ahorro::class, 'periodo_id');
    }

    public function gastosFijos()
    {
        return $this->hasMany(GastoFijo::class, 'periodo_id');
    }

    public static function crearPeriodo($data)
    {
        return self::create($data);
    }
    public function getFechaFinAttribute()
    {
        // created_at + cantidaddias en días
        return Carbon::parse($this->created_at)->addDays($this->cantidaddias);
    }
}
