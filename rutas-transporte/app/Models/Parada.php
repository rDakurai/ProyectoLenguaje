<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parada extends Model
{
    protected $fillable = ['nombre','direccion','lat','lng'];

    public function rutas(): BelongsToMany
    {
        return $this->belongsToMany(Ruta::class, 'ruta_parada')
            ->withPivot(['orden','sentido'])
            ->withTimestamps();
    }
}
