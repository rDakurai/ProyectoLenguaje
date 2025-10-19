<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    protected $fillable = ['ruta_id','dia_semana','hora_salida','sentido'];

    public function ruta(): BelongsTo
    {
        return $this->belongsTo(Ruta::class);
    }
}
