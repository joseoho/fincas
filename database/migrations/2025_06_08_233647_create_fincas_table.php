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
        Schema::create('fincas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100);
                $table->string('ubicacion', 255)->nullable();
                $table->decimal('area', 10, 2)->comment('En hectáreas')->nullable();
                $table->text('descripcion')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fincas');
    }
};
