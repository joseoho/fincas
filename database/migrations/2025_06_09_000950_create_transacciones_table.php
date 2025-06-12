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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained()->onDelete('cascade');
            $table->foreignId('moneda_id')->constrained();
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->string('categoria', 50)->nullable();
            $table->string('referencia', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
