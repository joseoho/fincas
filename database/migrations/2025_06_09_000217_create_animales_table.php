<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animales', function (Blueprint $table) {
           $table->id();
            $table->foreignId('lote_id')->constrained()->onDelete('cascade');
            $table->string('codigo', 50)->unique()->comment('Número de arete');
            $table->string('raza', 50)->nullable();
            $table->enum('sexo', ['macho', 'hembra']);
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso_inicial', 10, 2)->comment('En kg')->nullable();
            $table->enum('estado', ['activo', 'vendido', 'muerto', 'enfermo'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};
