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
    // database/migrations/2023_XX_XX_XXXXXX_create_permisos_table.php
    Schema::create('permisos', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('tienda_id');
        $table->date('fecha_permiso');
        $table->string('certificado_bomberos')->nullable();
        $table->string('soporte_acripol')->nullable();
        $table->timestamps();

        $table->foreign('tienda_id')->references('id')->on('tiendas');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
