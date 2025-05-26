<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egreso extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idegreso';
    protected $fillable = ['valor', 'fecha', 'descripcion'];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function gastosFijos()
    {
        return $this->belongsToMany(GastoFijo::class, 'gasto_egreso', 'egreso_id', 'gastofijo_id');
    }

    public static function retiro($data)
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

    public static function buscarFecha($fecha)
    {
        return self::where('fecha', $fecha)->get();
    }

    public static function buscarUltimos($cantidad = 10)
    {
        return self::orderBy('fecha', 'desc')->limit($cantidad)->get();
    }

    public static function buscarRango($min, $max)
    {
        return self::whereBetween('valor', [$min, $max])->get();
    }

    public static function totalactual()
    {
        return self::whereNull('deleted_at')->sum('valor');
    }

}
