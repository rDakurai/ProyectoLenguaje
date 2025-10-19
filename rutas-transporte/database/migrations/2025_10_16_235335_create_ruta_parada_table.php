<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ruta_parada', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ruta_id')
                ->constrained('rutas')
                ->cascadeOnDelete();

            $table->foreignId('parada_id')
                ->constrained('paradas')
                ->cascadeOnDelete();

            // Orden de paso por la parada dentro del sentido
            $table->unsignedInteger('orden');

            // $table->enum('sentido', ['Ida','Vuelta']);
            $table->string('sentido', 10);

            $table->timestamps();

            // Evita duplicados de una misma parada en un sentido de una ruta
            $table->unique(['ruta_id','parada_id','sentido']);

            // Para ordenar rápido por orden dentro de un sentido
            $table->index(['ruta_id','sentido','orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruta_parada');
    }
};
