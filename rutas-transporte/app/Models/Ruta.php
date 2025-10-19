<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruta extends Model
{
    protected $fillable = ['nombre','descripcion'];

    public function paradas(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->withTimestamps();
    }

    public function paradasIda(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->wherePivot('sentido', 'Ida')
            ->orderBy('ruta_parada.orden')
            ->withTimestamps();
    }

    public function paradasVuelta(): BelongsToMany
    {
        return $this->belongsToMany(Parada::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->wherePivot('sentido', 'Vuelta')
            ->orderBy('ruta_parada.orden')
            ->withTimestamps();
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }
}
