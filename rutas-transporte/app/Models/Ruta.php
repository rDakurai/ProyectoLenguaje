<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';
    protected $fillable = ['nombre','codigo','estado','color_ruta'];

    // Paradas de la ruta (tabla pivote ruta_parada)
    public function paradas(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->orderBy('ruta_parada.orden');
    }

    // Atajos por sentido
    public function paradasIda(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->wherePivot('sentido','Ida')
            ->orderBy('ruta_parada.orden');
    }

    public function paradasVuelta(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->wherePivot('sentido','Vuelta')
            ->orderBy('ruta_parada.orden');
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }
}