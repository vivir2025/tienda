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
    // database/migrations/2023_XX_XX_XXXXXX_create_propietarios_table.php
    Schema::create('propietarios', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('nombre');
        $table->text('direccion')->nullable();
        $table->string('telefono')->nullable();
        $table->string('foto')->nullable();
        $table->string('foto_url')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
