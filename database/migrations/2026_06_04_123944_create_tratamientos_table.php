<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('duracion');
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->string('estado')->default('Activo');
            $table->string('frecuencia_administracion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
