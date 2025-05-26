<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GastoFijo extends Model
{
    protected $table = 'gastos_fijos';

    protected $primaryKey = 'idgastofijo';
    protected $fillable = ['descripcion', 'periodo_id', 'valor', 'fecha_inicio'];


    protected $casts = [
    'fecha_inicio' => 'datetime',
    ];
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id', 'idperiodo');
    }

    public function egresos()
    {
        return $this->belongsToMany(Egreso::class, 'gasto_egreso', 'gastofijo_id', 'egreso_id');
    }

    public static function alerta($limite)
    {
        return self::where('valor', '>', $limite)->get();
    }

    public function egresoXAlerta()
    {
        return $this->egresos()->where('valor', '>', $this->valor)->get();
    }
}
