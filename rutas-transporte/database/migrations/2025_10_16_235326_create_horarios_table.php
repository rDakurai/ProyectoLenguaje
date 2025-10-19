<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruta_id')
                ->constrained('rutas')
                ->cascadeOnDelete();

            // Puedes cambiar por ENUM si prefieres:
            // $table->enum('dia_semana', ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo']);
            $table->string('dia_semana', 15);
            $table->time('hora_salida');

            // Sentido de la ruta para este horario (coincide con pivote)
            // $table->enum('sentido', ['Ida','Vuelta'])->default('Ida');
            $table->string('sentido', 10)->default('Ida');

            $table->timestamps();

            $table->index(['ruta_id','dia_semana','sentido']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
