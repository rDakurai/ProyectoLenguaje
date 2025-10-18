<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parada extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','direccion','coordenadas'];

    public function rutas(): BelongsToMany
    {
        return $this->belongsToMany(Ruta::class, 'ruta_parada')
            ->withPivot(['orden','sentido']);
    }
}