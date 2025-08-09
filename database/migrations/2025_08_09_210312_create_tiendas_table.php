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
    // database/migrations/2023_XX_XX_XXXXXX_create_tiendas_table.php
    Schema::create('tiendas', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('propietario_id');
        $table->string('direccion_tienda');
        $table->decimal('latitud', 10, 8)->nullable();
        $table->decimal('longitud', 11, 8)->nullable();
        $table->string('foto')->nullable();
        $table->string('foto_url')->nullable();
        $table->timestamps();

        $table->foreign('propietario_id')->references('id')->on('propietarios');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiendas');
    }
};
